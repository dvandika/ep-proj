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
          <!-- <PopupTemplateUpload :active="popup" @saved="fetchReport" /> -->
          <vs-button
            @click="popup=true"
            class="inline"
            type="filled"
            icon="add"
            color="primary"
            size="small"
            style="margin-bottom: 20px;"
          >Report</vs-button>
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
              <vs-th sort-key="filename">File Name</vs-th>
              <vs-th sort-key="dateupload">Date Upload</vs-th>
              <vs-th sort-key="actions">Actions</vs-th>
            </template>
            <template slot-scope="{data}">
              <vs-tr :data="tr" :key="indextr" v-for="(tr,indextr) in data">
                <vs-td :data="tr.id">{{ tr.id }}</vs-td>
                <vs-td :data="tr.vendorname">{{ tr.vendorname }}</vs-td>
                <vs-td :data="tr.filename">{{ tr.filename }}</vs-td>
                <vs-td :data="tr.dateupload">{{ tr.dateupload }}</vs-td>
                <vs-td :data="tr.id">
                  <vs-button icon="edit" size="medium" @click="edit(tr.id)" style="margin-right: 2px">Edit
                  </vs-button>
                  <vs-button icon="save_alt" size="medium" @click="download(tr.id)" style="margin-right: 2px">Download
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
  name: "material-template",
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
      popup: false,
      file: null,
      date: "",
      filters: 1,
      stocks: [],
      filter_option: [
        { id: 1, value: 1, text: "Tampilkan Semua" },
        { id: 2, value: 2, text: "Tampilkan Berdasarkan Tanggal" }
      ],
      vendor_option: []
    };
  },
  methods: {
    fetchReport() {
      axios.get(this.site_url + "/stock/report").then(res => {
        this.stocks = res.data.stock;
      });
    },
    goToUpload() {
      this.$router.push({ name: "upload-stock" });
    }
  },
  created() {
    this.fetchReport();

  },
  beforeCreate() {
    this.$store.dispatch("pages/changeIndex", "5");
  }
};
</script>

<style scoped>
.vs-con-table {
  width: 100%;
  margin: 5px;
}
</style>