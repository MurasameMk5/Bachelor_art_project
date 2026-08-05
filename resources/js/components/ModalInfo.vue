<template>
    <div class="fixed inset-0 bg-black/50 grid place-items-center z-50">
        <div class="bg-white p-8 rounded-md ">
            <span>
                {{text}}
            </span>
        </div>
    </div>
</template>

<script>
export default{
    props: {
        text: {
            type: String,
            default: "The order has been sent!",
        }
    }
}
</script>
