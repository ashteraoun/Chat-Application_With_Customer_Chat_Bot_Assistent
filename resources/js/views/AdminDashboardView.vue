<template>
  <div class="admin-dashboard">
    <!-- Header Section -->
    <div class="dashboard-header">
      <div class="header-content">
        <div class="header-left">
          <div class="icon-wrapper">
            <svg class="shield-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
          </div>
          <div>
            <h1 class="dashboard-title">Admin Dashboard</h1>
            <p class="dashboard-subtitle">Welcome back, Administrator</p>
          </div>
        </div>
        <div class="header-right">
          <span class="status-badge">
            <span class="status-dot"></span>
            Online
          </span>
        </div>
      </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-icon users-icon">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
          </svg>
        </div>
        <div class="stat-info">
          <p class="stat-label">Total Users</p>
          <p class="stat-value">1,284</p>
          <p class="stat-change positive">↑ 12% this month</p>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-icon chats-icon">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
          </svg>
        </div>
        <div class="stat-info">
          <p class="stat-label">Active Chats</p>
          <p class="stat-value">47</p>
          <p class="stat-change positive">↑ 8% this week</p>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-icon profile-icon">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
          </svg>
        </div>
        <div class="stat-info">
          <p class="stat-label">Profile Views</p>
          <p class="stat-value">342</p>
          <p class="stat-change">↑ 5% this week</p>
        </div>
      </div>
    </div>

    <!-- Action Cards -->
    <div class="actions-section">
      <h2 class="section-title">Quick Actions</h2>
      <div class="actions-grid">
        <router-link to="/admin/users" class="action-card action-users">
          <div class="action-icon-wrapper">
            <svg class="action-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
          </div>
          <div class="action-content">
            <h3 class="action-title">Manage Users</h3>
            <p class="action-description">View and manage user accounts</p>
            <span class="action-arrow">→</span>
          </div>
        </router-link>

        <router-link to="/chats" class="action-card action-chats">
          <div class="action-icon-wrapper">
            <svg class="action-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
          </div>
          <div class="action-content">
            <h3 class="action-title">Open Chats</h3>
            <p class="action-description">View active chat conversations</p>
            <span class="action-arrow">→</span>
          </div>
        </router-link>

        <router-link to="/profile" class="action-card action-profile">
          <div class="action-icon-wrapper">
            <svg class="action-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
          </div>
          <div class="action-content">
            <h3 class="action-title">Edit Profile</h3>
            <p class="action-description">Update your personal information</p>
            <span class="action-arrow">→</span>
          </div>
        </router-link>
      </div>
    </div>
  </div>
</template>

<style scoped>
.admin-dashboard {
  @apply max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8;
}

/* Header */
.dashboard-header {
  @apply bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl p-6 mb-8 shadow-xl;
}

.header-content {
  @apply flex items-center justify-between flex-wrap gap-4;
}

.header-left {
  @apply flex items-center gap-4;
}

.icon-wrapper {
  @apply bg-white/20 backdrop-blur-sm p-3 rounded-xl;
}

.shield-icon {
  @apply w-8 h-8 text-white;
}

.dashboard-title {
  @apply text-2xl md:text-3xl font-bold text-white;
}

.dashboard-subtitle {
  @apply text-indigo-100 text-sm md:text-base;
}

.header-right {
  @apply flex items-center;
}

.status-badge {
  @apply flex items-center gap-2 bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full text-white text-sm font-medium;
}

.status-dot {
  @apply w-2.5 h-2.5 bg-emerald-400 rounded-full animate-pulse;
}

/* Stats Grid */
.stats-grid {
  @apply grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8;
}

.stat-card {
  @apply bg-white dark:bg-slate-800 rounded-xl p-6 shadow-lg border border-slate-200 dark:border-slate-700 hover:shadow-xl transition-all duration-300 hover:-translate-y-1;
}

.stat-icon {
  @apply w-12 h-12 rounded-xl flex items-center justify-center mb-3;
}

.users-icon {
  @apply bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400;
}

.chats-icon {
  @apply bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400;
}

.profile-icon {
  @apply bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400;
}

.stat-info {
  @apply flex flex-col;
}

.stat-label {
  @apply text-sm text-slate-600 dark:text-slate-400 font-medium;
}

.stat-value {
  @apply text-2xl font-bold text-slate-900 dark:text-white;
}

.stat-change {
  @apply text-xs font-medium mt-1;
}

.stat-change.positive {
  @apply text-emerald-600 dark:text-emerald-400;
}

.stat-change:not(.positive) {
  @apply text-slate-500 dark:text-slate-400;
}

/* Actions Section */
.actions-section {
  @apply mt-8;
}

.section-title {
  @apply text-xl font-semibold text-slate-900 dark:text-white mb-4;
}

.actions-grid {
  @apply grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4;
}

.action-card {
  @apply relative overflow-hidden rounded-xl p-6 shadow-lg border transition-all duration-300 hover:shadow-xl hover:-translate-y-1 group;
}

.action-users {
  @apply bg-gradient-to-br from-blue-500 to-blue-600 border-blue-400 text-white;
}

.action-chats {
  @apply bg-gradient-to-br from-emerald-500 to-emerald-600 border-emerald-400 text-white;
}

.action-profile {
  @apply bg-gradient-to-br from-purple-500 to-purple-600 border-purple-400 text-white;
}

.action-icon-wrapper {
  @apply bg-white/20 backdrop-blur-sm w-14 h-14 rounded-xl flex items-center justify-center mb-4 transition-transform duration-300 group-hover:scale-110;
}

.action-icon {
  @apply w-7 h-7 text-white;
}

.action-content {
  @apply relative;
}

.action-title {
  @apply text-lg font-semibold mb-1;
}

.action-description {
  @apply text-sm opacity-90;
}

.action-arrow {
  @apply absolute top-0 right-0 text-xl opacity-0 transform translate-x-2 transition-all duration-300 group-hover:opacity-100 group-hover:translate-x-0;
}

/* Responsive */
@media (max-width: 640px) {
  .header-content {
    @apply flex-col items-start;
  }
  
  .header-right {
    @apply w-full;
  }
  
  .status-badge {
    @apply w-full justify-center;
  }
}
</style>