<template>
  <div class="flex justify-items-center">
    <div
      class="
        flex flex-row
        w-3/4
        bg-white
        border border-2 border-red
        shadow-lg
        rounded-lg
        m-10
      "
    >
      <div class="w-1/3">
        <img
          :alt="product.name"
          :src="product.image ? product.image : require(`~/assets/images/noimage.jpg`)"
          class="h-72 object-cover md:w-72 lg:w-96"
        >
      </div>
      <div class="w-2/3 flex flex-col">
        <div class="text-4xl m-5">
          {{ product.name }}
        </div>
        <div class="text-xl m-5">
          {{ product.details }}
        </div>
        <div 
          v-if="categories.length > 0" 
          class="flex m-3">
          <div>
            Categories:
          </div><br>
          <div 
            v-for="(category, index) in categories" 
            :key="index"
            class="flex flex-row">
            <NuxtLink
              :to="'/categories/' + category.id"
              class="no-underline text-black block mx-2 hover:text-blue"
            >{{ category.name }}</NuxtLink
            >
          </div>
        </div>
        <div 
          v-if="brands.length > 0" 
          class="flex m-3">
          <div>
            Brands:
          </div><br>
          <div 
            v-for="(brand, index) in brands" 
            :key="index"
            class="flex flex-row">
            <NuxtLink
              :to="'/categories/' + brand.id"
              class="no-underline text-black block mx-2 hover:text-blue"
            >{{ brand.name }}</NuxtLink
            >
          </div>
        </div>
        <div 
          v-if="product.amount > 0" 
          class="flex m-3">
          <div>
            Price: {{ product.amount + " EGP" }}
          </div><br>
        </div>
        <div 
          class="flex m-3">
          <input 
            v-model="quantity"
            type="number"
            class="bg-grey-lightest border-2 w-1/5 p-3 rounded-lg">
          <div class="flex flex-col mx-2">
            <button
              type="submit"
              class="bg-blue text-white px-4 py-3 rounded font-medium w-full hover:bg-blue-dark"
              @click="addToCart()"
            >
              Add to cart
            </button>
          </div><br>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  layout: "appLayout",
  middleware: "auth",
  head() {
    return {
      title: this.product.name,
    };
  },
  data: () => ({
    product: {},
    categories: [],
    brands: [],
    quantity: 0
  }),
  mounted() {
    this.id = this.$route.params.id;
    this.getData();
  },
  methods: {
    async getData() {
      try {
        await this.$axios.$get("/api/products/" + this.id).then((resp) => {
          this.product = resp.data.product;
          this.categories = resp.data.categories;
          this.brands = resp.data.brands;
        });
      } catch (error) {
        this.$router.replace("/products");

        console.log(error);
      }
    },
    async addToCart() {
        if (this.quantity > 0) {
            try {
                await this.$axios.$post("/api/cart/add", {
                    'id': this.id,
                    'quantity': this.quantity

                }).then((resp) => {
                this.product = resp.data.product;
                this.categories = resp.data.categories;
                this.brand = resp.data.brands;
                });
            } catch (error) {
                this.$router.replace("/products");
                console.log(error);
            }
        }
    }
  },
};
</script>
