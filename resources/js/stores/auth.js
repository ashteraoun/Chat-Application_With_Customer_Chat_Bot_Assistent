import { defineStore } from 'pinia';
import axios from 'axios';
import api from '../services/api';

const token = localStorage.getItem('support_chat_token');
if (token) {
    axios.defaults.headers.common.Authorization = `Bearer ${token}`;
    api.defaults.headers.common.Authorization = `Bearer ${token}`;
}

const updateEchoAuthHeader = (tokenValue) => {
    if (window.Echo?.connector?.options?.auth?.headers) {
        window.Echo.connector.options.auth.headers.Authorization = tokenValue ? `Bearer ${tokenValue}` : undefined;
    }
};

export const useAuthStore = defineStore('auth', {
    state: () => ({
        user: null,
        token: token || null,
        loading: false,
        message: null,
        errors: null,
    }),

    actions: {
        async ensureCsrfCookie() {
            await axios.get('/sanctum/csrf-cookie', {
                withCredentials: true,
            });
        },

        async register(payload) {
            this.loading = true;
            this.errors = null;
            try {
                await this.ensureCsrfCookie();
                const { data } = await api.post('/auth/register', payload);
                this.token = data.token;
                this.user = data.user;
                localStorage.setItem('support_chat_token', data.token);
                axios.defaults.headers.common.Authorization = `Bearer ${data.token}`;
                api.defaults.headers.common.Authorization = `Bearer ${data.token}`;
                updateEchoAuthHeader(data.token);
                this.message = data.message;
                return data;
            } catch (error) {
                this.errors = error.response?.data?.errors || null;
                this.message = error.response?.data?.message || 'Registration failed.';
                throw error;
            } finally {
                this.loading = false;
            }
        },

        async login(payload) {
            this.loading = true;
            this.errors = null;
            try {
                await this.ensureCsrfCookie();
                const { data } = await api.post('/auth/login', payload);
                this.token = data.token;
                this.user = data.user;
                localStorage.setItem('support_chat_token', data.token);
                axios.defaults.headers.common.Authorization = `Bearer ${data.token}`;
                api.defaults.headers.common.Authorization = `Bearer ${data.token}`;
                updateEchoAuthHeader(data.token);
                this.message = data.message;
                return data;
            } catch (error) {
                this.errors = error.response?.data?.errors || null;
                this.message = error.response?.data?.message || 'Login failed.';
                throw error;
            } finally {
                this.loading = false;
            }
        },

        async logout() {
            this.loading = true;
            await api.post('/auth/logout');
            this.user = null;
            this.token = null;
            localStorage.removeItem('support_chat_token');
            delete axios.defaults.headers.common.Authorization;
            delete api.defaults.headers.common.Authorization;
            updateEchoAuthHeader(null);
            this.loading = false;
            this.message = 'Logged out successfully.';
        },

        async forgotPassword(payload) {
            const { data } = await axios.post('/auth/forgot-password', payload);
            this.message = data.message;
            return data;
        },

        async fetchUser() {
            if (! this.token) {
                return;
            }

            this.loading = true;
            const { data } = await axios.get('/auth/me');
            this.user = data.user;
            this.loading = false;
        },
    },
});
