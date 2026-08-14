<template>
    <div>
        <OrderDetailInfo name="brief" v-if="order.awaiting_confirmation"/>
        <div class="bg-secondary p-2 my-4 rounded-md">
            <span class="text-lg">Generate brief</span>
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

        <!-- Client answers view -->
        <div class="flex flex-col gap-4 p-2" v-if="!brief_view">
            <div class="flex flex-col gap-2">
                <label for="client" class="block ml-2">Client</label>
                <input type="text" class="bg-slate-50 border-slate-200 border rounded-md w-full p-3 h-10" :placeholder="order.client.name"/>
            </div>
            <div v-for="answer in order.answers" :key="answer.id" class="flex flex-col gap-2">
                <label :for="`question${answer.question_id}`" class="block ml-2"> {{ answer.question?.text.label }}</label>
                <div v-if="hasFiles(answer)" class="flex flex-wrap gap-3 rounded-md border border-slate-200 bg-slate-50 p-3">
                    <a v-for="file in answer.value.files" key="file.url":href="file.url" target="_blank" rel="noopener noreferrer" class="flex flex-col gap-2 items-center">
                        <img v-if="isImage(file)" :src="file.url":alt="file.name" class="h-24 w-24 rounded-md object-cover"/>
                        <span class="max-w-32 truncate text-sm text-secondary underline">{{ file.name }}</span>
                    </a>
                </div>
                <input v-else type="text" readonly="readonly" class="bg-slate-50 border-slate-200 border-1 rounded-md w-full p-3 h-10" :placeholder="answer.value.text"/>
            </div>
        </div>

        <!-- Brief edition view -->
        <div v-else class="border border-slate-200 rounded-lg bg-white">
            <div v-if="editor && !order.awaiting_confirmation" class="flex flex-wrap items-center gap-1 p-2 bg-slate-50 border-b border-slate-200">
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

            <div class="a4-page-wrapper">
                <editor-content
                    :editor="editor"
                    class="a4-page max-w-none focus:outline-none [&_.ProseMirror]:outline-none"
                />
            </div>
        </div>
        <div class="flex place-content-end py-4">
            <button v-if="!order.awaiting_confirmation" @click="submit" class="btn-secondary-filled">
                <span>Send brief</span>
            </button>
        </div>
    </div>

    <!-- Template for the brief -->
    <div ref="briefTemplate" style="display: none;">
        <h2>Art commission brief</h2>
        <hr>
        <h3>Commission type</h3>
        <p><strong>{{ order.commission.title }}</strong></p>
        <p>{{ order.commission.description }}</p>
        <hr>
        <h3>Commission request</h3>
        <p><strong>Client name :</strong> {{ order.client.name }}</p>
        <p><strong>Client email adress :</strong> {{ order.client.email }}</p>
            <div v-for="answer in order.answers" :key="answer.id">
                <strong>{{ answer.question?.text.label }}</strong>
                <p>
                    {{ answer.value.text }}
                </p>
                <ul v-if="hasFiles(answer)">
                    <li v-for="file in answer.value.files" :key="file.url">
                        <a :href="file.url" target="_blank" rel="noopener noreferrer">{{ file.name }}</a>
                    </li>
                </ul>
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
import { useForm } from '@inertiajs/vue3';

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
            awaitingConfirmationModal: false,
            brief_view: false,
            editor: null,
            form: useForm({
                awaiting_confirmation: false,
                stage_details : {}
            })
        };
    },
    methods: {
        hasFiles(answer) {
            return Array.isArray(answer?.value?.files) && answer.value.files.length > 0;
        },
        isImage(file) {
            return /\.(png|jpe?g|gif|webp)$/i.test(file?.name ?? '');
        },
        submit() {
            this.form.awaiting_confirmation = true;
            this.form.stage_details = {
                brief: {
                    brief_html: this.editor.getHTML()
                }
            };
            this.form.patch(`/orders/${this.order.id}`, {
                onSucess: () => {
                    this.awaitingConfirmationModal = true;
                }
            })
        }
    },
    mounted() {
        let briefHTML = '';
        this.$nextTick(() => {
            if (this.order.stage_details?.brief?.brief_html)
                briefHTML = this.form.stage_details.brief.brief_html;
            else
                briefHTML = this.$refs.briefTemplate.innerHTML;

            this.editor = markRaw(new Editor({
                editable: !this.order.awaiting_confirmation,
                extensions: [
                    StarterKit,
                    TextAlign.configure({ types: ['heading', 'paragraph'] }),
                ],
                content: briefHTML,
                onTransaction: () => {
                    this.$forceUpdate();
                },
            }));
        });
    },
    beforeUnmount() {
        if (this.editor) {
            this.editor?.destroy();
        }
    },
};
</script>
