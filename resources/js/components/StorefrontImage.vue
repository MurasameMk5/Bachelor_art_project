<template>
    <div v-if="preview || $page.props.auth.user.id !== artist" class="flex h-72 w-full max-w-full flex-row justify-center gap-2">
        <div v-for="image in imageComponent.images" class="flex flex-1 flex-col">
            <img
                :src="image.ref"
                :alt="image.label"
                class="h-0 min-h-0 w-full flex-1 object-contain"
            />
            <span class="mt-1 text-center text-sm leading-tight">{{ image.label }}</span>
        </div>
    </div>
    <div v-else class="component-border h-72 justify-center flex-row flex-1 gap-2 relative">
        <StorefrontComponentHeader header="Image component" @delete="delete"/>
        <div v-for="image in imageComponent.content.images" class="flex flex-1 flex-col min-h-0">
            <img
                :src="image.ref"
                :alt="image.label"
                class="h-0 min-h-0 w-full flex-1 object-contain"
            />
            <span class="mt-1 text-center text-sm leading-tight">{{ image.label }}</span>
        </div>
        <Icon @click="storefrontStore.setSidebarActive(true, MenuPages.IMAGE, imageComponent)" icon="lucide:square-pen" class="absolute w-6 h-6 bottom-0 right-0 mb-4 mr-4"/>
    </div>
</template>

<script>
import StorefrontComponentHeader from './StorefrontComponentHeader.vue';
import { MenuPages, useStorefrontStore } from '../stores/storefront';
import { Icon } from '@iconify/vue';
export default {
    props: {
        imageComponent: {
            type: Object,
            default: () => ({}),
        },
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
        Icon,
    },
    data() {
        return {
            MenuPages,
            storefrontStore: useStorefrontStore(),
        };
    },
    method: {
        delete() {
            this.storefrontStore.deleteComponent(this.imageComponent);
        }
    },
    mounted() {
        console.log("preview:", this.preview, "artist:", this.artist);
    },

}
</script>
