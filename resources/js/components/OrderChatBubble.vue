<template>
    <div class="shadow-lg rounded-md p-4" :class="{'border-r-3 border-r-tertiary bg-tertiary-300': chat.sender.role === 'client', 'border-l-3 border-l-secondary bg-secondary-300': chat.sender.role === 'artist'}">
        <div class="flex items-center gap-4 mb-2">
            <div v-if="chat.sender.role=== 'artist'" class="rounded-full bg-slate-100 w-10 h-10"></div>
            <span class="font-semibold">{{ chat.sender.name }}</span>
        </div>
        <p>{{ chat.content.text }}</p>
    </div>
</template>

<script>
export default {
    props: {
        chat: {
            type: Object,
            required: true,
        },
    },
}
</script>