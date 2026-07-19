<template>
  <div class="flex flex-col gap-4 items-center justify-center h-screen">
    <h1>Sign In</h1>
    <form class="flex flex-col gap-4 w-1/3">
      <input type="email" placeholder="Email" />
      <input type="password" placeholder="Password" />
      <button type="submit">Sign In</button>
    </form>
    <span>Don't have an account? <router-link to="/sign-up">Sign up</router-link></span>
  </div>
</template>
