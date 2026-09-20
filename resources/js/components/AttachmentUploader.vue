<template>
  <label title="Attach a file" class="flex h-10 w-10 shrink-0 cursor-pointer items-center justify-center rounded-lg border border-white/10 bg-white/5 text-lg text-slate-300 transition hover:border-teal-300/50 hover:bg-teal-300/10 hover:text-teal-200">
    <input type="file" class="hidden" @change="handleFileChange" />
    +
  </label>
</template>

<script setup>
import { defineEmits } from 'vue';

const emit = defineEmits(['select']);

const handleFileChange = (event) => {
  const file = event.target.files?.[0];
  if (file) {
    emit('select', file);
  }
};
</script>
