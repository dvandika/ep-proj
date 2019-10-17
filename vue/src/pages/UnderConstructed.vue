<template>
  <vs-col vs-type="flex" vs-w="11" class="content">
      <vs-row class="" vs-type="flex">
        <vs-row vs-w="12" vs-type="flex" :style="{margin:'10px'}">
            <h3>Under Constructed</h3>
        </vs-row>
      </vs-row>
  </vs-col>
</template>

<script>
export default {
  name:"under-constructed",
  beforeCreate() {
    this.$store.dispatch("user/changeIndex", "0");
  }
}
</script>