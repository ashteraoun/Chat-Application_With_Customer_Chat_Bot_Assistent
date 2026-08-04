import { createRouter, createWebHistory } from 'vue-router';
import HomeView from '../views/HomeView.vue';
import LoginView from '../views/LoginView.vue';
import RegisterView from '../views/RegisterView.vue';
import ForgotPasswordView from '../views/ForgotPasswordView.vue';
import DashboardView from '../views/DashboardView.vue';
import ChatListView from '../views/ChatListView.vue';
import ConversationView from '../views/ConversationView.vue';
import SettingsView from '../views/SettingsView.vue';
import ProfileView from '../views/ProfileView.vue';
import CustomerDashboardView from '../views/CustomerDashboardView.vue';
import AdminDashboardView from '../views/AdminDashboardView.vue';
import AdminUsersView from '../views/AdminUsersView.vue';
import SupportDashboardView from '../views/SupportDashboardView.vue';
import { useAuthStore } from '../stores/auth';

const routes = [
    { path: '/', component: HomeView, name: 'home' },
    { path: '/login', component: LoginView, name: 'login' },
    { path: '/register', component: RegisterView, name: 'register' },
    { path: '/forgot-password', component: ForgotPasswordView, name: 'forgot-password' },
    {
        path: '/customer/dashboard',
        component: CustomerDashboardView,
        name: 'customer-dashboard',
        meta: { requiresAuth: true, role: 'customer' },
    },
    {
        path: '/admin/dashboard',
        component: AdminDashboardView,
        name: 'admin-dashboard',
        meta: { requiresAuth: true, role: 'admin' },
    },
    {
        path: '/admin/users',
        component: AdminUsersView,
        name: 'admin-users',
        meta: { requiresAuth: true, role: 'admin' },
    },
    {
        path: '/support/dashboard',
        component: SupportDashboardView,
        name: 'support-dashboard',
        meta: { requiresAuth: true, role: 'support_agent' },
    },
    {
        path: '/dashboard',
        component: DashboardView,
        name: 'dashboard',
        meta: { requiresAuth: true },
    },
    {
        path: '/chats',
        component: ChatListView,
        name: 'chat-list',
        meta: { requiresAuth: true },
    },
    {
        path: '/conversations/:conversationId',
        component: ConversationView,
        name: 'conversation',
        meta: { requiresAuth: true },
    },
    {
        path: '/settings',
        component: SettingsView,
        name: 'settings',
        meta: { requiresAuth: true },
    },
    {
        path: '/profile',
        component: ProfileView,
        name: 'profile',
        meta: { requiresAuth: true },
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, _from, next) => {
    const auth = useAuthStore();

    if (!to.meta.requiresAuth) {
        next();
        return;
    }

    if (!auth.user) {
        next({ name: 'login' });
        return;
    }

    if (to.meta.role && auth.user.role !== to.meta.role) {
        next({ name: 'home' });
        return;
    }

    next();
});

export default router;
