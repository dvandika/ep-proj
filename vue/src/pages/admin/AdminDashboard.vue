<template>
<vs-col vs-w="12" class="content">
<h1>Welcome to Dashboard</h1>
</vs-col>
</template>

<script>
export default {
  name: "admin-dashboard",
  beforeCreate() {
    this.$store.dispatch("pages/changeIndex", "0");
  }
};
</script>