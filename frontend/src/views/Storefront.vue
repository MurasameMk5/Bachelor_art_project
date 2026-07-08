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

        
        <div class="h-screen p-4 basis-1/2">
            <div class="flex flex-col gap-4">
                <StorefrontCommission/>
                <StorefrontDivider/>
                <StorefrontKanban/>
                <StorefrontImage
                    :images="this.images"
                />
                <StorefrontText/>
            </div>
        </div>


        <div class="basis-1/4 ">
            <div class="flex min-w-0 justify-end gap-8 mx-4 mt-4">
                <button
                    @click="sidebarActive = true"
                    class="btn-secondary justify-end"
                >
                    Components
                </button>
                <button class="btn-secondary justify-end">Preview</button>
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

export default {
    components: {
        StorefrontSidebar,
        StorefrontCommission,
        StorefrontDivider,
        StorefrontKanban,
        StorefrontImage,
        StorefrontText,
    },
    data() {
        return {
            sidebarActive: false,
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
};
</script>
