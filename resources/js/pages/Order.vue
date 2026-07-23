<template>
    <div class="flex h-full min-h-0 flex-row">
        <div class="md:basis-1/4 min-w-60 min-h-0">
            <OrderChat :chats="order.messages" />
        </div>
        <div class="basis-3/4 h-full min-h-0">
            <OrderDetail :order="order"/>
        </div>
    </div>
</template>

<script>
import OrderChat from '@/components/OrderChat.vue';
import OrderDetail from '@/components/OrderDetail.vue';
import MainLayout from '../layouts/MainLayout.vue';

export default {
    layout: MainLayout,
    components: {
        OrderChat,
        OrderDetail,
    },
    props: {
        id: {
            type: Number,
            required: true,
        },
        order: {
            type: Object,
            required: true,
        },
        messages: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            chats: [
                { message: 'Hello, I need more information for your order.', sender: 'artist1', role: 'artist' },
                { message: 'Sure, what do you need?', sender: 'client1', role: 'client' },
                { message: 'Hello, I need more information for your order.', sender: 'artist1', role: 'artist' },
                { message: 'Sure, what do you need?', sender: 'client1', role: 'client' },
                { message: 'Hello, I need more information for your order.', sender: 'artist1', role: 'artist' },
                { message: 'Sure, what do you need?', sender: 'client1', role: 'client' },
            ],
        };
    },
    methods: {},
    mounted() {
        const orderId = this.id;
        console.log(this.order);
    },
};
</script>
