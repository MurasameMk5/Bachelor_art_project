<template>
    <Link :href="`/${storefront.slug}/${commission.id}`" class="w-full flex flex-row rounded-t-xl rounded-x-xl p-2 relative cursor-pointer">
        <div class="bg-slate-600/20 transition-all hover:opacity-0 w-full h-full absolute top-0 left-0 rounded-t-xl rounded-x-xl"></div>
        <img v-for="image in commission.images" :src="image?.storage_path" class="w-full h-100 object-cover"/>

        <span class="absolute top-0 left-0 bg-secondary text-white mt-4 ml-4 px-4 py-2 rounded-full">{{ commission.title }}</span>
        <span class="absolute bottom-0 right-30 bg-secondary text-white mb-4 mr-4 px-4 py-2 rounded-full"> {{ commission.estimated_days }} days</span>
        <span class="absolute bottom-0 right-0 bg-secondary text-white mb-4 mr-4 px-4 py-2 rounded-full">{{ commission.base_price }} {{ commission.currency }}</span>
    </Link>
</template>

<script>
import { Link } from '@inertiajs/vue3';

export default {
    props: {
        commission: Object,
        required: true,
    },
    data() {
        return {
            expanded: false,
        };
    },
    mounted() {
        console.log(this.commission.component.storefront)
    },
}
</script>