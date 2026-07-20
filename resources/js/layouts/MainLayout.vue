<template>
    <div class="relative flex h-screen flex-col overflow-hidden">
        <Header />
        <main class="min-h-0 flex-1 overflow-hidden">
            <slot/>
        </main>
    </div>
</template>

<script>
import Header from "../components/Header.vue";

export default {
    components: {
        Header,
    },
};
</script>
