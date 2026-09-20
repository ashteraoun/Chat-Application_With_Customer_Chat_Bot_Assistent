<template>
  <div class="grid gap-5 lg:grid-cols-[minmax(0,1fr)_300px]">
    <section class="overflow-hidden rounded-2xl border border-white/10 bg-[#0d1b2b]/95 shadow-2xl shadow-black/20">
      <ChatHeader :conversation="conversation" :onlineStatus="onlineStatus" />

      <div class="flex max-h-[62vh] min-h-[360px] flex-col space-y-3 overflow-y-auto bg-[#081522] px-4 py-5 sm:px-6">
        <div v-if="!messages.length" class="m-auto max-w-sm text-center">
          <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl border border-teal-300/20 bg-teal-300/10 text-2xl text-teal-200">~</div>
          <h2 class="mt-4 text-lg font-semibold text-white">Start the conversation</h2>
          <p class="mt-2 text-sm leading-6 text-slate-400">Send a message to begin helping with this request.</p>
        </div>
        <MessageBubble
          v-for="message in messages"
          :key="message.id"
          :message="message"
          :currentUserId="userId"
        />
      </div>

      <TypingIndicator :typingUsers="typingUsers" />

      <form @submit.prevent="submitMessage" class="border-t border-white/10 bg-[#0d1b2b] p-4 sm:p-5">
        <div class="flex items-end gap-3 rounded-xl border border-white/10 bg-[#081522] p-2 focus-within:border-teal-300/50 focus-within:ring-2 focus-within:ring-teal-300/10">
          <AttachmentUploader @select="handleFileSelect" />
        <textarea
          v-model="body"
          rows="4"
          @input="handleTypingInput"
          @blur="handleTypingState(false)"
          placeholder="Write a reply..."
          class="min-h-12 flex-1 resize-none bg-transparent px-2 py-2 text-sm leading-6 text-slate-100 outline-none placeholder:text-slate-500"
        ></textarea>
          <button class="rounded-lg bg-teal-400 px-4 py-3 text-sm font-bold text-[#07111f] shadow-lg shadow-teal-400/10 hover:bg-teal-300">Send</button>
        </div>
      </form>
    </section>

    <aside class="rounded-2xl border border-white/10 bg-[#0d1b2b]/90 p-5 shadow-xl shadow-black/20">
      <div class="mb-5 flex items-start justify-between gap-3">
        <div>
          <p class="text-[11px] font-bold tracking-[0.2em] text-teal-300 uppercase">Workspace</p>
          <h3 class="mt-1 text-lg font-semibold text-white">Conversation details</h3>
        </div>
        <span class="h-2.5 w-2.5 rounded-full bg-emerald-400 shadow-lg shadow-emerald-400/40"></span>
      </div>
      <div class="divide-y divide-white/10 overflow-hidden rounded-xl border border-white/10 bg-[#081522] text-sm">
        <div class="flex items-center justify-between px-4 py-3"><span class="text-slate-400">Participants</span><strong class="text-white">{{ conversation.participants?.length || 0 }}</strong></div>
        <div class="flex items-center justify-between px-4 py-3"><span class="text-slate-400">Messages</span><strong class="text-white">{{ messages.length }}</strong></div>
        <div class="flex items-center justify-between px-4 py-3"><span class="text-slate-400">Your role</span><strong class="capitalize text-teal-200">{{ auth.user?.role || 'guest' }}</strong></div>
      </div>

      <div class="mt-5 rounded-xl border border-white/10 bg-[#081522] p-4">
        <p class="text-[11px] font-bold tracking-[0.16em] text-slate-500 uppercase">Subject</p>
        <div class="mt-3 text-sm leading-6 text-slate-200">
          {{ conversation.title || 'Customer support conversation' }}
        </div>
      </div>
    </aside>
  </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import { useRoute } from 'vue-router';
import { useAuthStore } from '../stores/auth';
import { useChatStore } from '../stores/chat';
import chatService from '../services/chatService';
import ChatHeader from '../components/ChatHeader.vue';
import MessageBubble from '../components/MessageBubble.vue';
import TypingIndicator from '../components/TypingIndicator.vue';
import AttachmentUploader from '../components/AttachmentUploader.vue';

const route = useRoute();
const auth = useAuthStore();
const chat = useChatStore();
const conversation = ref({});
const messages = ref([]);
const onlineStatus = ref([]);
const typingUsers = ref([]);
const body = ref('');
const attachments = ref([]);
const poller = ref(null);
const typingTimer = ref(null);
const echoChannel = ref(null);

const userId = ref(auth.user?.id ?? null);

const refreshTypingIndicators = async () => {
  const conversationId = Number(route.params.conversationId);

  if (!conversationId) {
    typingUsers.value = [];
    return;
  }

  try {
    const { data } = await chatService.getTypingStatus({ conversation_id: conversationId });
    typingUsers.value = (data.typing_statuses ?? [])
      .filter((status) => status.is_typing && status.user_id !== auth.user?.id)
      .map((status) => status.user?.name || 'Someone');
  } catch {
    typingUsers.value = [];
  }
};

const registerTypingBroadcast = () => {
  if (!window.Echo || !route.params.conversationId) {
    return;
  }

  const conversationId = Number(route.params.conversationId);

  if (echoChannel.value) {
    echoChannel.value.leave();
  }

  echoChannel.value = window.Echo.private(`conversation.${conversationId}`);
  echoChannel.value.listen('.TypingStatusUpdated', async (event) => {
    if (event.user_id === auth.user?.id) {
      return;
    }

    const participant = conversation.value.participants?.find((entry) => entry.user_id === event.user_id || entry.user?.id === event.user_id);
    const participantName = participant?.user?.name || participant?.name || 'Someone';

    if (event.is_typing) {
      typingUsers.value = [...new Set([...typingUsers.value, participantName])];
    } else {
      typingUsers.value = typingUsers.value.filter((name) => name !== participantName);
    }
  });
};

const handleTypingState = async (isTyping) => {
  const conversationId = Number(route.params.conversationId);

  if (!conversationId) {
    return;
  }

  await chatService.updateTypingStatus({
    conversation_id: conversationId,
    is_typing: isTyping,
  });

  if (isTyping) {
    if (typingTimer.value) {
      window.clearTimeout(typingTimer.value);
    }

    typingTimer.value = window.setTimeout(async () => {
      await chatService.updateTypingStatus({
        conversation_id: conversationId,
        is_typing: false,
      });
      await refreshTypingIndicators();
    }, 1500);
  }
};

const handleTypingInput = async () => {
  if (!body.value.trim()) {
    await handleTypingState(false);
    return;
  }

  await handleTypingState(true);
};

const loadConversation = async () => {
  const id = route.params.conversationId;
  await chat.fetchConversation(id);
  await chat.fetchMessages(id);
  await chat.getOnlineStatus();
  conversation.value = chat.currentConversation;
  messages.value = chat.messages;
  onlineStatus.value = chat.onlineStatus;
  userId.value = auth.user?.id ?? null;
  await refreshTypingIndicators();
  registerTypingBroadcast();
};

const submitMessage = async () => {
  if (!body.value.trim() && !attachments.value.length) return;

  const { data } = await chat.sendMessage(conversation.value.id, {
    body: body.value,
    type: 'text',
    attachments: attachments.value,
  });

  if (data?.data) {
    messages.value = [...messages.value, data.data];
  }

  await handleTypingState(false);
  body.value = '';
  attachments.value = [];
};

const handleFileSelect = (file) => {
  attachments.value = [
    {
      filename: file.name,
      content_type: file.type,
      size: file.size,
      url: URL.createObjectURL(file),
    },
  ];
};

onMounted(() => {
  loadConversation();
  poller.value = window.setInterval(() => {
    loadConversation();
  }, 2000);
});

onBeforeUnmount(() => {
  if (poller.value) {
    window.clearInterval(poller.value);
  }

  if (typingTimer.value) {
    window.clearTimeout(typingTimer.value);
  }

  if (echoChannel.value) {
    echoChannel.value.leave();
  }
});
</script>
