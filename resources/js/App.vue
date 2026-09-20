<template>
    <div class="min-h-screen text-slate-100">
        <header class="sticky top-0 z-30 border-b border-white/10 bg-[#07111f]/90 backdrop-blur-xl">
            <div class="mx-auto flex max-w-[1480px] items-center justify-between gap-5 px-4 py-4 sm:px-6 lg:px-8">
                <router-link to="/" class="flex items-center gap-3 text-sm font-bold tracking-[0.18em] text-white uppercase">
                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-teal-400 font-black text-[#07111f] shadow-lg shadow-teal-400/20">S</span>
                    Support Hub
                </router-link>
                <div class="flex items-center gap-3">
                    <nav class="hidden items-center gap-1 text-sm md:flex">
                        <router-link v-if="!auth.user" to="/login" class="rounded-lg px-3 py-2 text-slate-300 hover:bg-white/5 hover:text-white">Login</router-link>
                        <router-link v-if="!auth.user" to="/register" class="rounded-lg bg-teal-400 px-3 py-2 font-semibold text-[#07111f] hover:bg-teal-300">Register</router-link>
                        <router-link v-if="!auth.user" to="/forgot-password" class="rounded-lg px-3 py-2 text-slate-400 hover:bg-white/5 hover:text-white">Forgot password</router-link>
                        <router-link v-if="auth.user" to="/chats" class="rounded-lg px-3 py-2 text-slate-300 hover:bg-white/5 hover:text-white">Chats</router-link>
                        <router-link v-if="auth.user" to="/dashboard" class="rounded-lg px-3 py-2 text-slate-300 hover:bg-white/5 hover:text-white">Dashboard</router-link>
                        <router-link v-if="auth.user && auth.user.role === 'admin'" to="/admin/dashboard" class="rounded-lg px-3 py-2 text-slate-300 hover:bg-white/5 hover:text-white">Admin</router-link>
                        <router-link v-if="auth.user && auth.user.role === 'support_agent'" to="/support/dashboard" class="rounded-lg px-3 py-2 text-slate-300 hover:bg-white/5 hover:text-white">Support</router-link>
                        <router-link v-if="auth.user && auth.user.role === 'customer'" to="/customer/dashboard" class="rounded-lg px-3 py-2 text-slate-300 hover:bg-white/5 hover:text-white">Customer</router-link>
                        <button v-if="auth.user" @click="logout" class="ml-2 rounded-lg border border-white/10 px-3 py-2 text-slate-300 hover:border-rose-400/40 hover:bg-rose-400/10 hover:text-rose-200">Logout</button>
                    </nav>
                    <span v-if="!echoEnabled" class="hidden rounded-full border border-amber-400/20 bg-amber-400/10 px-3 py-1 text-xs font-semibold text-amber-200 sm:inline-flex">
                        Real-time disabled
                    </span>
                </div>
            </div>
        </header>

        <main class="mx-auto max-w-[1480px] px-4 py-6 sm:px-6 sm:py-8 lg:px-8">
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
