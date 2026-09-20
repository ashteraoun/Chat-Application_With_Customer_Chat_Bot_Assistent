<template>
  <div :class="['flex max-w-[88%] gap-3 rounded-2xl px-4 py-3 shadow-sm', isOwnMessage ? 'ml-auto bg-[#f26f52] text-white shadow-[#f26f52]/15' : 'mr-auto border border-[#e0e6df] bg-white text-[#24383d]']">
    <div class="min-w-0">
      <p class="text-sm leading-relaxed break-words">{{ message.body }}</p>
      <div class="mt-2 flex items-center justify-between gap-4 text-[11px]" :class="isOwnMessage ? 'text-white/70' : 'text-[#8a9996]'">
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
