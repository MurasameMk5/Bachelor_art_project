<template>
    <div class="flex flex-col gap-4 p-4">
        <span> Command list</span>
        <StorefrontKanban :orders="orders" />
        <div>
            <span> Work in progress</span>
            <div class="flex flex-row gap-4 justify-center">
                <Link v-for="order in orders" :key="order.id" :href="`/order/${order.id}`" class="shadow-md h-80 flex flex-col relative rounded-md flex-1 gap-2 hover:shadow-xl transition-shadow">
                    <div class="flex flex-row gap-2 bg-secondary rounded-t-md text-white p-2">
                        <span>{{ order.commission.title }}</span> - <span>{{ order.client.name }}</span>
                    </div>
                    <div class="m-2">
                        <span class="p-2 border-1 border-secondary rounded-lg">{{ order.production_stage }}</span>
                    </div>
                    <div class="absolute bottom-0 p-4 flex flex-row gap-2 items-center">
                        <Icon icon="lucide:calendar" />
                        <span> {{ order.deadline }}</span>
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

