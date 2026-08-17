<template>
    <div>
        <div class="py-4">
            <p> Max free revision: {{order.commission.max_free_revisions}} </p>
            <p> Current revision count: {{order.current_revision_count}} </p>
            <p v-if="order.current_revision_count > order.commission.max_free_revisions"> Paid revision: {{order.current_revision_count - order.commission.max_free_revisions }} </p>
        </div>
        <div class="flex flex-row gap-4">
            <Icon @click="revisionStep = 'request'" icon="lucide-arrow-left" class="w-6 h-6" :class="revisionStep === 'request' ? 'text-gray-300' : 'text-black'"/>
            <Icon @click="revisionStep = 'image'" icon="lucide-arrow-right" class="w-6 h-6" :class="revisionStep === 'image' ? 'text-gray-300' : 'text-black'"/>
        </div>
        <div v-if="revisionStep === 'request'" class="p-4">
            <div class="flex flex-row items-center component-border">
                <h1 class="component-title"> Revision {{order.current_revision_count + 1}}</h1>
                <p> {{order.stage_details?.revision[0]?.request}} </p>
            </div>
            <div class="flex flex-row justify-center gap-4 p-4">
                <span class="">How many revision does this request count?</span>
                <input class="w-20 bg-tertiary-300 rounded-lg px-2" type="number" v-model="revisionNumber"/>
            </div>
            <div class="flex flex-row gap-4 justify-end">
                <button class="btn-primary"> Refuse </button>
                <button @click="submit('accept')" class="btn-secondary-filled"> Accept </button>
            </div>
        </div>
        <div v-else-if="revisionStep === 'image'" class="p-4">
            <div class="relative flex flex-col h-50 min-w-5 max-w-full gap-2 items-center border-2 border-secondary rounded-md">
                <input type="file" multiple accept=".jpg, .png" class="relative opacity-0 cursor-pointer z-10 w-full h-full"/>
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
            revisionNumber: 1,
            revisionStep: 'request',
            form: useForm({
                current_revision_count: 0,
            })
        };
    },
    methods: {
        submit(value) {
            if (value === 'accept') {
                this.form.current_revision_count = this.order.current_revision_count + this.revisionNumber;
            }
            this.form.patch(`/orders/${this.order.id}`, {
                onSuccess: () => {
                    if(value === 'accept')
                        this.revisionStep = 'image';
                }
            })
        }
    },
    mounted() {
    },
};
</script>
