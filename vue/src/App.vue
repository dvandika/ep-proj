<template>
  <div id="app">
    <!-- <dashboard-layout></dashboard-layout> -->
    <router-view></router-view>
  </div>
</template>
<script>
// import { mapGetters, mapActions, mapState } from "vuex";
import DashboardLayout from "./layouts/DashboardLayout.vue"
export default {
  name: "app",
  components:{
    DashboardLayout
  }
  // methods: {
  //   ...mapActions({
  //     clearAlert: 'alert/clearAlert'
  //   })
  // },
  // watch: {
  //   $route(to, from) {
  //     this.clearAlert();
  //   }
  // }
};
</script>