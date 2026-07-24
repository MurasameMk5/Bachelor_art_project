<template>
    <div class="border-r-2 border-r-secondary px-4 pt-8 flex h-full min-h-0 flex-col">
        <span class="text-lg shrink-0">Chat</span>
        <div class="flex-1 min-h-0 px-4 overflow-y-auto">
            <div v-for="(chat, index) in chats" :key="index" >
                <OrderChatStage v-if="index === 0 || chat.content.production_stage !== chats[index - 1].content.production_stage" :stage="chat.content.production_stage" />
                <div class="flex flex-col gap-4">
                    <OrderChatBubble :chat="chat" :user="user" />
                </div>
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
        user: {
            type: Object,
            required: true,
        }
    },
    data() {
        return {
        };
    },
    mounted() {
        console.log('chats', this.chats);
    },
}
</script>
