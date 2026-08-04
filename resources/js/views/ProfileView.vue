<template>
  <div class="rounded-3xl border border-slate-800 bg-slate-900 p-8">
    <h2 class="text-2xl font-semibold text-white">Profile</h2>
    <form class="mt-6 grid gap-4">
      <div>
        <label class="text-sm text-slate-400">Name</label>
        <input v-model="form.name" class="mt-1 w-full rounded-2xl border border-slate-700 bg-slate-950 px-4 py-3 text-white" />
      </div>
      <div>
        <label class="text-sm text-slate-400">Email</label>
        <input v-model="form.email" class="mt-1 w-full rounded-2xl border border-slate-700 bg-slate-950 px-4 py-3 text-white" />
      </div>
      <button class="rounded-2xl bg-indigo-600 px-4 py-3 text-white">Save changes</button>
    </form>
  </div>
</template>

<script setup>
import { reactive } from 'vue';
import { useAuthStore } from '../stores/auth';

const auth = useAuthStore();
const form = reactive({
  name: auth.user?.name || '',
  email: auth.user?.email || '',
});
</script>
