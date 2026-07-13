<template>
    <div class="relative flex min-h-screen flex-col">
        <Header />
        <main class="min-h-0 flex-1">
            <router-view />
        </main>
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
