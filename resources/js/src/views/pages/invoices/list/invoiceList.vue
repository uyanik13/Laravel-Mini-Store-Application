<!-- =========================================================================================
  File Name: DataListListView.vue
  Description: Data List - List View
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: https://www.dijitalreklam.org
========================================================================================== -->

<template>
  <div id="data-list-list-view" class="data-list-container">

    <data-view-sidebar :isSidebarActive="addNewDataSidebar" @closeSidebar="toggleDataSidebar" :data="sidebarData" />

    <vs-table ref="table" v-if="user.status==='1'" multiple v-model="selected" pagination :max-items="itemsPerPage" search :data="invoices">

      <div slot="header" class="flex flex-wrap-reverse items-center flex-grow justify-between">

        <div class="flex flex-wrap-reverse items-center data-list-btn-container">

          <!-- ADD NEW -->
          <div class="btn-add-new p-3 mb-4 mr-4 rounded-lg cursor-pointer flex items-center justify-center text-lg font-medium text-base text-primary border border-solid border-primary" @click="addNewData">
              <feather-icon icon="PlusIcon" svgClasses="h-4 w-4" />
              <span class="ml-2 text-base text-primary">Alışveriş Ekle</span>
          </div>
        </div>

        <!-- ITEMS PER PAGE -->
        <vs-dropdown vs-trigger-click class="cursor-pointer mb-4 mr-4 items-per-page-handler">
          <div class="p-4 border border-solid d-theme-border-grey-light rounded-full d-theme-dark-bg cursor-pointer flex items-center justify-between font-medium">
            <span class="mr-2">{{ currentPage * itemsPerPage - (itemsPerPage - 1) }} - {{ invoices.length - currentPage * itemsPerPage > 0 ? currentPage * itemsPerPage : invoices.length }} of {{ queriedItems }}</span>
            <feather-icon icon="ChevronDownIcon" svgClasses="h-4 w-4" />
          </div>
          <!-- <vs-button class="btn-drop" type="line" color="primary" icon-pack="feather" icon="icon-chevron-down"></vs-button> -->
          <vs-dropdown-menu>

            <vs-dropdown-item @click="itemsPerPage=4">
              <span>4</span>
            </vs-dropdown-item>
            <vs-dropdown-item @click="itemsPerPage=10">
              <span>10</span>
            </vs-dropdown-item>
            <vs-dropdown-item @click="itemsPerPage=15">
              <span>15</span>
            </vs-dropdown-item>
            <vs-dropdown-item @click="itemsPerPage=20">
              <span>20</span>
            </vs-dropdown-item>
          </vs-dropdown-menu>
        </vs-dropdown>
      </div>

      <template slot="thead">
<!--        <vs-th sort-key="name">Kullanıcı Id</vs-th>-->
        <vs-th sort-key="name">Müşteri Adı</vs-th>
        <vs-th sort-key="name">Alışveriş Adı</vs-th>
        <vs-th sort-key="name">Açıklama</vs-th>
<!--        <vs-th sort-key="popularity">Yüzdelik</vs-th>-->
        <vs-th sort-key="order_status">Durum</vs-th>
        <vs-th sort-key="price">Fiyat</vs-th>
        <vs-th>İşlem</vs-th>
      </template>

        <template slot-scope="{data}">
          <tbody>
            <vs-tr :data="tr" :key="indextr" v-for="(tr, indextr) in data">
<!--              <vs-td>-->
<!--                <p class="product-name font-medium truncate" @click="goToUser(tr.user_id)" >{{ tr.user_id }}</p>-->
<!--              </vs-td>-->

              <vs-td>
             <p class="product-name font-medium truncate">{{ tr.user_name }}</p>
              </vs-td>

              <vs-td>
            <p class="product-name font-medium truncate">{{ tr.name }}</p>
              </vs-td>

              <vs-td>
                <p class="product-name font-medium truncate">{{ tr.description }}</p>
              </vs-td>

<!--              <vs-td>-->
<!--            <vs-progress :percent="Number(tr.price)" :color="getPopularityColor(Number(tr.price))" class="shadow-md" />-->
<!--              </vs-td>-->

              <vs-td>
                <vs-chip :color="getOrderStatusColor(tr.status)" class="product-order-status">{{ tr.status == 'open' ? 'Ödenmedi' : 'Ödendi'}}</vs-chip>
              </vs-td>

              <vs-td>
                <p class="product-price">{{ tr.price }}₺</p>
              </vs-td>

              <vs-td class="whitespace-no-wrap">
                <feather-icon icon="EditIcon" svgClasses="w-5 h-5 hover:text-primary stroke-current" @click="editData(tr)" />
                <feather-icon icon="TrashIcon" svgClasses="w-5 h-5 hover:text-danger stroke-current" class="ml-2" @click.stop="deleteData(tr.id)" />
              </vs-td>

            </vs-tr>
          </tbody>
        </template>
    </vs-table>
    <vs-table ref="table" v-else multiple v-model="selected" pagination :max-items="itemsPerPage" search :data="invoices">
      <!-- CARD 1: CONGRATS -->
      <div class="vx-col w-full  mb-base" v-show="user.role === 'store' && user.status === '0'">
        <vx-card slot="no-body" class="text-center bg-danger greet-user" >
          <feather-icon icon="InfoIcon" class="p-6 mb-8 bg-white inline-flex rounded-full text-black shadow" svgClasses="h-8 w-8"></feather-icon>
          <h1 class="mb-6 text-white">Kullanım Süreniz Sona Ermiştir.</h1>
          <p class="xl:w-3/4 lg:w-4/5 md:w-2/3 w-4/5 mx-auto text-white">Bize Katkıda Bulunarak Sizlere Hizmet Verebilmemize Olanak Sağlayın.</p>
          <popup-background></popup-background>
        </vx-card>
      </div>
    </vs-table>
  </div>
</template>

<script>
import DataViewSidebar from '../DataViewSidebar.vue'
import moduleInvoiceList from "@/store/invoices/moduleInvoiceList.js"
import jwt from "../../../../http/requests/auth/jwt";
import PopupBackground from '../../../../views/components/app-components/PopupBackground.vue'

export default {
  components: {
    DataViewSidebar,
    PopupBackground
  },
  data() {
    return {
      selected: [],
      user:{},
      itemsPerPage: 10,
      isMounted: false,

      // Data Sidebar
      addNewDataSidebar: false,
      sidebarData: {}
    }
  },
  computed: {
      currentPage () {
        if (this.isMounted) {
        return this.$refs.table.currentx
      }
      return 0
    },
    invoices() {
      return this.$store.state.invoice.AllInvoices
    },
    queriedItems () {
      return this.$refs.table ? this.$refs.table.queriedResults.length : this.invoices.length
    }
  },
  methods: {
    goToUser(id){
      this.$store.dispatch("invoice/findUser", id)
        .then(response => {
          this.$vs.notify({
            title: `Name : ${response.data.data.name}`,
            text: `Email: ${response.data.data.email}`,
            iconPack: 'feather',
            icon: 'icon-alert-circle',
            color: 'success'
          })
           })
        .catch(err => { console.error(err) })
    },
    addNewData() {
      this.sidebarData = {}
      this.toggleDataSidebar(true)
    },
    deleteData(id) {
      this.$store.dispatch("invoice/removeItem", id).catch(err => { console.error(err) })
    },
    editData(data) {
      // this.sidebarData = JSON.parse(JSON.stringify(this.blankData))
      console.log(data)
      this.sidebarData = data
      this.toggleDataSidebar(true)
    },
    getOrderStatusColor(status) {
     // if(status == 'open') return "warning"
      if(status == 'closed') return "success"
      if(status == 'open') return "danger"
      return "primary"
    },
    getPopularityColor(num) {
      if(num > 90) return "success"
      if(num >70) return "primary"
      if(num >= 50) return "warning"
      if(num < 50) return "danger"
      return "primary"
    },
    toggleDataSidebar(val=false) {
      this.addNewDataSidebar = val
    },
    fetchUser(){
      jwt.fetchUser().then(response => {
        // Update user details
        this.user = response.data
      })
    },
  },
  created() {
    if(!moduleInvoiceList.isRegistered) {
      this.$store.registerModule('invoices', moduleInvoiceList)
      moduleInvoiceList.isRegistered = true
    }
    this.$store.dispatch("invoice/fetchInvoiceListItems")
    this.fetchUser()
  },
  mounted() {
    this.isMounted = true;
  }
}
</script>

<style lang="scss">
#data-list-list-view {
  .vs-con-table {

    /*
      Below media-queries is fix for responsiveness of action buttons
      Note: If you change action buttons or layout of this page, Please remove below style
    */
    @media (max-width: 689px) {
      .vs-table--search {
        margin-left: 0;
        max-width: unset;
        width: 100%;

        .vs-table--search-input {
          width: 100%;
        }
      }
    }

    @media (max-width: 461px) {
      .items-per-page-handler {
        display: none;
      }
    }

    @media (max-width: 341px) {
      .data-list-btn-container {
        width: 100%;

        .dd-actions,
        .btn-add-new {
          width: 100%;
          margin-right: 0 !important;
        }
      }
    }

    .product-name {
      max-width: 23rem;
    }

    .vs-table--header {
      display: flex;
      flex-wrap: wrap;
      margin-left: 1.5rem;
      margin-right: 1.5rem;
      > span {
        display: flex;
        flex-grow: 1;
      }

      .vs-table--search{
        padding-top: 0;

        .vs-table--search-input {
          padding: 0.9rem 2.5rem;
          font-size: 1rem;

          &+i {
            left: 1rem;
          }

          &:focus+i {
            left: 1rem;
          }
        }
      }
    }

    .vs-table {
      border-collapse: separate;
      border-spacing: 0 1.3rem;
      padding: 0 1rem;

      tr{
          box-shadow: 0 4px 20px 0 rgba(0,0,0,.05);
          td{
            padding: 20px;
            &:first-child{
              border-top-left-radius: .5rem;
              border-bottom-left-radius: .5rem;
            }
            &:last-child{
              border-top-right-radius: .5rem;
              border-bottom-right-radius: .5rem;
            }
          }
          td.td-check{
            padding: 20px !important;
          }
      }
    }

    .vs-table--thead{
      th {
        padding-top: 0;
        padding-bottom: 0;

        .vs-table-text{
          text-transform: uppercase;
          font-weight: 600;
        }
      }
      th.td-check{
        padding: 0 15px !important;
      }
      tr{
        background: none;
        box-shadow: none;
      }
    }

    .vs-table--pagination {
      justify-content: center;
    }
  }
}
</style>
