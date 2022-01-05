<template>
  <div class="flex flex-col justify-between min-h-screen">
    <div
      class="flex-1 flex flex-col justify-center items-start space-y-4 ml-10"
    >
      <h1 class="text-white text-3xl">Welcome to Simple Shop</h1>
      <div class="flex space-x-12">
        <NuxtLink
          to="/auth/register"
          class="text-white mx-5 text-2xl hover:text-blue-500"
        >
          REGISTER
        </NuxtLink>
        <NuxtLink
          to="/auth/login"
          class="text-white mx-5 text-2xl hover:text-blue-500"
        >
          LOGIN
        </NuxtLink>
      </div>
    </div>
  </div>
</template>