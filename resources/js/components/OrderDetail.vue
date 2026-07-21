<template>
    <div class="mx-4 py-8 flex h-full flex-col">
        <span class="text-lg shrink-0"> {{order.production_stage}} client</span>
        <div class="overflow-y-auto px-4">
            <OrderDetailBrief />
            <OrderDetailProduction />
        </div>
    </div>
</template>

<script>
import OrderDetailBrief from './OrderDetailBrief.vue';
import OrderDetailProduction from './OrderDetailProduction.vue';

export default {
    components: {
        OrderDetailBrief,
        OrderDetailProduction,
    },
    props: {
        order: {
            type: Object,
            required: true,
        },
    }
}
</script>
