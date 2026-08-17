<template>
    <div class="flex items-start w-full py-4">
        <div
            v-for="(step, i) in steps"
            :key="step.key"
            class="flex-1 flex flex-col items-center text-center"
        >
            <div class="flex items-center w-full">
                <div class="flex-1 h-0.5" :class="i === 0 ? 'bg-transparent' : lineClass(i)"></div>
                <div
                    class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-medium shrink-0 border-2"
                    :class="dotClass(i)"
                >
                    <Icon v-if="i < currentStep" icon="lucide:check" class="w-3 h-3"/>
                    <span v-else>{{ i + 1 }}</span>
                </div>
                <div class="flex-1 h-0.5" :class="i === steps.length - 1 ? 'bg-transparent' : lineClass(i + 1)"></div>
            </div>
            <span class="text-xs mt-2" :class="i <= currentStep ? 'text-primary font-medium' : 'text-gray-400'">
                {{ step.label }}
            </span>
        </div>
    </div>
</template>

<script>
import { Icon } from '@iconify/vue';

export default {
    components: {
        Icon,
    },
    props: {
        order: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            steps: [
                { key: 'brief', label: 'Brief' },
                { key: 'first_payment', label: 'First payment' },
                { key: 'production', label: 'Production' },
                { key: 'revision', label: 'Revision' },
                { key: 'final_payment', label: 'Final payment' },
                { key: 'final_delivery', label: 'Delivery' },
            ],
        };
    },
    computed: {
        isFirstPayment() {
            return this.order.stage_details?.awaiting_payment?.base === null
                || this.order.stage_details?.awaiting_payment?.base === undefined;
        },
        currentStep() {
            const stage = this.order.production_stage;

            if (stage === 'brief') return 0;
            if (stage === 'awaiting_payment') {
                return this.isFirstPayment ? 1 : 4;
            }
            if (stage === 'production') return 2;
            if (stage === 'revision') return 3;
            if (stage === 'final_delivery') return 5;

            return 0;
        },
    },
    methods: {
        dotClass(i) {
            if (i < this.currentStep) {
                return 'bg-secondary border-secondary text-white';
            }
            if (i === this.currentStep) {
                return 'bg-white border-secondary text-secondary';
            }
            return 'bg-white border-gray-300 text-gray-400';
        },
        lineClass(i) {
            return i <= this.currentStep ? 'bg-secondary' : 'bg-gray-300';
        },
    },
};
</script>
