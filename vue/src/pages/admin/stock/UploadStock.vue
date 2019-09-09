<template>
  <vs-col vs-type="flex" vs-w="11" class="content">
    <h3>Daily Stock Report</h3>
    <vs-col class="content-body" vs-w="12">
      <vs-alert
        color="danger"
        :active.sync="active1"
        title="Informasi Penting"
        closable
        close-icon="close"
      >Pastikan format file sesuai dengan format yang telah ditentukan.</vs-alert>
      <vs-row
        vs-justify="left"
        vs-align="center"
        vs-w="10"
        style="margin-top: 30px; padding-bottom: 20px;"
      >
        <vs-col vs-offset="1" vs-w="3">File</vs-col>
        <vs-col vs-offset="1" vs-w="5">
          <input type="file" name="file" ref="file" @change="onFileChange()" />
        </vs-col>
      </vs-row>
      <vs-row vs-justify="left" vs-align="center" vs-w="10" style="padding-bottom: 10px;">
        <vs-col vs-offset="1" vs-w="3">Catatan Tambahan</vs-col>
        <vs-col vs-offset="1" vs-w="5">

          <vs-textarea counter="50" :counter-danger.sync="counterDanger" v-model="notes" />
        </vs-col>
      </vs-row>
      <vs-row vs-type="flex" vs-justify="left" vs-w="10" style="padding-bottom: 20px;">
        <vs-col vs-offset="5" vs-w="5">
          <vs-button color="success" @click="save">Upload</vs-button>
        </vs-col>
      </vs-row>
    </vs-col>
  </vs-col>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  name: "stock-upload",
  computed: {
    ...mapGetters("pages", {
      index: "index",
      base_url: "base_url",
      site_url: "site_url"
    })
  },
  data() {
    return {
      active1: true,
      counterDanger: false,
      notes: "",
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
    save() {
      let formData = new FormData();
      //   formData.append("vendor", this.form.vendor);
      formData.append("file", this.file);
      axios
        .post(this.site_url + "/stock/do_upload/", formData)
        .then(res => {
          this.$vs.notify({
            color: "success",
            title: "Berhasil",
            text: res.data.filename + " berhasil di upload.",
            icon: "done_all"
          });
          this.$router.push({ name: "material-stock" });
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
    this.$store.dispatch("pages/changeIndex", "4");
  }
};
</script>