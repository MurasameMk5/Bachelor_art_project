<template>
    <Link v-if="preview || $page.props.auth.user.id !== artist" :href="`/${storefrontSlug}/${commission.id}`" target="_blank" class="w-full flex flex-row rounded-t-xl rounded-x-xl overflow-hidden relative cursor-pointer">
        <div class="bg-slate-600/20 transition-all hover:opacity-0 w-full h-full absolute top-0 left-0 rounded-t-xl rounded-x-xl"></div>
        <img v-for="image in commission.images" :src="image?.storage_path" class="w-full h-100 object-cover"/>

        <span class="absolute top-0 left-0 bg-secondary text-white mt-4 ml-4 px-4 py-2 rounded-full">{{ commission.title }}</span>
        <span class="absolute top-0 right-5 bg-secondary text-white mt-4 ml-4 px-4 py-2 rounded-full">{{ commission.slots_available }} slots available</span>
        <span class="absolute bottom-0 right-30 bg-secondary text-white mb-4 mr-4 px-4 py-2 rounded-full"> {{ commission.estimated_days }} days</span>
        <span class="absolute bottom-0 right-0 bg-secondary text-white mb-4 mr-4 px-4 py-2 rounded-full">{{ commission.base_price }} {{ commission.currency }}</span>
    </Link>
    <div v-else class="flex flex-row">
        <img v-for="image in commission.images" :src="image?.storage_path" class="w-full h-100 object-contain"/>

        <span class="absolute top-0 left-0 bg-secondary text-white mt-4 ml-4 px-4 py-2 rounded-full">{{ commission.title }}</span>
        <Icon @click="storefrontStore.setSidebarActive(true, MenuPages.COMMISSION, commission)" icon="lucide:square-pen" class="absolute w-6 h-6 bottom-0 right-0 mb-4 mr-4"/>
    </div>
</template>

<script>
import { Link } from '@inertiajs/vue3';
import { Icon } from '@iconify/vue';
import StorefrontComponentHeader from './StorefrontComponentHeader.vue';
import { MenuPages, useStorefrontStore } from '../stores/storefront';

export default {
    props: {
        commission: {
            type: Object,
            required: true,
        },
        storefrontSlug: {
            type: String,
            required: true,
        },
        artist: {
            type: Number,
            required: true,
        },
        preview: {
            type: Boolean,
            default: false,
        },
    },
    components: {
        Link,
        StorefrontComponentHeader,
        Icon,
    },
    data() {
        return {
            MenuPages,
            storefrontStore: useStorefrontStore(),
        };
    },
    mounted() {
    },
}
</script>
