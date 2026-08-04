<template>
  <div :class="['flex max-w-[82%] gap-3 rounded-[1.5rem] px-4 py-3 shadow-lg', isOwnMessage ? 'ml-auto bg-gradient-to-r from-indigo-600 to-sky-500 text-white' : 'mr-auto bg-slate-800 text-slate-100']">
    <div class="min-w-0">
      <p class="text-sm leading-relaxed break-words">{{ message.body }}</p>
      <div class="mt-2 flex items-center justify-between gap-4 text-[11px]" :class="isOwnMessage ? 'text-indigo-100' : 'text-slate-400'">
        <span>{{ message.sender?.name || 'Unknown sender' }}</span>
        <span>{{ formattedTime }}</span>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed, defineProps } from 'vue';

const props = defineProps({
  message: {
    type: Object,
    required: true,
  },
  currentUserId: {
    type: Number,
    required: true,
  },
});

const isOwnMessage = computed(() => props.message.sender?.id === props.currentUserId);
const formattedTime = computed(() => new Date(props.message.created_at).toLocaleTimeString());
</script>
