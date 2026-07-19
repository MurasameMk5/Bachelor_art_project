<template>
    <div class="flex flex-col gap-4">
        <div class="flex flex-col gap-2">
            <label for="backgroundImage" class="block text-sm font-medium text-gray-700">Title</label>
            <input type="text" class="border border-gray-400 rounded-md w-full"/>
        </div>
        <div class="flex flex-col gap-2">
            <label for="backgroundImage" class="block text-sm font-medium text-gray-700">Price</label>
            <input type="text" class="border border-gray-400 rounded-md w-full"/>
        </div>
        <div class="flex flex-col gap-2">
            <label for="backgroundImage" class="block text-sm font-medium text-gray-700">Time</label>
            <input type="text" class="border border-gray-400 rounded-md w-full"/>
        </div>
        <div class="flex flex-col gap-2">
            <label for="backgroundImage" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea class="border border-gray-400 rounded-md w-full"/>
        </div>
        <span>Reference Images</span>
        <div class="relative flex flex-col h-50 min-w-5 max-w-full gap-2 items-center border-2 border-secondary rounded-md">
            <input v-on:change="insertFile" type="file" multiple accept="jpg, png" class="relative opacity-0 cursor-pointer z-10 w-full h-full"/>
            <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                <Icon icon="lucide:download" class="w-10 h-10 text-secondary"/>
                <span class="text-gray-600">Insert files</span>
            </div>
        </div>
        <div v-if="imagesSelected.length > 0" class="flex flex-row gap-4 overflow-x-auto    ">
            <div v-for="(image, i) in imagesSelected" @click="removeFile(i)" :key="i" class="relative flex-shrink-0">
                <Icon icon="lucide:delete" class="absolute top-0 right-0 text-danger" />
                <img :src="image.url" alt="Preview" class="h-20"/>
            </div>
        </div>
        <div class="flex flex-row justify-between gap-2">
            <span>Questions</span>
            <button @click="addQuestion" class="btn-secondary">Add Question</button>
        </div>
        <div v-auto-animate class="flex flex-col gap-2">
            <div v-for="(question, index) in questions" v-auto-animate :key="index" class="flex flex-col gap-2">
                <div class="flex flex-row items-center justify-between gap-2">
                    <span> Question {{ index + 1 }}</span>
                    <Icon @click="questions.splice(index, 1)" class="btn-danger hover:text-red-500 transition-color" icon="lucide:trash-2"/>
                </div>
                <input v-model="question.label" type="text" class="border border-gray-400 rounded-md w-full"/>
                <select v-model="question.type" class="border border-gray-400 rounded-md w-full">
                    <option value="text">Text</option>
                    <option value="radio">Radio Button</option>
                    <option value="file">File</option>
                </select>
                <div v-if="question.type === 'radio'" v-auto-animate class="flex flex-col gap-2 justify-center ">
                    <span>Options</span>
                    <div class="flex flex-col gap-2">
                        <div v-for="(option, optionIndex) in question.options" :key="optionIndex" class="flex flex-row items-center gap-2">
                            <input v-model="question.options[optionIndex]" type="text" class="border border-gray-400 rounded-md w-full"/>
                            <Icon @click="question.options.splice(optionIndex, 1)" class="btn-danger hover:text-red-500 transition-color" icon="lucide:trash-2"/>
                        </div>
                    </div>
                    <button @click="question.options.push('')" class="btn-secondary">Add Option</button>
                </div>
            </div> 
        </div>

        <button class="btn-primary">Insert</button>
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
            questions:[]
        }
    },
    methods: {
        insertFile(event) {
            const files = event.target.files;
            if (files.length > 0) {
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    this.imagesSelected.push(URL.createObjectURL(file));
                }
            }
        },
        removeFile(index){
            this.imagesSelected.splice(index, 1);
        },
        addQuestion(){
            this.questions.push({ label: "", type: "text", options: []});
        },
    },
    mounted() {
    }
}
</script>
