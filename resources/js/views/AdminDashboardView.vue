<template>
  <div class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 p-6">
    <div class="mx-auto max-w-6xl space-y-8">
      <!-- Header Section -->
      <div class="relative overflow-hidden rounded-2xl border border-slate-700/50 bg-slate-800/50 p-8 backdrop-blur-sm">
        <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-indigo-500/10 blur-3xl"></div>
        <div class="absolute -bottom-20 -left-20 h-64 w-64 rounded-full bg-emerald-500/10 blur-3xl"></div>
        
        <div class="relative flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
          <div>
            <div class="flex items-center gap-3">
              <div class="rounded-lg bg-indigo-500/20 p-2">
                <svg class="h-6 w-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
              </div>
              <h1 class="text-3xl font-bold text-white">Admin Dashboard</h1>
            </div>
            <p class="mt-2 text-slate-400">Welcome back, Admin! Here's your control panel overview.</p>
          </div>
          <div class="flex items-center gap-3">
            <span class="inline-flex items-center rounded-full bg-emerald-500/20 px-3 py-1 text-xs font-medium text-emerald-400">
              <span class="mr-1.5 h-2 w-2 rounded-full bg-emerald-400"></span>
              Online
            </span>
          </div>
        </div>
      </div>

      <!-- Stats Cards -->
      <div class="grid gap-4 sm:grid-cols-3">
        <div class="rounded-xl border border-slate-700/50 bg-slate-800/30 p-6 backdrop-blur-sm">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-medium text-slate-400">Total Users</p>
              <p class="mt-2 text-3xl font-bold text-white">2,847</p>
              <p class="mt-1 text-xs text-emerald-400">↑ 12% this month</p>
            </div>
            <div class="rounded-lg bg-indigo-500/20 p-3">
              <svg class="h-6 w-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
              </svg>
            </div>
          </div>
        </div>

        <div class="rounded-xl border border-slate-700/50 bg-slate-800/30 p-6 backdrop-blur-sm">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-medium text-slate-400">Active Chats</p>
              <p class="mt-2 text-3xl font-bold text-white">143</p>
              <p class="mt-1 text-xs text-emerald-400">↑ 8% this week</p>
            </div>
            <div class="rounded-lg bg-emerald-500/20 p-3">
              <svg class="h-6 w-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
              </svg>
            </div>
          </div>
        </div>

        <div class="rounded-xl border border-slate-700/50 bg-slate-800/30 p-6 backdrop-blur-sm">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-medium text-slate-400">Pending Actions</p>
              <p class="mt-2 text-3xl font-bold text-white">12</p>
              <p class="mt-1 text-xs text-amber-400">↑ 3 need attention</p>
            </div>
            <div class="rounded-lg bg-amber-500/20 p-3">
              <svg class="h-6 w-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
          </div>
        </div>
      </div>

      <!-- Action Cards -->
      <div class="grid gap-6 md:grid-cols-3">
        <router-link 
          to="/admin/users" 
          class="group relative overflow-hidden rounded-xl border border-slate-700/50 bg-gradient-to-br from-indigo-600/90 to-indigo-700/90 p-8 transition-all duration-300 hover:scale-105 hover:shadow-2xl hover:shadow-indigo-500/20"
        >
          <div class="absolute inset-0 bg-gradient-to-br from-indigo-400/20 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
          <div class="relative">
            <div class="mb-4 flex items-center justify-between">
              <div class="rounded-lg bg-white/20 p-3 backdrop-blur-sm">
                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
              </div>
              <svg class="h-6 w-6 text-white/50 transition-transform duration-300 group-hover:translate-x-1 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
              </svg>
            </div>
            <h3 class="text-xl font-semibold text-white">Manage Users</h3>
            <p class="mt-2 text-indigo-100/80">View, edit, and manage user accounts</p>
          </div>
        </router-link>

        <router-link 
          to="/chats" 
          class="group relative overflow-hidden rounded-xl border border-slate-700/50 bg-gradient-to-br from-emerald-600/90 to-emerald-700/90 p-8 transition-all duration-300 hover:scale-105 hover:shadow-2xl hover:shadow-emerald-500/20"
        >
          <div class="absolute inset-0 bg-gradient-to-br from-emerald-400/20 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
          <div class="relative">
            <div class="mb-4 flex items-center justify-between">
              <div class="rounded-lg bg-white/20 p-3 backdrop-blur-sm">
                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                </svg>
              </div>
              <svg class="h-6 w-6 text-white/50 transition-transform duration-300 group-hover:translate-x-1 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
              </svg>
            </div>
            <h3 class="text-xl font-semibold text-white">Open Chats</h3>
            <p class="mt-2 text-emerald-100/80">Monitor and respond to active conversations</p>
          </div>
        </router-link>

        <router-link 
          to="/profile" 
          class="group relative overflow-hidden rounded-xl border border-slate-700/50 bg-gradient-to-br from-slate-700/90 to-slate-800/90 p-8 transition-all duration-300 hover:scale-105 hover:shadow-2xl hover:shadow-slate-500/20"
        >
          <div class="absolute inset-0 bg-gradient-to-br from-slate-400/20 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
          <div class="relative">
            <div class="mb-4 flex items-center justify-between">
              <div class="rounded-lg bg-white/20 p-3 backdrop-blur-sm">
                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
              </div>
              <svg class="h-6 w-6 text-white/50 transition-transform duration-300 group-hover:translate-x-1 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
              </svg>
            </div>
            <h3 class="text-xl font-semibold text-white">Edit Profile</h3>
            <p class="mt-2 text-slate-300/80">Update your account settings and preferences</p>
          </div>
        </router-link>
      </div>

      <!-- Footer -->
      <div class="mt-8 text-center text-sm text-slate-500">
        <p>🔒 This area is protected for administrator accounts</p>
      </div>
    </div>
  </div>
</template>

<style scoped>
/* Smooth transitions for all interactive elements */
* {
  transition: all 0.2s ease-in-out;
}

/* Custom scrollbar for the dashboard */
::-webkit-scrollbar {
  width: 8px;
}

::-webkit-scrollbar-track {
  background: rgb(30, 41, 59);
  border-radius: 4px;
}

::-webkit-scrollbar-thumb {
  background: rgb(51, 65, 85);
  border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
  background: rgb(71, 85, 105);
}
</style>