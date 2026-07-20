<template>
    <div class="h-full" :class="connected ? 'p-4' : ''">
        <div class="flex items-center justify-center h-full">
            <div class="h-1/2 bg-tertiary-300 w-full flex flex-col gap-4 items-center justify-center">
                <h1 class="text-3xl text-center my-8">Art Commission platform</h1>
                <div class="flex flex-row gap-4 justify-around">
                    <button class="btn-secondary-filled"><Link href="/register">sign up</Link></button>
                    <button class="btn-secondary"><Link href="/login">sign in</Link></button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Icon } from '@iconify/vue';
import { Head, Link } from '@inertiajs/vue3';
import MainLayout from '../layouts/MainLayout.vue';

export default {
    layout: MainLayout,
    components: {
        Icon,
        Head,
        Link,
    },
    data() {
        return {};
    },
    methods: {},
};
</script>
