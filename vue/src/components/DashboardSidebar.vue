<template>
  <vs-sidebar
    :parent="$refs.dashboardLayout"
    :default-index="getIndex"
    color="primary"
    class="sidebarx"
    hidden-background
    spacer
    v-model="active"
  >
    <div
      class="header-sidebar"
      slot="header"
      :style="{'justify-content':'center', 'display':'flex'}"
    >
      <img :src="base_url + 'assets/images/aski-logo.png'" alt="Logo" class="logo" />
    </div>
    <span :style="{'justify-content':'center', 'display':'flex', 'text-align':'center'}">
      {{ this.user.role }}
    </span>
    <template v-for="component in sidebar">
      <template v-if="component.type == 'single'">
        <vs-sidebar-item
          :index="component.index"
          :icon="component.icon"
          :key="component.index"
          :to="component.link"
        >{{component.title}}
        </vs-sidebar-item>
      </template>
      <template v-else>
        <vs-sidebar-group
          :title="component.title"
          :key="component.title"
          open
          >
          <vs-sidebar-item
            v-for="item in component.child"
            :index="item.index"
            :icon="item.icon"
            :key="item.index"
            :to="item.link"
            >{{item.title}}
          </vs-sidebar-item>
        </vs-sidebar-group>
      </template>
    </template>
    <div class="footer-sidebar" slot="footer">
      <vs-button @click="logout" icon="reply" color="danger" type="flat">log out</vs-button>
    </div>
  </vs-sidebar>
</template>

<script>
import { mapGetters, mapState } from 'vuex';

import SidebarAdmin from "./SidebarAdmin.js";
import SidebarOperator from "./SidebarOperator.js";
import SidebarVendor from "./SidebarVendor.js";
import SidebarDev from "./SidebarDev.js";

export default {
  name: "dashboard-sidebar",
  computed: {
    ...mapGetters('user', {
        user: 'user'
    }),
    sidebar: function() {
      if(this.user.role === 'admin') {
        return SidebarAdmin;
      } else if (this.user.role === 'operator') {
        return SidebarOperator;
      } else if (this.user.role === 'vendor') {
        return SidebarVendor;
      } else if (this.user.role === 'developer') {
          return SidebarDev;
      };
    },
    getIndex:function(){
      return this.index;
    },
    ...mapGetters('pages', {
        index: 'index',
        site_url: 'site_url',
        base_url: 'base_url'
    })
  },
  data() {
    return {
      active: true
    };
  },
  methods: {
    isActive: function(name) {
      return this.$route.matched.filter(x => x.name === name).length > 0
        ? true
        : false;
    },
    logout: function() {
      let self = this;
      window.location.href = this.site_url + '/auth/logout';
    },
    activeIndex:function(num){
      let self = this;
      self.$store.dispatch('pages/changeIndex', num)
    }
  },
  mounted() {
    console.log()
  }
};
</script>

<style>
.header-sidebar {
    justify-content: center;
}
.logo {
    width: 100px;
}
</style>
