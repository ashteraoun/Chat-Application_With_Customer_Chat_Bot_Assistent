<template>
    <div class="min-h-screen text-[#17212b]">
        <aside class="fixed inset-y-0 left-0 z-40 hidden w-64 flex-col bg-[#142b35] px-5 py-6 text-white lg:flex">
            <router-link to="/" class="flex items-center gap-3 px-2 text-sm font-black tracking-[0.18em] uppercase">
                <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-[#f26f52] text-lg text-white shadow-lg shadow-[#f26f52]/25">S</span>
                Support Hub
            </router-link>

            <div class="mt-12 px-2 text-[10px] font-bold tracking-[0.2em] text-[#86a5a7] uppercase">Workspace</div>
            <nav class="mt-3 space-y-1 text-sm">
                <router-link v-if="auth.user" to="/chats" class="flex items-center gap-3 rounded-xl px-3 py-3 text-[#c8d8d5] hover:bg-white/10 hover:text-white" active-class="bg-[#f26f52] !text-white shadow-lg shadow-[#f26f52]/20"><span class="text-base">◌</span> Conversations</router-link>
                <router-link v-if="auth.user" to="/dashboard" class="flex items-center gap-3 rounded-xl px-3 py-3 text-[#c8d8d5] hover:bg-white/10 hover:text-white" active-class="bg-white/10 !text-white"><span class="text-base">▦</span> Overview</router-link>
                <router-link v-if="auth.user && auth.user.role === 'admin'" to="/admin/dashboard" class="flex items-center gap-3 rounded-xl px-3 py-3 text-[#c8d8d5] hover:bg-white/10 hover:text-white" active-class="bg-white/10 !text-white"><span class="text-base">◇</span> Administration</router-link>
                <router-link v-if="auth.user" to="/profile" class="flex items-center gap-3 rounded-xl px-3 py-3 text-[#c8d8d5] hover:bg-white/10 hover:text-white" active-class="bg-white/10 !text-white"><span class="text-base">○</span> Profile</router-link>
                <router-link v-if="auth.user" to="/settings" class="flex items-center gap-3 rounded-xl px-3 py-3 text-[#c8d8d5] hover:bg-white/10 hover:text-white" active-class="bg-white/10 !text-white"><span class="text-base">⚙</span> Settings</router-link>
            </nav>

            <div v-if="!auth.user" class="mt-8 space-y-2 text-sm">
                <router-link to="/login" class="block rounded-xl px-3 py-3 text-[#c8d8d5] hover:bg-white/10 hover:text-white">Login</router-link>
                <router-link to="/register" class="block rounded-xl bg-[#f26f52] px-3 py-3 text-center font-bold text-white">Create account</router-link>
                <router-link to="/forgot-password" class="block px-3 py-2 text-xs text-[#86a5a7] hover:text-white">Forgot password?</router-link>
            </div>

            <div class="mt-auto rounded-2xl border border-white/10 bg-white/5 p-4">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-full bg-[#d9ece3] font-bold text-[#142b35]">{{ auth.user?.name?.charAt(0)?.toUpperCase() || 'G' }}</span>
                    <div class="min-w-0"><p class="truncate text-sm font-bold">{{ auth.user?.name || 'Guest visitor' }}</p><p class="truncate text-xs text-[#86a5a7]">{{ auth.user?.role || 'Welcome' }}</p></div>
                </div>
                <button v-if="auth.user" @click="logout" class="mt-4 w-full rounded-lg border border-white/10 py-2 text-xs text-[#c8d8d5] hover:bg-white/10 hover:text-white">Sign out</button>
            </div>
        </aside>

        <div class="lg:pl-64">
            <header class="sticky top-0 z-30 border-b border-[#dfe3dd] bg-[#f5f3ee]/90 backdrop-blur-xl">
                <div class="mx-auto flex max-w-[1500px] items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-10">
                    <div class="lg:hidden"><router-link to="/" class="font-black tracking-[0.12em] text-[#142b35] uppercase">Support Hub</router-link></div>
                    <div class="hidden text-sm text-[#6e7b7d] sm:block">{{ auth.user ? `Good to see you, ${auth.user.name}` : 'A calmer way to get support' }}</div>
                    <div class="flex items-center gap-3">
                        <span v-if="!echoEnabled" class="rounded-full bg-[#fff0d6] px-3 py-1.5 text-[11px] font-bold text-[#9a682c]">Offline mode</span>
                        <span class="h-2.5 w-2.5 rounded-full bg-[#27a99d] shadow-lg shadow-[#27a99d]/40"></span>
                    </div>
                </div>
            </header>

            <main class="mx-auto max-w-[1500px] px-4 py-6 sm:px-6 sm:py-8 lg:px-10">
                <router-view />
            </main>
        </div>
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
