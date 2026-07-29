<template>
  <div class="flex flex-col gap-4 items-center justify-center h-screen">
    <h1>Sign In</h1>
    <form @submit.prevent="submit" class="flex flex-col gap-4 w-1/5">
      <input class="border border-gray-500 rounded p-2" v-model="form.email" type="email" placeholder="Email" />
      <input class="border border-gray-500 rounded p-2" v-model="form.password" type="password" placeholder="Password" />
      <button type="submit" @click.prevent="submit" class="btn-primary-filled">Sign In</button>
    </form>
    <span>Don't have an account? <Link href="/register" class="text-secondary font-bold">Sign up</Link></span>
  </div>
</template>

<script>
import { Link, useForm } from '@inertiajs/vue3';
import MainLayout from '../layouts/MainLayout.vue';
export default {
    layout: MainLayout,
    components: {
        Link,
    },
    data() {
        return {
            form: useForm({
                email: '',
                password: '',
            })
        };
    },
    methods: {
        submit() {
            this.form.post('/login', {
                onSuccess: () => {
                    console.log("Login successful");
                },
                onFinish: () => {
                    this.form.reset()
                },
            });
        }
    },
};
</script>
