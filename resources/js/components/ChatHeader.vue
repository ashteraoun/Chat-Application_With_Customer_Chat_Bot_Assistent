<template>
  <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 sm:gap-4 border-b border-slate-700/50 px-4 sm:px-6 py-4 bg-gradient-to-r from-slate-900/50 to-transparent backdrop-blur-sm">
    <div class="flex-1 min-w-0">
      <div class="flex items-center gap-3">
        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center flex-shrink-0">
          <span class="text-white font-semibold text-sm">
            {{ conversation.title ? conversation.title.charAt(0).toUpperCase() : 'C' }}
          </span>
        </div>
        <div class="min-w-0">
          <h3 class="text-lg font-semibold text-white truncate">
            {{ conversation.title || 'Untitled Conversation' }}
          </h3>
          <div class="flex items-center gap-2">
            <span class="text-sm text-slate-400 truncate">{{ participantNames }}</span>
            <span v-if="participantCount > 2" class="text-xs text-slate-500 bg-slate-800/50 px-2 py-0.5 rounded-full">
              +{{ participantCount - 2 }}
            </span>
          </div>
        </div>
      </div>
    </div>

    <div class="flex items-center gap-2 flex-wrap">
      <!-- Online Status Indicators -->
      <div v-if="onlineStatus.length > 0" class="flex items-center gap-2">
        <div v-for="status in onlineStatus" :key="status.user_id" 
             class="flex items-center gap-1.5 rounded-full border border-slate-700/80 bg-slate-800/50 backdrop-blur-sm px-3 py-1.5 text-xs"
             :class="status.is_online ? 'border-emerald-500/30' : 'border-slate-700/30'">
          <span class="relative flex h-2 w-2">
            <span v-if="status.is_online" 
                  class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-2 w-2"
                  :class="status.is_online ? 'bg-emerald-400' : 'bg-slate-500'"></span>
          </span>
          <span class="text-slate-300 font-medium">{{ status.is_online ? 'Online' : 'Offline' }}</span>
        </div>
      </div>

      <!-- Action Buttons -->
      <button class="p-2 rounded-lg hover:bg-slate-800/50 transition-colors duration-200 text-slate-400 hover:text-white">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
        </svg>
      </button>
      <button class="p-2 rounded-lg hover:bg-slate-800/50 transition-colors duration-200 text-slate-400 hover:text-white">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
        </svg>
      </button>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  conversation: {
    type: Object,
    default: () => ({}),
  },
  onlineStatus: {
    type: Array,
    default: () => [],
  },
});

const participantNames = computed(() => {
  return props.conversation.participants?.map((participant) => participant.user?.name).join(', ') || 'No participants';
});

const participantCount = computed(() => {
  return props.conversation.participants?.length || 0;
});
</script>