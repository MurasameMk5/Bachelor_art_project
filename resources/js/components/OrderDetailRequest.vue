<template>
    <div>
        <div class="bg-tertiary-300 p-2 my-4 rounded-md">
            <span class="text-lg">Request detail</span>
        </div>

        <div class="flex flex-col gap-4 p-2">
            <div class="flex flex-col gap-2">
                <label for="client" class="block ml-2">Client</label>
                <input type="text" class="bg-slate-50 border-slate-200 border rounded-md w-full p-3 h-10" :placeholder="order.client.name"/>
            </div>
            <div v-for="answer in order.answers" :key="answer.id" class="flex flex-col gap-2">
                <label :for="`question${answer.question_id}`" class="block ml-2"> {{ answer.question?.text.label }}</label>
                <input type="text" readonly="readonly" class="bg-slate-50 border-slate-200 border rounded-md w-full p-3 h-10" :placeholder="answer.value.text"/>
            </div>
        </div>
        <div class="flex place-content-end my-4 gap-4">
            <button @click="submit('refuse')" class="btn-primary">
                <span>Refuse request</span>
            </button>
            <button @click="submit('confirm')" class="btn-primary-filled">
                <span>Confirm request</span>
            </button>
        </div>
        <ModalInfo text="" v-if="confirmationModal"/>
    </div>
</template>

<script>
import { Icon } from '@iconify/vue';
import { useForm } from '@inertiajs/vue3';import ModalInfo from './ModalInfo.vue';


export default {
    components: {
        Icon,
    },
    props: {
        order: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            confirmationModal: false,
            form: useForm({
                status: '',
                production_stage : '',
            })
        };
    },
    methods: {
        submit(value) {
            if (value === 'confirm') {
                this.form.status = 'doing';
                this.form.production_stage = 'brief';
            }
            else if (value === 'refuse')
                this.form.status = 'cancelled';
            ;
            this.form.patch(`/order/${this.order.id}`, {
                onSucess: () => {
                    this.confirmationModal = true;
                    setTimeout(() => {
                        this.confirmationModal = false;
                    }, 1500)
                }
            })
        }
    },
    mounted() {
    },
};
</script>
