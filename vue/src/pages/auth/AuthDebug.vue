<template>
  <div class="login-box">
    <vs-row
      vs-type="flex"
      vs-w="12"
      vs-justify="center"
      vs-align="center"
      :style="{'margin-top':'100px'}"
    >
      <vs-col vs-type="flex" vs-align="center" vs-justify="center" vs-w="4">
        <img :src="base_url+'assets/images/aski-logo.png'" :style="{width:'90px'}">
      </vs-col>
      <vs-col vs-type="flex" :style="{'flex-direction':'column'}" vs-w="6">
        <h2 :style="{'font-size':'15px'}">Electronic Order Portal</h2>
        <div :style="{'font-size':'11px'}">PT. Astra Komponen Indonesia</div>
      </vs-col>
    </vs-row>
    <vs-row
      vs-type="flex"
      vs-w="12"
      vs-justify="center"
      vs-align="center"
      :style="{'margin-bottom':'100px'}"
    >
      <vs-col vs-type="flex" vs-justify="center" vs-w="10" :style="{'padding':'5px'}">
        <vs-button
          color="primary"
          type="filled"
          @click="login('admin')"
          :style="{'width':'200px', 'margin':'5px'}"
          size="small"
        >Admin</vs-button>
        <vs-button
          color="primary"
          type="filled"
          @click="login('vendor')"
          :style="{'width':'200px', 'margin':'5px'}"
          size="small"
        >Vendor</vs-button>
        <vs-button
          color="primary"
          type="filled"
          @click="login('operator')"
          :style="{'width':'200px', 'margin':'5px'}"
          size="small"
        >Operator</vs-button>
        <vs-button
          color="primary"
          type="filled"
          @click="login('developer')"
          :style="{'width':'200px', 'margin':'5px'}"
          size="small"
        >Developer</vs-button>
      </vs-col>
    </vs-row>
  </div>
</template>
<script>
import { mapGetters, mapState } from "vuex";

export default {
  name: "auth-debug",
  computed: {
    ...mapState({
      userStatus: state => state.user.userStatus,
      role:state=>state.user.role
    }),
    ...mapGetters("user", {
      isLoggedIn: "isLoggedIn",
      user: "user"
    }),
    ...mapGetters("pages", {
      base_url:"base_url",
      site_url:"site_url"
    })
  },
  methods: {
    login: function(role){
        console.log(role);
      this.$store.dispatch("user/loginDebug", role);
    }
  },
  beforeCreate() {
    this.$store.commit("pages/clearIndex");
    this.$store.commit("user/clearStatus");
  }
};
</script>
<style>
body {
  height: auto;
  min-height: 100%;
  background: #d2d6de;
}
</style>