<template>
    <div class="flex h-full w-full max-w-sm flex-col items-start bg-white p-3 shadow-lg sm:p-4">

        <!-- Bouton fermer (Fixe) -->
        <div class="w-full flex justify-end flex-shrink-0">
            <Icon @click="$emit('close')" icon="lucide:panel-left-close" class="w-6 h-6 cursor-pointer" />
        </div>

        <!-- Conteneur principal (prend l'espace restant sans dépasser grâce à min-h-0) -->
        <div v-auto-animate class="w-full flex-1 flex flex-col min-h-0 mt-2">

            <!-- PAGE : GLOBAL -->
            <div v-if="storefrontStore.getPage === MenuPages.GLOBAL" class="w-full flex-1 overflow-y-auto min-h-0 pb-10">
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
                    <div v-for="component in this.components.filter(c => c.form)" :key="component.type" @click="changePage(component.type)" class="my-2 flex cursor-pointer flex-col items-center justify-center rounded-3xl bg-secondary-300 py-2 text-center hover:bg-secondary-400">
                        <Icon :icon="component.icon" class="w-6 h-6" />
                        <span> {{ component.label }} </span>
                    </div>
                    <div v-for="component in this.components.filter(c => !c.form)" :key="component.type" @click="submit(component.type)" class="my-2 flex cursor-pointer flex-col items-center justify-center rounded-3xl bg-secondary-300 py-2 text-center hover:bg-secondary-400">
                        <Icon :icon="component.icon" class="w-6 h-6" />
                        <span> {{ component.label }} </span>
                    </div>
                </div>
            </div>

            <!-- PAGE : FORMULAIRES (Commission, etc.) -->
            <div v-else class="w-full flex-1 flex flex-col min-h-0">

                <!-- En-tête avec bouton retour (Fixe) -->
                <div class="flex flex-row items-center gap-4 mb-4 flex-shrink-0">
                    <Icon @click="storefrontStore.setPage(MenuPages.GLOBAL)" icon="lucide:arrow-left" class="w-6 h-6 cursor-pointer hover:text-gray-600" />
                    <span class="text-lg">{{ storefrontStore.getPage }}</span>
                </div>

                <!-- Zone de scroll dédiée aux formulaires -->
                <div class="w-full flex-1 overflow-y-auto min-h-0 pr-2 pb-10">
                    <div v-if="storefrontStore.getPage === MenuPages.COMMISSION">
                        <StorefrontCommissionForm :totalComponents="totalComponents" />
                    </div>
                    <div v-if="storefrontStore.getPage === MenuPages.TOS">
                        <StorefrontTosForm :totalComponents="totalComponents" />
                    </div>
                    <div v-if="storefrontStore.getPage === MenuPages.IMAGE">
                        <StorefrontImageForm :totalComponents="totalComponents" />
                    </div>
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
import { useForm } from "@inertiajs/vue3";
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
            storefrontStore: useStorefrontStore(),
            totalComponents: 0,
            form: useForm({
                type: 'text',
                content: {},
                is_visible: true,
                position: 0,
            }),
            components: [
                { type: "commission", label: "Commission", form: true, icon: "lucide:form" },
                {
                    type: "tos",
                    label: "Tos",
                    form: true,
                    icon: "material-symbols:contract-outline-rounded",
                },
                { type: "image", label: "Image", form: true, icon: "lucide:image" },
                { type: "text", label: "Text", form: false, icon: "lucide:text" },
                { type: "kanban", label: "Kanban", form: false, icon: "lucide:kanban" },
                { type: "divider", label: "Divider", form: false, icon: "pixel:divider" },
            ],
        };
    },
    methods: {
        changePage(componentType) {
            switch (componentType) {
                case "commission":
                    this.storefrontStore.setPage(MenuPages.COMMISSION);
                    break;
                case "tos":
                    this.storefrontStore.setPage(MenuPages.TOS);
                    break;
                case "image":
                    this.storefrontStore.setPage(MenuPages.IMAGE);
                    break;
            }
        },
        submit(componentType) {
            this.form.position = this.totalComponents;
            if (componentType === "text") {
                this.form.type = "text";
                this.form.content = { text: "Type your text here..." };
            } else if (componentType === "divider") {
                this.form.type = "divider";
                this.form.content = {};
            } else if (componentType === "kanban") {
                this.form.type = "kanban";
                this.form.content = {};
            }
            this.form.post("/storefront/components");
        },
    },
    mounted() {
        if(this.storefrontStore.getTotalComponents) {
            this.totalComponents = this.storefrontStore.getTotalComponents;
        }
    },
    unmounted() {
        this.storefrontStore.clearData();
    },
};
</script>
