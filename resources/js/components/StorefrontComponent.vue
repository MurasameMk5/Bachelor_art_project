<template>
    <div :class="!preview ? 'component-border': ''">
        <StorefrontComponentHeader v-if="!preview" :header="`${component.type.charAt(0).toUpperCase() + component.type.slice(1)} component`" @delete="handleDelete" @position-up="handlePositionUp" @position-down="handlePositionDown"/>
        <StorefrontCommission v-if="component.type === 'commission'" :commission="component.commission" :storefrontSlug="storefront.slug" :artist="storefront.user_id" :preview="preview"/>
        <StorefrontDivider v-if="component.type === 'divider'" :artist="storefront.user_id" :preview="preview"/>
        <StorefrontKanban v-if="component.type === 'kanban'" :orders="orders" :artist="storefront.user_id" :preview="preview"/>
        <StorefrontImage v-if="component.type === 'image'" :imageComponent="component" :artist="storefront.user_id" :preview="preview"/>
        <StorefrontText v-if="component.type === 'text'" :component="component" :artist="storefront.user_id" :preview="preview" />
        <StorefrontTos v-if="component.type === 'tos'" :component="component" :artist="storefront.user_id" :preview="preview" />
    </div>

</template>

<script>
import StorefrontComponentHeader from './StorefrontComponentHeader.vue';
import StorefrontCommission from "@/components/StorefrontCommission.vue";
import StorefrontDivider from "@/components/StorefrontDivider.vue";
import StorefrontKanban from "@/components/StorefrontKanban.vue";
import StorefrontImage from "@/components/StorefrontImage.vue";
import StorefrontText from "@/components/StorefrontText.vue";
import {router} from '@inertiajs/vue3';
import StorefrontTos from './StorefrontTos.vue';

export default {
    props: {
        storefront: {
            type: Object,
            required: true,
        },
        component:{
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
    components: {
        StorefrontCommission,
        StorefrontDivider,
        StorefrontKanban,
        StorefrontImage,
        StorefrontText,
        StorefrontTos,
        StorefrontComponentHeader,
    },
    data() {
        return {
        };
    },
    methods: {
        handleDelete() {
            if(confirm('Delete component?'))
                router.delete(`/storefront/components/${this.component.id}`)
        },
        handlePositionUp() {
            router.put(`/storefront/components/${this.component.id}/up`);
        },
        handlePositionDown() {
            router.put(`/storefront/components/${this.component.id}/down`);
        },
    }
}
</script>
