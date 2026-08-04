<template>
    <section class="grid gap-8 lg:grid-cols-[1.2fr_0.8fr]">
        <div class="rounded-2xl border border-slate-800 bg-slate-900 p-8 shadow-2xl">
            <p class="mb-3 text-sm uppercase tracking-[0.3em] text-indigo-400">Module 1</p>
            <h1 class="text-4xl font-semibold">Customer Support Chat System</h1>
            <p class="mt-4 max-w-2xl text-lg text-slate-300">
                This foundation provides Laravel 12, Sanctum auth, a Vue 3 SPA shell, and a ready API structure for the upcoming chat modules.
            </p>
        </div>

        <div v-if="auth.user" class="rounded-2xl border border-emerald-800 bg-emerald-950/60 p-8">
            <h2 class="text-xl font-semibold">Authenticated</h2>
            <p class="mt-3 text-slate-300">Welcome back, {{ auth.user.name }}.</p>
            <div class="mt-6 flex flex-wrap gap-3">
                <router-link to="/chats" class="rounded bg-indigo-600 px-4 py-2 text-white">Go to chats</router-link>
                <router-link v-if="auth.user.role === 'customer'" to="/customer/dashboard" class="rounded bg-slate-800 px-4 py-2 text-white">Customer dashboard</router-link>
                <router-link v-if="auth.user.role === 'support_agent'" to="/support/dashboard" class="rounded bg-slate-800 px-4 py-2 text-white">Support dashboard</router-link>
                <router-link v-if="auth.user.role === 'admin'" to="/admin/dashboard" class="rounded bg-slate-800 px-4 py-2 text-white">Admin dashboard</router-link>
            </div>
        </div>

        <div v-else class="rounded-2xl border border-slate-800 bg-slate-900 p-8">
            <h2 class="text-xl font-semibold">Get started</h2>
            <p class="mt-3 text-slate-300">Create an account or sign in to begin the support workspace.</p>
        </div>
    </section>
</template>

<script setup>
import { useAuthStore } from '../stores/auth';

const auth = useAuthStore();
</script>
