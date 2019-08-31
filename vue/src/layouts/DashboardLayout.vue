<template>
  <div class="container" ref="dashboardLayout">
    <dashboard-navbar></dashboard-navbar>
    <dashboard-sidebar></dashboard-sidebar>
    <main>
      <vs-row>
        <vs-col vs-offset="2" vs-type="flex" vs-w="10" class="main-content">
            <router-view/>
        </vs-col>
      </vs-row>
    </main>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import DashboardNavbar from "../components/DashboardNavbar.vue";
import DashboardSidebar from "../components/DashboardSidebar.vue";

export default {
  name: "dashboard-layout",
  components: {
    DashboardNavbar,
    DashboardSidebar
  },
  computed: {
    ...mapGetters("user", {
      isLoggedIn: "isLoggedIn",
      user: "user"
    }),
    ...mapGetters("pages", {
      base_url:"base_url",
      site_url:"site_url",
      index: "index"
    })
  },
  created() {
    if (this.user.role === "admin") {
      let SidebarAdmin = require('../components/SidebarAdmin.js');
      let array = []
      SidebarAdmin.default.map(i => (i.child) ? array.push(i.child) : array.push(i))
      let merged = [].concat.apply([], array);
      let redirect = merged.find(i => i.index == this.index).link.name;
      if (redirect) {
        this.$router.push({ name: redirect });
      } else {
        this.$router.push({ path: this.site_url + "/v/dashboard" });
      }
    } else if (this.user.role === "operator") {
      let SidebarOperator = require('../components/SidebarOperator.js');
      let array = []
      SidebarOperator.default.map(i => (i.child) ? array.push(i.child) : array.push(i))
      let merged = [].concat.apply([], array);
      let redirect = merged.find(i => i.index == this.index).link.name;
      if (redirect) {
        this.$router.push({ name: redirect });
      } else {
        this.$router.push({ path: this.site_url + "/v2/dashboard/admin" });
      }
    } else if (this.user.role === "vendor") {
      let SidebarVendor = require('../components/SidebarVendor.js');
      let array = []
      SidebarVendor.default.map(i => (i.child) ? array.push(i.child) : array.push(i))
      let merged = [].concat.apply([], array);
      let redirect = merged.find(i => i.index == this.index).link.name;
      if (redirect) {
        this.$router.push({ name: redirect });
      } else {
        this.$router.push({ path: this.site_url + "/v/dashboard/vendor" });
      }
    } else if (this.user.role === "developer") {
      let SidebarDev = require('../components/SidebarDev.js');
      let array = []
      SidebarDev.default.map(i => (i.child) ? array.push(i.child) : array.push(i))
      let merged = [].concat.apply([], array);
      let redirect = merged.find(i => i.index == this.index).link.name;
      if (redirect) {
        this.$router.push({ name: redirect });
      } else {
        this.$router.push({ path: this.site_url + "/v/dashboard/" });
      }
    }
  }
};
</script>
