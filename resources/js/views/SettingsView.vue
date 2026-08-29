<template>
  <div class="relative overflow-hidden rounded-3xl border border-slate-700/50 bg-gradient-to-br from-slate-900 to-slate-950 p-8 shadow-2xl shadow-black/50 backdrop-blur-sm">
    <!-- Decorative elements -->
    <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-indigo-500/10 blur-3xl"></div>
    <div class="absolute -bottom-20 -left-20 h-64 w-64 rounded-full bg-purple-500/10 blur-3xl"></div>
    
    <!-- Header -->
    <div class="relative mb-8 flex items-start justify-between">
      <div>
        <div class="flex items-center gap-3">
          <div class="rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-500 p-2.5 shadow-lg shadow-indigo-500/20">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
          </div>
          <div>
            <h2 class="text-3xl font-bold text-white">
              <span class="bg-gradient-to-r from-indigo-400 to-purple-400 bg-clip-text text-transparent">Settings</span>
            </h2>
            <p class="mt-1 text-sm text-slate-400">Manage your chat preferences, notifications, and account settings</p>
          </div>
        </div>
      </div>
      <button class="rounded-full bg-slate-800/50 p-2 text-slate-400 transition-all hover:bg-slate-700 hover:text-white">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
      </button>
    </div>

    <!-- Settings Cards -->
    <div class="relative grid gap-4 sm:grid-cols-2">
      <!-- Notifications Card -->
      <div class="group relative overflow-hidden rounded-2xl border border-slate-700/50 bg-slate-950/70 p-6 transition-all hover:border-indigo-500/50 hover:bg-slate-950/90 hover:shadow-lg hover:shadow-indigo-500/5">
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/0 to-purple-500/0 opacity-0 transition-opacity group-hover:opacity-100"></div>
        
        <div class="relative flex items-start gap-4">
          <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-indigo-500/10 text-indigo-400 transition-colors group-hover:bg-indigo-500/20">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
          </div>
          <div class="flex-1">
            <div class="flex items-center justify-between">
              <h3 class="text-lg font-semibold text-white group-hover:text-indigo-300 transition-colors">Notifications</h3>
              <span class="rounded-full bg-emerald-500/15 px-2.5 py-0.5 text-xs font-medium text-emerald-300">2 active</span>
            </div>
            <p class="mt-2 text-sm text-slate-400">Enable or disable chat notifications and sounds</p>
            <div class="mt-4 flex items-center gap-4">
              <button class="rounded-full bg-indigo-600/20 px-4 py-1.5 text-xs font-medium text-indigo-300 transition-all hover:bg-indigo-600 hover:text-white">
                Configure
              </button>
              <span class="flex items-center gap-1.5 text-xs text-slate-500">
                <span class="relative flex h-2 w-2">
                  <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"></span>
                  <span class="relative inline-flex h-2 w-2 rounded-full bg-emerald-400"></span>
                </span>
                Active
              </span>
            </div>
          </div>
        </div>
      </div>

      <!-- Privacy Card -->
      <div class="group relative overflow-hidden rounded-2xl border border-slate-700/50 bg-slate-950/70 p-6 transition-all hover:border-purple-500/50 hover:bg-slate-950/90 hover:shadow-lg hover:shadow-purple-500/5">
        <div class="absolute inset-0 bg-gradient-to-br from-purple-500/0 to-indigo-500/0 opacity-0 transition-opacity group-hover:opacity-100"></div>
        
        <div class="relative flex items-start gap-4">
          <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-purple-500/10 text-purple-400 transition-colors group-hover:bg-purple-500/20">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
          </div>
          <div class="flex-1">
            <div class="flex items-center justify-between">
              <h3 class="text-lg font-semibold text-white group-hover:text-purple-300 transition-colors">Privacy</h3>
              <span class="rounded-full bg-slate-700/50 px-2.5 py-0.5 text-xs font-medium text-slate-400">Secure</span>
            </div>
            <p class="mt-2 text-sm text-slate-400">Control your online presence and read receipt preferences</p>
            <div class="mt-4 flex items-center gap-4">
              <button class="rounded-full bg-purple-600/20 px-4 py-1.5 text-xs font-medium text-purple-300 transition-all hover:bg-purple-600 hover:text-white">
                Manage
              </button>
              <span class="flex items-center gap-1.5 text-xs text-slate-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                </svg>
                Protected
              </span>
            </div>
          </div>
        </div>
      </div>

      <!-- Additional Card - Appearance -->
      <div class="group relative overflow-hidden rounded-2xl border border-slate-700/50 bg-slate-950/70 p-6 transition-all hover:border-cyan-500/50 hover:bg-slate-950/90 hover:shadow-lg hover:shadow-cyan-500/5">
        <div class="absolute inset-0 bg-gradient-to-br from-cyan-500/0 to-blue-500/0 opacity-0 transition-opacity group-hover:opacity-100"></div>
        
        <div class="relative flex items-start gap-4">
          <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-cyan-500/10 text-cyan-400 transition-colors group-hover:bg-cyan-500/20">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
            </svg>
          </div>
          <div class="flex-1">
            <div class="flex items-center justify-between">
              <h3 class="text-lg font-semibold text-white group-hover:text-cyan-300 transition-colors">Appearance</h3>
              <span class="rounded-full bg-slate-700/50 px-2.5 py-0.5 text-xs font-medium text-slate-400">Theme</span>
            </div>
            <p class="mt-2 text-sm text-slate-400">Customize the chat interface and theme preferences</p>
            <div class="mt-4 flex items-center gap-4">
              <button class="rounded-full bg-cyan-600/20 px-4 py-1.5 text-xs font-medium text-cyan-300 transition-all hover:bg-cyan-600 hover:text-white">
                Customize
              </button>
              <span class="flex items-center gap-1.5 text-xs text-slate-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                </svg>
                Dark mode
              </span>
            </div>
          </div>
        </div>
      </div>

      <!-- Additional Card - Security -->
      <div class="group relative overflow-hidden rounded-2xl border border-slate-700/50 bg-slate-950/70 p-6 transition-all hover:border-rose-500/50 hover:bg-slate-950/90 hover:shadow-lg hover:shadow-rose-500/5">
        <div class="absolute inset-0 bg-gradient-to-br from-rose-500/0 to-orange-500/0 opacity-0 transition-opacity group-hover:opacity-100"></div>
        
        <div class="relative flex items-start gap-4">
          <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-rose-500/10 text-rose-400 transition-colors group-hover:bg-rose-500/20">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
          </div>
          <div class="flex-1">
            <div class="flex items-center justify-between">
              <h3 class="text-lg font-semibold text-white group-hover:text-rose-300 transition-colors">Security</h3>
              <span class="rounded-full bg-emerald-500/15 px-2.5 py-0.5 text-xs font-medium text-emerald-300">2FA</span>
            </div>
            <p class="mt-2 text-sm text-slate-400">Manage account security and two-factor authentication</p>
            <div class="mt-4 flex items-center gap-4">
              <button class="rounded-full bg-rose-600/20 px-4 py-1.5 text-xs font-medium text-rose-300 transition-all hover:bg-rose-600 hover:text-white">
                Configure
              </button>
              <span class="flex items-center gap-1.5 text-xs text-slate-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                </svg>
                Verified
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Footer Action -->
    <div class="relative mt-8 flex items-center justify-between rounded-xl border border-slate-700/30 bg-slate-950/30 p-4">
      <div class="flex items-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <p class="text-sm text-slate-400">Need help? <span class="text-indigo-400 hover:text-indigo-300 cursor-pointer">Contact support</span></p>
      </div>
      <div class="flex items-center gap-2">
        <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
        <span class="text-xs text-slate-500">All settings saved</span>
      </div>
    </div>
  </div>
</template>