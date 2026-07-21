<template>
    <div>
        <h1>Profile</h1>
        <p>This is the profile page.</p>
        <span> {{user.name}} </span>
    </div>
</template>

<script>
import MainLayout from '../layouts/MainLayout.vue';

export default {
    layout: MainLayout,
    props: {
        user: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            // Add your data properties here
        };
    },
    methods: {
        // Add your methods here
    },
}
</script>
