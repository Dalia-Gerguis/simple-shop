<template>
  <div class="my-auto">
    <main class="container mx-auto">
      <div 
        v-if="message" 
        class="my-10 flex flex-col mx-auto w-1/2 text-center">
        <div class="bg-red-light my-10 text-red-darker border-2 border-red p-3 rounded-lg">
          {{ message }}
        </div>
      </div>
      <form
        class="bg-red-800 rounded w-3/4 mx-auto px-6 py-6 space-y-6"
        @submit.prevent="submit"
      >
        <div class="flex justify-between w-full">
          <div class="w-1/3">
            <label
              id="listbox-label"
              class="block font-medium text-gery-darker mb-2"
            >
              categories
            </label>
            <div class="mt-1 relative">
              <div class="mt-1 relative">
                <select
                  v-model="form.category"
                  class="
                    focus:ring-indigo-dark focus:border-indigo-dark
                    h-full
                    w-48
                    py-3
                    px-5
                    border border-blue
                    bg-white
                    text-black
                    rounded-sm
                    mb-5
                  "
                >
                  <option
                    v-for="(category, index) in categories"
                    :key="index"
                    :value="category.id"
                    class="text-black relative my-2 hover:bg-blue"
                  >
                    {{ category.name }}
                  </option>
                </select>
              </div>
            </div>
          </div>
          <div class="w-1/3">
            <label
              id="listbox-label"
              class="block font-medium text-gery-darker mb-2"
            >
              brands
            </label>
            <div class="mt-1 relative">
              <select
                v-model="form.brand"
                class="
                  focus:ring-indigo-dark focus:border-indigo-dark
                  h-full
                  w-48
                  py-3
                  px-5
                  border border-blue
                  bg-white
                  text-black
                  rounded-sm
                  mb-5
                "
              >
                <option
                  v-for="(brand, index) in brands"
                  :key="index"
                  :value="brand.id"
                  class="text-black relative my-2 hover:bg-blue"
                >
                  {{ brand.name }}
                </option>
              </select>
            </div>
          </div>
        </div>
        <div class="flex flex-col mt-4">
          <input
            v-model="form.name"
            type="text"
            class="bg-grey-lightest border-2 w-full p-4 rounded-lg"
            placeholder="Product Name"
            autofocus
          >
          <span 
            v-if="errors.name" 
            class="text-red italic">{{ errors.name[0] }}
          </span>
        </div>
        <div class="flex flex-col mt-4">
          <textarea
            v-model="form.details"
            class="
              form-control
              block
              w-full
              bg-grey-lightest 
              border-2 
              w-full 
              p-4 
              rounded-lg
              focus:border-black
              focus:outline-none
            "
            rows="3"
            placeholder="Product details"
          />
          <span 
            v-if="errors.slug" 
            class="text-red italic">{{ errors.slug[0] }}</span>
        </div>
        <div class="flex flex-col mt-4">
          <input
            v-model="form.product_code"
            type="text"
            class="bg-grey-lightest border-2 w-full p-4 rounded-lg"
            placeholder="Product code"
            autofocus
          >
          <span 
            v-if="errors.product_code" 
            class="text-red italic">{{ errors.product_code[0] }}</span>
        </div>
        <div class="flex flex-col mt-4">
          <input
            v-model="form.amount"
            type="text"
            class="bg-grey-lightest border-2 w-full p-4 rounded-lg"
            placeholder="Product amount"
            autofocus
          >
          <span 
            v-if="errors.amount" 
            class="text-red italic">{{ errors.amount[0] }}</span>
        </div>
        <div class="flex flex-col mt-3">
          <button
            type="submit"
            class="bg-blue text-white px-4 py-3 rounded font-medium w-full hover:bg-blue-dark"
          >
            Submit
          </button>
        </div>
      </form>
    </main>
  </div>
</template>

<script>
export default {
  layout: "appLayout",
  middleware: "admin",
  data: () => ({
    form: {
      category: {},
      brand: {},
      name: "",
      slug: "",
      product_code: "",
      amount: "",
      details: ""
    },
    errors: [],
    categories: [],
    brands: [],
    message: ''
  }),
  mounted() {
    this.getCategories();
    this.getBrands();
  },
  methods: {
    async getCategories() {
      try {
        await this.$axios.$get("/api/categories").then((resp) => {
          this.categories = resp.data;
        });
      } catch (error) {
        console.log(error);
      }
    },
    async getBrands() {
      try {
        await this.$axios.$get("/api/brands").then((resp) => {
          this.brands = resp.data;
        });
      } catch (error) {
        console.log(error);
      }
    },
    async submit() {
      if (this.$auth.user === 1) {
        try {
          await this.$axios
            .$post("/api/products/create", this.form)
            .then((resp) => {
              this.message = resp.message;
            });
          this.$router.replace("/products");
        } catch (error) {
          this.errors = error.response.data.errors;
        }
      } else {
        this.message = 'You are not allowed!'; 
      }
    },
  },
};
</script>