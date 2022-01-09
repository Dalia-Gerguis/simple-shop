<template>
  <div class="">
    <div 
      class="flex border-l">
      <div 
        v-if="Object.keys(products).length > 0" 
        class="container flex flex-col mx-auto justify-center max-h-32">
        <div
          v-for="(product, index) in products"
          :key="index"
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
            <div class="text-4xl m-2">
              {{ product.name }}
            </div>
            <div class="text-xl m-2">
              {{ product.details }}
            </div>
            <div 
              v-if="product.categories.length > 0" 
              class="flex m-3">
              <div>Categories:</div>
              <div
                v-for="(category, index) in product.categories"
                :key="index"
                class="flex flex-row"
              >
                <NuxtLink
                  :to="'/categories/' + category.id"
                  class="no-underline text-black block mx-2 hover:text-blue"
                >{{ category.name }}</NuxtLink
                >
              </div>
            </div>
            <div 
              v-if="product.brands.length > 0" 
              class="flex m-3">
              <div>Brands:</div>
              <div
                v-for="(brand, index) in product.brands"
                :key="index"
                class="flex flex-row"
              >
                <NuxtLink
                  :to="'/categories/' + brand.id"
                  class="no-underline text-black block mx-2 hover:text-blue"
                >{{ brand.name }}</NuxtLink
                >
              </div>
            </div>
            <div class="flex flex-row justify-between">
              <div 
                v-if="product.amount > 0" 
                class="flex m-3">
                <div>Price: {{ product.amount + " EGP" }}</div>
              </div>
              <div class="flex m-3">
                Quantity: {{ product.quantity }}
              </div>
            </div>
          </div>
        </div>
        <div class="flex flex-row">
          <div class="mt-5">
            <h3>Order total = {{ total + ' EGP' }}</h3>
            <div>
              Order status
              <select
                v-model="status"
                class="
                focus:ring-indigo-dark focus:border-indigo-dark
                h-full
                w-32
                py-1
                px-5
                border border-blue
                bg-white
                text-black
                rounded-sm
                mb-5
                "
              >
                <option
                  class="text-black relative my-2 hover:bg-blue"
                >
                  Paid
                </option>
                <option
                  class="text-black relative my-2 hover:bg-blue"
                >
                  unPaid
                </option>
              </select>
              <span 
                v-if="errors.status" 
                class="text-red italic">{{ errors.status[0] }}
              </span>
            </div>
          </div>
          <div class="mt-8">
            <button 
              class="mx-5 bg-green px-5 py-3 rounded-lg hover:bg-green-light" 
              @click="makeOrder()">
              make order!
            </button>
          </div>
        </div>
      </div>
      <div 
        v-else 
        class="my-10 flex flex-col mx-auto w-1/2 text-center">
        <div class="bg-red-light my-10 text-red-darker border-2 border-red p-3 rounded-lg">
          your cart is empty! enjoy shopping
        </div>
        <button class="bg-green py-3 rounded-lg hover:bg-green-light">
          <NuxtLink
            to="/products"
            class="no-underline text-black"
          >go to products page</NuxtLink
          >        
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  layout: "appLayout",
  middleware: "auth",
  data: () => ({
    products: {},
    errors: [],
    total: 0,
    status: ''
  }),
  mounted() {
    this.getData();
  },
  methods: {
    async getData() {
      try {
        await this.$axios.$get("/api/cart").then((resp) => {
            this.products = resp.cart;
            this.total = resp.total;
        });
      } catch (error) {
        // this.$router.replace("/products");
        console.log("log error", error);
      }
    },
    async makeOrder() {
      try {
        await this.$axios.$post("/api/orders/create", {
          total: this.total,
          status: this.status
        }).then((resp) => {
          console.log(resp);
        });
        this.$router.replace("/dashboard");
      } catch (error) {
          this.errors = error.response.data.errors;
        console.log("log error", error);
      }
    },
    // async addToCart(id) {
    //   try {
    //     await this.$axios
    //       .$post("/api/cart/add", {
    //         id: id,
    //         quantity: 1,
    //       })
    //       .then((resp) => {
    //         this.product = resp.data.product;
    //         this.categories = resp.data.categories;
    //         this.brand = resp.data.brands;
    //       });
    //   } catch (error) {
    //     this.$router.replace("/products");
    //     console.log(error);
    //   }
    // },
  },
};
</script>
<style>
.pagination {
  display: flex;
  list-style: none;
  justify-content: end;
  margin-right: 3%;
}
.page-item {
  text-align: center;
  width: 5rem;
  border: #1c3d5a 2px solid;
  padding: 0.5% 0 0.5% 0;
}
.page-link {
  margin: 3% 0 3% 0;
  text-decoration: none;
  color: #1c3d5a;
}
.page-link:hover {
  text-decoration: underline;
}
.active {
  color: black;
}
</style>