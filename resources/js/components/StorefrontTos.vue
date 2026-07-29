<template>
    <div v-if="preview || $page.props.auth.user.id !== artist" class="flex flex-col gap-4 m-2">
        <h1 class="text-2xl font-bold">Terms of Service</h1>
        <p> {{component.content.text}} </p>
    </div>
    <div v-else class="flex flex-col gap-4 m-2">
        <h1 class="text-2xl font-bold">Terms of Service</h1>
        <textarea @pointerleave="submit" class="bg-slate-50 border-slate-200 border rounded-md w-full p-2 field-sizing-content" v-model="typedText">
        </textarea>
    </div>
</template>

<script>
import { useForm } from '@inertiajs/vue3';
export default {
    props: {
        component: {
            type: Object,
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
            typedText: this.component.content.text,
            form: useForm({
                content: {},
            })
        };
    },

    methods: {
        submit() {
            if (this.typedText !== this.component.content.text && this.component.id) {
                this.form.content = { text: this.typedText };
                this.form.put(`/storefront/components/${this.component.id}`);
            }
        }
    }
};
</script>
