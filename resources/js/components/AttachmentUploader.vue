<template>
  <label title="Attach a file" class="flex h-10 w-10 shrink-0 cursor-pointer items-center justify-center rounded-xl border border-[#dfe3dd] bg-white text-lg text-[#6e7b7d] transition hover:border-[#27a99d] hover:bg-[#eaf7f3] hover:text-[#168e83]">
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
