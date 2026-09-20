<template>
  <div v-if="typingUsers.length" class="border-t border-[#e4e8e1] bg-white px-5 py-3 text-xs text-[#7d8b89]">
    <span class="mr-2 inline-flex gap-1 align-middle"><i class="h-1.5 w-1.5 rounded-full bg-[#27a99d]"></i><i class="h-1.5 w-1.5 rounded-full bg-[#27a99d]"></i><i class="h-1.5 w-1.5 rounded-full bg-[#27a99d]"></i></span>{{ typingUsers.join(', ') }} typing
  </div>
</template>

<script setup>
import { defineProps } from 'vue';

const props = defineProps({
  typingUsers: {
    type: Array,
    default: () => [],
  },
});
</script>
