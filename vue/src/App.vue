<template>
  <div id="app">
    <router-view></router-view>
  </div>
</template>
<script>
import DashboardLayout from "./layouts/DashboardLayout.vue"
export default {
  name: "app",
  components:{
    DashboardLayout
  }  
};
</script>