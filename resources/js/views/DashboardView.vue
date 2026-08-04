<template>
  <div class="space-y-6">
    <section class="rounded-[2rem] border border-slate-800 bg-slate-900 p-8 shadow-2xl shadow-slate-950/40">
      <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
          <p class="text-sm uppercase tracking-[0.35em] text-sky-400">Overview</p>
          <h2 class="mt-2 text-3xl font-semibold text-white">{{ dashboardTitle }}</h2>
          <p class="mt-3 max-w-2xl text-slate-400">{{ dashboardSubtitle }}</p>
        </div>
        <div class="rounded-full border border-slate-700 bg-slate-950 px-4 py-2 text-sm text-slate-300">
          {{ roleLabel }} workspace
        </div>
      </div>
    </section>

    <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
      <article v-for="stat in stats" :key="stat.label" class="rounded-[1.5rem] border border-slate-800 bg-slate-900 p-5 shadow-lg shadow-slate-950/30">
        <p class="text-sm text-slate-400">{{ stat.label }}</p>
        <div class="mt-3 flex items-end justify-between">
          <span class="text-3xl font-semibold text-white">{{ stat.value }}</span>
          <span class="rounded-full bg-slate-800 px-2 py-1 text-xs text-slate-300">{{ stat.helper }}</span>
        </div>
      </article>
    </section>

    <section class="grid gap-6 lg:grid-cols-[1fr_1fr]">
      <article class="rounded-[1.5rem] border border-slate-800 bg-slate-900 p-6">
        <div class="mb-4 flex items-center justify-between">
          <h3 class="text-lg font-semibold text-white">Quick actions</h3>
          <span class="text-xs text-slate-400">Live access</span>
        </div>
        <div class="grid gap-3 sm:grid-cols-2">
          <router-link to="/chats" class="rounded-[1.2rem] bg-indigo-600 px-4 py-4 text-center text-sm font-medium text-white hover:bg-indigo-500">Open chats</router-link>
          <router-link to="/profile" class="rounded-[1.2rem] border border-slate-700 bg-slate-800 px-4 py-4 text-center text-sm font-medium text-white hover:bg-slate-700">Profile</router-link>
          <router-link v-if="auth.user?.role === 'admin'" to="/admin/users" class="rounded-[1.2rem] border border-slate-700 bg-emerald-600 px-4 py-4 text-center text-sm font-medium text-white hover:bg-emerald-500">Manage users</router-link>
          <router-link v-if="auth.user?.role === 'customer'" to="/customer/dashboard" class="rounded-[1.2rem] border border-slate-700 bg-sky-600 px-4 py-4 text-center text-sm font-medium text-white hover:bg-sky-500">Customer hub</router-link>
        </div>
      </article>

      <article class="rounded-[1.5rem] border border-slate-800 bg-slate-900 p-6">
        <h3 class="text-lg font-semibold text-white">Realtime snapshot</h3>
        <div class="mt-4 space-y-3 text-sm text-slate-300">
          <div class="flex items-center justify-between rounded-[1rem] bg-slate-950 px-4 py-3">
            <span>Active online users</span>
            <strong class="text-white">{{ statsMap.onlineUsers }}</strong>
          </div>
          <div class="flex items-center justify-between rounded-[1rem] bg-slate-950 px-4 py-3">
            <span>Unread conversation count</span>
            <strong class="text-white">{{ statsMap.unreadCount }}</strong>
          </div>
          <div class="flex items-center justify-between rounded-[1rem] bg-slate-950 px-4 py-3">
            <span>Conversations in workspace</span>
            <strong class="text-white">{{ statsMap.conversations }}</strong>
          </div>
        </div>
      </article>
    </section>
  </div>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';
import api from '../services/api';
import { useAuthStore } from '../stores/auth';

const auth = useAuthStore();
const loading = ref(false);
const userCount = ref(0);
const conversationCount = ref(0);
const onlineCount = ref(0);
const unreadCount = ref(0);

const roleLabel = computed(() => {
  if (auth.user?.role === 'admin') return 'Admin';
  if (auth.user?.role === 'support_agent') return 'Support agent';
  return 'Customer';
});

const dashboardTitle = computed(() => {
  if (auth.user?.role === 'admin') return 'Admin control center';
  if (auth.user?.role === 'support_agent') return 'Support operations dashboard';
  return 'Customer support dashboard';
});

const dashboardSubtitle = computed(() => {
  if (auth.user?.role === 'admin') return 'Monitor team health, active users, and support activity at a glance.';
  if (auth.user?.role === 'support_agent') return 'Track conversations, online activity, and customer interactions in one place.';
  return 'Monitor your conversations and keep up with the latest support replies.';
});

const statsMap = computed(() => ({
  onlineUsers: onlineCount.value,
  unreadCount: unreadCount.value,
  conversations: conversationCount.value,
}));

const stats = computed(() => {
  if (auth.user?.role === 'admin') {
    return [
      { label: 'Total users', value: userCount.value, helper: 'Accounts' },
      { label: 'Active users', value: onlineCount.value, helper: 'Online now' },
      { label: 'Open conversations', value: conversationCount.value, helper: 'Threads' },
      { label: 'Unread messages', value: unreadCount.value, helper: 'Pending' },
    ];
  }

  return [
    { label: 'Conversations', value: conversationCount.value, helper: 'Open' },
    { label: 'Unread', value: unreadCount.value, helper: 'New' },
    { label: 'Support members', value: onlineCount.value, helper: 'Online' },
    { label: 'Role', value: roleLabel.value, helper: 'Portal' },
  ];
});

onMounted(async () => {
  loading.value = true;

  try {
    const [usersResponse, conversationsResponse, unreadResponse, onlineResponse] = await Promise.all([
      api.get('/admin/users'),
      api.get('/conversations'),
      api.get('/unread'),
      api.get('/online-status'),
    ]);

    const users = usersResponse.data.users?.data ?? usersResponse.data.users ?? [];
    const conversations = conversationsResponse.data.conversations ?? [];
    const onlineStatuses = onlineResponse.data.online_statuses ?? [];

    userCount.value = Array.isArray(users) ? users.length : users.total ?? 0;
    conversationCount.value = Array.isArray(conversations) ? conversations.length : conversations.total ?? 0;
    onlineCount.value = Array.isArray(onlineStatuses) ? onlineStatuses.length : 0;
    unreadCount.value = unreadResponse.data.unread_count ?? 0;
  } catch {
    userCount.value = 0;
    conversationCount.value = 0;
    onlineCount.value = 0;
    unreadCount.value = 0;
  } finally {
    loading.value = false;
  }
});
</script>
