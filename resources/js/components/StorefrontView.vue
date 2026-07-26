<template>
    <div class="flex flex-col gap-4 pt-14">
        <div v-for="(component, index) in storefront.components" :key="index">
            <StorefrontCommission v-if="component.type === 'commission'" :commission="component.commission" :storefrontSlug="storefront.slug" :artist="storefront.user_id" :preview="preview"/>
            <StorefrontDivider v-if="component.type === 'divider'" :artist="storefront.user_id" :preview="preview"/>
            <StorefrontKanban v-if="component.type === 'kanban'" :orders="orders" :artist="storefront.user_id" :preview="preview"/>
            <StorefrontImage v-if="component.type === 'image'" :imageComponent="component" :artist="storefront.user_id" :preview="preview"/>
            <StorefrontText v-if="component.type === 'text'" :text="component.content.text" :artist="storefront.user_id" :preview="preview" />
        </div>
    </div>
</template>

<script>
import StorefrontCommission from "@/components/StorefrontCommission.vue";
import StorefrontDivider from "@/components/StorefrontDivider.vue";
import StorefrontKanban from "@/components/StorefrontKanban.vue";
import StorefrontImage from "@/components/StorefrontImage.vue";
import StorefrontText from "@/components/StorefrontText.vue";
import { useStorefrontStore } from "@/stores/storefront.js";

export default {
    components: {
        StorefrontCommission,
        StorefrontDivider,
        StorefrontKanban,
        StorefrontImage,
        StorefrontText,
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
