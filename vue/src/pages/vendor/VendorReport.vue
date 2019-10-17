<template>
  <vs-col vs-type="flex" vs-w="13" class="content">
    <h3>Daily Report Vendor</h3>
    <vs-col class="content-body" vs-w="12">
      <!-- filter menu -->
      <vs-row
        vs-type="flex"
        vs-w="11"
        vs-justify="left"
        vs-align="center"
        :style="{'margin':'20px 0'}"
      >
        <vs-col vs-offset="1" vs-w="3">Filter</vs-col>
        <vs-col vs-offset="1" vs-w="6">
          <vs-select width="400px" v-model="filters" size="large" autocomplete>
            <vs-select-item
              :key="id"
              :value="item.id"
              :text="item.text"
              v-for="(item, id) in filter_option"
            ></vs-select-item>
          </vs-select>
        </vs-col>
      </vs-row>
      <transition name="fade">
        <vs-row
          v-if="filters==2"
          vs-type="flex"
          vs-w="11"
          vs-justify="left"
          vs-align="center"
          :style="{'margin':'20px 0'}"
        >
          <vs-col vs-offset="1" vs-w="3">Tanggal</vs-col>
          <vs-col vs-offset="1" vs-w="6">
            <date-picker v-model="startdate" type="date" lang="en" format="DD-MM-YYYY" confirm></date-picker>&nbsp; To &nbsp;
            <date-picker v-model="enddate" type="date" lang="en" format="DD-MM-YYYY" confirm></date-picker>
          </vs-col>
        </vs-row>
      </transition>
      <!-- start button -->
      <vs-row vs-w="11" vs-type="flex" vs-justify="left" style="margin: 15px 0">
        <vs-col vs-offset="5" vs-w="6" vs-align="center" vs-justify>
          <vs-button
            v-if="filters==2"
            style="margin:5px 0;"
            @click="search()"
            size="medium"
            icon="search"
          >Search</vs-button>
          <vs-button
            @click="uploadPopup=true"
            class="inline"
            type="filled"
            icon="add"
            size="medium"
            style="margin: 5px 5px 20px 5px;"
          >Upload Report</vs-button>
        </vs-col>
        <PopupReportUpload :active="uploadPopup" @saved="fetchReport" />
      </vs-row>
      <!-- end button-->
      <!-- start table -->
      <vs-divider color="primary" vs-w="5"></vs-divider>
      <vs-col vs-offset="1" vs-w="10" vs-justify="center" vs-align="center" :vs-if="submitted">
        <vs-table stripe pagination max-items="5" :data="reports">
          <template slot="thead">
            <vs-th sort-key="stock_date">Stock Date</vs-th>
            <vs-th sort-key="filename">File Name</vs-th>
            <vs-th sort-key="notes">Notes</vs-th>
            <vs-th sort-key="upload_date">Upload Date</vs-th>
          </template>

          <template slot-scope="{data}">
            <vs-tr :data="tr" :key="indextr" v-for="(tr, indextr) in data">
              <vs-td :data="tr.datestock">{{ tr.datestock }}</vs-td>
              <vs-td :data="tr.originalname">{{ tr.originalname }}</vs-td>
              <vs-td :data="tr.notes">{{ tr.notes }}</vs-td>
              <vs-td :data="tr.dateupload">{{ tr.dateupload }}</vs-td>
            </vs-tr>
          </template>
        </vs-table>
      </vs-col>
      <!-- end of table -->
    </vs-col>
  </vs-col>
</template>

<script>
import { mapGetters } from "vuex";
import DatePicker from "vue2-datepicker";
import PopupReportUpload from "../../components/vendor/UploadReportPopup.vue";
export default {
  name: "vendor-stock",
  components: {
    DatePicker,
    PopupReportUpload
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
      // filter
      startdate: "",
      enddate: "",
      filters: 1,
      filter_option: [
        { id: 1, value: 1, text: "Tampilkan Semua" },
        { id: 2, value: 2, text: "Tampilkan Berdasarkan Tanggal" }
      ],
      // popup
      uploadPopup: false,
      stockDate: "",
      // index
      reports: [],

      // datepicker
      lang: {
        days: ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"],
        months: [
          "Januari",
          "Februari",
          "Maret",
          "April",
          "Mei",
          "Juni",
          "Juli",
          "Agustus",
          "September",  
          "Oktober",
          "November",
          "Desember"
        ],
        pickers: [
          "Next 7 days",
          "Next 30 days",
          "Previous 7 days",
          "Previous 30 days"
        ],
        placeholder: {
          date: "Pilih Tanggal"
        }
      }
      //
    };
  },
  methods: {
    fetchReport() {
      this.uploadPopup = false;
      this.$vs.loading();
      axios.get(this.site_url + "/report").then(res => {
        this.reports = res.data.report;
        this.$vs.loading.close();
      });
    }
  },
  created() {
    this.fetchReport();
  },
  beforeCreate() {
    this.$store.dispatch("pages/changeIndex", "2");
  }
};
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active in <2.1.8 */ {
  opacity: 0;
}
</style>