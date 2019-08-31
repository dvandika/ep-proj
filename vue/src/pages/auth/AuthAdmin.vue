<template>
  <div class="login-box">
    <vs-row class="head" vs-type="flex" vs-w="10" vs-justify="center" vs-align="center">
      <vs-col vs-type="flex" vs-align="center" vs-justify="center" vs-w="4">
        <img :src="base_url+'assets/images/aski-logo.png'" :style="{width:'100px'}" />
      </vs-col>
      <vs-col vs-offset="1" vs-type="flex" :style="{'flex-direction':'column'}" vs-w="7">
        <div :style="{'font-size':'18px'}">Admin Login</div>
        <div :style="{'font-size':'12px'}">PT. Astra Komponen Indonesia</div>
      </vs-col>
    </vs-row>
    <vs-col
      class="divider"
      :style="{'margin-left' : 'auto', 'margin-right' : 'auto'}"
      vs-w="10"
      vs-type="flex"
      vs-justify="flex-start"
      vs-align="flex-start"
    >
      <vs-divider color="primary"></vs-divider>
    </vs-col>
    <vs-row
      vs-type="flex"
      vs-w="12"
      vs-justify="center"
      vs-align="center"
      :style="{'margin-bottom':'5px'}"
    >
      <vs-col vs-type="flex" vs-justify="center" vs-w="10" :style="{'padding':'3px'}">
        <vs-input
          type="text"
          label="Username"
          placeholder="Username"
          v-model="form.username"
          :style="{'width' : '75%'}"
          size="large"
        />
      </vs-col>
      <vs-col vs-type="flex" vs-justify="center" vs-w="10" :style="{'padding':'3px'}">
        <vs-input
          type="password"
          label="Passaword"
          placeholder="Password"
          v-model="form.password"
          :style="{'width' : '75%'}"
          size="large"
        />
      </vs-col>
      <vs-col vs-type="flex" vs-justify="left" vs-w="6" :style="{'padding':'3px'}">
        <span :style="{'font-size' : '10px'}">v.1.0.0</span>
      </vs-col>
      <vs-col vs-type="flex" vs-justify="center" vs-w="4" :style="{'padding':'3px'}">
        <vs-button type="filled" icon="lock" @click="login()">Login</vs-button>
      </vs-col>
    </vs-row>
  </div>
</template>
<script>
import { mapGetters, mapState } from "vuex";

export default {
  name: "auth-admin",
  data() {
    return {
      form: {
          username: '',
          password: ''
      }
    };
  },
  computed: {
    ...mapState({
      userStatus: state => state.user.userStatus,
      role: state => state.user.role
    }),
    ...mapGetters("user", {
      isLoggedIn: "isLoggedIn",
      user: "user"
    }),
    ...mapGetters("pages", {
      base_url: "base_url",
      site_url: "site_url"
    })
  },
  methods: {
    login: function() {
        let user = this.form.username;
        let pass = this.form.password;
      this.$store.dispatch("user/loginAdmin", { user, pass });
    }
  }
};
</script>
<style scoped>
body {
  height: auto;
  min-height: 100%;
  background: #d2d6de;
}
.vs-input {
  width: 100% !important;
  display: block !important;
}
.vs-button {
  width: 100% !important;
}
.login-box > div > .head {
  margin-top: 20px !important;
}
.divider {
  margin-bottom: 5px !important;
}
</style>
