<template>
    <div class="mx-4 mt-4 flex flex-col gap-4">
        <div class="flex flex-row justify-between items-center bg-tertiary px-4 rounded-md">
            <span> You received a request for a new painting</span>
            <button class="btn-secondary">Open</button>
        </div>
    </div>
</template>

<script>
import App from '../App.vue';
export default {
    layout: App,
    data() {
        return {
            // Add your data properties here
        };
    },
    methods: {
        // Add your methods here
    },
};
</script>
