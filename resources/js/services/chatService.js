import api from './api';

export default {
    getConversations(params) {
        return api.get('/conversations', { params });
    },

    getConversation(conversationId) {
        return api.get(`/conversations/${conversationId}`);
    },

    createConversation(payload) {
        return api.post('/conversations', payload);
    },

    updateConversation(conversationId, payload) {
        return api.put(`/conversations/${conversationId}`, payload);
    },

    deleteConversation(conversationId) {
        return api.delete(`/conversations/${conversationId}`);
    },

    getMessages(conversationId, params) {
        return api.get(`/conversations/${conversationId}/messages`, { params });
    },

    sendMessage(conversationId, payload) {
        return api.post(`/conversations/${conversationId}/messages`, payload);
    },

    getTypingStatus(params) {
        return api.get('/typing-status', { params });
    },

    updateTypingStatus(payload) {
        return api.post('/typing-status', payload);
    },

    search(query, type, params) {
        return api.get('/search', { params: { query, type, ...params } });
    },

    getUnread() {
        return api.get('/unread');
    },

    markConversationRead(conversationId) {
        return api.post(`/unread/${conversationId}`);
    },

    getOnlineStatus() {
        return api.get('/online-status');
    },

    updateOnlineStatus(payload) {
        return api.post('/online-status', payload);
    },
};
