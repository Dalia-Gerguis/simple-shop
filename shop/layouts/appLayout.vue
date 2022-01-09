<template>
  <div class="bg-grey-lighter flex flex-col font-primary min-h-screen">
    <header class="bg-blue-darker shadow-lg text-white py-6">
      <nav class="container flex justify-between mx-auto w-3/4">
        <div class="italic">Simple Shop</div>
        <div class="-ml-32">
          <template v-if="this.$auth.loggedIn">
            <div class="relative inline-block text-left cursor-pointer mx-3">
              <h5 
                class="text-white" 
                @click="showCat =! showCat">Categories</h5>
              <div 
                v-if="showCat" 
                class="origin-top-right absolute right-0 mt-6 w-56 rounded-md shadow-lg bg-blue-darker" 
                @click="showCat =! showCat"
              >
                <div class="" >
                  <NuxtLink 
                    v-for="(category, index) in categories" 
                    :key="index" 
                    :to="'/categories/' + category.id"
                    class="no-underline text-white block px-4 py-2 text-sm hover:bg-white hover:text-black"
                  >{{ category.name }}</NuxtLink>
                </div>
              </div>
            </div>
            <div class="relative inline-block text-left cursor-pointer mx-3">
              <h5 
                class="text-white" 
                @click="showBrand =! showBrand">Brands</h5>
              <div 
                v-if="showBrand" 
                class="origin-top-right absolute right-0 mt-6 w-56 rounded-md shadow-lg bg-blue-darker"
                @click="showBrand =! showBrand"
              >
                <div class="">
                  <NuxtLink 
                    v-for="(brand, index) in brands" 
                    :key="index" 
                    :to="'/brands/' + brand.id" 
                    class="no-underline text-white block px-4 py-2 text-sm hover:bg-white hover:text-black">{{ brand.name }}</NuxtLink>
                </div>
              </div>
            </div>
            <div class="inline-block text-left cursor-pointer mx-3">
              <div class="">
                <NuxtLink 
                  to="/products" 
                  class="no-underline text-white text-sm">Products</NuxtLink>
              </div>
            </div>
            <div class="inline-block text-left cursor-pointer mx-3">
              <div class="">
                <NuxtLink 
                  to="/cart"
                  class="no-underline text-white text-sm">
                  Cart</NuxtLink>
              </div>
            </div>
          </template>
        </div>
        <div class="space-x-5">
          <template v-if="this.$auth.loggedIn">
            <span>{{ this.$auth.user.name }}</span>
            <NuxtLink 
              to="/dashboard" 
              class="no-underline text-white mx-2">Dashboard</NuxtLink>
            <a 
              href="#" 
              class="no-underline text-white mx-2"
              @click.prevent="logout">LOGOUT</a>
          </template>
          <template v-else>
            <NuxtLink 
              to="/auth/register"
              class="no-underline text-white mx-2">REGISTER</NuxtLink>
            <NuxtLink 
              to="/auth/login"
              class="no-underline text-white mx-2">LOGIN</NuxtLink>
          </template>
        </div>
      </nav>
    </header>
    <Nuxt />
  </div>
</template>

<script>
export default {
  data: () => ({
    categories: [],
    brands: [],
    showCat: false,
    showBrand: false
  }),
  mounted() {
    this.getCategories();
    this.getBrands();
    window.addEventListener('click', this.closeMenus)
  },
  methods: {
    // closeMenus() {
    //   if (this.showCat) {
    //     this.showCat = false;
    //   }
    //   if (this.showBrand) {
    //     this.showBrand = false;
    //   }
    // },
    logout() {
      this.$auth.logout();
    },
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
  },
};
</script>