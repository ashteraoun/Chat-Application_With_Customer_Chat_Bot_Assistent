<template>
    <div class="min-h-screen bg-slate-950 text-slate-100">
        <header class="border-b border-slate-800 bg-slate-900/80">
            <div class="mx-auto flex max-w-6xl items-center justify-between px-6 py-4">
                <router-link to="/" class="text-lg font-semibold">Support Hub</router-link>
                <div class="flex items-center gap-4">
                    <nav class="flex items-center gap-4 text-sm">
                        <router-link v-if="!auth.user" to="/login" class="text-slate-300 hover:text-white">Login</router-link>
                        <router-link v-if="!auth.user" to="/register" class="rounded bg-indigo-600 px-3 py-2 text-white">Register</router-link>
                        <router-link v-if="!auth.user" to="/forgot-password" class="text-slate-400 hover:text-white">Forgot password</router-link>
                        <router-link v-if="auth.user" to="/chats" class="text-slate-300 hover:text-white">Chats</router-link>
                        <router-link v-if="auth.user" to="/dashboard" class="text-slate-300 hover:text-white">Dashboard</router-link>
                        <router-link v-if="auth.user && auth.user.role === 'admin'" to="/admin/dashboard" class="text-slate-300 hover:text-white">Admin</router-link>
                        <router-link v-if="auth.user && auth.user.role === 'support_agent'" to="/support/dashboard" class="text-slate-300 hover:text-white">Support</router-link>
                        <router-link v-if="auth.user && auth.user.role === 'customer'" to="/customer/dashboard" class="text-slate-300 hover:text-white">Customer</router-link>
                        <button v-if="auth.user" @click="logout" class="rounded bg-slate-800 px-3 py-2">Logout</button>
                    </nav>
                    <span v-if="!echoEnabled" class="rounded-full bg-amber-500 px-3 py-1 text-xs font-semibold text-slate-950">
                        Real-time disabled
                    </span>
                </div>
            </div>
        </header>

        <main class="mx-auto max-w-6xl px-6 py-10">
            <router-view />
        </main>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { useAuthStore } from './stores/auth';

const auth = useAuthStore();
const echoEnabled = ref(false);

onMounted(() => {
    auth.fetchUser();
    echoEnabled.value = Boolean(window?.Echo);
});

const logout = async () => {
    await auth.logout();
};
</script>
