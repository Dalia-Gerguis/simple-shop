<template>
  <div
    class="
      container
      mx-auto
      flex flex-col
      justify-center
      items-center
      min-h-screen
    "
  >
    <div
      class="
        bg-grey-lightest
        shadow-lg
        p-8
        rounded-lg
        w-2/3
        xl:w-1/2
      "
    >
      <h1
        class="
          text-blue text-3xl text-center
        "
      >
        Register
      </h1>
      <form @submit.prevent="submit">
        <div class="flex flex-col mt-4">
          <!-- <label class="text-gray-50">Name</label> -->
          <input
            v-model="form.name"
            type="text"
            class="bg-grey-lightest border-2 w-full p-4 rounded-lg"
            placeholder="Name"
            autofocus
          >
          <span
            v-if="errors.name" 
            class="text-red italic" 
          >{{
            errors.name[0]
          }}</span>
        </div>
        <div class="flex flex-col mt-4">
          <!-- <label class="text-gray-50">Email</label> -->
          <input
            v-model="form.email"
            type="email"
            class="bg-grey-lightest border-2 w-full p-4 rounded-lg"
            placeholder="Email"
          >
          <span 
            v-if="errors.email"
            class="text-red italic" 
          >{{
            errors.email[0]
          }}</span>
        </div>
        <div class="flex flex-col mt-4">
          <!-- <label class="text-gray-50">Password</label> -->
          <input
            v-model="form.password"
            type="password"
            class="bg-grey-lightest border-2 w-full p-4 rounded-lg"
            placeholder="Password"
          >
          <span 
            v-if="errors.password"
            class="text-red italic" 
          >{{
            errors.password[0]
          }}</span>
        </div>
        <div class="flex flex-col mt-4">
          <!-- <label class="text-gray-50">Confirm your password</label> -->
          <input
            v-model="form.password_confirmation"
            type="password"
            class="bg-grey-lightest border-2 w-full p-4 rounded-lg"
            placeholder="Password Confirmation"
          >
        </div>
        <div class="flex flex-col mt-4">
          <button
            type="submit"
            class="bg-blue text-white px-4 py-3 rounded font-medium w-full hover:bg-blue-dark"
          >
            Submit
          </button>
        </div>
        <div class="flex justify-center mt-4">
          <NuxtLink 
            to="/auth/login" 
            class="text-blue hover:text-blue-darker"
          >Already have an account?</NuxtLink
          >
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  data: () => ({
    form: {
      name: "",
      email: "",
      password: "",
      password_confirmation: "",
    },
    errors: [],
  }),
  methods: {
    async submit() {
      try {
        await this.$axios.$get("sanctum/csrf-cookie");
        await this.$axios.$post("/api/register", this.form);
        // this.$router.replace("/auth/verify");
        await this.$auth.loginWith('laravelSanctum', {data: this.form});
      } catch (error) {
        //   console.log(error);
        this.errors = error.response.data.errors;
      }
    },
  },
};
</script>