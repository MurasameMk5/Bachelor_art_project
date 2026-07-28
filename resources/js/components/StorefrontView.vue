<template>
    <div class="flex flex-col gap-4 pt-14" v-auto-animate>
        <div v-for="(component, index) in storefront.components" :key="component.id">
            <StorefrontComponent :component="component" :storefront="storefront" :orders="orders" :preview="preview"/>
        </div>
    </div>
</template>

<script>
import StorefrontComponent from "./StorefrontComponent.vue";
import { useStorefrontStore } from "@/stores/storefront.js";

export default {
    components: {
        StorefrontComponent,
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
        preview: {
            type: Boolean,
            required: true,
        },
    },
    data() {
        return {
            storefrontStore: useStorefrontStore(),
        };
    },
    mounted() {
      this.storefrontStore.setTotalComponents(this.storefront.components.length);
    },
}
</script>
