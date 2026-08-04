<template>
  <label class="cursor-pointer rounded-2xl border border-slate-700 bg-slate-900 px-4 py-3 text-sm text-slate-200 transition hover:border-indigo-500">
    <input type="file" class="hidden" @change="handleFileChange" />
    Attach file
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
