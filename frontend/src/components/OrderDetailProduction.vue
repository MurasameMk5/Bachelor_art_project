<template>
    <div class="flex flex-col gap-4">
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
            <input v-on:change="insertFile" type="file" multiple accept="jpg, png" class="relative opacity-0 cursor-pointer z-10 w-full h-full"/>
            <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                <Icon icon="lucide:download" class="w-10 h-10 text-secondary"/>
                <span class="text-gray-600">Insert files</span>
            </div>
        </div>
        <div v-if="imagesSelected.length > 0" class="flex flex-col gap-4">
            <div v-for="stage in stageSelected" :key="stage" class="p-2 my-4 rounded-md">
                <span class="text-lg">{{ stage }}</span>
                <div class="flex flex-row gap-4 flex-wrap">
                    <div v-for="(image, i) in imagesSelected.filter(img => img.stage === stage)" @click="removeFile(i)" :key="i" class="relative">
                        <Icon icon="lucide:delete" class="absolute top-0 right-0 text-danger" />
                        <img :src="image.url" alt="Preview" class="h-40"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex place-content-end py-4">
            <button class="btn-secondary-filled">
                <span>Send images</span>
            </button>
        </div>
    </div>
</template>

<script>
import {Icon} from '@iconify/vue';
export default {
    components: {
        Icon,
    },    
    data() {
        return {
            imagesSelected: [],
            selectedStage: null,
            stageSelected: [],
        }
    },
    methods: {
        insertFile(event) {
            const files = event.target.files;
            if (files.length > 0) {
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    if(this.stageSelected.includes(this.selectedStage) === false) {
                        this.stageSelected.push(this.selectedStage);
                    }
                    this.imagesSelected.push({stage: this.selectedStage, url: URL.createObjectURL(file) });
                    console.log(this.imagesSelected);
                }
            }
        },
        removeFile(index) {
            this.imagesSelected.splice(index, 1);
        }
    },
    mounted() {
    }
}
</script>