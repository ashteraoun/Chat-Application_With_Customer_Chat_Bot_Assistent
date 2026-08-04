import { defineStore } from 'pinia';
import chatService from '../services/chatService';

export const useChatStore = defineStore('chat', {
    state: () => ({
        conversations: [],
        currentConversation: null,
        messages: [],
        typingUsers: [],
        onlineStatus: [],
        unreadCount: 0,
        searchResults: [],
        pagination: {
            current_page: 1,
            last_page: 1,
            total: 0,
        },
    }),

    actions: {
        async fetchConversations(params = {}) {
            const { data } = await chatService.getConversations(params);
            this.conversations = data.conversations;
            this.pagination = data.meta;
        },

        async fetchConversation(conversationId) {
            const { data } = await chatService.getConversation(conversationId);
            this.currentConversation = data.conversation;
        },

        async createConversation(payload) {
            const { data } = await chatService.createConversation(payload);
            this.conversations.unshift(data.conversation);
            return data;
        },

        async fetchMessages(conversationId, params = {}) {
            const { data } = await chatService.getMessages(conversationId, params);
            this.messages = data.messages;
            this.pagination = data.meta;
        },

        async sendMessage(conversationId, payload) {
            const { data } = await chatService.sendMessage(conversationId, payload);
            this.messages.push(data.data);
            return data;
        },

        async getUnread() {
            const { data } = await chatService.getUnread();
            this.unreadCount = data.unread_count;
        },

        async markRead(conversationId) {
            await chatService.markConversationRead(conversationId);
            await this.getUnread();
        },

        async search(query, type, params = {}) {
            const { data } = await chatService.search(query, type, params);
            this.searchResults = data.results;
            this.pagination = data.meta || this.pagination;
        },

        async getOnlineStatus() {
            const { data } = await chatService.getOnlineStatus();
            this.onlineStatus = data.online_statuses;
        },
    },
});
