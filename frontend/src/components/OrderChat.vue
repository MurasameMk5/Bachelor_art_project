<template>
    <div class="border-r-2 border-r-secondary px-4 pt-8 min-h-full">
        <span class="text-lg">Chat</span>
        <OrderChatStage/>
        <div class="flex flex-col gap-4 justify-between h-full">
            <OrderChatBubble v-for="(chat, index) in chats" :key="index" :chat="chat" />
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
    props: ['chats'],
    data() {
        return {
        };
    },
}
</script>
