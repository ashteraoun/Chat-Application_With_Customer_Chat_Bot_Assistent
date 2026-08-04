<template>
  <div class="grid gap-6 lg:grid-cols-[1.15fr_0.85fr]">
    <section class="rounded-[2rem] border border-slate-800 bg-slate-900 p-4 shadow-2xl shadow-slate-950/40">
      <ChatHeader :conversation="conversation" :onlineStatus="onlineStatus" />

      <div class="mt-4 space-y-3 overflow-y-auto rounded-[1.5rem] bg-slate-950/70 p-3 max-h-[62vh]">
        <MessageBubble
          v-for="message in messages"
          :key="message.id"
          :message="message"
          :currentUserId="userId"
        />
      </div>

      <TypingIndicator :typingUsers="typingUsers" />

      <form @submit.prevent="submitMessage" class="mt-4 grid gap-3">
        <AttachmentUploader @select="handleFileSelect" />
        <textarea
          v-model="body"
          rows="4"
          @input="handleTypingInput"
          @blur="handleTypingState(false)"
          class="w-full rounded-[1.5rem] border border-slate-800 bg-slate-950 px-4 py-3 text-sm text-slate-100 outline-none focus:border-indigo-500"
        ></textarea>
        <button class="rounded-[1.2rem] bg-gradient-to-r from-indigo-600 to-sky-500 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-900/30">Send message</button>
      </form>
    </section>

    <aside class="rounded-[2rem] border border-slate-800 bg-slate-950 p-4 shadow-xl shadow-slate-950/40">
      <div class="mb-4">
        <h3 class="text-lg font-semibold text-white">Conversation details</h3>
      </div>
      <div class="space-y-3 text-sm text-slate-300">
        <p><strong>Participants:</strong> {{ conversation.participants?.length || 0 }}</p>
        <p><strong>Messages:</strong> {{ messages.length }}</p>
        <p><strong>Current role:</strong> {{ auth.user?.role || 'guest' }}</p>
      </div>

      <div class="mt-6 rounded-[1.3rem] border border-slate-800 bg-slate-900 p-4">
        <p class="text-sm text-slate-400">Conversation preview</p>
        <div class="mt-3 rounded-[1rem] bg-slate-950 px-3 py-3 text-sm text-slate-300">
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
