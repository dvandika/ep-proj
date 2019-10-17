<template>
  <vs-popup button-close-hidden title="Daily Stock Report" :active.sync="active">
    <vs-card style="background-color: #b9d3ff;">
      <div slot="header">
        <h3>Informasi Penting</h3>
      </div>
      <div>
        <span>Pastikan format file sesuai dengan format yang telah ditentukan.</span>
      </div>
    </vs-card>
    <vs-row vs-justify="center" vs-align="center" vs-w="10" style="padding: 10px;">
      <vs-col vs-offset="2" vs-w="1">Vendor</vs-col>
      <vs-col vs-offset="1" vs-w="6">
        <vs-select vs-w="5" v-model="vendor" size="large" autocomplete>
          <vs-select-item
            :key="index"
            :value="item.VendorCode"
            :text="item.VendorName + ' (' + item.VendorCode + ')'"
            v-for="(item, index) in vendor_option"
          ></vs-select-item>
        </vs-select>
      </vs-col>
    </vs-row>
    <vs-row vs-justify="center" vs-align="center" vs-w="10" style="padding: 10px;">
      <vs-col vs-offset="2" vs-w="1">Bulan</vs-col>
      <vs-col vs-offset="1" vs-w="6">
        <date-picker v-model="date" type="month" format="MM-YYYY" lang="en" />
      </vs-col>
    </vs-row>
    <vs-row vs-justify="center" vs-align="center" vs-w="10" style="padding: 10px;">
      <vs-col vs-offset="2" vs-w="1">File</vs-col>
      <vs-col vs-offset="1" vs-w="6">
        <vs-input type="file" name="file" ref="file" @change="onFileChange()" />
      </vs-col>
    </vs-row>
    <vs-row vs-justify="center" vs-align="center" vs-w="10" style="padding: 10px;">
      <vs-col vs-offset="2" vs-w="1">Catatan Tambahan</vs-col>
      <vs-col vs-offset="1" vs-w="6">
        <vs-textarea counter="50" :counter-danger.sync="counterDanger" v-model="notes" />
      </vs-col>
    </vs-row>
    <vs-row vs-justify="center" vs-align="center" vs-w="10" style="padding: 10px;">
      <vs-col vs-offset="4" vs-w="6">
        <vs-button color="success" @click="save">Upload</vs-button>
        <vs-button style="margin-left: 10px" color="primary" @click="close">Close</vs-button>
      </vs-col>
    </vs-row>
  </vs-popup>
</template>

<script>
import { mapGetters } from "vuex";
import DatePicker from "vue2-datepicker";
export default {
  name: "upload-template-popup",
  computed: {
    ...mapGetters("pages", {
      site_url: "site_url"
    })
  },
  components: {
    DatePicker
  },
  props: ["active"],
  data() {
    return {
      notes: "",
      date: "",
      vendor: "",
      vendor_option: []
    };
  },
  methods: {
    fetchVendors() {
      axios.get(this.site_url + "/admins/vendor").then(res => {
        this.vendor_option = res.data;
        console.log(this.vendor_option);
      });
    },
    onFileChange() {
      this.file = this.$refs.file.files[0];
    },
    close() {
      this.active = false;
      this.$emit("saved");
    },
    convert(str) {
      // convert date string
      var date = new Date(str),
        mnth = ("0" + (date.getMonth() + 1)).slice(-2),
        day = ("0" + date.getDate()).slice(-2);
      return [day, mnth, date.getFullYear()].join("-");
    },
    save() {
      let formData = new FormData();
      formData.append("vendor", this.vendor);
      formData.append("date", this.convert(this.date));
      formData.append("notes", this.notes);
      formData.append("file", this.file);
      this.$vs.loading();
      axios
        .post(this.site_url + "/report/upload_templates", formData)
        .then(res => {
          this.$vs.loading.close();
          this.$vs.notify({
            color: "#73A3F7",
            title: "Berhasil disimpan"
          });
          this.active = false;
          this.$emit("saved");
        })
        .catch(err => {
          if (err.response) {
            this.$vs.loading.close();
            this.$vs.notify({
              color: "#FF0000",
              title: err.response.data.message
            });
          }
          this.active = false;
          this.$emit("saved");
        });
    }
  },
  created() {
    this.fetchVendors;
  }
};
</script>