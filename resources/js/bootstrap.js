import axios from 'axios';

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

const token = localStorage.getItem('support_chat_token');

if (token) {
    axios.defaults.headers.common.Authorization = `Bearer ${token}`;
}
