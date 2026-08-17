<template>
    <div class="w-full flex flex-row rounded-x-xl">
        <img v-for="image in commission.images" :src="image?.storage_path" class="w-full h-100 object-cover"/>
    </div>
    <div class="flex flex-row">
        <div class="flex flex-col gap-2 px-4 pt-2 basis-3/4">
            <h3 class="text-md font-bold">{{ commission.title }}</h3>
            <p>{{ commission.description }}</p>

        </div>
        <div class="flex flex-col gap-2 px-4 pt-2 basis-1/4">
            <span>{{ commission.base_price }} {{ commission.currency }}</span>
            <span>{{ commission.estimated_days }} days</span>
            <button @click="orderForm = !orderForm" class="btn-secondary-filled">
                <span>Request commission</span>
            </button>
        </div>
    </div>
    <CommissionDetailOrderForm v-if="orderForm" :commission="commission" @close="orderForm=false"/>
</template>

<script>
import { Icon } from '@iconify/vue';
import CommissionDetailOrderForm from '../components/CommissionDetailOrderForm.vue';

export default {
    props: {
        commission: Object,
        required: true,
    },
    components: {
        Icon,
        CommissionDetailOrderForm,
    },
    data() {
        return {
            orderForm: false,
        };
    },
}
</script>
