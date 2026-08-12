<template>
    <div class="mx-4 py-8 flex h-full flex-col">
        <span v-if="order.stage_details?.awaiting_payment?.base === null" class="text-xl shrink-0 bg-secondary p-2">First payment</span>
        <span v-else class="text-xl shrink-0 bg-secondary rounded-lg p-2">Last payment</span>
        <OrderDetailInfo text="An email has been sent to the client. Every 2 days until the completion of the payment a reminder will be sent."/>
        <div class="overflow-y-auto px-4">
            <div class="p-4 pb-8 flex flex-col items-center">
                <Icon icon="fluent:payment-20-regular" class="w-8 h-8"/>
                <span> Awaiting payment from the client before proceeding to the next stage of the order.</span>
            </div>
            <div class="component-border">
                <h1 class="component-title">Payment due</h1>
                <p v-if="order.stage_details?.awaiting_payment?.base === null">Price: {{ parseInt(order.base_price/2)}} </p>
                <p v-else>Price: {{ parseInt(order.final_price - order.base_price/2)}} {{order.commission.currency}} </p>
                <p>Invoice: {{order.invoice_number}} </p>
            </div>
        </div>
    </div>
</template>

<script>
import { Icon } from '@iconify/vue';
import OrderDetailInfo from './OrderDetailInfo.vue';
export default {
    components: {
        Icon,
        OrderDetailInfo
    },
    props: {
        order: {
            type: Object,
            required: true,
        },
    },
}
</script>
