<template>
    <div class="relative flex h-full min-h-0 w-full flex-row items-stretch overflow-hidden">
        <img v-if="storefront.background_image" :src="storefront.background_image" class="absolute top-0 left-0 w-full h-full object-cover -z-10"/>
        <div class="h-full min-h-0 p-4 max-w-4/5 mx-auto flex-1 overflow-auto">
            <StorefrontView :storefront="storefront" :orders="orders" :preview="preview"/>
        </div>
    </div>
</template>

<script>
import StorefrontSidebar from "@/components/StorefrontSidebar.vue";
import MainLayout from "../layouts/MainLayout.vue";
import StorefrontView from "../components/StorefrontView.vue";

export default {
    layout: MainLayout,
    components: {
        StorefrontSidebar,
        StorefrontView,
    },
    props: {
        storefront: {
            type: Object,
            required: true,
        },
        orders: {
            type: Array,
            required: true,
        },
    },
    mounted() {
        this.storefront.components.sort((a, b) => a.position - b.position);
    }
};
</script>
