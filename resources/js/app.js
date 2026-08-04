import './bootstrap';
import { createApp } from 'vue';
import { createPinia } from 'pinia';
import router from './router';
import App from './App.vue';
import axios from 'axios';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
import '../css/app.css';

const broadcastDriver = import.meta.env.VITE_BROADCAST_DRIVER || 'log';
const pusherKey = import.meta.env.VITE_PUSHER_APP_KEY;
const pusherHost = import.meta.env.VITE_PUSHER_HOST;
const pusherPort = import.meta.env.VITE_PUSHER_PORT;
const pusherScheme = import.meta.env.VITE_PUSHER_SCHEME;

if (broadcastDriver === 'pusher' && pusherKey && pusherKey !== 'local') {
    window.Pusher = Pusher;
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: pusherKey,
        cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
        wsHost: pusherHost || window.location.hostname,
        wsPort: pusherPort || 6001,
        wssPort: pusherPort || 6001,
        forceTLS: pusherScheme === 'https',
        enabledTransports: ['ws', 'wss'],
        auth: {
            headers: {
                Authorization: axios.defaults.headers.common.Authorization,
            },
        },
    });
} else {
    window.Echo = null;
    console.info('Laravel Echo disabled: Pusher broadcast is not configured for this environment.');
}

const app = createApp(App);
const pinia = createPinia();

app.use(pinia);
app.use(router);

axios.defaults.baseURL = import.meta.env.VITE_API_BASE_URL || '/api';
axios.defaults.withCredentials = true;

app.mount('#app');
