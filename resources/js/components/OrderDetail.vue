<template>
    <div class="mx-4 py-8 flex h-full flex-col">
        <span class="text-lg shrink-0"> {{order.commission.title}} - {{ order.client.name }}</span>
        <div class="overflow-y-auto px-4">
            <OrderDetailBrief v-if="order.production_stage === 'brief'" :order="order"/>
            <OrderDetailProduction v-if="order.production_stage === 'production'" :order="order"/>
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
