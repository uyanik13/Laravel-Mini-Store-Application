<!-- =========================================================================================
  File Name: AddNewDataSidebar.vue
  Description: Add New Data - Sidebar component
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: https://www.dijitalreklam.org
========================================================================================== -->


<template>
  <vs-sidebar click-not-close position-right parent="body" default-index="1" color="primary" class="add-new-data-sidebar items-no-padding" spacer v-model="isSidebarActiveLocal">
    <div class="mt-6 flex items-center justify-between px-6">
      <h4>{{ Object.entries(this.data).length === 0 ? "ALIŞVERİŞ EKLE" : "ALIŞVERİŞİ GÜNCELLE" }}</h4>
      <feather-icon icon="XIcon" @click.stop="isSidebarActiveLocal = false" class="cursor-pointer"></feather-icon>
    </div>
    <vs-divider class="mb-0"></vs-divider>

    <VuePerfectScrollbar class="scroll-area--data-list-add-new" :settings="settings" :key="$vs.rtl">

      <div class="p-6">


        <!-- NAME -->
        <vs-input label="Alışveriş Adı" v-model="dataName" class="mt-5 w-full" name="dataName" v-validate="'required'" />
        <span class="text-danger text-sm" v-show="errors.has('dataName')">{{ errors.first('dataName') }}</span>

        <vs-input label="Alışveriş Açıklaması" v-model="dataDescription" class="mt-5 w-full" name="dataDescription" v-validate="'required'" />
        <span class="text-danger text-sm" v-show="errors.has('dataDescription')">{{ errors.first('dataDescription') }}</span>

        <!--  STATUS -->
        <vs-select v-model="dataStatus" label="Durumu" name="dataStatus" class="mt-5 w-full">
          <vs-select-item :key="status.value" :value="status.value" :text="status.text" v-for="status in status_choices" />
          <span class="text-danger text-sm" v-show="errors.has('dataStatus')">{{ errors.first('dataStatus') }}</span>
        </vs-select>

        <!--  USERS -->
        <vs-select v-model="dataUserId" label="Müşteriler" name="dataUserId" class="mt-5 w-full">
          <vs-select-item :key="user.id" :value="user.id" :text="user.name" v-for="user in users_Data" />
          <span class="text-danger text-sm" v-show="errors.has('dataUserId')">{{ errors.first('dataUserId') }}</span>
        </vs-select>

        <!-- usage_amount -->
        <vs-input
          label="Fiyatı"
          v-model="dataPrice"
          class="mt-5 w-full"
          v-validate="{ required: true, regex: /\d+(\.\d+)?$/ }"
          name="dataUsage_amount" />
        <span class="text-danger text-sm" v-show="errors.has('dataPrice')">{{ errors.first('dataPrice') }}</span>

       <!--  Upload
        &lt;!&ndash; <vs-upload text="Upload Image" class="img-upload" ref="fileUpload" /> &ndash;&gt;

        <div class="upload-img mt-5" v-if="!dataImg">
          <input type="file" class="hidden" ref="uploadImgInput" @change="updateCurrImg" accept="image/*">
          <vs-button @click="$refs.uploadImgInput.click()">Upload Image</vs-button>
        </div>-->


      </div>
    </VuePerfectScrollbar>

    <div class="flex flex-wrap items-center p-6" slot="footer">
      <vs-button class="mr-6" @click="submitData" :disabled="!isFormValid">Kaydet</vs-button>
      <vs-button type="border" color="danger" @click="isSidebarActiveLocal = false">İptal</vs-button>
    </div>
  </vs-sidebar>
</template>

<script>
  import VuePerfectScrollbar from 'vue-perfect-scrollbar'
  import axios from 'axios';

  export default {
    props: {
      isSidebarActive: {
        type: Boolean,
        required: true
      },
      data: {
        type: Object,
        default: () => {},
      }
    },
    watch: {
      isSidebarActive(val) {
        if(!val) return
        if(Object.entries(this.data).length === 0) {
          this.initValues()
          this.$validator.reset()
        }else {
          let {  id, name,description, status,user_id, price } = JSON.parse(JSON.stringify(this.data))
          this.dataId = id
          this.dataName = name
          this.dataDescription = description
          this.dataStatus = status
          this.dataUserId = user_id
          this.dataPrice = price
          this.initValues()
        }
        // Object.entries(this.data).length === 0 ? this.initValues() : { this.dataId, this.dataName, this.dataCategory, this.dataOrder_status, this.dataUsage_amount } = JSON.parse(JSON.stringify(this.data))
      }
    },
    created() {
      axios.get("/api/users")
        .then((response) => { this.users_Data = response.data.data
        })
        .catch((error) => { console.log(error) })
    },
    data() {
      return {

        dataId: null,
        dataName: "",
        dataDescription: "",
        dataStatus: "Ödenmedi",
        dataUserId: null,
        dataPrice: 0,

        users_Data: {},
        status_choices: [
          {text:'Ödenmedi',value:'open'},
          {text:'Ödendi',value:'closed'}
         /* {text:'Delivered',value:'delivered'},
          {text:'On Hold',value:'on_hold'}*/
        ],

        settings: { // perfectscrollbar settings
          maxScrollbarLength: 60,
          wheelSpeed: .60,
        },
      }
    },
    computed: {
      isSidebarActiveLocal: {
        get() {
          return this.isSidebarActive
        },
        set(val) {
          if(!val) {
            this.$emit('closeSidebar')
            // this.$validator.reset()
            // this.initValues()
          }
        }
      },
      isFormValid() {
        return !this.errors.any() && this.dataName && this.dataDescription && this.dataUserId  && (this.dataPrice > 0)
      }
    },
    methods: {
      initValues() {
        if(this.data.id) return
        this.dataId = null
        this.dataName = ""
        this.dataDescription = ""
        this.dataStatus = "open"
        this.dataUserId = null
        this.dataPrice = 0
        //this.dataImg = null
      },
      submitData() {
        this.$validator.validateAll().then(result => {
          if (result) {
            const obj = {
              id: this.dataId,
              name: this.dataName,
              description:this.dataDescription,
              status: this.dataStatus,
              user_id: this.dataUserId,
              price: this.dataPrice
            }

            if(this.dataId !== null && this.dataId >= 0) {
              this.$store.dispatch("invoice/updateItem", obj).catch(err => { console.error(err) })
            }else{
              delete obj.id
              this.$store.dispatch("invoice/addItem", obj).catch(err => { console.error(err) })
            }
            this.$emit('closeSidebar')
            this.initValues()
          }
        })
      },
     /* updateCurrImg(input) {
        if (input.target.files && input.target.files[0]) {
          var reader = new FileReader()
          reader.onload = e => {
            this.dataImg = e.target.result
          }
          reader.readAsDataURL(input.target.files[0])
        }
      }*/
    },
    components: {
      VuePerfectScrollbar,
    }
  }
</script>

<style lang="scss" scoped>
  .add-new-data-sidebar {
    ::v-deep .vs-sidebar--background {
      z-index: 52010;
    }

    ::v-deep .vs-sidebar {
      z-index: 52010;
      width: 400px;
      max-width: 90vw;

      .img-upload {
        margin-top: 2rem;

        .con-img-upload {
          padding: 0;
        }

        .con-input-upload {
          width: 100%;
          margin: 0;
        }
      }
    }
  }

  .scroll-area--data-list-add-new {
    // height: calc(var(--vh, 1vh) * 100 - 4.3rem);
    height: calc(var(--vh, 1vh) * 100 - 16px - 45px - 82px);
  }
</style>
