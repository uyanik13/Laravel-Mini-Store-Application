<!-- =========================================================================================
  File Name: DashboardAnalytics.vue
  Description: Dashboard Analytics
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: https://www.dijitalreklam.org
========================================================================================== -->

<template>
  <div id="dashboard-analytics">
    <div class="vx-row">

      <!-- CARD 1: CONGRATS -->
      <div class="vx-col w-full lg:w-1/2 mb-base">
        <vx-card slot="no-body" class="text-center bg-primary-gradient greet-user">
                    <img src="@assets/images/elements/decore-left.png" class="decore-left" alt="Decore Left" idth="200" >
                    <img src="@assets/images/elements/decore-right.png" class="decore-right" alt="Decore Right" width="175">
          <feather-icon icon="AwardIcon" class="p-6 mb-8 bg-primary inline-flex rounded-full text-white shadow" svgClasses="h-8 w-8"></feather-icon>
          <h1 class="mb-6 text-white">Hoşgeldin {{ !user.store_name ? 'Güncelleniyor...' : user.store_name}}</h1>
          <p class="xl:w-3/4 lg:w-4/5 md:w-2/3 w-4/5 mx-auto text-white">İşletmenizdeki Müşterilerinizi Buradan Kolaylıkla Yönetebilirsiniz.</p>
        </vx-card>
      </div>

      <!-- CARD 2: SUBSCRIBERS GAINED -->
      <div class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/4 xl:w-1/4 mb-base">
        <statistics-card-line icon="UsersIcon" :statistic="!allUsers.length ? '0' : allUsers.length " :chartData="subscribersGained.series"  statisticTitle="Toplam Müşterilerim"  type='area'></statistics-card-line>
      </div>

      <!-- CARD 3: ORDER RECIEVED -->
      <div class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/4 xl:w-1/4 mb-base">
      <statistics-card-line icon="ShoppingBagIcon" :statistic="!user.total_debt ? '0' : user.total_debt+' ₺'" :chartData="subscribersGained.series"  statisticTitle="Toplam Alacağım" color='warning' type='area'></statistics-card-line>
    </div>

      <div class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/2 xl:w-1/2 mb-base">
        <div class="vx-row">
          <div class="vx-col w-1/2 sm:w-1/2 lg:w-1/2 mb-base">
            <vx-card>
              <div slot="no-body">
                <img src="/images/playstore-app-900.png" alt="content-img" class="responsive card-img-top">
              </div>
              <h5 class="mb-2">Mini İşletmem Android</h5>
              <p class="text-grey">Hemen İndirin</p>
              <div class="flex justify-between flex-wrap">
                <vs-button class="mt-4 mr-2 shadow-lg" type="gradient" href="https://play.google.com/store/apps/details?id=com.dijitalreklam.storeapp" color="#7367F0" gradient-color-secondary="#CE9FFC">İndir</vs-button>
              </div>
            </vx-card>
          </div>
          <div class="vx-col w-1/2 sm:w-1/2 lg:w-1/2 mb-base">
          <vx-card>
            <div slot="no-body">
              <img src="/images/iosstore-app.png" alt="content-img" class="responsive card-img-top">
            </div>
            <h5 class="mb-2">Mini İşletmem IOS</h5>
            <p class="text-grey">Çok Yakında</p>
            <div class="flex justify-between flex-wrap">
              <vs-button class="mt-4 mr-2 shadow-lg" type="gradient" color="#7367F0" gradient-color-secondary="#CE9FFC">Yakında</vs-button>
            </div>
          </vx-card>
        </div>
       </div>
      </div>
      <div class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/2 xl:w-1/2 mb-base" v-if="user.role === 'store' && user.status === '0'">
        <div class="vx-row">
          <div class="vx-col w-full">
            <div class="vx-col w-full  mb-base" >
              <vx-card slot="no-body" class="text-center bg-danger greet-user" >
                <feather-icon icon="InfoIcon" class="p-6 mb-8 bg-white inline-flex rounded-full text-black shadow" svgClasses="h-8 w-8"></feather-icon>
                <h1 class="mb-6 text-white">Kullanım Süreniz Sona Ermiştir.</h1>
                <p class="xl:w-3/4 lg:w-4/5 md:w-2/3 w-4/5 mx-auto text-white">Bize Katkıda Bulunarak Sizlere Hizmet Verebilmemize Olanak Sağlayın.</p>
                <popup-background></popup-background>
              </vx-card>
            </div>
          </div>
        </div>
      </div>
      <div class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/2 xl:w-1/2 mb-base" v-else>
        <div class="vx-row">
          <div class="vx-col w-full">
            <div class="vx-col w-full  mb-base" >
              <vx-card slot="no-body" class="text-center bg-primary greet-user" >
                <feather-icon icon="UserIcon" class="p-6 mb-8 bg-white inline-flex rounded-full text-black shadow" svgClasses="h-8 w-8"></feather-icon>
                <h1 class="mb-6 text-white">REFERANS NUMARANIZ</h1>
                <p class="xl:w-3/4  md:w-2/3 w-4/5 mx-auto text-white">{{ !user.store_ref_number ? '0' : user.store_ref_number}}</p>

                <vs-button
                  class="mt-4 mr-2 shadow-lg text-black text-bold"
                  v-clipboard:copy="user.store_ref_number"
                  v-clipboard:success="onCopy"
                  v-clipboard:error="onError"
                  color="#FFBC01" gradient-color-secondary="#FFBC01"
                >Kopyala</vs-button>
              </vx-card>
            </div>
          </div>
        </div>
      </div>

    </div>










  </div>
</template>

<script>
import VueApexCharts from 'vue-apexcharts'
import StatisticsCardLine from '@/components/statistics-cards/StatisticsCardLine.vue'
import analyticsData from './ui-elements/card/analyticsData.js'
import ChangeTimeDurationDropdown from '@/components/ChangeTimeDurationDropdown.vue'
import VxTimeline from "@/components/timeline/VxTimeline"
import jwt from "../http/requests/auth/jwt";
import PopupBackground from '../views/components/app-components/PopupBackground.vue'


export default {
    data() {
        return {
            allUsers:{},
            user:{},
            subscribersGained: {},
            ordersRecevied: {},
            salesBarSession: {},
            supportTracker: {},
            productsOrder: {},
            salesRadar: {},

            analyticsData: analyticsData,
            dispatchedOrders: [],
        }
    },
    components: {
        VueApexCharts,
        StatisticsCardLine,
        ChangeTimeDurationDropdown,
        VxTimeline,
        PopupBackground,
    },
  methods:{
    onCopy() {
      this.$vs.notify({
        title: 'Başarılı',
        text: 'Referans Numaranız Kopyalandı',
        color: 'success',
        iconPack: 'feather',
        position: 'top-center',
        icon:'icon-check-circle'
      })
    },
    onError() {
      this.$vs.notify({
        title: 'Başarısız',
        text: 'Referans Numaranız Kopyalanamadı!',
        color: 'danger',
        iconPack: 'feather',
        position: 'top-center',
        icon:'icon-alert-circle'
      })
    },
    fetchUsers(){
      jwt.fetchUsers().then(response => {
        console.log('USERs',response.data)
        this.allUsers = response.data.data
      })
    },
    fetchUser(){
      jwt.fetchUser().then(response => {
        this.user = response.data
      })
    },


  },
  created() {
    this.fetchUsers()
    this.fetchUser()
    //if(this.user === null) this.$router.push('/login')

  },


}
</script>

<style lang="scss">
/*! rtl:begin:ignore */
#dashboard-analytics {
  .greet-user{
    position: relative;

    .decore-left{
      position: absolute;
      left:0;
      top: 0;
    }
    .decore-right{
      position: absolute;
      right:0;
      top: 0;
    }
  }

  @media(max-width: 576px) {
    .decore-left, .decore-right{
      width: 140px;
    }
  }
}
/*! rtl:end:ignore */
</style>
