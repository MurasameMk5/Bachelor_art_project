<template>
    <div v-if="preview || $page.props.auth.user.id !== artist" class="flex flex-row-3 gap-2 border-t-4 border-secondary-300 rounded-xl shadow-lg p-2 bg-white">
        <div class="flex flex-col gap-4 w-full">
            <span class="text-lg">Brief</span>
            <div v-for="order in orders?.filter(order => order.production_stage === 'brief')" :key="order.id" class="flex flex-col gap-2">
                <div class="border-2 border-tertiary p-2 rounded-lg shadow-md">
                    <span> {{ order.commission?.title }} - {{ order.client?.name }} </span>
                </div>
            </div>
        </div>
        <div class="flex flex-col gap-4 w-full">
            <span class="text-lg">Production</span>
            <div v-for="order in orders?.filter(order => order.production_stage === 'production')" :key="order.id" class="flex flex-col gap-2">
                <div class="border-2 border-secondary p-2 rounded-lg shadow-md">
                    <span> {{ order.commission?.title }} - {{ order.client?.name }} </span>
                </div>
            </div>
        </div>
        <div class="flex flex-col gap-4 w-full">
            <span class="text-lg">Revision</span>
            <div v-for="order in orders?.filter(order => order.production_stage === 'revision')" :key="order.id" class="flex flex-col gap-2">
                <div class="border-2 border-secondary p-2 rounded-lg shadow-md">
                    <span> {{ order.commission?.title }} - {{ order.client?.name }} </span>
                </div>
            </div>
        </div>
        <div class="flex flex-col gap-4 w-full">
            <span class="text-lg">Awaiting payment</span>
            <div v-for="order in orders?.filter(order => order.production_stage === 'awaiting_payment')" :key="order.id" class="flex flex-col gap-2">
                <div class="border-2 border-secondary p-2 rounded-lg shadow-md">
                    <span> {{ order.commission?.title }} - {{ order.client?.name }} </span>
                </div>
            </div>
        </div>
        <div class="flex flex-col gap-4 w-full">
            <span class="text-lg">Delivered</span>
            <div v-for="order in orders?.filter(order => order.status === 'done')" :key="order.id" class="flex flex-col gap-2">
                <div class="border-2 border-secondary p-2 rounded-lg shadow-md">
                    <span> {{ order.commission?.title }} - {{ order.client?.name }} </span>
                </div>
            </div>
        </div>
    </div>
    <div v-else>
        <div class="flex flex-row-3 gap-2 border-t-4 border-secondary-300 rounded-xl shadow-lg p-2 bg-white">
            <div class="flex flex-col gap-4 w-full">
                <span class="text-lg">Brief</span>
                <div v-for="order in orders?.filter(order => order.production_stage === 'brief')" :key="order.id" class="flex flex-col gap-2">
                    <div class="border-2 border-tertiary p-2 rounded-lg shadow-md">
                        <span> {{ order.commission?.title }} - {{ order.client?.name }} </span>
                    </div>
                </div>
            </div>
            <div class="flex flex-col gap-4 w-full">
                <span class="text-lg">Production</span>
                <div v-for="order in orders?.filter(order => order.production_stage === 'production')" :key="order.id" class="flex flex-col gap-2">
                    <div class="border-2 border-secondary p-2 rounded-lg shadow-md">
                        <span> {{ order.commission?.title }} - {{ order.client?.name }} </span>
                    </div>
                </div>
            </div>
            <div class="flex flex-col gap-4 w-full">
                <span class="text-lg">Revision</span>
                <div v-for="order in orders?.filter(order => order.production_stage === 'revision')" :key="order.id" class="flex flex-col gap-2">
                    <div class="border-2 border-secondary p-2 rounded-lg shadow-md">
                        <span> {{ order.commission?.title }} - {{ order.client?.name }} </span>
                    </div>
                </div>
            </div>
            <div class="flex flex-col gap-4 w-full">
                <span class="text-lg">Awaiting payment</span>
                <div v-for="order in orders?.filter(order => order.production_stage === 'awaiting_payment')" :key="order.id" class="flex flex-col gap-2">
                    <div class="border-2 border-secondary p-2 rounded-lg shadow-md">
                        <span> {{ order.commission?.title }} - {{ order.client?.name }} </span>
                    </div>
                </div>
            </div>
            <div class="flex flex-col gap-4 w-full">
                <span class="text-lg">Delivered</span>
                <div v-for="order in orders?.filter(order => order.status === 'done')" :key="order.id" class="flex flex-col gap-2">
                    <div class="border-2 border-secondary p-2 rounded-lg shadow-md">
                        <span> {{ order.commission?.title }} - {{ order.client?.name }} </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import StorefrontComponentHeader from './StorefrontComponentHeader.vue';
export default {
    props: {
        orders: {
            type: Array,
            required: true,
        },
        preview: {
            type: Boolean,
            default: false
        },
        artist: {
            type: Number,
            required: true
        }
    },
    components: {
        StorefrontComponentHeader
    },
}
</script>
