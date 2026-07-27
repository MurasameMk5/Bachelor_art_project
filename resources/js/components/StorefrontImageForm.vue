<template>
    <div class="flex flex-col gap-8">
        <span>Images are positioned and resized to fit in a line. Below is a preview of how they will be positioned based on the number selected. </span>
        <div class="flex flex-row justify-between gap-2">
            <span>Number of images</span>
            <input type="number" min="1" max="10" v-model="imageNumber"/>
        </div>
        <div class="flex flex-row gap-2 justify-center" v-auto-animate>
            <div v-for="i in imageNumber" :key="i" class="relative flex flex-col h-50 min-w-5 max-w-full gap-2 items-center bg-secondary-300">
                <input v-on:change="(e) => insertFile(e, i)" type="file" accept=".jpg, .png, .gif" class="relative opacity-0 cursor-pointer z-10 w-full h-full"/>
                <Icon icon="lucide:download" class="absolute inset-0 m-auto" :style="{ display: imagesSelected[i-1] ? 'none' : 'block' }"/>
                <img v-if="imagesSelected[i-1]" :src="imagesSelected[i-1].ref" :alt="imagesSelected[i-1].label" class="w-full h-full absolute top-0 object-cover"/>          </div>
        </div>
        <span class="text-sm text-center"> This is a preview. Images will be resized according to their original format.</span>
        <button @click="submit" class="w-full btn-primary">Insert</button>
    </div>
</template>

<script>
import { Icon } from '@iconify/vue';
import { useStorefrontStore } from '../stores/storefront';
import { useForm } from '@inertiajs/vue3';

export default {
    components: {
        Icon,
    },
    data() {
        return {
            storefrontStore: useStorefrontStore(),
            imageNumber: 1,
            imagesSelected: [],
            totalComponents: 0,
            form: useForm({
                type: 'image',
                content: {},
                files: [],
                is_visible: true,
                position: 0,
            })
        }
    },
    methods: {
        insertFile(event, index) {
            const file = event.target.files[0];
            if (file) {
                const url = URL.createObjectURL(file);
                this.imagesSelected[index - 1] = {ref: url, label: file.name, file: file};
            }
            console.log("imagesSelected", this.imagesSelected);
        },
        submit() {
            console.log("Submitting form with imagesSelected:", this.imagesSelected);
            const unchangedImages = this.imagesSelected.filter(img => img && !img.file);
            const newImages = this.imagesSelected.filter(img => img && img.file);

            this.form.content = {
                image_nb: this.imageNumber,
                images: [
                    ...unchangedImages.map(img => ({ref: img.ref, label: img.label})),
                    ...newImages.map( img=>({label: img.label}))
                ],
            };
            this.form.files = newImages.map(img => img.file);
            const existingId = this.storefrontStore.getData?.id;

            if (existingId) {
                // On force un POST, mais on dit à Laravel de le traiter comme un PUT
                this.form.transform((data) => ({
                    ...data,
                    _method: 'PUT',
                })).post(`/storefront/components/${existingId}`, {
                    onSuccess: () => {
                        console.log('Composant mis à jour avec succès', this.form);
                        this.storefrontStore.setSidebarActive(false);
                    },
                });
                return;
            }
            else {
                this.form.position = this.totalComponents;
                this.form.post('/storefront/components', {
                    onSuccess: () => {
                        console.log('Composant créé avec succès', this.form);
                        this.storefrontStore.setSidebarActive(false);
                    },
                });
            }
        }
    },
    mounted() {
        if (this.storefrontStore.getData) {
            this.imageNumber = this.storefrontStore.getData.content.image_nb || 1;
            const storeImages = this.storefrontStore.getData.content.images || [];
            this.imagesSelected = storeImages.map(img => ({...img}));
        }
        if(this.storefrontStore.getTotalComponents) {
            this.totalComponents = this.storefrontStore.getTotalComponents;
        }
        console.log("images", this.storefrontStore.getData);
    },
    watch: {
        imageNumber(newVal) {
            if (this.imagesSelected.length > newVal) {
                this.imagesSelected.splice(newVal);
            }
        }
    }
}
</script>
