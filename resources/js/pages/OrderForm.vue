<template>
    <div class="w-full flex flex-row rounded-x-xl">
        <img v-for="image in commission.images" :src="image?.storage_path" class="w-full h-100 object-cover"/>
    </div>
    <div class="flex flex-col gap-2 px-4 pt-2">
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
