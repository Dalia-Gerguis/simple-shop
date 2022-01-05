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
        <span class="flex justify-center text-blue italic">{{
          message
        }}</span>
      </template>

      <template v-else>
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
          >{{ errors.this.email[0] }}</span
          >

          <div class="flex flex-col mt-4">
            <!-- <label class="text-gray-50">New Password</label> -->
            <input
              v-model="form.password"
              type="password"
              class="bg-grey-lightest border-2 w-full p-4 rounded-lg"
              placeholder="New Password"
            >
          </div>
          <span
            v-if="errors.password"
            class="flex justify-start text-red italic mt-4"
          >{{ errors.password[0] }}</span
          >

          <div class="flex flex-col mt-4">
            <!-- <label class="text-gray-50">Confirm New Password</label> -->
            <input
              v-model="form.password_confirmation"
              type="password"
              class="bg-grey-lightest border-2 w-full p-4 rounded-lg"
              placeholder="Confirm New Password"
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
        </form>
      </template>
    </div>
  </div>
</template>

<script>
export default {
  data: () => ({
    form: {
      email: "",
      token: "",
      password: "",
      password_confirmation: "",
    },
    errors: [],
    message: "",
  }),
  mounted() {
    return [
      (this.form.email = this.$route.query.email),
      (this.form.token = this.$route.params.token),
    ];
  },
  methods: {
    async submit() {
      try {
        await this.$axios
          .$post("/api/reset-password", this.form)
          .then((resp) => {
            this.message = resp.message;
          });
        this.$router.replace("/auth/login");
      } catch (error) {
        this.errors = error.response.data.errors;
      }
    },
  },
};
</script>