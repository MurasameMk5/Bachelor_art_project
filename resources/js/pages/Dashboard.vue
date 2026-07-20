<template>
    <div class="flex flex-col gap-4 p-4">
        <span> Command list</span>
        <StorefrontKanban/>
        <div>
            <span> Work in progress</span>
            <div class="flex flex-row gap-4 justify-center">
                <Link v-for="doingOrder in doingOrders" :key="doingOrder.id" :href="`/order/${doingOrder.id}`" class="shadow-md h-80 flex flex-col relative rounded-md flex-1 gap-2 hover:shadow-xl transition-shadow">
                    <div class="flex flex-row gap-2 bg-secondary rounded-t-md text-white p-2">
                        <span>{{ doingOrder.type }}</span> - <span>{{ doingOrder.client }}</span>
                    </div>
                    <div class="m-2">
                        <span class="p-2 border-1 border-secondary rounded-lg">{{ doingOrder.step }}</span>
                    </div>
                    <div class="absolute bottom-0 p-4 flex flex-row gap-2 items-center">
                        <Icon icon="lucide:calendar" />
                        <span> {{ doingOrder.deadline }}</span>
                    </div>
                </Link>
            </div>
        </div>
    </div>
</template>

<script>
import StorefrontKanban from '@/components/StorefrontKanban.vue';
import { Icon } from '@iconify/vue';
import { Link } from '@inertiajs/vue3';
import MainLayout from '../layouts/MainLayout.vue';

export default {
    layout: MainLayout,
    components: {
        StorefrontKanban,
        Icon,
        Link,
    },
    data() {
        return {
            doingOrders: [
                { id: 1, type: "Character Sketch", step: "brief", deadline: "2026-08-30", client: "John" },
                { id: 2, type: "Illustration", step: "sketch", deadline: "2026-09-15", client: "Aless" },
                { id: 3, type: "Concept Art", step: "revision", deadline: "2026-08-01", client: "Maria" },
                { id: 4, type: "Character Design", step: "final", deadline: "2026-10-10", client: "Liam" },
                { id: 5, type: "Storyboard", step: "draft", deadline: "2026-11-05", client: "Emma" },
            ],
        };
    },
    methods: {},
};
</script>
