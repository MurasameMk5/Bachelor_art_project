<template>
    <div v-if="preview" class="flex justify-center">
        <span> {{ text }} </span>
    </div>
    <textarea v-else class="bg-slate-50 border-slate-200 border rounded-md w-full p-2 field-sizing-content" v-model="typedText">
    </textarea>
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
        }
    },
    data() {
        return {
            typedText: this.text
        };
    },
};
</script>
