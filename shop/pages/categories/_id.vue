<template>
  <div>
    <div class="m-5">
      <h2>{{ category.name }}</h2>
    </div>
    <div class="border-l w-4/5">
      <div class="container flex flex-wrap mx-auto">
        <div
          v-for="(product, index) in products.data"
          :key="index"
          class="flex flex-col w-full p-4 rounded-md sm:w-1/2 md:w-1/3 mt-5"
        >
          <NuxtLink
            :to="'/products/' + product.id"
            class="no-underline">
            <img
              :alt="product.name"
              :src="product.image ? product.image : require(`~/assets/images/noimage.jpg`)"
              class="h-72 w-full max-h-custom object-cover md:w-72 lg:w-96"
            >
            <div class="flex justify-around bg-grey-dark py-2">
              <span class="text-white">{{ product.name }}</span>
              <span class="text-yellow">{{ product.amount+ ' EPG' }} </span>
            </div>

          </NuxtLink>
          <div class="flex flex-col">
            <button
              type="submit"
              class="bg-blue text-white px-4 py-3 rounded font-medium w-full hover:bg-blue-dark"
              @click="addToCart(product.id)"
            >
              Add to cart
            </button>
          </div>
        </div>
      </div>
    </div>
    <pagination
      :data="products"
      size="small"
      align="right"
      @pagination-change-page="getData"
    >blaa</pagination
    >
  </div>
</template>

<script>
export default {
  layout: "appLayout",
  middleware: "auth",
  head() {
    return {
      title: this.category.name,
    };
  },
  data: () => ({
    id: "",
    category: [],
    products: {},
  }),
  mounted() {
    this.id = this.$route.params.id;
    this.getData();
  },
  methods: {
    async getData(page = 1) {
      try {
        await this.$axios
          .$get("/api/categories/" + this.id + "?page=" + page)
          .then((resp) => {
            this.category = resp.data.category_details;
            this.products = resp.data.products;
          });
      } catch (error) {
        this.$router.replace("/categories");
        console.log(error);
      }
    },
    async addToCart(id) {
      try {
          await this.$axios.$post("/api/cart/add", {
              'id': id,
              'quantity': 1

          }).then((resp) => {
          });
      } catch (error) {
          this.$router.replace("/products");
          console.log(error);
      }
    }
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