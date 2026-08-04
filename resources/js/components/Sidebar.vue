<template>
  <aside class="flex h-full w-full max-w-xs flex-col gap-4 rounded-[2rem] border border-slate-700/50 bg-gradient-to-b from-slate-900 to-slate-950 p-4 shadow-2xl shadow-slate-950/60 backdrop-blur-sm">
    <!-- Header -->
    <div class="mb-2 flex items-center justify-between px-2">
      <div class="flex items-center gap-3">
        <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg shadow-indigo-500/20">
          <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
          </svg>
        </div>
        <div>
          <h2 class="text-lg font-semibold text-white tracking-tight">Chats</h2>
          <p class="text-xs text-slate-400 flex items-center gap-1">
            <span class="inline-block h-1.5 w-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
            {{ conversations.length }} conversations
          </p>
        </div>
      </div>
      <button 
        @click="$emit('create-chat')" 
        class="group relative rounded-xl bg-gradient-to-r from-indigo-500 to-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-lg shadow-indigo-500/20 transition-all duration-300 hover:shadow-indigo-500/40 hover:scale-105 active:scale-95"
      >
        <span class="relative z-10 flex items-center gap-1">
          <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
          </svg>
          New
        </span>
        <span class="absolute inset-0 rounded-xl bg-gradient-to-r from-indigo-400 to-purple-500 opacity-0 transition-opacity duration-300 group-hover:opacity-100"></span>
      </button>
    </div>

    <!-- Search Bar -->
    <div class="relative px-2">
      <input 
        type="text" 
        placeholder="Search conversations..."
        class="w-full rounded-xl border border-slate-700/50 bg-slate-800/30 px-4 py-2.5 pl-10 text-sm text-white placeholder:text-slate-400 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200"
      />
      <svg class="absolute left-6 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
      </svg>
    </div>

    <!-- Conversation List -->
    <div class="flex-1 overflow-y-auto px-1 space-y-2.5 scrollbar-thin scrollbar-thumb-slate-700 scrollbar-track-transparent">
      <template v-if="conversations.length">
        <button
          v-for="conversation in conversations"
          :key="conversation.id"
          @click="$emit('select', conversation)"
          class="group relative w-full rounded-2xl border border-slate-700/30 bg-gradient-to-br from-slate-800/40 to-slate-900/40 px-4 py-3.5 text-left transition-all duration-300 hover:border-indigo-500/50 hover:bg-slate-800/60 hover:shadow-lg hover:shadow-indigo-500/5 active:scale-[0.98]"
        >
          <!-- Active indicator -->
          <div class="absolute -left-px top-1/2 h-8 w-1 -translate-y-1/2 rounded-r-full bg-indigo-500 opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
          
          <div class="flex items-start justify-between gap-3">
            <div class="flex-1 min-w-0">
              <div class="flex items-center gap-2">
                <div class="h-8 w-8 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center flex-shrink-0">
                  <span class="text-xs font-medium text-white">
                    {{ conversation.title ? conversation.title.charAt(0).toUpperCase() : 'C' }}
                  </span>
                </div>
                <div class="min-w-0">
                  <span class="block truncate text-sm font-medium text-white group-hover:text-indigo-300 transition-colors duration-200">
                    {{ conversation.title || 'Untitled conversation' }}
                  </span>
                  <span class="text-xs text-slate-400 flex items-center gap-1.5">
                    <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    {{ conversation.participants?.length || 0 }} participants
                  </span>
                </div>
              </div>
            </div>
            <div class="flex flex-col items-end gap-1 flex-shrink-0">
              <span class="text-[10px] text-slate-500 whitespace-nowrap">
                {{ conversation.last_message_at ? formatTime(conversation.last_message_at) : 'No activity' }}
              </span>
              <span v-if="conversation.unread_count" 
                    class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-indigo-500 text-[10px] font-medium text-white shadow-lg shadow-indigo-500/30">
                {{ conversation.unread_count }}
              </span>
            </div>
          </div>
        </button>
      </template>
      
      <!-- Empty State -->
      <div v-else class="flex flex-col items-center justify-center py-12 px-4">
        <div class="h-16 w-16 rounded-full bg-slate-800/50 flex items-center justify-center mb-4">
          <svg class="h-8 w-8 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
          </svg>
        </div>
        <p class="text-sm font-medium text-slate-300">No conversations yet</p>
        <p class="text-xs text-slate-400 mt-1">Start a new chat to begin</p>
        <button 
          @click="$emit('create-chat')"
          class="mt-4 rounded-lg bg-indigo-600/20 px-4 py-2 text-sm text-indigo-400 hover:bg-indigo-600/30 transition-colors"
        >
          Create conversation
        </button>
      </div>
    </div>

    <!-- Footer -->
    <div class="border-t border-slate-700/30 pt-3 px-2">
      <div class="flex items-center justify-between text-xs text-slate-400">
        <span>{{ conversations.length }} total</span>
        <span class="flex items-center gap-1.5">
          <span class="inline-block h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
          Online
        </span>
      </div>
    </div>
  </aside>
</template>

<script setup>
import { defineProps, defineEmits } from 'vue';

const props = defineProps({
  conversations: {
    type: Array,
    default: () => [],
  },
});

const emit = defineEmits(['select', 'create-chat']);

const formatTime = (timestamp) => {
  if (!timestamp) return '';
  const date = new Date(timestamp);
  const now = new Date();
  const diffMs = now - date;
  const diffMins = Math.floor(diffMs / 60000);
  const diffHours = Math.floor(diffMs / 3600000);
  const diffDays = Math.floor(diffMs / 86400000);

  if (diffMins < 1) return 'Just now';
  if (diffMins < 60) return `${diffMins}m ago`;
  if (diffHours < 24) return `${diffHours}h ago`;
  if (diffDays < 7) return `${diffDays}d ago`;
  return date.toLocaleDateString();
};
</script>

<style scoped>
/* Custom scrollbar */
.overflow-y-auto::-webkit-scrollbar {
  width: 4px;
}

.overflow-y-auto::-webkit-scrollbar-track {
  background: transparent;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
  background: rgba(51, 65, 85, 0.5);
  border-radius: 9999px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
  background: rgba(51, 65, 85, 0.8);
}

/* Smooth hover transitions */
.group {
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
</style>