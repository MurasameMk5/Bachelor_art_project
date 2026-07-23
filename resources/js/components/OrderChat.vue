<template>
    <div class="border-r-2 border-r-secondary px-4 pt-8 flex h-full min-h-0 flex-col">
        <span class="text-lg shrink-0">Chat</span>
        <div v-for="(chat, index) in chats" :key="index" class="flex-1 min-h-0 px-4 overflow-y-auto">
            <OrderChatStage :stage="chat.content.production_stage" />
            <div class="flex flex-col gap-4">
                <OrderChatBubble v-for="(text, index) in chat.content.text" :key="index" :chat="chat" />
            </div>
        </div>
        
        <div class="shrink-0 py-4">
            <OrderChatInput />
        </div>
    </div>
</template>

<script>
import OrderChatBubble from '@/components/OrderChatBubble.vue';
import OrderChatInput from './OrderChatInput.vue';
import OrderChatStage from './OrderChatStage.vue';

export default {
    components: {
        OrderChatBubble,
        OrderChatInput,
        OrderChatStage,
    },
    props: {
        chats: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
        };
    },
}
</script>
