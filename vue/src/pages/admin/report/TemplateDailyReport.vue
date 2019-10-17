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
          <date-picker v-model="filterDate" type="date" lang="en" format="DD-MM-YYYY"></date-picker>
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
          <vs-button
            @click="popup=true"
            class="inline"
            type="filled"
            icon="add"
            color="primary"
            size="small"
            style="margin-bottom: 20px;"
          >Upload Templates</vs-button>
        </vs-col>
      </vs-row>

      <!-- end of buttone -->
      <!-- start popup -->
      <vs-popup button-close-hidden title="Daily Stock Report" :active.sync="popup">
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
            <input type="file" name="file" ref="file" @change="onFileChange()" />
            <!-- <vs-input type="file" name="file" ref="file" @change="onFileChange()" /> -->
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
            <vs-button color="success" @click="saveTemplate">Upload</vs-button>
            <vs-button style="margin-left: 10px" color="primary" @click="popup=false">Close</vs-button>
          </vs-col>
        </vs-row>
      </vs-popup>
      <!-- end popup -->
      <!-- start table -->
      <vs-row vs-type="flex" vs-justify="center" vs-align="center">
        <vs-col vs-type="flex">
          <vs-table pagination max-items="10" :data="template" stripe>
            <template slot="thead">
              <vs-th sort-key="idx">ID</vs-th>
              <vs-th sort-key="vendorname">Vendor Name</vs-th>
              <vs-th sort-key="filename">File Name</vs-th>
              <vs-th sort-key="month">Month</vs-th>
              <vs-th sort-key="dateupload">Date Upload</vs-th>
              <vs-th sort-key="actions">Actions</vs-th>
            </template>
            <template slot-scope="{data}">
              <vs-tr :data="tr" :key="indextr" v-for="(tr,indextr) in data">
                <vs-td :data="tr.id">{{ tr.id }}</vs-td>
                <vs-td :data="tr.vendorname">{{ tr.vendorname }}</vs-td>
                <vs-td :data="tr.filename">{{ tr.filename }}</vs-td>
                <vs-td :data="tr.month">{{ tr.month }}</vs-td>
                <vs-td :data="tr.dateupload">{{ tr.dateupload }}</vs-td>
                <vs-td :data="tr.id">
                  <vs-button
                    icon="save_alt"
                    size="medium"
                    @click="download(tr.id)"
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
  name: "template-daily-report",
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
      //filter
      filters: 1,
      filterDate: "",
      template: [],
      filter_option: [
        { id: 1, value: 1, text: "Tampilkan Semua" },
        { id: 2, value: 2, text: "Tampilkan Berdasarkan Tanggal" }
      ],
      // popup
      popup: false,
      file: null,
      // data form
      vendor: "",
      date: "",
      file: null,
      notes: "",
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
    saveTemplate() {
      this.popup = false;
      let formData = new FormData();
      formData.append("vendor", this.vendor);
      formData.append("date", this.convert(this.date));
      formData.append("notes", this.notes);
      formData.append("file", this.file);
      this.$vs.loading();
      axios
        .post(this.site_url + "/report/upload_templates", formData)
        .then(res => {
          console.log(res.data);
          this.fetchTemplate();
          window.location.reload()
          this.$vs.loading.close();
          this.$vs.notify({
            color: "#73A3F7",
            title: "Berhasil disimpan"
          });
        })
        .catch(err => {
          if (err.response) {
            this.$vs.loading.close();
            this.$vs.notify({
              color: "#FF0000",
              title: err.response.data.message
            });
            this.fetchTemplate();
          }
        });
    },
    fetchTemplate() {
      this.$vs.loading();
      axios.get(this.site_url + "/report/templates").then(res => {
        this.template = res.data.templates;
        this.$vs.loading.close();
      });
    }
  },
  created() {
    this.fetchTemplate();
    this.fetchVendors();
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