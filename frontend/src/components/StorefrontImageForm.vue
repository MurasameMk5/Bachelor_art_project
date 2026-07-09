<template>
    <div class="flex flex-col gap-8">
        <span>Images are positioned and resized to fit in a line. Below is a preview of how they will be positioned based on the number selected. </span>
        <div class="flex flex-row justify-between gap-2">
            <span>Number of images</span>
            <input type="number" min="1" max="10" v-model="imageNumber"/>
        </div>
        <div class="flex flex-row gap-2 justify-center" v-auto-animate>
            <div v-for="i in imageNumber" :key="i" class="relative flex flex-col h-50 min-w-5 max-w-full gap-2 items-center bg-secondary-300">
                <input v-on:change="(e) => insertFile(e, i)" type="file" accept="jpg, png" class="relative opacity-0 cursor-pointer z-10 w-full h-full"/>
                <Icon icon="lucide:download" class="absolute inset-0 m-auto" :style="{ display: imagesSelected[i-1] ? 'none' : 'block' }"/>
                <img v-if="imagesSelected[i-1]" :src="imagesSelected[i-1]" alt="Preview" class="w-full h-full absolute top-0 object-cover"/>
            </div>
        </div>
        <span class="text-sm text-center"> This is a preview. Images will be resized according to their original format.</span>
        <button class="w-full btn-primary">Insert</button>
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
            imageNumber: 1,
            imagesSelected: [],
        }
    },
    methods: {
        insertFile(event, index) {
            const file = event.target.files[0];
            if (file) {
                const url = URL.createObjectURL(file);
                this.imagesSelected[index - 1] = file;
            }
        }
    },
    mounted() {
    }
}
</script>

