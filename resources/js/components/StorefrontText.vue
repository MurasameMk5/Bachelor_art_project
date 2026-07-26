<template>
    <div v-if="preview || $page.props.auth.user.id !== artist" class="flex justify-center">
        <span> {{ text }} </span>
    </div>
    <div v-else class="component-border">
        <StorefrontComponentHeader header="Text component" />
        <textarea class="bg-slate-50 border-slate-200 border rounded-md w-full p-2 field-sizing-content" v-model="typedText"></textarea>
    </div>
</template>

<script>
import StorefrontComponentHeader from './StorefrontComponentHeader.vue';
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
    components: {
        StorefrontComponentHeader
    },
    data() {
        return {
            typedText: this.text
        };
    },
};
</script>
