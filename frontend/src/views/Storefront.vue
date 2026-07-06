<template>
    <div class="h-full">
        <div class="flex justify-end gap-8 mx-4">
            <button
                @click="sidebarActive = true"
                class="btn-secondary justify-end"
            >
                Add component
            </button>
            <button class="btn-secondary justify-end">Preview</button>
        </div>
        <Transition
            enter-active-class="transition duration-200 ease-out transform"
            enter-from-class="-translate-x-full opacity-0"
            enter-to-class="translate-x-0 opacity-100"
            leave-active-class="transition duration-200 ease-in transform"
            leave-from-class="translate-x-0 opacity-100"
            leave-to-class="-translate-x-full opacity-0"
        >
            <StorefrontSidebar
                v-if="sidebarActive"
                @close="sidebarActive = false"
            />
        </Transition>
    </div>
</template>

<script>
import StorefrontSidebar from "@/components/StorefrontSidebar.vue";

export default {
    components: {
        StorefrontSidebar,
    },
    data() {
        return {
            sidebarActive: false,
        };
    },
};
</script>
