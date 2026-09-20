<template>
  <div v-if="typingUsers.length" class="border-t border-white/10 bg-[#0d1b2b] px-5 py-3 text-xs text-slate-400">
    <span class="mr-2 inline-flex gap-1 align-middle"><i class="h-1.5 w-1.5 rounded-full bg-teal-300"></i><i class="h-1.5 w-1.5 rounded-full bg-teal-300"></i><i class="h-1.5 w-1.5 rounded-full bg-teal-300"></i></span>{{ typingUsers.join(', ') }} typing
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
