<template>
  <div class="flex flex-col gap-4 items-center justify-center h-screen">
    <h1>Sign In</h1>
    <form class="flex flex-col gap-4 w-1/3">
      <input type="email" placeholder="Email" />
      <input type="password" placeholder="Password" />
      <button type="submit">Sign In</button>
    </form>
    <span>Don't have an account? <Link href="/sign-up">Sign up</Link></span>
  </div>
</template>

<script>
import { Link } from '@inertiajs/vue3';
import App from '../App.vue';
export default {
    layout: App,
    components: {
        Link,
    },
    data() {
        return {
            // Add your data properties here
        };
    },
    methods: {
        // Add your methods here
    },
};
</script>
