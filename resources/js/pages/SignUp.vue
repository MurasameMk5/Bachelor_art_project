<template>
  <div class="flex flex-col gap-4 items-center justify-center h-screen">
    <h1>Sign Up</h1>
    <form @submit.prevent="submit" class="flex flex-col gap-4 w-1/3">
      <input v-model="form.name" type="text" placeholder="Name" />
      <input v-model="form.email" type="email" placeholder="Email" />
      <span v-if="form.errors.email" class="text-red-500">{{ form.errors.email }}</span>
      <input v-model="form.password" type="password" placeholder="Password" />
      <span v-if="form.errors.password" class="text-red-500">{{ form.errors.password }}</span>
      <input v-model="form.password_confirmation" type="password" placeholder="Confirm Password" />
      <div class="flex items-center gap-2">
        <input v-model="form.role" type="checkbox" />
        <label for="role">Are you an artist?</label>
      </div>
      <button type="submit">Sign Up</button>
    </form>
    <span>Already have an account? <Link href="/login">Sign in</Link></span>
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
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
                role: false
            })
        };
    },
    methods: {
        submit() {
            this.form.role = this.form.role ? 'artist' : 'client';
            this.form.post('/register', {
                onSuccess: () => {
                    console.log("Registration successful");
                    this.$inertia.visit('/login');
                },
                onFinish: () => {
                    this.form.reset()
                },
            });
        }
    },
};
</script>
