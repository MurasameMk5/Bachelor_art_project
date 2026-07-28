<template>
    <div v-if="preview || $page.props.auth.user.id !== artist" class="flex flex-col gap-4 m-2">
        <h1 class="text-2xl font-bold">Terms of Service</h1>
        <p> {{text}} </p>
    </div>
    <div v-else class="flex flex-col gap-4 m-2">
        <h1 class="text-2xl font-bold">Terms of Service</h1>
        <textarea class="bg-slate-50 border-slate-200 border rounded-md w-full p-2 field-sizing-content" v-model="typedText">
        </textarea>
    </div>
</template>

<script>
export default {
    props: {
        text: {
            type: String,
            required: true
        },
        preview: {
            type: Boolean,
            default: false
        },
        artist: {
            type: Number,
            required: true
        }
    },
    data() {
        return {
            typedText: this.text,
        };
    },
};
</script>
