<template>
    <div class="flex h-72 w-full max-w-full flex-row justify-center gap-2">
        <div v-for="image in images" class="flex flex-1 flex-col">
            <img
                :src="image.image_ref"
                :alt="image.image_desc"
                class="h-0 min-h-0 w-full flex-1 object-contain"
            />
            <span class="mt-1 text-center text-sm leading-tight">{{ image.label }}</span>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        images: {
            type: Array,
            default: () => [],
        },
    },
}
</script>