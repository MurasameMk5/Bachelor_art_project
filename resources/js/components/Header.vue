<template>
    <div
        class="mt-2 flex flex-row gap-6 border-b border-b-secondary px-4 py-4 text-sm sm:gap-10 sm:px-8 lg:gap-12 lg:px-12"
    >
        <router-link to="/home" active-class="text-tertiary font-bold"
            >Home</router-link
        >
        <router-link to="/request" active-class="text-tertiary font-bold"
            >Request</router-link
        >
        <router-link to="/storefront" active-class="text-tertiary font-bold"
            >Storefront</router-link
        >
    </div>
</template>
