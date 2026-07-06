<template>
    <div class="min-h-screen flex flex-col relative">
        <Header />
        <router-view />
    </div>
</template>

<script>
import Header from "./components/Header.vue";

export default {
    components: {
        Header,
    },
};
</script>
