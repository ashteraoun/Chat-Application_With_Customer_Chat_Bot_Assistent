<template>
  <aside class="flex h-full w-full max-w-xs flex-col gap-4 rounded-[2rem] border border-slate-800 bg-slate-950 p-4 shadow-2xl shadow-slate-950/40">
    <div class="mb-4 flex items-center justify-between px-3">
      <div>
        <h2 class="text-lg font-semibold text-white">Chats</h2>
        <p class="text-xs text-slate-400">Recent conversations</p>
      </div>
      <button @click="$emit('create-chat')" class="rounded-full bg-indigo-600 px-3 py-2 text-sm font-medium text-white hover:bg-indigo-500">New</button>
    </div>
    <div class="flex-1 overflow-y-auto">
      <template v-if="conversations.length">
        <button
          v-for="conversation in conversations"
          :key="conversation.id"
          @click="$emit('select', conversation)"
          class="mb-3 w-full rounded-[1.4rem] border border-slate-800 bg-gradient-to-br from-slate-900 to-slate-950 px-4 py-3 text-left transition hover:border-indigo-500 hover:shadow-lg hover:shadow-slate-950/40"
        >
          <div class="flex items-start justify-between gap-2">
            <div>
              <span class="font-medium text-white">{{ conversation.title || 'Untitled conversation' }}</span>
              <p class="mt-2 text-xs text-slate-400">{{ conversation.participants.length }} participants</p>
            </div>
            <span class="text-[11px] text-slate-400">{{ conversation.last_message_at ? new Date(conversation.last_message_at).toLocaleString() : 'No recent activity' }}</span>
          </div>
        </button>
      </template>
      <p v-else class="p-4 text-sm text-slate-400">No conversations yet.</p>
    </div>
  </aside>
</template>

<script setup>
import { defineProps } from 'vue';

const props = defineProps({
  conversations: {
    type: Array,
    default: () => [],
  },
});
</script>
