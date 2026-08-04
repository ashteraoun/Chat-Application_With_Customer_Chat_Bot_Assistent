<template>
  <div>
    <div class="grid gap-8 lg:grid-cols-[340px_1fr]">
      <Sidebar :conversations="conversations" @select="selectConversation" @create-chat="openCreate" />

      <div class="rounded-[2rem] border border-slate-800 bg-slate-900 p-6 shadow-2xl shadow-slate-950/40">
        <div class="mb-6 flex items-center justify-between">
          <div>
            <h2 class="text-2xl font-semibold text-white">Conversations</h2>
            <p class="text-sm text-slate-400">Select a conversation to view messages.</p>
          </div>
          <button @click="refresh" class="rounded-full bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-500">Refresh</button>
        </div>

        <div v-if="!conversations.length" class="rounded-[1.5rem] border border-dashed border-slate-700 bg-slate-950/80 p-8 text-center text-slate-400">
          No conversations found.
        </div>

        <div v-else class="rounded-[1.5rem] border border-slate-800 bg-slate-950/70 p-4 text-slate-300">
          <div class="flex items-center justify-between gap-4 border-b border-slate-800 pb-4">
            <div>
              <h3 class="text-lg font-semibold text-white">{{ conversations[0]?.title || 'Support conversation' }}</h3>
              <p class="text-sm text-slate-400">{{ conversations[0]?.participants?.length || 0 }} participants</p>
            </div>
            <div class="rounded-full bg-emerald-500/15 px-3 py-1 text-xs text-emerald-300">Live</div>
          </div>
          <p class="mt-4 text-sm text-slate-400">Your room is ready. Open any conversation from the left panel to continue the chat.</p>
        </div>
      </div>
    </div>

    <div v-if="showCreateModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/80 px-4 py-8">
      <div class="w-full max-w-2xl rounded-[2rem] bg-slate-900 p-8 shadow-2xl ring-1 ring-slate-800">
        <div class="flex items-start justify-between gap-4">
          <div>
            <h2 class="text-2xl font-semibold text-white">Start a new chat</h2>
            <p class="mt-2 text-sm text-slate-400">{{ createModalSubtitle }}</p>
          </div>
          <button @click="showCreateModal = false" class="rounded-full bg-slate-800 px-4 py-2 text-sm text-slate-200 hover:bg-slate-700">Close</button>
        </div>

        <div class="mt-8 space-y-6">
          <div>
            <label class="block text-sm font-medium text-slate-300">{{ createModalLabel }}</label>
            <select v-model="selectedParticipantId" class="mt-3 w-full rounded-3xl border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20">
              <option value="" disabled>Select a contact</option>
              <option v-if="isFetchingParticipants" disabled>Loading contacts...</option>
              <option v-else-if="!participants.length" disabled>No contacts available</option>
              <option v-for="user in participants" :key="user.id" :value="user.id">{{ user.name }} — {{ user.email }}</option>
            </select>
          </div>

          <div class="space-y-3 text-sm text-slate-300">
            <p><strong>Selected contact:</strong> {{ activeParticipantName }}</p>
            <p class="text-slate-500">Once created, the conversation opens immediately and the chosen contact can reply from their chat portal.</p>
          </div>

          <div class="flex flex-wrap gap-3">
            <button @click="createConversation" class="rounded-3xl bg-indigo-600 px-5 py-3 text-white hover:bg-indigo-500" :disabled="!selectedParticipantId">
              Start chat
            </button>
            <button @click="showCreateModal = false" class="rounded-3xl border border-slate-700 bg-slate-800 px-5 py-3 text-slate-200 hover:bg-slate-700">Cancel</button>
          </div>

          <div v-if="modalError" class="rounded-3xl border border-red-600 bg-red-950/90 p-4 text-sm text-red-300">
            {{ modalError }}
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref, computed } from 'vue';
import { useRouter } from 'vue-router';
import api from '../services/api';
import { useAuthStore } from '../stores/auth';
import { useChatStore } from '../stores/chat';
import Sidebar from '../components/Sidebar.vue';

const router = useRouter();
const auth = useAuthStore();
const chat = useChatStore();
const conversations = ref([]);
const participants = ref([]);
const isFetchingParticipants = ref(false);
const showCreateModal = ref(false);
const selectedParticipantId = ref(null);
const modalError = ref(null);

const createModalSubtitle = computed(() => auth.user?.role === 'customer'
  ? 'Choose a support agent or admin to start your conversation.'
  : 'Choose a customer to message.');

const createModalLabel = computed(() => auth.user?.role === 'customer'
  ? 'Support contact'
  : 'Customer');

const activeParticipantName = computed(() => {
  const participant = participants.value.find((user) => user.id === selectedParticipantId.value);
  return participant ? `${participant.name} (${participant.email})` : 'None selected';
});

const refresh = async () => {
  await chat.fetchConversations();
  conversations.value = chat.conversations;
};

const fetchParticipants = async () => {
  if (!auth.user?.role) {
    participants.value = [];
    return;
  }

  isFetchingParticipants.value = true;
  modalError.value = null;

  try {
    const requestedRoles = auth.user.role === 'customer'
      ? ['support_agent', 'admin']
      : ['customer'];

    const responses = await Promise.all(
      requestedRoles.map((role) => api.get('/admin/users', { params: { role } }))
    );

    const merged = responses.flatMap((response) => response.data.users?.data ?? response.data.users ?? []);
    participants.value = [...new Map(merged.map((user) => [user.id, user])).values()];

    if (!participants.value.length) {
      modalError.value = auth.user.role === 'customer'
        ? 'No support agents or admins are available right now.'
        : 'No customer accounts found. Create customers in the user management panel.';
    }
  } catch (error) {
    participants.value = [];
    modalError.value = error.response?.data?.message || 'Unable to load participants.';
  } finally {
    isFetchingParticipants.value = false;
  }
};

const selectConversation = async (conversation) => {
  await chat.fetchConversation(conversation.id);
  await chat.fetchMessages(conversation.id);
  router.push({ name: 'conversation', params: { conversationId: conversation.id } });
};

const openCreate = async () => {
  modalError.value = null;
  selectedParticipantId.value = null;
  showCreateModal.value = true;
  await fetchParticipants();
};

const createConversation = async () => {
  if (!selectedParticipantId.value) {
    modalError.value = 'Please select a contact to start a chat.';
    return;
  }

  try {
    const { data } = await chat.createConversation({
      type: 'private',
      participant_ids: [selectedParticipantId.value],
      title: auth.user?.role === 'customer' ? 'Support conversation' : 'Customer support chat',
    });

    showCreateModal.value = false;
    await refresh();
    router.push({ name: 'conversation', params: { conversationId: data.conversation.id } });
  } catch (error) {
    modalError.value = error.response?.data?.message || 'Unable to create conversation.';
  }
};

onMounted(async () => {
  await refresh();
  if (auth.user?.role) {
    await fetchParticipants();
  }
});
</script>
