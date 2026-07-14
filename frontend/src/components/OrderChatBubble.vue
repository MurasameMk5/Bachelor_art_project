<template>
    <div class="shadow-lg rounded-md p-4" :class="{'border-r-3 border-r-tertiary bg-tertiary-300': chat.role === 'client', 'border-l-3 border-l-secondary bg-secondary-300': chat.role === 'artist'}">
        <div class="flex items-center gap-4 mb-2">
            <div v-if="chat.role=== 'artist'" class="rounded-full bg-slate-100 w-10 h-10"></div>
            <span class="font-semibold">{{ chat.sender }}</span>
        </div>
        <p>{{ chat.message }}</p>
    </div>
</template>

<script>
export default {
    props: ['chat']
}
</script>