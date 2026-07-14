<template>
    <div class="flex flex-row min-h-screen">
        <div class="md:basis-1/4 min-w-60">
            <OrderChat :chats="chats" />
        </div>
        <div class="basis-3/4">
            <OrderDetail />
        </div>
    </div>
</template>

<script>
import OrderChat from '@/components/OrderChat.vue';
import OrderDetail from '@/components/OrderDetail.vue';

export default {
    components: {
        OrderChat,
        OrderDetail,
    },
    data() {
        return {
            chats: [
                { message: 'Hello, I need more information for your order.', sender: 'artist1', role: 'artist' },
                { message: 'Sure, what do you need?', sender: 'client1', role: 'client' },
            ],
        };
    },
    methods: {},
    mounted() {
        const orderId = this.$route.params.id;
    },
};
</script>
