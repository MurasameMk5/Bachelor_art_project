<template>
    <div v-if="$page.props.auth.user"
        class="border-b border-b-secondary px-4 mt-2  sm:px-8 lg:px-12 flex flex-row justify-between"
    >
        <div
        class="flex flex-row gap-6 py-4 text-sm sm:gap-10  lg:gap-12 items-center "
        >
            <span class="border-2 border-dashed border-tertiary p-2 rounded-lg"> Art commission Logo</span>
            <Link href="/dashboard" v-if="$page.props.auth.user.role === 'artist'" :class="{'text-tertiary font-bold': isActive('/dashboard')}"
                >Dashboard</Link
            >
            <Link href="/request" v-if="$page.props.auth.user.role === 'artist'" :class="{ 'text-tertiary font-bold': isActive('/request')}"
                > Request </Link
            >
            <Link href="/storefront" v-if="$page.props.auth.user.role === 'artist'" :class="{'text-tertiary font-bold' : isActive('/storefront')}"
                >Storefront</Link
            >
        </div>
        <div v-if="$page.props.auth.user" @click="logout"
        class="rounded-full bg-tertiary-300 flex justify-center items-center px-4 py-2 gap-2 cursor-pointer">
            <span class="text-sm">Log out</span>
        </div>
    </div>
</template>

<script>
import { Link, router } from '@inertiajs/vue3';
    export default {
        components: {
            Link,
    },
    methods: {
        isActive(path) {
            return this.$page.url.startsWith(path)
        },
        logout() {
            router.post('/logout');
        },
    },
    };
</script>
