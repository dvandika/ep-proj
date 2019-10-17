<template>
  <vs-col vs-w="12" class="content" vs-justify="center" vs-align="center">
    <h1>Vendor Dashboard</h1>
  </vs-col>
</template>

<script>
export default {
  name: "vendor-home",
  created() {
  },
  beforeCreate() {
    this.$store.dispatch("pages/changeIndex", "0");
  }
};
</script>