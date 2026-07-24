<template>
    <div>
        <OrderDetailInfo name="brief" v-if="order.awaiting_confirmation"/>
        <div class="bg-tertiary-300 p-2 my-4 rounded-md">
            <span class="text-lg">Brief</span>
        </div>

        <div class="flex place-content-end my-4 gap-4">
            <button class="btn-secondary" v-if="brief_view">
                <span>Export brief</span>
            </button>
            <button v-if="!brief_view" class="btn-primary-filled" @click="brief_view = !brief_view">
                <span>View brief</span>
            </button>
            <button v-else class="btn-primary" @click="brief_view = !brief_view">
                <span>View answers</span>
            </button>

        </div>

        <div class="flex flex-col gap-4 p-2" v-if="!brief_view">
            <div class="flex flex-col gap-2">
                <label for="client" class="block ml-2">Client</label>
                <input type="text" class="bg-slate-50 border-slate-200 border-1 rounded-md w-full p-3 h-10" :placeholder="order.client.name"/>
            </div>
            <div v-for="answer in order.answers" :key="answer.id" class="flex flex-col gap-2">
                <label :for="`question${answer.question_id}`" class="block ml-2"> {{ answer.question?.text }}</label>
                <input type="text" class="bg-slate-50 border-slate-200 border-1 rounded-md w-full p-3 h-10" :placeholder="answer.value"/>
            </div>
        </div>

        <div v-else class="border border-slate-200 rounded-lg bg-white">
            <!-- Toolbar -->
            <div class="flex flex-wrap items-center gap-1 p-2 bg-slate-50 border-b border-slate-200">

                <button type="button" class="toolbar-btn" :class="{ 'is-active': editor.isActive({ textAlign: 'left' }) }" @click="editor.chain().focus().setTextAlign('left').run()">
                    <Icon icon="lucide:text-align-start" class="w-4 h-4" />
                </button>
                <button type="button" class="toolbar-btn" :class="{ 'is-active': editor.isActive({ textAlign: 'center' }) }" @click="editor.chain().focus().setTextAlign('center').run()">
                    <Icon icon="lucide:text-align-center" class="w-4 h-4" />
                </button>
                <button type="button" class="toolbar-btn" :class="{ 'is-active': editor.isActive({ textAlign: 'right' }) }" @click="editor.chain().focus().setTextAlign('right').run()">
                    <Icon icon="lucide:text-align-end" class="w-4 h-4" />
                </button>
                <button type="button" class="toolbar-btn" :class="{ 'is-active': editor.isActive({ textAlign: 'justify' }) }" @click="editor.chain().focus().setTextAlign('justify').run()">
                    <Icon icon="lucide:text-align-justify" class="w-4 h-4" />
                </button>

                <span class="toolbar-separator"></span>

                <button
                    type="button"
                    class="toolbar-btn"
                    :class="{ 'is-active': editor.isActive('bold') }"
                    :disabled="!editor.can().chain().focus().toggleBold().run()"
                    @click="editor.chain().focus().toggleBold().run()"
                >
                    <Icon icon="lucide:bold" class="w-4 h-4" />
                </button>
                <button
                    type="button"
                    class="toolbar-btn"
                    :class="{ 'is-active': editor.isActive('italic') }"
                    :disabled="!editor.can().chain().focus().toggleItalic().run()"
                    @click="editor.chain().focus().toggleItalic().run()"
                >
                    <Icon icon="lucide:italic" class="w-4 h-4" />
                </button>
                <button
                    type="button"
                    class="toolbar-btn"
                    :class="{ 'is-active': editor.isActive('strike') }"
                    :disabled="!editor.can().chain().focus().toggleStrike().run()"
                    @click="editor.chain().focus().toggleStrike().run()"
                >
                    <Icon icon="lucide:strikethrough" class="w-4 h-4" />
                </button>

                <span class="toolbar-separator"></span>

                <button type="button" class="toolbar-btn" :class="{ 'is-active': editor.isActive('heading', { level: 1 }) }" @click="editor.chain().focus().toggleHeading({ level: 1 }).run()">
                    <Icon icon="lucide:heading-1" class="w-4 h-4" />
                </button>
                <button type="button" class="toolbar-btn" :class="{ 'is-active': editor.isActive('heading', { level: 2 }) }" @click="editor.chain().focus().toggleHeading({ level: 2 }).run()">
                    <Icon icon="lucide:heading-2" class="w-4 h-4" />
                </button>
                <button type="button" class="toolbar-btn" :class="{ 'is-active': editor.isActive('heading', { level: 3 }) }" @click="editor.chain().focus().toggleHeading({ level: 3 }).run()">
                    <Icon icon="lucide:heading-3" class="w-4 h-4" />
                </button>

                <span class="toolbar-separator"></span>

                <button type="button" class="toolbar-btn" :class="{ 'is-active': editor.isActive('bulletList') }" @click="editor.chain().focus().toggleBulletList().run()">
                    <Icon icon="lucide:list" class="w-4 h-4" />
                </button>
                <button type="button" class="toolbar-btn" :class="{ 'is-active': editor.isActive('orderedList') }" @click="editor.chain().focus().toggleOrderedList().run()">
                    <Icon icon="lucide:list-ordered" class="w-4 h-4" />
                </button>
                <button type="button" class="toolbar-btn" @click="editor.chain().focus().setHorizontalRule().run()">
                    <Icon icon="lucide:separator-horizontal" class="w-4 h-4" />
                </button>

                <span class="toolbar-separator"></span>

                <button
                    type="button"
                    class="toolbar-btn"
                    :disabled="!editor.can().chain().focus().undo().run()"
                    @click="editor.chain().focus().undo().run()"
                >
                    <Icon icon="lucide:undo" class="w-4 h-4" />
                </button>
                <button
                    type="button"
                    class="toolbar-btn"
                    :disabled="!editor.can().chain().focus().redo().run()"
                    @click="editor.chain().focus().redo().run()"
                >
                    <Icon icon="lucide:redo" class="w-4 h-4" />
                </button>
            </div>

            <!-- Zone d'édition -->
            <div class="a4-page-wrapper">
                <editor-content
                    :editor="editor"
                    class="a4-page max-w-none focus:outline-none [&_.ProseMirror]:outline-none"
                />
            </div>
        </div>
        <div class="flex place-content-end py-4">
            <button v-if="order.awaiting_confirmation" inactive class="btn-secondary-filled bg-secondary-300 border-secondary-300">
                <span>Send brief</span>
            </button>
            <button v-else class="btn-secondary-filled">
                <span>Send brief</span>
            </button>
        </div>
    </div>
</template>

<script>
import { markRaw } from 'vue';
import { EditorContent } from '@tiptap/vue-3';
import { Editor } from '@tiptap/core';
import StarterKit from '@tiptap/starter-kit';
import TextAlign from '@tiptap/extension-text-align';
import { Icon } from '@iconify/vue';
import OrderDetailInfo from './OrderDetailInfo.vue';

export default {
    components: {
        EditorContent,
    Icon,
    OrderDetailInfo,
    },
    props: {
        order: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            brief_view: false,
            editor: null,
        };
    },
    mounted() {
        this.editor = markRaw(new Editor({
            extensions: [
                StarterKit,
                TextAlign.configure({
                    types: ['heading', 'paragraph'],
                }),
            ],
          content: '<p>Hello World! 🌎️</p>',
          onTransaction: () => {
              this.$forceUpdate();
          },
        }));
    },
    beforeUnmount() {
        if (this.editor) {
            this.editor?.destroy();
        }
    },
};
</script>
