<template>
    <div class="mx-4 mt-4 flex flex-col gap-4">
        <div v-for="order in orders" class="flex flex-col px-4 rounded-2xl component-border bg-amber-100 border-white">
            <div class="component-title border border-secondary">
                <h1>New request</h1>
            </div>
            <div class="flex flex-row justify-between items-center">
                <span> {{order.commission.title}} </span>
                <div>
                    <button class="btn-secondary">Refuse</button>
                    <button class="btn-secondary">Accept</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import MainLayout from '../layouts/MainLayout.vue';
export default {
    layout: MainLayout,
    props: {
        orders: {
            type: Array,
            required: true,
        },
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
