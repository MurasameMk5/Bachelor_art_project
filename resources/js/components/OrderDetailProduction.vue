<template>
    <div class="flex flex-col gap-4">
        <OrderDetailInfo v-if="order.awaiting_confirmation" />

        <div class="bg-tertiary-300 p-2 my-4 rounded-md">
            <span class="text-lg">Production</span>
        </div>
        <span>Insert images</span>

        <div class="flex flex-col gap-2">
            <label>Stage</label>
            <select v-model="selectedStage" class="border border-gray-400 rounded-md w-full">
                <option value="">Select a stage</option>
                <option value="Sketch">Sketch</option>
                <option value="Rendering">Rendering</option>
                <option value="Inking">Inking</option>
            </select>
        </div>

        <div class="relative flex flex-col h-50 min-w-5 max-w-full gap-2 items-center border-2 border-secondary rounded-md">
            <input @change="insertFile" type="file" multiple accept=".jpg, .png" class="relative opacity-0 cursor-pointer z-10 w-full h-full"/>
            <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                <Icon icon="lucide:download" class="w-10 h-10 text-secondary"/>
                <span class="text-gray-600">Insert files</span>
            </div>
        </div>

        <div v-if="imagesSelected.length > 0" class="flex flex-col gap-4">
            <div v-for="stage in stageSelected" :key="stage" class="p-2 my-4 rounded-md">
                <span class="text-lg">{{ stage }}</span>
                <div class="flex flex-row gap-4 flex-wrap">
                    <!-- Correction : removeFile(image) au lieu de removeFile(i) -->
                    <div v-for="image in imagesSelected.filter(img => img.stage === stage)" @click="removeFile(image)" :key="image.url" class="relative cursor-pointer">
                        <Icon icon="lucide:delete" class="absolute top-0 right-0 text-danger bg-white rounded-full" />
                        <img :src="image.url" alt="Preview" class="h-40 object-cover rounded-md"/>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex place-content-end py-4">
            <button @click="submit" :disabled="form.processing" class="btn-secondary-filled">
                <span>{{ form.processing ? 'Sending...' : 'Send images' }}</span>
            </button>
        </div>
    </div>
</template>

<script>
import { Icon } from '@iconify/vue';
import { useForm } from '@inertiajs/vue3';
import OrderDetailInfo from './OrderDetailInfo.vue';
export default {
    components: {
        Icon,
        OrderDetailInfo
    },
    props: {
        order: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            imagesSelected: [],
            selectedStage: "",
            stageSelected: [],
            form: useForm({
                awaiting_confirmation: false,
                stage_details: this.order.stage_details || {},
                files: [],
                image_stages: [],
            })
        }
    },
    methods: {
        insertFile(event) {
            const files = event.target.files;
            if (!this.selectedStage) {
                alert("Please select a stage before adding images.");
                event.target.value = null;
                return;
            }

            if (files.length > 0) {
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    if(this.stageSelected.includes(this.selectedStage) === false) {
                        this.stageSelected.push(this.selectedStage);
                    }
                    this.imagesSelected.push({
                        stage: this.selectedStage,
                        url: URL.createObjectURL(file),
                        file: file
                    });
                }
            }
            event.target.value = null;
        },
        removeFile(imageToRemove) {
            const index = this.imagesSelected.indexOf(imageToRemove);
            if (index > -1) {
                if (imageToRemove.file) {
                    URL.revokeObjectURL(imageToRemove.url);
                }
                this.imagesSelected.splice(index, 1);
            }
        },
        submit() {
            this.form.awaiting_confirmation = true;

            const existingImages = this.imagesSelected.filter(img => !img.file);
            const newImages = this.imagesSelected.filter(img => img.file);

            const productionData = {};
            existingImages.forEach(img => {
                if (!productionData[img.stage]) productionData[img.stage] = [];
                productionData[img.stage].push({
                    url: img.url,
                    name: img.name,
                    uploaded_at: img.uploaded_at
                });
            });

            this.form.stage_details = this.order.stage_details || {};
            this.form.stage_details.production = productionData;

            this.form.files = newImages.map(img => img.file);
            this.form.image_stages = newImages.map(img => img.stage);

            this.form.patch(`/orders/${this.order.id}`, {
                    preserveState: true,
                    onSuccess: () => {
                        console.log('Images sent successfully!');
                    }
                });
        }
    },
    mounted() {
        if (this.order.stage_details && this.order.stage_details.production) {
            const production = this.order.stage_details.production;

            for (const stage in production) {
                if (!this.stageSelected.includes(stage)) {
                    this.stageSelected.push(stage);
                }

                production[stage].forEach(image => {
                    this.imagesSelected.push({
                        stage: stage,
                        url: image.url,
                        name: image.name,
                        uploaded_at: image.uploaded_at,
                        file: null
                    });
                });
            }
        }
    }
}
</script>
