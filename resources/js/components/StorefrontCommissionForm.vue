<template>
    <div class="flex flex-col gap-4 p-2">
        <div class="flex flex-col gap-2">
            <label for="backgroundImage" class="block text-sm font-medium text-gray-700">Title</label>
            <input v-model="form.title" type="text" class="border border-gray-400 rounded-md w-full"/>
        </div>
        <div class="flex flex-col gap-2 flex-2">
            <label for="backgroundImage" class="block text-sm font-medium text-gray-700">Price</label>
            <div class="flex flex-row gap-2">
                <input v-model="form.base_price" type="text" class="border border-gray-400 rounded-md w-full"/>
                <select v-model="form.currency" class="border border-gray-400 rounded-md flex-1">
                    <option value="usd">USD</option>
                    <option value="eur">EUR</option>
                    <option value="chf">CHF</option>
                </select>
            </div>
        </div>
        <div class="flex flex-col gap-2">
            <label for="backgroundImage" class="block text-sm font-medium text-gray-700">Estimated Days</label>
            <input v-model="form.estimated_days" type="text" class="border border-gray-400 rounded-md w-full"/>
        </div>
        <div class="flex flex-col gap-2">
            <label for="backgroundImage" class="block text-sm font-medium text-gray-700">Number of free revisions max</label>
            <input v-model="form.max_free_revisions" type="number" class="border border-gray-400 rounded-md w-full"/>
        </div>
        <div class="flex flex-col gap-2">
            <label for="backgroundImage" class="block text-sm font-medium text-gray-700">Available slots</label>
            <input v-model="form.slots_available" type="number" class="border border-gray-400 rounded-md w-full"/>
        </div>
        <div class="flex flex-col gap-2">
            <label for="backgroundImage" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea v-model="form.description" class="border border-gray-400 rounded-md w-full"/>
        </div>
        <span>Reference Images</span>
        <div class="relative flex flex-col h-50 min-w-5 max-w-full gap-2 items-center border-2 border-secondary rounded-md">
            <input v-on:change="insertFile" type="file" multiple accept=".jpg, .png, .gif" class="relative opacity-0 cursor-pointer z-10 w-full h-full"/>
            <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                <Icon icon="lucide:download" class="w-10 h-10 text-secondary"/>
                <span class="text-gray-600">Insert files</span>
            </div>
        </div>
        <div v-if="imagesSelected.length > 0" class="flex flex-row gap-4 overflow-x-auto    ">
            <div v-for="(image, i) in imagesSelected" @click="removeFile(i)" :key="i" class="relative flex-shrink-0">
                <Icon icon="lucide:delete" class="absolute top-0 right-0 text-danger" />
                <img :src="image.ref" :alt="image.label" class="h-20"/>
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
                <select v-model="question.field_type" class="border border-gray-400 rounded-md w-full">
                    <option value="text">Text</option>
                    <option value="select">Selection</option>
                    <option value="file">File</option>
                </select>
                <div v-if="question.field_type === 'select'" v-auto-animate class="flex flex-col gap-2 justify-center ">
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

        <button @click="submit" class="btn-primary">Insert</button>
    </div>
</template>

<script>
import {Icon} from '@iconify/vue';
import {useForm} from '@inertiajs/vue3';
import {useStorefrontStore} from '../stores/storefront';

export default {
    components: {
        Icon,
    },
    data() {
        return {
            imagesSelected: [],
            questions:[],
            storefrontStore: useStorefrontStore(),
            form: useForm({
                title: '',
                base_price: '',
                currency: 'usd',
                estimated_days: '',
                max_free_revisions: 0,
                slots_available: 0,
                description: '',
                images: [],
                questions: [],
                files: [],
            })
        }
    },
    methods: {
        insertFile(event) {
            const files = event.target.files;
            if (files.length > 0) {
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    this.imagesSelected.push({
                        ref: URL.createObjectURL(file),
                        label: file.name,
                        file: file,
                    });
                }
            }
        },
        removeFile(index){
            this.imagesSelected.splice(index, 1);
        },
        addQuestion(){
            this.questions.push({ text: "", field_type: "text", options: [] });
        },
        submit() {
            this.form.images = this.imagesSelected.map(img => ({
                id: img.id ?? null,
                ref: img.file ? null : img.ref,
                label: img.label,
            }));
            this.form.questions = this.questions.map(q => ({
                label: q.label,
                field_type: q.field_type,
                options: q.options,
            }));
            this.form.files = this.imagesSelected.filter(img => img.file).map(img => img.file);

            const existingId = this.storefrontStore.getData?.id;

            if (existingId) {
                this.form.patch(`/commissions/${existingId}`);
            } else {
                console.log("Submitting new commission with data:", this.form);
                this.form.post('/commissions');
            }
        }
    },
    mounted() {
        if (this.storefrontStore.getData) {
            const data = this.storefrontStore.getData;

            this.form.title = data.title ?? '';
            this.form.base_price = data.base_price ?? '';
            this.form.estimated_days = data.estimated_days ?? '';
            this.form.max_free_revisions = parseInt(data.max_free_revisions) || 0;
            this.form.slots_available = parseInt(data.slots_available) || 0;
            this.form.description = data.description ?? '';
            this.form.currency = data.currency ?? 'usd';

            this.imagesSelected = (data.images || []).map(image => ({
                id: image.id,
                ref: image.storage_path,
                label: image.caption,
            }));

            this.questions = (data.questions || []).map(question => ({
                label: question.text?.label ?? '',
                field_type: question.field_type ?? 'text',
                options: question.text?.options ?? [],
            }));
        }
    }
}
</script>
