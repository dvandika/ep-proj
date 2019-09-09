<template>
  <vs-col vs-w="12" vs-type="flex" class="content">
    <h3>Material (Component)</h3>
    <vs-col class="content-body" vs-w="12">
      <!-- param -->
      <vs-row vs-type="flex" vs-justify="left" :style="{'margin':'15px 0'}">
        <vs-col vs-offset="1" vs-w="3">Select by Vendor</vs-col>
        <vs-col vs-w="8" vs-justify="center" vs-align="center" class="space-vertical">
          <vs-select width="400px" v-model="form.vendor" size="large" autocomplete>
            <vs-select-item v-if="vendor_option.length == 0" value="null" text="Tidak ada data" />
            <vs-select-item
              :value="item.VendorCode"
              :text="item.VendorName + ' (' + item.VendorCode + ')'"
              v-for="(item, index) in vendor_option"
              :key="index"
            ></vs-select-item>
          </vs-select>
        </vs-col>
        <vs-col vs-offset="8" vs-w="4" vs-align="center" vs-justify="right">
          <vs-button style="margin:10px;" @click="search()" size="medium">Search</vs-button>
          <vs-button style="margin:10px;" @click="add()" size="medium">Add</vs-button>
        </vs-col>

        <!-- list -->
        <vs-col vs-type="flex" vs-justify="center" vs-align="center" :style="{'padding':'5px'}" vs-w="12">
          <vs-table :data="materials" max-items="10" pagination stripe>
            <template slot="header">
              <h3>Material</h3>
            </template>
            <template slot="thead">
              <vs-th sort-key="material">Material Number</vs-th>
              <vs-th sort-key="description">Description</vs-th>
              <vs-th sort-key="type">Type</vs-th>
              <vs-th sort-key="category">Category</vs-th>
              <vs-th sort-key="vendor">Vendor</vs-th>
              <vs-th sort-key="action">Actions</vs-th>
            </template>
            <template slot-scope="{data}">
              <vs-tr :data="tr" :key="indextr" v-for="(tr, indextr) in data">
                <vs-td :data="tr.MaterialNumber">{{tr.MaterialNumber}}</vs-td>
                <vs-td :data="tr.MaterialDescription">{{tr.MaterialDescription}}</vs-td>
                <vs-td :data="tr.Type">{{tr.Type}}</vs-td>
                <vs-td :data="tr.Category">{{tr.Category}}</vs-td>
                <vs-td :data="tr.vendorname">{{tr.vendorname}}</vs-td>
                <vs-td :data="tr.ID">
                  <vs-button icon="delete" color="danger" size="small" @click="del(tr.ID)"></vs-button>
                </vs-td>
              </vs-tr>
            </template>
          </vs-table>
        </vs-col>
      </vs-row>
    </vs-col>
  </vs-col>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  name: "material-list",
  computed: {
    ...mapGetters("pages", {
      index: "index",
      base_url: "base_url",
      site_url: "site_url"
    })
  },
  data() {
    return {
      form: {
        vendor: ""
      },
      vendor_option: [],
      materials: []
    };
  },
  methods: {
    fetchMaterials() {
      axios.get(this.site_url + "/material").then(res => {
        this.materials = res.data.material;
        console.log(this.materials);
      });
    },
    fetchVendors() {
      axios.get(this.site_url + "/admins/vendor").then(res => {
        this.vendor_option = res.data;
      });
    },
    del(id) {
      window.alert("Are you sure want to delete: " + id);
    },
    add() {
      this.$router.push({ name: 'add-material'});
    }
  },
  created() {
    this.fetchVendors();
    this.fetchMaterials();
  },
  beforeCreate() {
    this.$store.dispatch("pages/changeIndex", "7");
  }
};
</script>