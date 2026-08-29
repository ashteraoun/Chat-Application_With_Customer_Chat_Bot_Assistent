<template>
  <div class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 p-6">
    <div class="mx-auto max-w-7xl">
      <div class="grid gap-8 lg:grid-cols-[380px_1fr]">
        <!-- Sidebar with enhanced styling -->
        <Sidebar :conversations="conversations" @select="selectConversation" @create-chat="openCreate" />

        <!-- Main Content Area -->
        <div class="relative overflow-hidden rounded-3xl border border-slate-700/50 bg-slate-900/90 p-8 shadow-2xl shadow-black/50 backdrop-blur-sm">
          <!-- Decorative gradient orb -->
          <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-indigo-500/10 blur-3xl"></div>
          <div class="absolute -bottom-20 -left-20 h-64 w-64 rounded-full bg-purple-500/10 blur-3xl"></div>
          
          <div class="relative">
            <!-- Header -->
            <div class="mb-8 flex items-center justify-between">
              <div>
                <h2 class="flex items-center gap-3 text-3xl font-bold text-white">
                  <span class="bg-gradient-to-r from-indigo-400 to-purple-400 bg-clip-text text-transparent">Messages</span>
                  <span class="rounded-full bg-indigo-500/20 px-3 py-1 text-xs font-medium text-indigo-300">
                    {{ conversations.length }}
                  </span>
                </h2>
                <p class="mt-1 text-sm text-slate-400">Select a conversation to view and reply to messages</p>
              </div>
              <button 
                @click="refresh" 
                class="group flex items-center gap-2 rounded-full bg-indigo-600/20 px-5 py-2.5 text-sm font-medium text-indigo-300 transition-all hover:bg-indigo-600 hover:text-white hover:shadow-lg hover:shadow-indigo-600/25"
              >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Refresh
              </button>
            </div>

            <!-- Empty State -->
            <div v-if="!conversations.length" class="relative rounded-2xl border-2 border-dashed border-slate-700/50 bg-slate-950/50 p-12 text-center backdrop-blur-sm">
              <div class="mx-auto mb-4 flex h-20 w-20 items-center justify-center rounded-full bg-slate-800/50">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
              </div>
              <h3 class="text-xl font-semibold text-white">No conversations yet</h3>
              <p class="mt-2 text-sm text-slate-400">Start a new conversation by clicking the + button in the sidebar</p>
            </div>

            <!-- Default Conversation Preview -->
            <div v-else class="relative rounded-2xl border border-slate-700/50 bg-slate-950/70 p-6 backdrop-blur-sm">
              <!-- Active conversation indicator -->
              <div class="absolute -top-px left-8 right-8 h-px bg-gradient-to-r from-transparent via-indigo-500/50 to-transparent"></div>
              
              <div class="flex items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                  <div class="relative">
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-500 shadow-lg shadow-indigo-500/20">
                      <span class="text-xl font-bold text-white">
                        {{ conversations[0]?.title?.charAt(0)?.toUpperCase() || 'S' }}
                      </span>
                    </div>
                    <span class="absolute -bottom-0.5 -right-0.5 block h-3.5 w-3.5 rounded-full border-2 border-slate-900 bg-emerald-400 ring-2 ring-emerald-400/30"></span>
                  </div>
                  <div>
                    <h3 class="text-xl font-semibold text-white">{{ conversations[0]?.title || 'Support conversation' }}</h3>
                    <p class="flex items-center gap-2 text-sm text-slate-400">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                      </svg>
                      {{ conversations[0]?.participants?.length || 0 }} participants
                    </p>
                  </div>
                </div>
                <div class="flex items-center gap-3">
                  <span class="flex items-center gap-2 rounded-full bg-emerald-500/15 px-4 py-1.5 text-xs font-medium text-emerald-300">
                    <span class="relative flex h-2 w-2">
                      <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"></span>
                      <span class="relative inline-flex h-2 w-2 rounded-full bg-emerald-400"></span>
                    </span>
                    Live
                  </span>
                </div>
              </div>
              
              <div class="mt-6 rounded-xl bg-slate-800/30 p-4">
                <p class="flex items-center gap-2 text-sm text-slate-400">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  Your room is ready. Open any conversation from the left panel to continue the chat.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Create Modal - Enhanced -->
      <div v-if="showCreateModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/80 px-4 py-8 backdrop-blur-sm">
        <!-- Modal backdrop with blur -->
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="showCreateModal = false"></div>
        
        <div class="relative w-full max-w-2xl transform rounded-3xl bg-gradient-to-br from-slate-900 to-slate-950 p-8 shadow-2xl shadow-black/80 ring-1 ring-slate-700/50 transition-all">
          <!-- Decorative elements -->
          <div class="absolute -right-16 -top-16 h-48 w-48 rounded-full bg-indigo-500/5 blur-2xl"></div>
          <div class="absolute -bottom-16 -left-16 h-48 w-48 rounded-full bg-purple-500/5 blur-2xl"></div>
          
          <div class="relative">
            <!-- Header -->
            <div class="flex items-start justify-between gap-4">
              <div>
                <h2 class="flex items-center gap-3 text-2xl font-bold text-white">
                  <span class="rounded-xl bg-indigo-500/20 p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                  </span>
                  New Conversation
                </h2>
                <p class="mt-2 text-sm text-slate-400">{{ createModalSubtitle }}</p>
              </div>
              <button 
                @click="showCreateModal = false" 
                class="rounded-xl bg-slate-800/50 p-2.5 text-slate-400 transition-all hover:bg-slate-700 hover:text-white"
              >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>

            <!-- Form -->
            <div class="mt-8 space-y-6">
              <!-- Select Contact -->
              <div>
                <label class="flex items-center gap-2 text-sm font-medium text-slate-300">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                  </svg>
                  {{ createModalLabel }}
                </label>
                <div class="relative mt-2">
                  <select 
                    v-model="selectedParticipantId" 
                    class="w-full rounded-xl border border-slate-700/50 bg-slate-950/50 px-4 py-3.5 text-slate-100 outline-none transition-all placeholder:text-slate-500 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 appearance-none cursor-pointer"
                  >
                    <option value="" disabled>Select a contact</option>
                    <option v-if="isFetchingParticipants" disabled>Loading contacts...</option>
                    <option v-else-if="!participants.length" disabled>No contacts available</option>
                    <option v-for="user in participants" :key="user.id" :value="user.id">
                      {{ user.name }} — {{ user.email }}
                    </option>
                  </select>
                  <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                  </div>
                </div>
              </div>

              <!-- Selected Contact Info -->
              <div class="rounded-xl bg-slate-800/30 p-4">
                <div class="flex items-center gap-3 text-sm">
                  <span class="text-slate-400">Selected contact:</span>
                  <span class="font-medium text-white">{{ activeParticipantName }}</span>
                </div>
                <p class="mt-2 text-xs text-slate-500">
                  <span class="flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Once created, the conversation opens immediately and the chosen contact can reply from their chat portal.
                  </span>
                </p>
              </div>

              <!-- Actions -->
              <div class="flex flex-wrap items-center gap-3 pt-2">
                <button 
                  @click="createConversation" 
                  class="flex items-center gap-2 rounded-xl bg-gradient-to-r from-indigo-600 to-indigo-500 px-6 py-3.5 font-medium text-white shadow-lg shadow-indigo-600/25 transition-all hover:scale-[1.02] hover:shadow-indigo-600/40 disabled:cursor-not-allowed disabled:opacity-50 disabled:hover:scale-100"
                  :disabled="!selectedParticipantId"
                >
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                  </svg>
                  Start Chat
                </button>
                <button 
                  @click="showCreateModal = false" 
                  class="rounded-xl border border-slate-700/50 bg-slate-800/50 px-6 py-3.5 text-slate-300 transition-all hover:bg-slate-700 hover:text-white"
                >
                  Cancel
                </button>
              </div>

              <!-- Error Message -->
              <div v-if="modalError" class="flex items-start gap-3 rounded-xl border border-red-600/30 bg-red-950/50 p-4 text-sm text-red-300 backdrop-blur-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-4 w-4 flex-shrink-0 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ modalError }}
              </div>
            </div>
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