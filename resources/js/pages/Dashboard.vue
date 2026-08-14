<template>
    <div class="flex flex-col gap-4 p-4 w-4/5 overflow-y-auto h-full mx-auto">
        <span> Command list</span>
        <StorefrontKanban :orders="orders" />
        <div class="flex flex-col gap-4">
            <span> Work in progress</span>
            <div class="flex gap-4 justify-center flex-wrap">
                <Link v-for="order in orders.filter(o => o.status === 'doing')" :key="order.id" :href="`/orders/${order.id}`" class="shadow-md h-80 min-w-1/5 flex flex-col relative gap-2 hover:shadow-xl hover:scale-105 transition-all">
                    <img :src="order.commission.images[0].storage_path" class="object-cover h-full w-full absolute z-0 rounded-t-md"/>
                    <div class="flex flex-row gap-2 bg-secondary rounded-t-md text-white p-2 z-5">
                        <span>{{ order.commission.title }}</span> - <span>{{ order.client.name }}</span>
                    </div>
                    <div class="m-2 z-5">
                        <span class="p-2 border-2 border-secondary rounded-lg bg-white">{{ order.production_stage }}</span>
                    </div>
                    <div class="absolute bottom-0 p-4 flex flex-row gap-2 items-center z-5">
                        <Icon icon="lucide:calendar" />
                        <span> {{ order.created_at.split('T')[0] }}</span>
                    </div>
                </Link>
            </div>
        </div>
    </div>
</template>

<script>
import StorefrontKanban from '@/components/StorefrontKanban.vue';
import { Icon } from '@iconify/vue';
import { Link } from '@inertiajs/vue3';
import MainLayout from '../layouts/MainLayout.vue';

export default {
    layout: MainLayout,
    components: {
        StorefrontKanban,
        Icon,
        Link,
    },
    props: {
        orders: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
        };
    },
    methods: {},
    mounted() {
        console.log(this.orders)
    },
};
</script>
