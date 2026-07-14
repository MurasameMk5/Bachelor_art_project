<template>
    <div class="bg-slate-200 p-2 rounded-lg flex flex-col gap-2">
        <div class="pl-4 pt-2 relative w-6 h-6">
            <Icon icon="lucide:paperclip"  class="absolute top-0 left-0 w-full h-full"/>
            <input type="file" class="absolute top-0 left-0 w-full h-full cursor-pointer opacity-0" />
        </div>
        <div class="flex flex-row gap-2 items-center justify-between">
            <input type="text" class="bg-slate-50 rounded-md w-full p-3 h-10 rounded-l-full"/>
            <button class="btn-primary p-3 rounded-full">
                <Icon icon="lucide:send" />
            </button>
        </div>
    </div>
</template>

<script>
import { Icon } from '@iconify/vue';

export default {
    components: {
        Icon
    }
}
</script>
