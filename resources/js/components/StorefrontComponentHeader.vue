<template>
    <h1 class="component-title"> {{header}} </h1>
    <div class="absolute -top-3 right-2 px-2 bg-white text-secondary flex flex-row gap-2">
        <Icon icon="lucide:arrow-up" class="w-6 h-6 hover:text-primary" @click="$emit('position-up')" />
        <Icon icon="lucide:arrow-down" class="w-6 h-6 hover:text-primary" @click="$emit('position-down')" />
        <Icon icon="lucide:badge-x" class="w-6 h-6 hover:text-primary"  @click="$emit('delete')" />
    </div>
</template>

<script>
import {Icon} from '@iconify/vue';

export default {
    props: {
        header: {
            type: String,
            required: true
        }
    },
    components: {
        Icon
    }
};
</script>
