<template>
    <div>
        <div class="bg-tertiary p-2 my-4">
            <span class="text-lg">Brief</span>
        </div>
        <div class="flex flex-col gap-4 p-2" v-if="!brief_view">
            <div class="flex flex-col gap-2">
                <label for="client" class="block ml-2">Client</label>
                <input type="text" class="bg-slate-50 border-slate-200 border-1 rounded-md w-full p-3 h-10" placeholder="client"/>
            </div>
            <div class="flex flex-col gap-2">
                <label for="client" class="block ml-2">Question 1</label>
                <input type="text" class="bg-slate-50 border-slate-200 border-1 rounded-md w-full p-3 h-10" placeholder="client"/>
            </div>
            <div class="flex flex-col gap-2">
                <label for="client" class="block ml-2">Question 2</label>
                <input type="text" class="bg-slate-50 border-slate-200 border-1 rounded-md w-full p-3 h-10" placeholder="client"/>
            </div>
            <div class="flex flex-col gap-2">
                <label for="client" class="block ml-2">Question 3</label>
                <input type="text" class="bg-slate-50 border-slate-200 border-1 rounded-md w-full p-3 h-10" placeholder="client"/>
            </div>
        </div>
        <div v-else>
            <editor-content :editor="editor" />
        </div>
    </div>
    <div class="flex place-content-end mt-4">
        <button class="btn-secondary" @click="brief_view = !brief_view">View brief</button>
    </div>
</template>

<script>
import {EditorContent} from '@tiptap/vue-3';
import {Editor} from '@tiptap/core';
import StarterKit from '@tiptap/starter-kit';

export default {
    components: {
        EditorContent,
    },
    data() {
        return {
            brief_view: false,
            editor: null,
        };
    },
    mounted() {
        this.editor = new Editor({
            extensions: [StarterKit],
            content: '<p>Hello World! 🌎️</p>',
        });
    },
    beforeUnmount() {
        if (this.editor) {
            this.editor?.destroy();
        }
    },
};
</script>