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
            <span> Liste de commandes</span>
            <StorefrontKanban/>
            <div>
                <span> En cours</span>
                <div class="flex flex-row gap-4 justify-center">
                    <div v-for="doingCommand in doingCommands" class="bg-secondary w-30 h-40">

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import StorefrontKanban from '@/components/StorefrontKanban.vue';

export default {
    components: {
        StorefrontKanban,
    },
    data() {
        return {
            connected: true,
            doingCommands: [
                { id: 1, title: "Command 1" },
                { id: 2, title: "Command 2" },
                { id: 3, title: "Command 3" },
            ],
        };
    },
    methods: {},
};
</script>
