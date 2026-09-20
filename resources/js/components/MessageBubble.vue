<template>
  <div :class="['flex max-w-[88%] gap-3 rounded-2xl px-4 py-3 shadow-lg', isOwnMessage ? 'ml-auto bg-teal-400 text-[#07111f] shadow-teal-950/20' : 'mr-auto border border-white/10 bg-[#13263a] text-slate-100']">
    <div class="min-w-0">
      <p class="text-sm leading-relaxed break-words">{{ message.body }}</p>
      <div class="mt-2 flex items-center justify-between gap-4 text-[11px]" :class="isOwnMessage ? 'text-teal-950/70' : 'text-slate-400'">
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
