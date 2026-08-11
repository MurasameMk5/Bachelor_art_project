<template>
    <div class="mt-4 w-4/5 mx-auto flex flex-col gap-4">
        <Link v-for="order in orders" :href="`/orders/${order.id}`" class="group flex flex-col px-4 rounded-2xl component-border hover:bg-amber-100 ">
            <div class="component-title rounded-xl">
                <h1>New request !</h1>
            </div>
            <div class="flex flex-row gap-4 items-center text-sm opacity-100 text-gray-600">
                <div class="flex flex-row gap-1 items-center">
                    <Icon icon="lucide:calendar" />
                    <span>{{order.created_at.split('T')[0]}}</span>
                </div>
                <div class="flex flex-row gap-1 items-center">
                    <Icon icon="lucide:clock" />
                    <span>{{order.created_at.split('T')[1].split(':')[0]}}:{{order.created_at.split('T')[1].split(':')[1]}}</span>
                </div>
            </div>
            <div v-auto-animate class="flex flex-row justify-between items-center pl-2 pt-1">
                <span><strong> {{order.commission.title}} </strong> from {{order.client.name}} </span>
                <Icon icon="uiw:d-arrow-right" class="opacity-40 group-hover:opacity-100 group-hover:translate-x-1 transition-all mr-4" />
            </div>
        </Link>
    </div>
</template>

<script>
import { Link } from '@inertiajs/vue3';
import MainLayout from '../layouts/MainLayout.vue';
import { Icon } from '@iconify/vue';
export default {
    layout: MainLayout,
    props: {
        orders: {
            type: Array,
            required: true,
        },
    },
    components: {
        Link,
        Icon,
    },
    data() {
        return {
            // Add your data properties here
        };
    },
    methods: {
        // Add your methods here
    },
};
</script>
