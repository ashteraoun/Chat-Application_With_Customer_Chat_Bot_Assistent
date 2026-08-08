<template>
  <div class="space-y-8 animate-fade-in">
    <!-- Hero Section with Gradient -->
    <section class="relative overflow-hidden rounded-[2rem] border border-slate-800 bg-gradient-to-br from-slate-900 via-slate-900 to-indigo-950/30 p-8 shadow-2xl shadow-indigo-950/20">
      <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-indigo-500/10 blur-3xl"></div>
      <div class="absolute -bottom-20 -left-20 h-64 w-64 rounded-full bg-sky-500/10 blur-3xl"></div>
      
      <div class="relative flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
          <div class="flex items-center gap-3">
            <span class="inline-flex h-2 w-2 animate-pulse rounded-full bg-emerald-400"></span>
            <p class="text-sm uppercase tracking-[0.35em] text-indigo-400">Live Dashboard</p>
          </div>
          <h2 class="mt-3 text-4xl font-bold text-white bg-gradient-to-r from-white to-indigo-200 bg-clip-text text-transparent">
            {{ dashboardTitle }}
          </h2>
          <p class="mt-3 max-w-2xl text-slate-400">{{ dashboardSubtitle }}</p>
        </div>
        <div class="flex items-center gap-3">
          <div class="rounded-full border border-indigo-500/30 bg-indigo-500/10 px-5 py-2.5 text-sm font-medium text-indigo-300 backdrop-blur-sm">
            <span class="mr-2">👋</span>
            {{ roleLabel }} workspace
          </div>
          <button @click="refreshData" class="rounded-full border border-slate-700 bg-slate-800/50 px-4 py-2.5 text-sm text-slate-300 transition-all hover:border-indigo-500 hover:bg-indigo-500/10 hover:text-white backdrop-blur-sm">
            <span class="mr-2">⟳</span> Refresh
          </button>
        </div>
      </div>
    </section>

    <!-- Stats Cards with Hover Effects -->
    <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
      <article 
        v-for="(stat, index) in stats" 
        :key="stat.label"
        class="group relative overflow-hidden rounded-[1.5rem] border border-slate-800 bg-gradient-to-br from-slate-900 to-slate-900/80 p-6 shadow-lg shadow-slate-950/30 transition-all duration-300 hover:-translate-y-1 hover:border-indigo-500/50 hover:shadow-indigo-500/10"
        :style="{ animationDelay: `${index * 100}ms` }"
      >
        <div class="absolute -right-12 -top-12 h-32 w-32 rounded-full bg-indigo-500/5 blur-2xl transition-all group-hover:bg-indigo-500/10"></div>
        
        <div class="relative">
          <div class="flex items-center justify-between">
            <p class="text-sm font-medium text-slate-400">{{ stat.label }}</p>
            <span class="rounded-full bg-slate-800 px-3 py-1 text-xs font-medium text-slate-300 transition-colors group-hover:bg-indigo-500/20 group-hover:text-indigo-300">
              {{ stat.helper }}
            </span>
          </div>
          <div class="mt-4 flex items-end justify-between">
            <span class="text-4xl font-bold text-white transition-colors group-hover:text-indigo-300">
              {{ stat.value }}
            </span>
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-500/10 text-indigo-400 opacity-0 transition-all group-hover:opacity-100">
              <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
              </svg>
            </div>
          </div>
        </div>
      </article>
    </section>

    <!-- Actions and Snapshot Grid -->
    <section class="grid gap-6 lg:grid-cols-[1.4fr_1fr]">
      <!-- Quick Actions -->
      <article class="group relative overflow-hidden rounded-[1.5rem] border border-slate-800 bg-gradient-to-br from-slate-900 to-slate-900/80 p-6 transition-all hover:border-indigo-500/30">
        <div class="absolute -right-20 -top-20 h-48 w-48 rounded-full bg-indigo-500/5 blur-3xl group-hover:bg-indigo-500/10"></div>
        
        <div class="relative">
          <div class="mb-5 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-white flex items-center gap-2">
              <span class="inline-block h-2 w-2 rounded-full bg-indigo-400"></span>
              Quick actions
            </h3>
            <span class="flex items-center gap-2 rounded-full bg-emerald-500/10 px-3 py-1 text-xs text-emerald-400">
              <span class="inline-block h-1.5 w-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
              Live access
            </span>
          </div>
          <div class="grid gap-3 sm:grid-cols-2">
            <router-link 
              to="/chats" 
              class="group/btn relative overflow-hidden rounded-[1.2rem] bg-gradient-to-r from-indigo-600 to-indigo-500 px-5 py-4 text-center text-sm font-medium text-white transition-all hover:shadow-lg hover:shadow-indigo-500/25 hover:scale-[1.02]"
            >
              <span class="relative z-10 flex items-center justify-center gap-2">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                Open chats
              </span>
              <div class="absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/20 to-transparent transition-transform group-hover/btn:translate-x-full"></div>
            </router-link>
            
            <router-link 
              to="/profile" 
              class="group/btn relative overflow-hidden rounded-[1.2rem] border border-slate-700 bg-slate-800/50 px-5 py-4 text-center text-sm font-medium text-white transition-all hover:border-indigo-500/50 hover:bg-slate-800 hover:shadow-lg hover:shadow-indigo-500/10"
            >
              <span class="relative z-10 flex items-center justify-center gap-2">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Profile
              </span>
            </router-link>
            
            <router-link 
              v-if="auth.user?.role === 'admin'" 
              to="/admin/users" 
              class="group/btn relative overflow-hidden rounded-[1.2rem] bg-gradient-to-r from-emerald-600 to-emerald-500 px-5 py-4 text-center text-sm font-medium text-white transition-all hover:shadow-lg hover:shadow-emerald-500/25 hover:scale-[1.02]"
            >
              <span class="relative z-10 flex items-center justify-center gap-2">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                Manage users
              </span>
              <div class="absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/20 to-transparent transition-transform group-hover/btn:translate-x-full"></div>
            </router-link>
            
            <router-link 
              v-if="auth.user?.role === 'customer'" 
              to="/customer/dashboard" 
              class="group/btn relative overflow-hidden rounded-[1.2rem] bg-gradient-to-r from-sky-600 to-sky-500 px-5 py-4 text-center text-sm font-medium text-white transition-all hover:shadow-lg hover:shadow-sky-500/25 hover:scale-[1.02]"
            >
              <span class="relative z-10 flex items-center justify-center gap-2">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Customer hub
              </span>
              <div class="absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/20 to-transparent transition-transform group-hover/btn:translate-x-full"></div>
            </router-link>
          </div>
        </div>
      </article>

      <!-- Real-time Snapshot -->
      <article class="group relative overflow-hidden rounded-[1.5rem] border border-slate-800 bg-gradient-to-br from-slate-900 to-slate-900/80 p-6 transition-all hover:border-indigo-500/30">
        <div class="absolute -left-20 -bottom-20 h-48 w-48 rounded-full bg-sky-500/5 blur-3xl group-hover:bg-sky-500/10"></div>
        
        <div class="relative">
          <h3 class="mb-5 text-lg font-semibold text-white flex items-center gap-2">
            <span class="inline-block h-2 w-2 rounded-full bg-sky-400"></span>
            Real-time snapshot
          </h3>
          <div class="space-y-3 text-sm">
            <div class="group/item flex items-center justify-between rounded-[1rem] bg-slate-950/50 px-5 py-3.5 transition-all hover:bg-slate-950 hover:border hover:border-indigo-500/20">
              <span class="flex items-center gap-3 text-slate-300">
                <span class="inline-block h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                Active online users
              </span>
              <strong class="text-xl font-bold text-white transition-colors group-hover/item:text-indigo-300">
                {{ statsMap.onlineUsers }}
              </strong>
            </div>
            <div class="group/item flex items-center justify-between rounded-[1rem] bg-slate-950/50 px-5 py-3.5 transition-all hover:bg-slate-950 hover:border hover:border-indigo-500/20">
              <span class="flex items-center gap-3 text-slate-300">
                <span class="inline-block h-2 w-2 rounded-full bg-amber-400"></span>
                Unread conversations
              </span>
              <strong class="text-xl font-bold text-white transition-colors group-hover/item:text-amber-300">
                {{ statsMap.unreadCount }}
              </strong>
            </div>
            <div class="group/item flex items-center justify-between rounded-[1rem] bg-slate-950/50 px-5 py-3.5 transition-all hover:bg-slate-950 hover:border hover:border-indigo-500/20">
              <span class="flex items-center gap-3 text-slate-300">
                <span class="inline-block h-2 w-2 rounded-full bg-indigo-400"></span>
                Active conversations
              </span>
              <strong class="text-xl font-bold text-white transition-colors group-hover/item:text-indigo-300">
                {{ statsMap.conversations }}
              </strong>
            </div>
          </div>
        </div>
      </article>
    </section>

    <!-- Loading Overlay -->
    <div v-if="loading" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/50 backdrop-blur-sm">
      <div class="flex flex-col items-center gap-4 rounded-2xl bg-slate-900 p-8 border border-slate-800">
        <div class="h-12 w-12 animate-spin rounded-full border-4 border-indigo-500/30 border-t-indigo-500"></div>
        <p class="text-sm text-slate-400">Loading dashboard data...</p>
      </div>
    </div>
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
  if (auth.user?.role === 'support_agent') return 'Support Agent';
  return 'Customer';
});

const dashboardTitle = computed(() => {
  if (auth.user?.role === 'admin') return 'Admin Control Center';
  if (auth.user?.role === 'support_agent') return 'Support Operations';
  return 'Customer Dashboard';
});

const dashboardSubtitle = computed(() => {
  if (auth.user?.role === 'admin') return 'Monitor team performance, user activity, and support metrics in real-time.';
  if (auth.user?.role === 'support_agent') return 'Track conversations, customer interactions, and team availability at a glance.';
  return 'Stay updated with your conversations and support ticket status.';
});

const statsMap = computed(() => ({
  onlineUsers: onlineCount.value,
  unreadCount: unreadCount.value,
  conversations: conversationCount.value,
}));

const stats = computed(() => {
  if (auth.user?.role === 'admin') {
    return [
      { label: 'Total Users', value: userCount.value, helper: 'Accounts' },
      { label: 'Active Now', value: onlineCount.value, helper: 'Online' },
      { label: 'Open Conversations', value: conversationCount.value, helper: 'Threads' },
      { label: 'Unread Messages', value: unreadCount.value, helper: 'Pending' },
    ];
  }

  return [
    { label: 'Conversations', value: conversationCount.value, helper: 'Open' },
    { label: 'Unread', value: unreadCount.value, helper: 'New' },
    { label: 'Team Online', value: onlineCount.value, helper: 'Available' },
    { label: 'Role', value: roleLabel.value, helper: 'Access' },
  ];
});

const refreshData = async () => {
  await fetchDashboardData();
};

const fetchDashboardData = async () => {
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
  } catch (error) {
    console.error('Failed to fetch dashboard data:', error);
    userCount.value = 0;
    conversationCount.value = 0;
    onlineCount.value = 0;
    unreadCount.value = 0;
  } finally {
    loading.value = false;
  }
};

onMounted(async () => {
  await fetchDashboardData();
});
</script>

<style scoped>
@keyframes fade-in {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate-fade-in {
  animation: fade-in 0.6s ease-out forwards;
}

/* Smooth hover transitions */
.group\/btn {
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Card entrance animations */
article {
  opacity: 0;
  animation: fade-in 0.6s ease-out forwards;
}

/* Staggered animation delays for stats cards */
article:nth-child(1) { animation-delay: 0.1s; }
article:nth-child(2) { animation-delay: 0.2s; }
article:nth-child(3) { animation-delay: 0.3s; }
article:nth-child(4) { animation-delay: 0.4s; }
</style>