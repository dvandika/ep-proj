<template>
  <vs-col vs-type="flex" vs-w="13" class="content">
    <vs-col vs-w="12" vs-type="flex" vs-justify="center" vs-align="center">
      <vs-card style="background-color: #b9d3ff;">
        <div slot="header">
          <h3>Informasi Penting</h3>
        </div>
        <div>
          <span>
            Pastikan
            <b>Template Report</b> sesuai dengan bulan ini!
          </span>
          <span>Prosedur mengisi Laporan Harian:</span>
          <span style="margin: 10px">
            <li>Mengubah nama sheet dan nama file sesuai dengan ketentuan yang telah ditetapkan. (Format: Lap [kode] [dd.mm.yy] - ex: Lap JAEIL 01.01.19)</li>
            <li>Memastikan mengisi Actual Stock, Rencana Produksi, serta OS Pending sesuai dengan kondisi real.</li>
            <li>
              Apabila terjadi kesalahan atau error, segera hubungi developer kami melalui email
              <strong>developer@aski.id</strong> disertai lampiran kesalahan.
            </li>
          </span>
        </div>
      </vs-card>
    </vs-col>
    <vs-col class="content-body" vs-w="12">
      <!-- start list -->
      <vs-list :key="index" v-for="(t, index) in template">
        <vs-list-header title="Template Report"></vs-list-header>
        <vs-list-item :title="t.month" :subtitle="t.notes">
          <vs-button
            :disabled="t.status == 'nonaktif'"
            icon="save_alt"
            color="primary"
            @click="downloadTemplate(t.id)"
          >Download</vs-button>
        </vs-list-item>
      </vs-list>
      <!-- end list -->
    </vs-col>
  </vs-col>
</template>

<script>
import { mapGetters } from "vuex";
import DatePicker from "vue2-datepicker";
export default {
  name: "vendor-template-report",
  components: {
    DatePicker
  },
  computed: {
    ...mapGetters("pages", {
      index: "index",
      base_url: "base_url",
      site_url: "site_url"
    })
  },
  data() {
    return {
      template: []
    };
  },
  methods: {
    downloadTemplate(id) {
      this.$vs.loading();
      axios.get(this.site_url + "/report/templates/" + id).then(res => {
        console.log(res.data.templates);
        let t = res.data.templates;
        let url =
          this.site_url +
          "/report/download_template/" +
          t.id +
          "?d=" +
          t.filename;
        console.log(url);
        window.location.href = url;
        this.$vs.loading.close();
        this.$vs.notify({
          time: 4000,
          title: "Mengunduh..",
          text: "Berhasil mengunduh file.",
          color: "primary",
          icon: "save_alt"
        });
      });
    },
    fetchTemplate() {
      this.$vs.loading();
      axios.get(this.site_url + "/report/templates").then(res => {
        this.template = res.data.templates;
        console.log(this.template);
        if (!this.template.notes) {
          this.template.notes = "Tidak ada catatan.";
        }
        this.$vs.loading.close();
      });
    }
  },
  created() {
    this.fetchTemplate();
  },
  beforeCreate() {
    this.$store.dispatch("pages/changeIndex", "3");
  }
};
</script>