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
    <vs-row vs-justify="center" vs-align="center" vs-w="10" style="padding: 5px;">
      <vs-col vs-offset="2" vs-w="1">Tanggal</vs-col>
      <vs-col vs-offset="1" vs-w="6">
        <date-picker v-model="date" type="date" format="DD-MM-YYYY" lang="en" />
      </vs-col>
    </vs-row>
    <vs-row vs-justify="center" vs-align="center" vs-w="10" style="padding-bottom: 20px;">
      <vs-col vs-offset="2" vs-w="1">File</vs-col>
      <vs-col vs-offset="1" vs-w="6">
        <!-- <vs-input type="file" name="file" ref="file" @change="onFileChange()" /> -->
        <input type="file" name="file" ref="file" @change="onFileChange()" />
      </vs-col>
      <vs-col vs-offset="2" vs-w="1">Catatan Tambahan</vs-col>
      <vs-col vs-offset="1" vs-w="6">
        <vs-textarea counter="50" :counter-danger.sync="counterDanger" v-model="notes" />
      </vs-col>
    </vs-row>
    <vs-row vs-type="flex" vs-justify="center">
      <vs-button color="success" @click="save">Upload</vs-button>
      <vs-button color="primary" @click="close">Close</vs-button>
    </vs-row>
  </vs-popup>
</template>

<script>
import { mapGetters } from "vuex";
import DatePicker from "vue2-datepicker";
export default {
  name: "upload-report-popup",
  props: ["active"],
  components: {
    DatePicker
  },
  computed: {
    ...mapGetters("pages", {
      site_url: "site_url"
    })
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
    onFileChange() {
      console.log(this.$refs);
      this.file = this.$refs.file.files[0];
      console.log(this.file)
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
      // formData.append("vendor", this.vendor);
      formData.append("date", this.convert(this.date));
      formData.append("notes", this.notes);
      formData.append("file", this.file);
      this.$vs.loading();
      axios
        .post(this.site_url + "/report/upload", formData)
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
              title: "Error!",
              text: err.response.data.message,
              fixed: true
              // title: "Terdapat kesalahan"
            });
          }
          console.log();
          this.active = false;
          this.$emit("saved");
        });
    }
  }
};
</script>