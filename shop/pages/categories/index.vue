es (62 sloc)  2.53 KB
   
<template>
  <div>
    <main class="container mx-auto my-6 space-y-6 w-3/4">
      <div
        v-for="(category, index) in categories"
        :key="index"
        class="flex justify-between items-center border px-3 py-3"
      >
        <div class="w-3/4">
          <div class="flex flex-col">
            <span class="text-lg font-semibold capitalize">{{
              category.name
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
    categories: [],
    errors: [],
  }),
  mounted() {
    this.getCategories();
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
  },
};
</script>