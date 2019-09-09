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
        :vs-show="filters == 2"
        vs-w="11"
        vs-type="flex"
        vs-justify="left"
        vs-align="center"
        :style="{'margin':'15px 0'}"
      >
        <vs-col vs-offset="1" vs-w="3">Date</vs-col>
        <vs-col vs-offset="1" vs-w="6">
          <date-picker v-model="date" type="date" :lang="lang" format="DD-MM-YYYY"></date-picker>
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
          <router-link :to="{name: 'upload-stock'}">
            <vs-button
              class="inline"
              type="filled"
              icon="add"
              color="primary"
              size="small"
              style="margin-bottom: 20px;"
            >Report</vs-button>
          </router-link>
        </vs-col>
      </vs-row>

      <!-- end of buttone -->
      <!-- start table -->
      <vs-row vs-type="flex" vs-justify="center" vs-align="center">
        <vs-col vs-type="flex">
          <vs-table pagination max-items="10" :data="stocks" stripe>
            <template slot="thead">
              <vs-th sort-key="idx">ID</vs-th>
              <vs-th sort-key="vendorname">Vendor Name</vs-th>
              <vs-th sort-key="filepath">File Path</vs-th>
              <vs-th sort-key="stockdate">Date Stock</vs-th>
              <vs-th sort-key="dateupload">Date Upload</vs-th>
              <vs-th sort-key="actions">Actions</vs-th>
            </template>
            <template slot-scope="{data}">
              <vs-tr :data="tr" :key="indextr" v-for="(tr,indextr) in data">
                <vs-td :data="tr.id">{{ tr.id }}</vs-td>
                <vs-td :data="tr.vendorname">{{ tr.vendorname }}</vs-td>
                <vs-td :data="tr.filepath">{{ tr.filepath }}</vs-td>
                <vs-td :data="tr.stockdate">{{ tr.stockdate }}</vs-td>
                <vs-td :data="tr.dateupload">{{ tr.dateupload }}</vs-td>
                <vs-td :data="tr.id">
                  <vs-button size="medium" @click="edit(tr.id)" style="margin-right: 2px">
                    <i class="fa fa-edit"></i> Edit
                  </vs-button>
                  <vs-button size="medium" @click="download(tr.id)" style="margin-right: 2px">
                    <i class="fa fa-download"></i> Download
                  </vs-button>
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
  name: "material-stock",
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
      file: null,
      date: "",
      filters: 1,
      stocks: [],
      filter_option: [
        { id: 1, value: 1, text: "Tampilkan Semua" },
        { id: 2, value: 2, text: "Tampilkan Berdasarkan Tanggal" }
      ],
      vendor_option: [],
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
        placeholder: {
          date: "Pilih Tanggal"
        }
      }
    };
  },
  methods: {
    fetchReports() {
      axios.get(this.site_url + "/stock").then(res => {
        this.stocks = res.data.stock;
      });
    },
    goToUpload() {
      this.$router.push({ name: "upload-stock" });
    }
  },
  created() {
    this.fetchReports();
  },
  beforeCreate() {
    this.$store.dispatch("pages/changeIndex", "3");
  }
};
</script>

<style scoped>
.vs-con-table {
  width: 100%;
  margin: 5px;
}
</style>