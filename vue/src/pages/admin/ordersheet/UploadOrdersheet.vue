<template>
  <vs-col vs-type="flex" vs-w="11" class="content">
    <h3>Upload Ordersheet</h3>
    <vs-col class="content-body" vs-w="12">
      <!-- vendor information -->
      <vs-row vs-type="flex" vs-justify="left" :style="{'margin': '15px 0'}">
        <vs-col vs-offset="1" vs-w="2">Vendor Name</vs-col>
        <vs-col vs-w="3" vs-justify="center" vs-align="center" class="space-vertical">
          <vs-select width="400px" v-model="form.vendor" size="large" autocomplete>
            <vs-select-item
              :key="index"
              :value="item.VendorCode"
              :text="item.VendorName + ' (' + item.VendorCode + ')'"
              v-for="(item, index) in vendor_option"
            ></vs-select-item>
          </vs-select>
        </vs-col>
      </vs-row>
      <vs-row vs-type="flex" vs-justify="left" :style="{'margin': '15px 0'}">
        <vs-col vs-offset="1" vs-w="2">File</vs-col>
        <vs-col vs-w="3" vs-justify="center" vs-align="center" class="space-vertical">
          <input type="file" name="file" ref="file" @change="onFileChange()" />
        </vs-col>
      </vs-row>
      <vs-row vs-type="flex" vs-justify="right">
        <vs-col vs-w="3">
          <vs-button style="margin:10px;" @click="upload()" size="medium">Upload</vs-button>
        </vs-col>
      </vs-row>
    </vs-col>
  </vs-col>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  name: "os-upload",
  computed: {
    ...mapGetters("pages", {
      index: "index",
      base_url: "base_url",
      site_url: "site_url"
    })
  },
  data() {
    return {
      form: {
        vendor: ""
      },
      vendor_option: []
    };
  },
  methods: {
    onFileChange() {
      this.file = this.$refs.file.files[0];
      console.log(this.file);
    },
    fetchVendors() {
      axios.get(this.site_url + "/admins/vendor").then(res => {
        this.vendor_option = res.data;
      });
    },
    upload() {
      console.log(this.form.vendor);
      let formData = new FormData();
      formData.append("vendor", this.form.vendor);
      formData.append("file", this.file);
      axios
        .post(this.site_url + "/admins/ordersheet/do_upload/", formData)
        .then(res => {
          // console.log(res.data);
          this.$vs.notify({
            color: "success",
            title: "Berhasil",
            text: res.data.success + " data berhasil ditambahkan.<br>"
            + res.data.failed + " sudah ada dalam database.",
            icon: "done_all"
          });
          this.$router.push({name: "list-os"});
        })
        .catch(err => {
          console.log(err);
          this.$vs.notify({
            color: "danger",
            title: "Gagal upload"
          });
        });
    }
  },
  created() {
    this.fetchVendors();
  },
  beforeCreate() {
    this.$store.dispatch("pages/changeIndex", "2");
  }
};
</script>