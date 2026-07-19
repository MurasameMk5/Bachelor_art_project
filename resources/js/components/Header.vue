<template>
    <div
        class="mt-2 flex flex-row gap-6 border-b border-b-secondary px-4 py-4 text-sm sm:gap-10 sm:px-8 lg:gap-12 lg:px-12"
    >
        <Link href="/" active-class="text-tertiary font-bold"
            >Home</Link
        >
        <Link href="/request" active-class="text-tertiary font-bold"
            >Request</Link
        >
        <Link href="/storefront" active-class="text-tertiary font-bold"
            >Storefront</Link
        >
    </div>
</template>

<script>
import { Link } from '@inertiajs/vue3';
    export default {
        components: {
            Link,
        },
    };
</script>
