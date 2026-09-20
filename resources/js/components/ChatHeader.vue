<template>
  <div class="flex items-center justify-between gap-4 border-b border-white/10 px-4 py-4 sm:px-6">
    <div class="min-w-0">
      <div class="flex items-center gap-2">
        <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
        <p class="text-[11px] font-bold tracking-[0.18em] text-emerald-300 uppercase">Active conversation</p>
      </div>
      <h3 class="mt-1 truncate text-lg font-semibold text-white">{{ conversation.title || 'Conversation' }}</h3>
      <p class="truncate text-sm text-slate-400">{{ participantNames }}</p>
    </div>
    <div class="hidden items-center gap-2 text-xs sm:flex">
      <span v-for="status in onlineStatus" :key="status.user_id" class="rounded-full border border-white/10 bg-white/5 px-3 py-1.5 text-slate-300">
        <span class="mr-1.5 inline-block h-1.5 w-1.5 rounded-full" :class="status.is_online ? 'bg-emerald-400' : 'bg-slate-500'"></span>{{ status.is_online ? 'Online' : 'Offline' }}
      </span>
    </div>
  </div>
</template>

<script setup>
import { computed, defineProps } from 'vue';

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
</script>
