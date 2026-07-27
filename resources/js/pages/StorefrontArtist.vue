<template>
    <div class="relative flex h-full min-h-0 w-full flex-row items-stretch overflow-hidden">
        <img v-if="backgroundImage" :src="backgroundImage" class="absolute top-0 left-0 w-full h-full -z-10"/>

        <Transition
            enter-active-class="transition duration-200 ease-out transform"
            enter-from-class="-translate-x-full opacity-0"
            enter-to-class="translate-x-0 opacity-100"
            leave-active-class="transition duration-200 ease-in transform"
            leave-from-class="translate-x-0 opacity-100"
            leave-to-class="-translate-x-full opacity-0"
        >
            <div
                v-if="storefrontStore.sidebarActive"
                class="absolute top-0 left-0 h-full w-full sm:w-80 md:w-96 z-20"
            >
                <StorefrontSidebar @close="storefrontStore.setSidebarActive(false)" />
            </div>
        </Transition>


        <div class="h-full min-h-0 p-4 w-full max-w-7xl mx-auto flex-1 overflow-auto">
            <div class=" flex gap-4 justify-end absolute z-10 right-10">
                <button @click="storefrontStore.setSidebarActive(!storefrontStore.sidebarActive, MenuPages.GLOBAL)" class="btn-secondary">Components</button>
                <button @click="preview = !preview" class="btn-secondary">Preview</button>
            </div>
            <StorefrontView :storefront="sortedStorefrontComponents" :orders="orders" :preview="preview"/>
        </div>

    </div>
</template>

<script>
import StorefrontSidebar from "@/components/StorefrontSidebar.vue";
import MainLayout from "../layouts/MainLayout.vue";
import StorefrontView from "../components/StorefrontView.vue";
import { MenuPages, useStorefrontStore } from "../stores/storefront";

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
    data() {
        return {
            MenuPages,
            sidebarActive: false,
            backgroundImage: null,
            preview: false,
            storefrontStore: useStorefrontStore(),
        };
    },
    computed: {
        backgroundImage() {
            return this.storefront.background_image?.storage_path || null;
        },
        sortedStorefrontComponents() {
            return {
                ...this.storefront,
                components: [...this.storefront.components].sort((a, b) => a.position - b.position),
            };
        },
    },
    mounted() {
        console.log(this.storefront);
        this.storefrontStore.setSidebarActive(false);
    }
};
</script>
