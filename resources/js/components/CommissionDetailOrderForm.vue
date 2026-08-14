<template>
    <div class="fixed inset-0 bg-black/10 grid place-items-center z-50 " @click="$emit('close')">
        <div @click.stop class="flex flex-col p-5 bg-white rounded-lg border-2 border-secondary max-h-[90vh] w-1/3 ">
            <h3 class="text-lg font-bold">Request Commission</h3>
            <p>Please fill out the form below to request this commission.</p>
            <div class="mt-4 overflow-y-auto px-5">
                <div v-for="question in commission.questions" :key="question.id" class="flex flex-col gap-2 mb-4">
                    <label :for="`question-${question.id}`" class="font-semibold">{{ question.text.label }}</label>

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

                    <!-- 💡 CORRECTION : Remplacement de v-model par @change -->
                    <input v-else-if="question.field_type === 'file'" type="file" multiple class="file:bg-secondary-300 border rounded-sm file:p-2" @change="(e) => handleFileUpload(e, question.id)"/>

                    <textarea v-else :id="`question-${question.id}`" v-model="form.answers[question.id]" class="border rounded p-2"></textarea>
                </div>
            </div>

            <!-- Ajout du shrink-0 pour que le bouton ne disparaisse pas avec le scroll -->
            <button @click="submit" class="btn-primary-filled mt-4 shrink-0" :disabled="form.processing">
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
        // 💡 NOUVELLE MÉTHODE : Pour capturer les fichiers
        handleFileUpload(event, questionId) {
            // On transforme la liste de fichiers en tableau et on l'assigne à la question
            this.form.answers[questionId] = Array.from(event.target.files);
        },
        submit() {
            this.form.post('/orders', {
                preserveState: true, // 👈 Toujours utile quand on a un modal
                onSuccess: () => {
                    console.log('Commande créée');
                    this.modalVisible = true;
                    setTimeout(() => {
                        this.modalVisible = false;
                        this.$emit('close');
                    }, 2000);
                },
            });
        },
    },
}
</script>
