<template>
    <div class="mx-auto max-w-md rounded-2xl border border-slate-800 bg-slate-900 p-8 shadow-2xl">
        <h2 class="text-2xl font-semibold">Forgot password</h2>
        <form class="mt-6 space-y-4" @submit.prevent="submit">
            <div>
                <label class="mb-2 block text-sm text-slate-400">Email</label>
                <input v-model="form.email" type="email" class="w-full rounded border border-slate-700 bg-slate-950 px-3 py-2" />
            </div>
            <button class="w-full rounded bg-indigo-600 px-4 py-2 font-medium text-white">Send reset link</button>
        </form>
    </div>
</template>

<script setup>
import { reactive } from 'vue';
import { useAuthStore } from '../stores/auth';

const auth = useAuthStore();
const form = reactive({ email: '' });

const submit = async () => {
    await auth.forgotPassword(form);
};
</script>
