<template>
  <div class="space-y-6">
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
      <div><p class="text-xs font-black tracking-[0.22em] text-[#f26f52] uppercase">Your workspace / Inbox</p><h1 class="mt-2 text-3xl font-black tracking-tight text-[#142b35] sm:text-4xl">Stay close to the conversation.</h1><p class="mt-2 max-w-xl text-sm leading-6 text-[#6e7b7d]">Everything you need to keep this conversation moving, in one calm space.</p></div>
      <div class="flex items-center gap-2 rounded-full border border-[#dfe3dd] bg-white/70 px-4 py-2 text-xs font-bold text-[#4d686b]"><span class="h-2 w-2 rounded-full bg-[#27a99d]"></span> Live support channel</div>
    </div>

    <div class="grid gap-5 lg:grid-cols-[minmax(0,1fr)_300px]">
    <section class="overflow-hidden rounded-[1.75rem] border border-[#dfe3dd] bg-white/80 shadow-[0_24px_70px_rgba(20,43,53,0.10)] backdrop-blur">
      <ChatHeader :conversation="conversation" :onlineStatus="onlineStatus" />

      <div class="flex max-h-[62vh] min-h-[360px] flex-col space-y-3 overflow-y-auto bg-[#f8faf7] px-4 py-5 sm:px-6">
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

      <form @submit.prevent="submitMessage" class="border-t border-[#e4e8e1] bg-white p-4 sm:p-5">
        <div class="flex items-end gap-3 rounded-2xl border border-[#dfe3dd] bg-[#f8faf7] p-2 focus-within:border-[#27a99d] focus-within:ring-2 focus-within:ring-[#27a99d]/10">
          <AttachmentUploader @select="handleFileSelect" />
        <textarea
          v-model="body"
          rows="4"
          @input="handleTypingInput"
          @blur="handleTypingState(false)"
          placeholder="Write a reply..."
          class="min-h-12 flex-1 resize-none bg-transparent px-2 py-2 text-sm leading-6 text-[#17212b] outline-none placeholder:text-[#9aa7a4]"
        ></textarea>
          <button class="rounded-xl bg-[#f26f52] px-5 py-3 text-sm font-bold text-white shadow-lg shadow-[#f26f52]/20 hover:-translate-y-0.5 hover:bg-[#e85c40]">Send</button>
        </div>
      </form>
    </section>

    <aside class="rounded-[1.75rem] border border-[#dfe3dd] bg-[#142b35] p-5 text-white shadow-[0_24px_70px_rgba(20,43,53,0.15)]">
      <div class="mb-5 flex items-start justify-between gap-3">
        <div>
          <p class="text-[11px] font-bold tracking-[0.2em] text-[#9ed7cb] uppercase">Workspace</p>
          <h3 class="mt-1 text-lg font-semibold text-white">Conversation details</h3>
        </div>
        <span class="h-2.5 w-2.5 rounded-full bg-emerald-400 shadow-lg shadow-emerald-400/40"></span>
      </div>
      <div class="divide-y divide-white/10 overflow-hidden rounded-xl border border-white/10 bg-white/5 text-sm">
        <div class="flex items-center justify-between px-4 py-3"><span class="text-[#9fb5b2]">Participants</span><strong class="text-white">{{ conversation.participants?.length || 0 }}</strong></div>
        <div class="flex items-center justify-between px-4 py-3"><span class="text-[#9fb5b2]">Messages</span><strong class="text-white">{{ messages.length }}</strong></div>
        <div class="flex items-center justify-between px-4 py-3"><span class="text-[#9fb5b2]">Your role</span><strong class="capitalize text-[#9ed7cb]">{{ auth.user?.role || 'guest' }}</strong></div>
      </div>

      <div class="mt-5 rounded-xl border border-white/10 bg-white/5 p-4">
        <p class="text-[11px] font-bold tracking-[0.16em] text-[#9fb5b2] uppercase">Subject</p>
        <div class="mt-3 text-sm leading-6 text-white">
          {{ conversation.title || 'Customer support conversation' }}
        </div>
      </div>
    </aside>
    </div>
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
