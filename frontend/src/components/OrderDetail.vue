<template>
    <div class="mx-4 py-8 flex h-full flex-col">
        <span class="text-lg shrink-0">Sketch client</span>
        <div class="overflow-y-auto px-4">
            <OrderDetailBrief />
        </div>
    </div>
</template>

<script>
import OrderDetailBrief from './OrderDetailBrief.vue';

export default {
    components: {
        OrderDetailBrief
    }
}
</script>
