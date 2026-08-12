<template>
    <div class="mx-4 py-8 flex h-full flex-col">
        <span class="text-2xl shrink-0"> {{order.commission.title}} - {{ order.client.name }}</span>
        <div class="overflow-y-auto px-4">
            <OrderDetailRequest v-if="order.status === 'to do' && order.production_stage === null" :order="order"/>
            <OrderDetailBrief v-else-if="order.status === 'doing' && order.production_stage === 'brief'" :order="order"/>
            <OrderDetailProduction v-else-if="order.status === 'doing' && order.production_stage === 'production'" :order="order"/>
            <OrderDetailPayment v-else-if="order.status === 'doing' && order.production_stage === 'awaiting_payment'" :order="order"/>
        </div>
    </div>
</template>

<script>
import OrderDetailRequest from './OrderDetailRequest.vue';
import OrderDetailBrief from './OrderDetailBrief.vue';
import OrderDetailProduction from './OrderDetailProduction.vue';
import OrderDetailPayment from './OrderDetailPayment.vue';

export default {
    components: {
        OrderDetailRequest,
        OrderDetailBrief,
        OrderDetailProduction,
        OrderDetailPayment
    },
    props: {
        order: {
            type: Object,
            required: true,
        },
    }
}
</script>
