es (62 sloc)  2.53 KB
   
<template>
  <div>
    <main class="container mx-auto my-6 space-y-6 w-3/4">
      <div
        v-for="(brand, index) in brands"
        :key="index"
        class="flex justify-between items-center border px-3 py-3"
      >
        <div class="w-3/4">
          <div class="flex flex-col">
            <span class="text-lg font-semibold capitalize">{{
              brand.name
            }}</span>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>
<script>
export default {
  layout: "appLayout",
  middleware: "auth",
  data: () => ({
    brands: [],
    errors: [],
  }),
  mounted() {
    this.getBrands();
  },
  methods: {
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