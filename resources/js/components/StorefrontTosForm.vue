<template>
    <div class="flex flex-col gap-4">
        <textarea v-model="text" class="w-full h-ful border border-gray-400 c p-4 field-sizing-content"></textarea>
        <button @click="submit" class="btn-primary">Insert</button>
        <ModalInfo v-if="confirmationModal" text="Component created"/>
</div>
</template>

<script>
import { useForm } from "@inertiajs/vue3";
import ModalInfo from "./ModalInfo.vue";

export default {
    props: {
        totalComponents: {
            type: Number,
            required: true,
        },
    },
    components: {
        ModalInfo,
    },
    data() {
        return {
            text: 'Welcome to our platform! Please read these terms and conditions carefully before using our services.',
            confirmationModal: false,
            form: useForm({
                type: 'tos',
                content: {},
                is_visible: true,
                position: 0,
            })
        }
    },
    methods: {
        submit() {
            this.form.content = {
                text: this.text,
            };
            this.form.position = this.totalComponents + 1;
            this.form.post('/storefront/components', {
                onSuccess: () => {
                    this.confirmationModal = true;
                    setTimeout(() => {
                        this.confirmationModal = false;
                    }, 1500)
                }
            });
        }
    }
};
</script>
