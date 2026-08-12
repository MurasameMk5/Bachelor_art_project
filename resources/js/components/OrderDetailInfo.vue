<template>
    <div class="m-4 p-4 rounded-lg bg-tertiary-300 border-2 border-tertiary">
        <p>{{displayText}}</p>
    </div>
</template>

<script>
export default {
    props: {
        name: {
            type: String,
            required: true,
        },
        text: {
            type: String,
            required: false,
            default: null
        }
    },
    computed: {
        displayText() {
            if (this.text) {
                return this.text;
            }

            return `The ${this.name} has been sent to the client for confirmation!`;
        }
    }
}
</script>
