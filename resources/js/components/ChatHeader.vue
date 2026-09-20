<template>
  <div class="flex items-center justify-between gap-4 border-b border-[#e4e8e1] bg-white px-4 py-5 sm:px-6">
    <div class="min-w-0">
      <div class="flex items-center gap-2">
        <span class="h-2 w-2 rounded-full bg-[#27a99d]"></span>
        <p class="text-[11px] font-bold tracking-[0.18em] text-[#27a99d] uppercase">Active conversation</p>
      </div>
      <h3 class="mt-1 truncate text-lg font-bold text-[#142b35]">{{ conversation.title || 'Conversation' }}</h3>
      <p class="truncate text-sm text-[#7d8b89]">{{ participantNames }}</p>
    </div>
    <div class="hidden items-center gap-2 text-xs sm:flex">
      <span v-for="status in onlineStatus" :key="status.user_id" class="rounded-full border border-[#dfe3dd] bg-[#f8faf7] px-3 py-1.5 text-[#5e7473]">
        <span class="mr-1.5 inline-block h-1.5 w-1.5 rounded-full" :class="status.is_online ? 'bg-[#27a99d]' : 'bg-[#9aa7a4]'"></span>{{ status.is_online ? 'Online' : 'Offline' }}
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
