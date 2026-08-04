<template>
    <div class="rounded-2xl border border-slate-800 bg-slate-900 p-8">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-semibold">User management</h2>
                <p class="mt-2 text-slate-400">Manage admins, agents, and customers.</p>
            </div>
        </div>

        <div v-if="loading" class="mt-6 rounded-xl border border-slate-800 bg-slate-950/70 p-4 text-sm text-slate-300">
            Loading users...
        </div>

        <div v-else-if="error" class="mt-6 rounded-xl border border-red-700 bg-red-950/70 p-4 text-sm text-red-200">
            {{ error }}
        </div>

        <div v-else class="mt-6 overflow-hidden rounded-xl border border-slate-800">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-slate-800 text-slate-300">
                    <tr>
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Role</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users" :key="user.id" class="border-t border-slate-800">
                        <td class="px-4 py-3">{{ user.name }}</td>
                        <td class="px-4 py-3">{{ user.email }}</td>
                        <td class="px-4 py-3">{{ user.role }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import api from '../services/api';

const users = ref([]);
const loading = ref(false);
const error = ref(null);

onMounted(async () => {
    loading.value = true;
    error.value = null;

    try {
        const { data } = await api.get('/admin/users');
        users.value = data.users?.data ?? data.users ?? [];
    } catch (responseError) {
        error.value = responseError.response?.data?.message || 'Unable to load users.';
    } finally {
        loading.value = false;
    }
});
</script>
