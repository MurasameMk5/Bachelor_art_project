<template>
    <div>
        <div class="py-4">
            <p> Max free revision: {{order.commission.max_free_revisions}} </p>
            <p> Current revision count: {{order.current_revision_count}} </p>
        </div>
        <div class="flex flex-row gap-4">
            <Icon @click="revisionStep = 'request'" icon="lucide-arrow-left" class="w-6 h-6" :class="revisionStep === 'request' ? 'text-gray-300' : 'text-black'"/>
            <Icon @click="revisionStep = 'image'" icon="lucide-arrow-right" class="w-6 h-6" :class="revisionStep === 'image' ? 'text-gray-300' : 'text-black'"/>
        </div>
        <div v-if="revisionStep === 'request'" class="p-4">
            <div>
                <p>
                    {{order.stage_details?.revision[0]?.request}}
                </p>
            </div>
            <div class="flex flex-row justify-center gap-4 p-4">
                <span class="">How many revision does this request count?</span>
                <input class="w-20" type="number" v-model="revisionNumber"/>
            </div>
            <div class="flex flex-row gap-4 justify-end">
                <button class="btn-primary"> Refuse </button>
                <button class="btn-secondary-filled"> Accept </button>
            </div>
        </div>
        <div v-else-if="revisionStep === 'image'" class="p-4">
            <div class="relative flex flex-col h-50 min-w-5 max-w-full gap-2 items-center border-2 border-secondary rounded-md">
                <input @change="insertFile" type="file" multiple accept=".jpg, .png" class="relative opacity-0 cursor-pointer z-10 w-full h-full"/>
                <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                    <Icon icon="lucide:download" class="w-10 h-10 text-secondary"/>
                    <span class="text-gray-600">Insert modified image</span>
                </div>
            </div>
            <div class="flex justify-end pt-4">
                <button class="btn-secondary-filled">Send image</button>
            </div>
        </div>
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
            revisionNumber: 1,
            revisionStep: 'request',
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
            this.form.patch(`/orders/${this.order.id}`, {
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
