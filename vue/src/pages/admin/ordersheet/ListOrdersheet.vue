<template>
  <vs-col vs-type="flex" vs-w="13" class="content">
    <h3>Order Sheet</h3>
    <vs-col class="content-body" vs-w="12">
      <!-- vendor information -->
      <vs-row vs-w="10" vs-type="flex" vs-justify="left" :style="{'margin': '15px 0'}">
        <vs-col vs-offset="1" vs-w="2">Vendor Name</vs-col>
        <vs-col vs-w="7" vs-justify="center" vs-align="center" class="space-vertical">
          <vs-select width="500px" v-model="form.vendor" size="large" autocomplete>
            <vs-select-item
              :key="index"
              :value="item.VendorCode"
              :text="item.VendorName + ' (' + item.VendorCode + ')'"
              v-for="(item, index) in vendor_option"
            ></vs-select-item>
          </vs-select>
        </vs-col>
      </vs-row>
      <!-- delivery date -->
      <vs-row vs-w="10" vs-type="flex" vs-justify="left" :style="{'margin': '15px 0'}">
        <vs-col vs-offset="1" vs-w="2">Delivery Date</vs-col>
        <vs-col vs-w="7" vs-justify="center" vs-align="center" class="space-vertical">
          <date-picker v-model="form.date" type="date" :lang="lang" format="DD-MM-YYYY"></date-picker>
        </vs-col>
      </vs-row>
      <!-- print status -->
      <vs-row vs-w="10" vs-type="flex" vs-justify="left" :style="{'margin': '15px 0'}">
        <vs-col vs-offset="1" vs-w="2">Print Status</vs-col>
        <vs-col vs-w="7" vs-justify="center" vs-align="center" class="space-vertical">
          <vs-select width="500px" v-model="form.print_status" size="large" autocomplete>
            <vs-select-item
              :key="index"
              :value="item.id"
              :text="item.text"
              v-for="(item, index) in print_option"
            ></vs-select-item>
          </vs-select>
        </vs-col>
        <vs-col vs-offset="6" vs-w="3">
        <vs-button style="margin:10px;" @click="search()" size="medium" icon="search">Search</vs-button>
        <vs-button style="margin:10px;" @click="print()" size="medium" icon="print">Print</vs-button>
        </vs-col>
      </vs-row>

      <vs-col vs-type="flex">
        <vs-table
          multiple
          v-model="selected"
          pagination
          max-items="10"
          :data="ordersheets"
        >
          <template slot="thead">
            <vs-th sort-key="os_no">OS Number</vs-th>
            <vs-th sort-key="os_vendor">Vendor</vs-th>
            <vs-th sort-key="po_number">PO Number</vs-th>
            <vs-th sort-key="material">Material</vs-th>
            <vs-th sort-key="material_desc">Material Desc.</vs-th>
            <vs-th sort-key="os_transm">Transm.</vs-th>
            <vs-th sort-key="deliverydate">Delivery Date</vs-th>
            <!-- <vs-th sort-key="kanban_qty">Kanban Qty</vs-th> -->
            <!-- <vs-th sort-key="schedule_qty">Schedule Qty</vs-th> -->
            <vs-th sort-key="bun">BUn</vs-th>
            <vs-th sort-key="total_qty">Total Schedule Qty</vs-th>
            <vs-th sort-key="print_status">Print Status</vs-th>
            <vs-th sort-key="action">Action</vs-th>
          </template>

          <template slot-scope="{data}">
            <vs-tr :data="tr" :key="indextr" v-for="(tr, indextr) in data">
              <vs-td :data="data[indextr].os_no">{{data[indextr].os_no}}</vs-td>
              <vs-td :data="data[indextr].os_vendor">{{data[indextr].os_vendor}}</vs-td>
              <vs-td :data="data[indextr].os_po_number">{{data[indextr].os_po_number}}</vs-td>
              <vs-td :data="data[indextr].os_material">{{data[indextr].os_material}}</vs-td>
              <vs-td :data="data[indextr].os_material_desc">{{data[indextr].os_material_desc}}</vs-td>
              <vs-td :data="data[indextr].os_transm">{{data[indextr].os_transm}}</vs-td>
              <vs-td :data="data[indextr].os_delivery_date">{{data[indextr].os_delivery_date}}</vs-td>
              <!-- <vs-td :data="data[indextr].os_kanban_qty">{{data[indextr].os_kanban_qty}}</vs-td> -->
              <!-- <vs-td :data="data[indextr].os_schedule_qty">{{data[indextr].os_schedule_qty}}</vs-td> -->
              <vs-td :data="data[indextr].os_bun">{{data[indextr].os_bun}}</vs-td>
              <vs-td :data="data[indextr].os_sum_schedule_qty">{{data[indextr].os_sum_schedule_qty}}</vs-td>
              <vs-td :data="data[indextr].os_print_status">{{data[indextr].os_print_status}}</vs-td>
              <vs-td :data="data[indextr].os_id">
                <vs-button
                  icon="delete"
                  color="danger"
                  size="small"
                  @click="del(data[indextr].os_id)"
                ></vs-button>
              </vs-td>
            </vs-tr>
          </template>
        </vs-table>
      </vs-col>
    </vs-col>
    <pre>{{ selected }}</pre>
  </vs-col>
</template>

<script>
import { mapGetters } from "vuex";
import DatePicker from "vue2-datepicker";

export default {
  name: "os-list",
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
      selected: [],
      form: {
        vendor: "",
        date: "",
        print_status: ""
      },
      print_option: [
        { id: 1, text: "PRINTED", value: 1 },
        { id: 2, text: "UNPRINTED", value: 2 }
      ],
      vendor_option: [],
      ordersheets: [],
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
    print() {
      // console.log(this.selected);
      let formData = new FormData();
      var selectedData = JSON.stringify(this.selected);
      formData.append("selected", selectedData);
      axios
        .post(this.site_url + "/admins/ordersheet/download/", formData, 
        { responseType: 'blob' }
        )
        .then(res => {
          // console.log(res);
          console.log(res);
          let link = document.createElement("a");
          link.href = window.URL.createObjectURL(res.data);
          link.download = "test1.pdf";
          link.click();
          // --
          // let blob = new Blob([res.data], { type: "application/pdf" });
          // let link = document.createElement("a");
          // link.href = window.URL.createObjectURL(blob);
          // link.download = "test.pdf";
          // link.click();
          // window.location.href = res.request.responseURL;
          // console.log(res.data);
          // console.log(res.request.responseURL);
          // window.location.href = res.request.responseURL;
        })
        .catch(err => {
          console.log(err);
        });
    },
    search() {
      let formData = new FormData();
      formData.append("vendor", this.form.vendor);
      formData.append("delivery_date", this.form.date);
      formData.append("print_status", this.form.print_status);
      console.log(this.form.date);
      console.log(this.form.vendor);
    },
    fetchVendors() {
      axios.get(this.site_url + "/admins/vendor").then(res => {
        // console.log(res.data);
        this.vendor_option = res.data;
      });
    },
    fetchOS() {
      axios.get(this.site_url + "/admins/ordersheet").then(res => {
        this.ordersheets = res.data.ordersheet;
        // console.log(this.ordersheets);
      });
    },
    del: function(id) {
      console.log("delete id: " + id);
    }
  },
  created() {
    this.fetchOS();
    this.fetchVendors();
  },
  beforeCreate() {
    this.$store.dispatch('pages/changeIndex', "1");
  },
};
</script>

<style>
.scroll-x {
  overflow-x: auto;
}
</style>