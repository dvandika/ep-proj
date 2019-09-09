<template>
  <vs-popup title="Upload Stock Daily Report" :active.sync="active">
    <vs-card style="background-color: #b9d3ff;">
      <div slot="header">
        <h3>Informasi Penting</h3>
      </div>
      <div>
        <span>Pastikan format file sesuai dengan format yang telah ditentukan.</span>
      </div>
    </vs-card>
    <vs-row vs-justify="center" vs-align="center" vs-w="10" style="padding-bottom: 20px;">
      <vs-col vs-offset="2" vs-w="1">File</vs-col>
      <vs-col vs-offset="1" vs-w="6">
        <vs-input type="file" name="file" ref="file" @change="onFileChange()" />
      </vs-col>
      <vs-col vs-offset="2" vs-w="1">Catatan Tambahan</vs-col>
      <vs-col vs-offset="1" vs-w="6">
        <vs-textarea
          counter="50"
          :counter-danger.sync="counterDanger"
          v-model="notes"
        />
      </vs-col>
    </vs-row>
    <vs-row vs-type="flex" vs-justify="center">
      <vs-button color="success" @click="save">Upload</vs-button>
    </vs-row>
  </vs-popup>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  name: "upload-stock-popup",
  computed: {
    ...mapGetters("pages", {
      site_url: "site_url"
    })
  },
  props: ["active"],
  data() {
    return {
      notes: ""
    };
  },
  methods: {
    onFileChange() {
      this.file = this.$refs.file.files[0];
    },
    save() {
      let formData = new FormData();
      formData.append("note", this.notes);
      formData.append("file", this.file);
      axios
        .post(this.site_url + "/stock/do_upload", formData)
        .then(res => {
          this.$vs.notify({
            color: "#73A3F7",
            title: "Berhasil disimpan"
          });
          this.active = false;
          this.$emit("saved");
        })
        .catch(err => {
          if (err.response) {
            this.$vs.notify({
              color: "#FF0000",
              title: err.response.data.message
            });
          }
        });
    }
  }
};
</script>