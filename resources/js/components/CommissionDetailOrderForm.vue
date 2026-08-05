<template>
    <div class="fixed inset-0 bg-black/10 grid place-items-center z-50" @click.stop="$emit('close')">
        <div class="p-4 bg-white rounded-md border-2 border-secondary max-h-full m-10">
            <h3 class="text-lg font-bold">Request Commission</h3>
            <p>Please fill out the form below to request this commission.</p>
            <div class="mt-4 overflow-y-auto">
                <div v-for="question in commission.questions" :key="question.id" class="flex flex-col gap-2">
                    <label :for="`question-${question.id}`">{{ question.text.label }}</label>
                    <div v-if="question.field_type === 'select' || question.field_type === 'radio'" class="ml-2 flex flex-col gap-1">
                                        <div v-for="(option, index) in question.text.options" :key="index" class="flex flex-row gap-2 items-center">
                                            <input
                                                type="radio"
                                                :id="`question-${question.id}-option-${index}`"
                                                :name="`question-${question.id}`"
                                                :value="option"
                                                v-model="form.answers[question.id]"
                                            />
                                            <label :for="`question-${question.id}-option-${index}`" class="cursor-pointer"> {{ option }} </label>
                                        </div>
                                    </div>
                    <textarea v-else :id="`question-${question.id}`" v-model="form.answers[question.id]" class="border rounded p-2"></textarea>
                </div>
            </div>
            <button @click="submit" class="btn-primary-filled mt-4" :disabled="form.processing">
                <span>{{ form.processing ? 'Envoi...' : 'Submit Request' }}</span>
            </button>
        </div>
        <ModalInfo v-if="modalVisible" />
    </div>
</template>

<script>
import { Icon } from '@iconify/vue';
import { useForm } from '@inertiajs/vue3';
import ModalInfo from './ModalInfo.vue';

export default {
    props: {
        commission: { type: Object, required: true },
    },
    components: {
        Icon,
        ModalInfo,
    },
    data() {
        return {
            modalVisible : false,
            form: useForm({
                commission_id: this.commission.id,
                answers: {},
            }),
        };
    },
    methods: {
        submit() {
            this.form.post('/orders', {
                onSuccess: () => {
                    console.log('Commande créée');
                    this.modalVisible = true;
                    setTimeout(() => {
                        this.modalVisible = false;
                    }, 2000);
                },
            });
        },
    },
}
</script>
