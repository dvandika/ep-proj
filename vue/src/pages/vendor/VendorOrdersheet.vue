<template>
  <vs-col vs-type="flex" vs-w="13" class="content">
    <h3>Order Sheet</h3>
    <vs-col class="content-body" vs-w="12">
      <!-- delivery date -->
      <vs-row vs-w="10" vs-type="flex" vs-justify="left" :style="{'margin': '15px 0'}">
        <vs-col vs-offset="1" vs-w="2">Delivery Date</vs-col>
        <vs-col vs-w="7" vs-justify="center" vs-align="center" class="space-vertical">
          <date-picker v-model="delivery_date" type="date" :lang="lang" format="DD-MM-YYYY"></date-picker>
        </vs-col>
      </vs-row>
      <!-- print status -->
      <vs-row vs-w="10" vs-type="flex" vs-justify="left" :style="{'margin': '15px 0'}">
        <vs-col vs-offset="1" vs-w="2">Print Status</vs-col>
        <vs-col vs-w="7" vs-justify="center" vs-align="center" class="space-vertical">
          <vs-select width="500px" v-model="print_status" size="large" autocomplete>
            <vs-select-item
              :key="index"
              :value="item.id"
              :text="item.text"
              v-for="(item, index) in print_option"
            ></vs-select-item>
          </vs-select>
        </vs-col>
      </vs-row>
      <vs-row vs-w="10" vs-type="flex" vs-justify="left" style="margin: 15px 0">
        <vs-col vs-offset="3" vs-w="7" vs-align="center" vs-justify>
          <vs-button style="margin:10px;" @click="search()" size="medium" icon="search">Search</vs-button>
          <vs-button style="margin:10px;" @click="print()" size="medium" icon="print">print</vs-button>
        </vs-col>
      </vs-row>
      <vs-divider color="primary" vs-w="5"></vs-divider>
      <vs-col vs-offset="1" vs-w="10" vs-justify="center" vs-align="center" :vs-if="submitted">
        <vs-table :data="ordersheets" v-model="selected" stripe search pagination max-item="5">
          <template slot="thead">
            <vs-th>OS Number</vs-th>
            <vs-th>Material</vs-th>
            <vs-th>Vendor ID</vs-th>
            <vs-th>Delivery Date</vs-th>
            <vs-th>Delivery Time</vs-th>
          </template>

          <template slot-scope="{data}">
            <vs-tr :data="tr" :key="indextr" v-for="(tr, indextr) in data">
              <vs-td :data="tr.os_no">{{tr.os_no}}</vs-td>
              <vs-td :data="tr.count_material">{{tr.count_material}} item(s)</vs-td>
              <vs-td :data="tr.os_vendor">{{tr.os_vendor}}</vs-td>
              <vs-td :data="tr.os_delivery_date">{{tr.os_delivery_date}}</vs-td>
              <vs-td :data="tr.os_transm">{{tr.os_transm}}</vs-td>
            </vs-tr>
          </template>
        </vs-table>
        <pre>
          {{ selected }}
        </pre>
      </vs-col>
    </vs-col>
  </vs-col>
</template>

<script>
import { mapGetters } from "vuex";
import DatePicker from "vue2-datepicker";

export default {
  name: "os-vendor",
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
      submitted: false,
      selected: [],
      form: {
        vendor: "",
        date: "",
        print_status: ""
      },
      print_option: [
        { id: 0, text: "Unprinted", value: 0 },
        { id: 1, text: "Printed", value: 1 }
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
    mergeArr(arr1, arr2) {
      var i;
      var result = [];
      var obj;
      for (i = 0; i < arr1.length; i++) {
        obj = { number: arr1[i], desc: arr2[i] };
        result.push(obj);
      }
      return result;
    },
    fetchOS() {
      this.$vs.loading();
      axios.get(this.site_url + "/vendors/ordersheet").then(res => {
        this.ordersheets = res.data.ordersheet;
        this.$vs.loading.close();

        // console.log(this.ordersheets);
      });
    },
    search() {},
    print() {
      if (this.selected) {
        let enc = this.selected.os_print_enc;
        let no = this.selected.os_no;
        let print_url = this.site_url + "/cetak/ordersheet/" + no + "/" + enc;
        console.log(print_url);
        window.open(print_url, "_blank");
        // window.location.href = print_url;
      } else if (this.selected === []) {
        this.$vs.notify({
          title: "Warning!",
          text: "Mohon pilih data!",
          color: "warning",
          icon: "warning"
        });
      }
    }
  },
  created() {
    this.fetchOS();
  },
  beforeCreate() {
    this.$store.dispatch("pages/changeIndex", "1");
  }
};
</script>

<style lang="stylus">
.con-expand-os {
  .con-btns-os {
    width: 100%;
    display: flex;
    padding: 10px;
    padding-bottom: 0px;
    align-items: center;
    justify-content: space-between;

    .con-osx {
      display: flex;
      align-items: center;
      justify-content: flex-start;
    }
  }

  .list-icon {
    i {
      font-size: 0.9rem !important;
    }
  }
}
</style>