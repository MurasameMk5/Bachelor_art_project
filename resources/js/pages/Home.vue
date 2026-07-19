<template>
    <div class="h-full">
        <div v-if="!connected" class="flex items-center justify-center h-full">
            <div class="h-1/2 bg-tertiary-300 w-full flex flex-col gap-4 items-center justify-center">
                <h1 class="text-3xl text-center my-8">Art Commission platform</h1>
                <div class="flex flex-row gap-4 justify-around">
                    <button class="btn-secondary-filled"><Link href="/sign-up">sign up</Link></button>
                    <button class="btn-secondary"><Link href="/sign-in">sign in</Link></button>
                </div>
            </div>
        </div>
        <div v-else class="flex flex-col gap-4">
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
    </div>
</template>

<script>
import StorefrontKanban from '@/components/StorefrontKanban.vue';
import { Icon } from '@iconify/vue';
import { Head, Link } from '@inertiajs/vue3';
import App from '../App.vue';

export default {
    layout: App,
    components: {
        StorefrontKanban,
        Icon,
        Head,
        Link,
    },
    data() {
        return {
            connected: true,
            doingOrders: [
                { id: 1, type: "Character Sketch", step: "brief", deadline: "2026-08-30", client: "John" },
                { id: 2, type: "Illustration", step: "sketch", deadline: "2026-09-15", client: "Aless" },
                { id: 3, type: "Concept Art", step: "revision", deadline: "2026-08-01", client: "Maria" },
                { id: 3, type: "Concept Art", step: "revision", deadline: "2026-08-01", client: "Maria" },
                { id: 3, type: "Concept Art", step: "revision", deadline: "2026-08-01", client: "Maria" },
            ],
        };
    },
    methods: {},
};
</script>
