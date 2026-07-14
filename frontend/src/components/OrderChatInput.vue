<template>
    <div class="bg-slate-200 p-2 rounded-lg flex flex-col gap-2">
        <div class="pl-4 relative w-8 h-8">
            <Icon icon="lucide:paperclip"  class="absolute t-0"/>
            <input type="file" class="absolute t-0 w-full h-full opacity-0" />
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
