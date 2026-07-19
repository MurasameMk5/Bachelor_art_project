<template>
    <div
        class="flex h-full w-full max-w-sm flex-col items-start bg-white p-3 shadow-lg sm:p-4"
    >
        <div class="w-full flex justify-end">
            <Icon
                @click="$emit('close')"
                icon="lucide:panel-left-close"
                class="w-6 h-6"
            />
        </div>
        <div v-auto-animate class="w-full">
            <div v-if="store.getPage === MenuPages.GLOBAL">
                <span class="text-lg">Global parameters</span>
                <div class="flex flex-col gap-4 my-4 mb-20">
                    <div class="mx-2 flex flex-row justify-between gap-3 sm:mx-4 sm:gap-4">
                        <label>Background</label>
                        <input type="file" class="w-full max-w-44" />
                    </div>
                    <div class="mx-2 flex flex-row justify-between sm:mx-4">
                        <label>Visible</label>
                        <input type="checkbox" />
                    </div>
                </div>
                <span class="text-lg">Add component</span>
                <div class="grid w-full grid-cols-2 gap-3 sm:grid-cols-3 sm:gap-4">
                    <div
                        v-for="component in this.components" @click="changePage(component.type)"
                        class="my-2 flex flex-col items-center justify-center rounded-3xl bg-secondary-300 py-2 text-center"
                    >
                        <Icon :icon="component.icon" class="w-6 h-6" />
                        <span> {{ component.label }} </span>
                    </div>
                </div>
            </div>
            <div v-else>
                <div class="flex flex-row items-center gap-4 mb-4">
                    <Icon
                        @click="store.setPage(MenuPages.GLOBAL)"
                        icon="lucide:arrow-left"
                        class="w-6 h-6"
                    />
                    <span class="text-lg">{{ store.getPage }}</span>
                </div>
                <div v-if="store.getPage === MenuPages.COMMISSION">
                    <StorefrontCommissionForm />
                </div>
                <div v-if="store.getPage === MenuPages.TOS">
                    <StorefrontTosForm />
                </div>
                <div v-if="store.getPage === MenuPages.IMAGE">
                    <StorefrontImageForm />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Icon } from "@iconify/vue";
import { MenuPages, useStorefrontStore } from "@/stores/storefront.js";
import StorefrontCommissionForm from "./StorefrontCommissionForm.vue";
import StorefrontTosForm from "./StorefrontTosForm.vue";
import StorefrontImageForm from "./StorefrontImageForm.vue";

export default {
    components: {
        Icon,
        StorefrontCommissionForm,
        StorefrontTosForm,
        StorefrontImageForm,
    },
    data() {
        return {
            MenuPages,
            store: useStorefrontStore(),
            components: [
                { type: "commission", label: "Commission", icon: "lucide:form" },
                {
                    type: "tos",
                    label: "Tos",
                    icon: "material-symbols:contract-outline-rounded",
                },
                { type: "image", label: "Image", icon: "lucide:image" },
                { type: "text", label: "Text", icon: "lucide:text" },
                { type: "kanban", label: "Kanban", icon: "lucide:kanban" },
                { type: "divider", label: "Divider", icon: "pixel:divider" },
            ],
        };
    },
    methods: {
        changePage(componentType) {
            switch (componentType) {
                case "commission":
                    this.store.setPage(MenuPages.COMMISSION);
                    break;
                case "tos":
                    this.store.setPage(MenuPages.TOS);
                    break;
                case "image":
                    this.store.setPage(MenuPages.IMAGE);
                    break;
            }
        },
    },
    mounted() {
        this.store.setPage(MenuPages.GLOBAL);
    },
};
</script>
