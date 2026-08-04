<template>
  <div v-if="typingUsers.length" class="rounded-3xl border border-slate-700 bg-slate-900 px-4 py-3 text-sm text-slate-300">
    <span>{{ typingUsers.join(', ') }} typing...</span>
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
