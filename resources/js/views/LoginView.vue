<template>
    <div class="min-h-screen bg-slate-950 py-12">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-[2rem] bg-slate-900 shadow-2xl ring-1 ring-slate-800">
                <div class="grid gap-6 lg:grid-cols-[1.1fr_0.9fr]">
                    <div class="p-10 sm:p-12">
                        <span class="inline-flex rounded-full bg-indigo-600 px-3 py-1 text-sm font-semibold text-white">Welcome back</span>
                        <h1 class="mt-6 text-4xl font-semibold tracking-tight text-white">Sign in to your support portal</h1>
                        <p class="mt-4 max-w-xl text-slate-400">Choose the correct portal and continue to your dashboard immediately after login.</p>

                        <form class="mt-10 space-y-6" @submit.prevent="submit">
                            <div class="grid gap-4 sm:grid-cols-2">
                                <label class="block">
                                    <span class="text-sm font-medium text-slate-300">Email</span>
                                    <input v-model="form.email" type="email" placeholder="jane@example.com" class="mt-2 w-full rounded-2xl border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20" />
                                </label>

                                <label class="block">
                                    <span class="text-sm font-medium text-slate-300">Password</span>
                                    <input v-model="form.password" type="password" placeholder="********" class="mt-2 w-full rounded-2xl border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20" />
                                </label>
                            </div>

                            <label class="block">
                                <span class="text-sm font-medium text-slate-300">Portal</span>
                                <select v-model="form.role" class="mt-2 w-full rounded-2xl border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20">
                                    <option value="customer">Customer</option>
                                    <option value="admin">Admin</option>
                                    <option value="support_agent">Support agent</option>
                                </select>
                            </label>

                            <button type="submit" class="w-full rounded-3xl bg-indigo-600 px-5 py-3 text-base font-semibold text-white shadow-xl shadow-indigo-500/20 transition hover:bg-indigo-500">Sign in</button>
                        </form>

                        <p class="mt-8 text-sm text-slate-500">Don't have an account? <router-link to="/register" class="font-semibold text-indigo-400 hover:text-indigo-300">Create one</router-link></p>

                        <div v-if="message" class="mt-6 rounded-3xl border border-red-600 bg-red-950/90 p-4 text-sm text-red-300">
                            {{ message }}
                        </div>

                        <ul v-if="errors" class="mt-4 space-y-2 text-sm text-red-300">
                            <li v-for="(messages, field) in errors" :key="field" class="rounded-2xl bg-slate-950/80 p-3">
                                <span class="font-semibold text-slate-200">{{ field }}:</span>
                                <span class="ml-2">{{ messages.join(', ') }}</span>
                            </li>
                        </ul>
                    </div>

                    <div class="hidden rounded-[1.75rem] bg-slate-950 p-10 sm:block">
                        <h2 class="text-2xl font-semibold text-white">Fast access for every role</h2>
                        <p class="mt-4 text-slate-400">Select the role you want to sign in as, and the app will route you to the correct dashboard automatically.</p>

                        <div class="mt-8 space-y-5 text-slate-300">
                            <div class="rounded-3xl bg-slate-900/90 p-5">
                                <p class="font-semibold">Customer dashboard</p>
                                <p class="mt-2 text-sm text-slate-400">View conversations, ask questions, and keep track of messages.</p>
                            </div>
                            <div class="rounded-3xl bg-slate-900/90 p-5">
                                <p class="font-semibold">Admin dashboard</p>
                                <p class="mt-2 text-sm text-slate-400">Manage users, monitor activity, and control access.</p>
                            </div>
                            <div class="rounded-3xl bg-slate-900/90 p-5">
                                <p class="font-semibold">Support agent access</p>
                                <p class="mt-2 text-sm text-slate-400">Help customers in real time and respond to incoming chats.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { reactive, ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '../stores/auth';

const router = useRouter();
const auth = useAuthStore();
const errors = ref(null);
const message = ref(null);

const form = reactive({ email: '', password: '', role: 'customer' });

const getHomeRoute = () => {
    if (auth.user?.role === 'customer') return { name: 'chat-list' };
    if (auth.user?.role === 'support_agent') return { name: 'support-dashboard' };
    if (auth.user?.role === 'admin') return { name: 'admin-dashboard' };
    return { name: 'home' };
};

const submit = async () => {
    errors.value = null;
    message.value = null;

    try {
        await auth.login(form);
        router.push(getHomeRoute());
    } catch (error) {
        errors.value = auth.errors || error.response?.data?.errors || null;
        message.value = auth.message || error.response?.data?.message || 'Login failed.';
    }
};
</script>
