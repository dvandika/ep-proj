<template>
  <vs-col vs-w="12" class="content" vs-justify="center" vs-align="center">
    <h3>Report Material Stock</h3>
    <vs-col class="content-body" vs-w="12">
      <!-- start of menu -->
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
              v-model="filters"
              :key="id"
              :value="item.id"
              :text="item.text"
              v-for="(item, id) in filter_option"
            ></vs-select-item>
          </vs-select>
        </vs-col>
      </vs-row>
      <vs-row
        vs-w="11"
        vs-type="flex"
        vs-justify="left"
        vs-align="center"
        :style="{'margin':'15px 0'}"
      >
        <vs-col vs-offset="1" vs-w="3">Date</vs-col>
        <vs-col vs-offset="1" vs-w="6">
          <date-picker v-model="date" type="date" lang="en" format="DD-MM-YYYY"></date-picker>
        </vs-col>
      </vs-row>
      <!-- end of menu -->
      <!-- start button -->
      <vs-row vs-type="flex" vs-justify="left" vs-w="11" vs-align="center">
        <vs-col vs-offset="8" vs-w="3">
          <vs-button
            @click="filter"
            class="inline"
            type="filled"
            icon="search"
            color="primary"
            size="small"
            style="margin-bottom: 20px; margin-right: 10px;"
          >Filter</vs-button>
        </vs-col>
      </vs-row>

      <!-- end of buttone -->
      <!-- start table -->
      <vs-row vs-type="flex" vs-justify="center" vs-align="center">
        <vs-col vs-type="flex">
          <vs-table pagination max-items="10" :data="reports" stripe>
            <template slot="thead">
              <vs-th sort-key="id">ID</vs-th>
              <vs-th sort-key="vendorname">Vendor Name</vs-th>
              <vs-th sort-key="originalname">File Name</vs-th>
              <vs-th sort-key="datestock">Date Stock</vs-th>
              <vs-th sort-key="dateupload">Date Upload</vs-th>
              <vs-th sort-key="id">Actions</vs-th>
            </template>
            <template slot-scope="{data}">
              <vs-tr :data="tr" :key="indextr" v-for="(tr,indextr) in data">
                <vs-td :data="data[indextr].id">{{ data[indextr].id }}</vs-td>
                <vs-td :data="data[indextr].vendorname">{{ data[indextr].vendorname }}</vs-td>
                <vs-td :data="data[indextr].originalname">{{ data[indextr].originalname }}</vs-td>
                <vs-td :data="data[indextr].datestock">{{ data[indextr].datestock }}</vs-td>
                <vs-td :data="data[indextr].dateupload">{{ data[indextr].dateupload }}</vs-td>
                <vs-td :data="data[indextr].id">
                  <vs-button
                    size="large"
                    icon="save_alt"
                    @click="download(data[indextr].id)"
                    style="margin-right: 2px"
                  >Download</vs-button>
                </vs-td>
              </vs-tr>
            </template>
          </vs-table>
        </vs-col>
      </vs-row>
      <!-- end of table -->
    </vs-col>
  </vs-col>
</template>

<script>
import { mapGetters } from "vuex";
import DatePicker from "vue2-datepicker";

export default {
  name: "list-daily-report",
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
      reports: [],
      filters: 1,
      filter_option: [
        { id: 1, value: 1, text: "Tampilkan Semua" },
        { id: 2, value: 2, text: "Tampilkan Berdasarkan Tanggal" }
      ],
      vendor_option: []
    };
  },
  methods: {
    download(id) {
      this.$vs.loading();
      axios.get(this.site_url + "/report?id=" + id).then(res => {
        let r = res.data.reports;
        let url =
          this.site_url + "/report/download/" + r.id + "?r=" + r.filename;
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
    fetchReport() {
      axios.get(this.site_url + "/report").then(res => {
        this.reports = res.data.report;
      });
    }
  },
  created() {
    this.fetchReport();
  },
  beforeCreate() {
    this.$store.dispatch("pages/changeIndex", "4");
  }
};
</script>

<style scoped>
.vs-con-table {
  width: 100%;
  margin: 5px;
}
</style>