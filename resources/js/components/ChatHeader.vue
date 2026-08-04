<template>
  <div class="flex items-center justify-between gap-4 border-b border-slate-800 px-4 py-3">
    <div>
      <h3 class="text-xl font-semibold text-white">{{ conversation.title || 'Conversation' }}</h3>
      <p class="text-sm text-slate-400">{{ participantNames }}</p>
    </div>
    <div class="flex items-center gap-2 text-sm text-slate-300">
      <span v-for="status in onlineStatus" :key="status.user_id" class="rounded-full border border-slate-700 bg-slate-950 px-3 py-1">
        {{ status.is_online ? 'Online' : 'Offline' }}
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
