<template>
    <div v-if="preview || $page.props.auth.user.id !== artist">
        <div class="h-1 w-full bg-gray-300 rounded-full"></div>
    </div>
    <div v-else>
        <div class="h-1 w-full bg-gray-300 rounded-full"></div>

    </div>
</template>

<script>
import StorefrontComponentHeader from './StorefrontComponentHeader.vue';
export default {
    props: {
        preview: {
            type: Boolean,
            default: false,
        },
        artist: {
            type: Number,
            required: true,
        },
    },
    components: {
        StorefrontComponentHeader,
    },
};
</script>
