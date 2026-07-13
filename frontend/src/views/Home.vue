<template>
    <div class="m-8">
        <div v-if="!connected">
            <h1 class="text-xl text-center my-8">Art Commission platform</h1>
            <div class="flex flex-row gap-4 justify-around">
                <button class="btn-secondary">sign up</button>
                <button class="btn-secondary">sign in</button>
            </div>
        </div>
        <div v-else class="flex flex-col gap-4">
            <span> Command list</span>
            <StorefrontKanban/>
            <div>
                <span> Work in progress</span>
                <div class="flex flex-row gap-4 justify-center">
                    <router-link v-for="doingOrder in doingOrders" :key="doingOrder.id" :to="`/order/${doingOrder.id}`" class="shadow-md h-80 flex flex-col relative rounded-md gap-2 w-1/6 hover:shadow-xl transition-shadow">
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
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import StorefrontKanban from '@/components/StorefrontKanban.vue';
import { Icon } from '@iconify/vue';

export default {
    components: {
        StorefrontKanban,
        Icon,
    },
    data() {
        return {
            connected: true,
            doingOrders: [
                { id: 1, type: "Character Sketch", step: "brief", deadline: "2026-08-30", client: "John" },
                { id: 2, type: "Illustration", step: "sketch", deadline: "2026-09-15", client: "Aless" },
                { id: 3, type: "Concept Art", step: "revision", deadline: "2026-08-01", client: "Maria" },
            ],
        };
    },
    methods: {},
};
</script>
