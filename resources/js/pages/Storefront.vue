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
                v-if="sidebarActive"
                class="absolute top-0 left-0 h-full w-full sm:w-80 md:w-96 z-20"
            >
                <StorefrontSidebar @close="sidebarActive = false" />
            </div>
        </Transition>


        <div class="h-full min-h-0 p-4 w-full max-w-7xl mx-auto flex-1 overflow-auto">
            <div class=" flex gap-4 justify-end">
                <button @click="sidebarActive = true" class="btn-secondary">Components</button>
                <button class="btn-secondary">Preview</button>
            </div>
            <div class="flex flex-col gap-4 pt-8">
                <StorefrontCommission/>
                <StorefrontDivider/>
                <StorefrontKanban/>
                <StorefrontImage :images="this.images" />
                <StorefrontText/>
            </div>
        </div>

    </div>
</template>

<script>
import StorefrontSidebar from "@/components/StorefrontSidebar.vue";
import StorefrontCommission from "@/components/StorefrontCommission.vue";
import StorefrontDivider from "@/components/StorefrontDivider.vue";
import StorefrontKanban from "@/components/StorefrontKanban.vue";
import StorefrontImage from "@/components/StorefrontImage.vue";
import StorefrontText from "@/components/StorefrontText.vue";
import MainLayout from "../layouts/MainLayout.vue";

export default {
    layout: MainLayout,
    components: {
        StorefrontSidebar,
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
    },
    data() {
        return {
            sidebarActive: false,
            backgroundImage: null,
            images: [
                {
                    image_ref: "./../../Kamome Shirahama-min.png",
                    image_desc: "Description of the image",
                    label: "Image by Kamome Shirahama"
                },
                {
                    image_ref: "./../../Akihiko Yoshida-min.png",
                    image_desc: "Description of another image",
                    label: "Image by Akihiko Yoshida"
                },
                {
                    image_ref: "./../../Arthur Rackham-min.png",
                    image_desc: "Description of yet another image",
                    label: "Image by Arthur Rackham"
                }
            ]
        };
    },
    mounted() {
        console.log(this.storefront);
    }
};
</script>
