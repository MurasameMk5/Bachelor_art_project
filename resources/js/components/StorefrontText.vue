<template>
    <div class="flex justify-center">
        <span> {{ text }} </span>
    </div>
</template>

<script>
export default {
    props: {
        text: {
            type: String,
            required: true
        }
    }
}
</script>
