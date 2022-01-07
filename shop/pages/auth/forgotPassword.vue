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
      <template v-if="message">
        <span class="flex justify-center text-blue-400 italic">{{
          message
        }}</span>
      </template>
      <template v-else>
        <div class="text-blue-darker mb-2">
          Forgot your password? No problem. Just let us know your email address
          and we will email you a password reset link that will allow you to
          choose a new one.
        </div>

        <form @submit.prevent="submit">
          <div class="flex flex-col mt-4">
            <!-- <label class="text-gray-50">Email</label> -->
            <input
              v-model="form.email"
              type="email"
              class="bg-grey-lightest border-2 w-full p-4 rounded-lg"
              placeholder="Email"
            >
          </div>
          <span
            v-if="errors.email"
            class="flex justify-start text-red italic mt-4"
          >{{ errors.email[0] }}</span
          >
          <div class="flex flex-col mt-4">
            <button
              type="submit"
              class="bg-blue text-white px-4 py-3 rounded font-medium w-full hover:bg-blue-dark"
            >
              Submit
            </button>
          </div>
        </form>
      </template>
    </div>
  </div>
</template>

<script>
export default {
  middleware: 'logged',
  data: () => ({
    form: {
      email: "",
    },
    errors: [],
    message: "",
  }),
  methods: {
    async submit() {
      try {
        await this.$axios.$get("sanctum/csrf-cookie");
        await this.$axios
          .$post("/api/forgot-password", this.form)
          .then((resp) => {
            this.message = resp.message;
          });
      } catch (err) {
        this.errors = err.response.data.errors;
      }
    },
  },
};
</script>