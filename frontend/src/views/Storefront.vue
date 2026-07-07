<template>
    <div class="flex h-full w-full flex-row gap-4">
        <div class=" basis-1/4">
            <Transition
                enter-active-class="transition duration-200 ease-out transform"
                enter-from-class="-translate-x-full opacity-0"
                enter-to-class="translate-x-0 opacity-100"
                leave-active-class="transition duration-200 ease-in transform"
                leave-from-class="translate-x-0 opacity-100"
                leave-to-class="-translate-x-full opacity-0"
            >
                <div
                    v-if="sidebarActive"
                    class="absolute left-0 z-20 w-1/4"
                >
                    <StorefrontSidebar
                        class="h-screen min-w-0"
                        @close="sidebarActive = false"
                    />
                </div>
            </Transition>
        </div>

        
        <div class="h-screen p-4 basis-1/2 bg-slate-200">
            <StorefrontForm/>
        </div>


        <div class="basis-1/4 ">
            <div class="flex min-w-0 justify-end gap-8 mx-4 mt-4">
                <button
                    @click="sidebarActive = true"
                    class="btn-secondary justify-end"
                >
                    Add component
                </button>
                <button class="btn-secondary justify-end">Preview</button>
            </div>
        </div>
    </div>
</template>

<script>
import StorefrontForm from "@/components/StorefrontForm.vue";
import StorefrontSidebar from "@/components/StorefrontSidebar.vue";

export default {
    components: {
        StorefrontSidebar,
        StorefrontForm
    },
    data() {
        return {
            sidebarActive: false,
        };
    },
};
</script>
