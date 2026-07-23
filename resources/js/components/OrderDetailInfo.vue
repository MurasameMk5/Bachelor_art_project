<template>
    <div class="m-4 p-4 rounded-lg bg-tertiary-300 border-2 border-tertiary">
        <p>The {{ name }} has been sent to the client for confirmation!</p>
    </div>
</template>

<script>
export default {
    props: {
        name: {
            type: String,
            required: true,
        },
    },
}
</script>