<template>
    <div
        class="flex h-screen w-full max-w-sm flex-col items-start p-4 shadow-md absolute top-14"
    >
        <div class="w-full flex justify-end">
            <Icon
                @click="$emit('close')"
                icon="lucide:panel-left-close"
                class="w-6 h-6"
            />
        </div>
        <div class="w-full mb-4">
            <span class="text-lg">Global parameters</span>
            <div class="flex flex-row justify-between mx-4">
                <label>Couleurs</label>
                <div class="w-8 h-5 bg-secondary"></div>
            </div>
        </div>
        <div class="grid w-full grid-cols-3 gap-4">
            <div
                v-for="component in this.components"
                class="flex flex-col items-center text-center justify-center my-2 py-2 bg-secondary-300 rounded-3xl"
            >
                <Icon :icon="component.icon" class="w-6 h-6" />
                <span> {{ component.label }} </span>
            </div>
        </div>
    </div>
</template>

<script>
import { Icon } from "@iconify/vue";

export default {
    components: {
        Icon,
    },
    data() {
        return {
            components: [
                { type: "form", label: "Form", icon: "lucide:form" },
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
};
</script>
