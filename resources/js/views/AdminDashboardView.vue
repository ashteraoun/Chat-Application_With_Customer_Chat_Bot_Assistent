<template>
    <div class="space-y-6 rounded-2xl border border-slate-800 bg-slate-900 p-8">
        <div>
            <h2 class="text-2xl font-semibold">Admin dashboard</h2>
            <p class="mt-3 text-slate-300">This area is protected for administrator accounts.</p>
        </div>

        <div class="grid gap-4 sm:grid-cols-3">
            <router-link to="/admin/users" class="rounded-3xl border border-slate-700 bg-indigo-600 px-6 py-5 text-center text-white hover:bg-indigo-500">
                Manage users
            </router-link>
            <router-link to="/chats" class="rounded-3xl border border-slate-700 bg-emerald-600 px-6 py-5 text-center text-white hover:bg-emerald-500">
                Open chats
            </router-link>
            <router-link to="/profile" class="rounded-3xl border border-slate-700 bg-slate-800 px-6 py-5 text-center text-white hover:bg-slate-700">
                Edit profile
            </router-link>
        </div>
    </div>
</template>
