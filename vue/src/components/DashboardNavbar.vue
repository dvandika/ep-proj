<template>
  <vs-navbar v-model="activeItem" class="nabarx" :color="colorx">
    <vs-navbar-title style="color:white;">{{user.role | capitalize }}</vs-navbar-title>
    <vs-spacer></vs-spacer>
    <vs-navbar-item index="1">
      <a href.prevent class="nav-item-flex">
        <span v-if="user.fullname" style="color:white;">Hi,  {{ user.fullname }}</span>
        <span v-if="user.Fullname" style="color:white;">Hi,  {{ user.Fullname }}</span>
      </a>
    </vs-navbar-item>
  </vs-navbar>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  name: "dashboard-navbar",
  computed: {
    ...mapGetters("user", {
      user: "user"
    })
  },
  filters: {
    capitalize: function(value) {
      if (!value) return "";
      value = value.toString();
      return value.charAt(0).toUpperCase() + value.slice(1);
    }
  },
  data() {
    return {
      colorx: "#282828",
      activeItem: ""
    };
  }
};
</script>