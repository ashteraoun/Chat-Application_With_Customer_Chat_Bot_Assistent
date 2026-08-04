<template>
    <div class="min-h-screen bg-slate-950 py-12">
        <div class="mx-auto grid max-w-6xl gap-10 px-4 sm:px-6 lg:px-8 lg:grid-cols-[1.4fr_0.9fr]">
            <section class="rounded-[2rem] bg-slate-900 p-10 shadow-2xl ring-1 ring-slate-800">
                <div class="mb-8">
                    <span class="inline-flex rounded-full bg-indigo-600 px-3 py-1 text-sm font-semibold text-white">Create account</span>
                    <h1 class="mt-6 text-4xl font-semibold tracking-tight text-white">Get started with support chat.</h1>
                    <p class="mt-4 max-w-2xl text-slate-400">Register as a customer or admin, then access the right portal automatically after sign-up.</p>
                </div>

                <form class="space-y-6" @submit.prevent="submit">
                    <div class="grid gap-4 sm:grid-cols-2">
                        <label class="block">
                            <span class="text-sm font-medium text-slate-300">Name</span>
                            <input v-model="form.name" type="text" placeholder="Jane Doe" class="mt-2 w-full rounded-2xl border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20" />
                        </label>

                        <label class="block">
                            <span class="text-sm font-medium text-slate-300">Email</span>
                            <input v-model="form.email" type="email" placeholder="jane@example.com" class="mt-2 w-full rounded-2xl border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20" />
                        </label>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <label class="block">
                            <span class="text-sm font-medium text-slate-300">Password</span>
                            <input v-model="form.password" type="password" placeholder="********" class="mt-2 w-full rounded-2xl border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20" />
                        </label>

                        <label class="block">
                            <span class="text-sm font-medium text-slate-300">Confirm password</span>
                            <input v-model="form.password_confirmation" type="password" placeholder="********" class="mt-2 w-full rounded-2xl border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20" />
                        </label>
                    </div>

                    <div class="rounded-3xl border border-slate-800 bg-slate-950/50 p-4">
                        <p class="text-sm font-medium text-slate-300">Register as</p>
                        <div class="mt-4 grid gap-3 sm:grid-cols-2">
                            <label class="cursor-pointer rounded-3xl border border-slate-700 bg-slate-900 px-4 py-3 transition hover:border-indigo-500">
                                <input type="radio" name="role" value="customer" v-model="form.role" class="sr-only" />
                                <div class="flex items-center justify-between gap-3">
                                    <div>
                                        <p class="font-semibold text-white">Customer</p>
                                        <p class="text-sm text-slate-400">Chat with support and open tickets.</p>
                                    </div>
                                    <div class="h-6 w-6 rounded-full border border-slate-600 bg-slate-800" :class="{'border-indigo-500 bg-indigo-600': form.role === 'customer'}"></div>
                                </div>
                            </label>

                            <label class="cursor-pointer rounded-3xl border border-slate-700 bg-slate-900 px-4 py-3 transition hover:border-indigo-500">
                                <input type="radio" name="role" value="admin" v-model="form.role" class="sr-only" />
                                <div class="flex items-center justify-between gap-3">
                                    <div>
                                        <p class="font-semibold text-white">Admin</p>
                                        <p class="text-sm text-slate-400">Manage users, view reports, and control settings.</p>
                                    </div>
                                    <div class="h-6 w-6 rounded-full border border-slate-600 bg-slate-800" :class="{'border-indigo-500 bg-indigo-600': form.role === 'admin'}"></div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="w-full rounded-3xl bg-indigo-600 px-5 py-3 text-base font-semibold text-white shadow-xl shadow-indigo-500/20 transition hover:bg-indigo-500">Create account</button>
                </form>

                <div v-if="message" class="mt-6 rounded-3xl border border-red-600 bg-red-950/90 p-4 text-sm text-red-300">
                    {{ message }}
                </div>

                <ul v-if="errors" class="mt-4 space-y-2 text-sm text-red-300">
                    <li v-for="(messages, field) in errors" :key="field" class="rounded-2xl bg-slate-950/80 p-3">
                        <span class="font-semibold text-slate-200">{{ field }}:</span>
                        <span class="ml-2">{{ messages.join(', ') }}</span>
                    </li>
                </ul>
            </section>

            <aside class="rounded-[2rem] border border-slate-800 bg-slate-900 p-10 shadow-2xl ring-1 ring-slate-800">
                <h2 class="text-2xl font-semibold text-white">Welcome to the support system</h2>
                <p class="mt-4 text-slate-400">Whether you are managing the platform or requesting help, your account is ready in seconds.</p>

                <div class="mt-8 space-y-5 text-slate-300">
                    <div class="rounded-3xl bg-slate-950/50 p-4">
                        <p class="font-semibold">Secure access</p>
                        <p class="mt-2 text-sm text-slate-400">Our registration flow creates a secure token for API access and protects your session with Sanctum.</p>
                    </div>
                    <div class="rounded-3xl bg-slate-950/50 p-4">
                        <p class="font-semibold">Role-based routing</p>
                        <p class="mt-2 text-sm text-slate-400">Customers and admins are redirected automatically after registration.</p>
                    </div>
                    <div class="rounded-3xl bg-slate-950/50 p-4">
                        <p class="font-semibold">Clean interface</p>
                        <p class="mt-2 text-sm text-slate-400">A modern dashboard experience makes it easy to get started.</p>
                    </div>
                </div>

                <p class="mt-10 text-sm text-slate-500">Already have an account? <router-link to="/login" class="font-semibold text-indigo-400 hover:text-indigo-300">Sign in</router-link></p>
            </aside>
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

const form = reactive({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    role: 'customer',
});

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
        await auth.register(form);
        router.push(getHomeRoute());
    } catch (error) {
        errors.value = auth.errors || error.response?.data?.errors || null;
        message.value = auth.message || error.response?.data?.message || 'Registration failed.';
    }
};
</script>
