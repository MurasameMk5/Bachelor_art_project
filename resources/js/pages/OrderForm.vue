<template>
    <div class="w-full flex flex-row rounded-t-xl rounded-x-xl p-2 relative cursor-pointer">
        <div class="bg-slate-600/20 transition-all hover:opacity-0 w-full h-full absolute top-0 left-0 rounded-t-xl rounded-x-xl"></div>
        <img v-for="image in commission.images" :src="image?.storage_path" class="w-full h-100 object-cover"/>
    </div>
    <div v-auto-animate class="flex flex-col gap-2 px-4 pt-2 shadow-sm">
        <h3 class="text-md font-bold">{{ commission.title }}</h3>
        <p>{{ commission.description }}</p>
    </div>
</template>

<script>
export default {
    props: {
        commission: Object,
        required: true,
    },
    data() {
        return {
        };
    },
}
</script>