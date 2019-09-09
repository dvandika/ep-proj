<template>
  <div class="login-box">
    <vs-row class="head" vs-type="flex" vs-w="10" vs-justify="center" vs-align="center">
      <vs-col vs-type="flex" vs-align="center" vs-justify="center" vs-w="4">
        <img :src="base_url+'assets/images/aski-logo.png'" :style="{width:'100px'}" />
      </vs-col>
      <vs-col vs-offset="1" vs-type="flex" :style="{'flex-direction':'column'}" vs-w="7">
        <h2 :style="{'font-size':'18px'}">Admin Login</h2>
        <div :style="{'font-size':'10px'}">PT. Astra Komponen Indonesia</div>
      </vs-col>
    </vs-row>
    <vs-col
      class="divider"
      style="margin-left: auto; margin-right: auto; margin-bottom: 0"
      :style="{'margin-left' : 'auto', 'margin-right' : 'auto'}"
      vs-w="10"
      vs-justify="flex-start"
      vs-align="flex-start"
    >
      <vs-divider color="primary"></vs-divider>
    </vs-col>
    <vs-col
      v-if="status.failed"
      vs-type="flex"
      vs-align="flex-start"
      vs-justify="flex-start"
      vs-w="10"
      style="padding:0; margin: 2px auto"
    >
      <vs-alert :active="status.failed" color="danger" icon="new_releases">
        <span>{{ status.message }}</span>
      </vs-alert>
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
  name: "auth-vendor",
  data() {
    return {
      form: {
        username: "",
        password: ""
      }
    };
  },
  computed: {
    ...mapState({
      status: state => state.user.status,
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
      let form = new FormData();
      form.append("username", this.form.username);
      form.append("password", this.form.password);
      this.$store.dispatch("user/loginAdmin", form).then(success => {
        if (success) {
          this.$router.push({ name: "admin-dashboard" });
        }
      });
    }
  },
  beforeCreate() {
    this.$store.commit("user/clearStatus");
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
