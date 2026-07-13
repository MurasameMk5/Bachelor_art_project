<template>
    <div class="flex flex-row min-h-screen">
        <div class="md:basis-1/4 min-w-60 border-r-2 border-r-secondary px-4 pt-8">
            <span class="text-lg">Chat</span>
            <div class="flex flex-row gap-2 items-center border-y-2 border-y-yellow-500 mt-4 pl-4 py-2 rounded-md justify-center border-dotted">
                <Icon icon="lucide:step-back" />
                <span>Sketch</span>
                <Icon icon="lucide:step-forward" />
            </div>
        </div>
        <div class="basis-3/4 ml-4 mt-8">
            <span class="text-lg">Order details</span>
        </div>
    </div>
</template>

<script>
import { Icon } from '@iconify/vue';

export default {
    components: {
        Icon,
    },
    data() {
        return {
        };
    },
    methods: {},
    mounted() {
        const orderId = this.$route.params.id;

    },
};
</script>
