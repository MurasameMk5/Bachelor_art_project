<template>
    <div class="border-r-2 border-r-secondary px-4 pt-8 min-h-full">
        <span class="text-lg">Chat</span>
        <div class="flex flex-row gap-2 items-center border-y-2 border-y-yellow-500 mt-4 pl-4 py-2 my-6 rounded-md justify-center border-dotted">
            <Icon icon="lucide:step-back" />
            <span>Sketch</span>
            <Icon icon="lucide:step-forward" />
        </div>
        <div class="flex flex-col gap-4 justify-between">
            <OrderChatBubble v-for="(chat, index) in chats" :key="index" :chat="chat" />
            <OrderChatInput />
        </div>
    </div>
</template>

<script>
import { Icon } from '@iconify/vue';
import OrderChatBubble from '@/components/OrderChatBubble.vue';
import OrderChatInput from './OrderChatInput.vue';

export default {
    components: {
        Icon,
        OrderChatBubble,
        OrderChatInput,
    },
    props: ['chats'],
    data() {
        return {
        };
    },
}
</script>