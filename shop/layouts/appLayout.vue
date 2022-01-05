<template>
  <div class="bg-grey-lighter flex flex-col font-primary min-h-screen">
    <header class="bg-blue-darker shadow-lg text-white py-6">
      <nav class="container flex justify-between mx-auto w-3/4">
        <div>Simple Shop</div>
        <div class="space-x-5">
          <template v-if="this.$auth.loggedIn">
            <span>{{ this.$auth.user.name }}</span>
            <NuxtLink 
              to="/dashboard" 
              class="text-white mx-2">DASHBOARD</NuxtLink>
            <!-- <NuxtLink 
              to="/posts"
              class="text-white mx-2">POSTS</NuxtLink> -->
            <a 
              href="#" 
              @click.prevent="logout">LOGOUT</a>
          </template>
          <template v-else>
            <NuxtLink 
              to="/auth/register"
              class="text-white mx-2">REGISTER</NuxtLink>
            <NuxtLink 
              to="/auth/login"
              class="text-white mx-2">LOGIN</NuxtLink>
          </template>
        </div>
      </nav>
    </header>
    <Nuxt />
  </div>
</template>

<script>
export default {
  methods: {
    logout() {
      this.$auth.logout();
    },
  },
};
</script>