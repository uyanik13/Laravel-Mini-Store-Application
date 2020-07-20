<!-- =========================================================================================
  File Name: UserEditTabInformation.vue
  Description: User Edit Information Tab content
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: https://www.dijitalreklam.org
========================================================================================== -->

<template>
  <div id="user-edit-tab-info">

    <!-- Avatar Row -->
    <div class="vx-row">
      <div class="vx-col w-full">
        <div class="flex items-start flex-col sm:flex-row">
          <img :src="data.photo_url" class="mr-8 rounded h-24 w-24" />
          <!-- <vs-avatar :src="data.avatar" size="80px" class="mr-4" /> -->
          <div>
            <p class="text-lg font-medium mb-2 mt-4 sm:mt-0">{{ data.name  }}</p>

          </div>
        </div>
      </div>
    </div>

    <!-- Content Row -->
    <div class="vx-row">
      <div class="vx-col md:w-1/2 w-full">
        <vs-input class="w-full mt-4" label="İsim" disabled="" v-model="data.name" v-validate="'required|alpha_spaces'" name="name" />
        <span class="text-danger text-sm"  v-show="errors.has('name')">{{ errors.first('name') }}</span>

        <vs-input class="w-full mt-4" disabled="" label="E-Posta" v-model="data.email" type="email" v-validate="'required|email'" name="email" />
        <span class="text-danger text-sm"  v-show="errors.has('email')">{{ errors.first('email') }}</span>
        <vs-input class="w-full mt-4" disabled="" label="Telefon No" v-model="data.phone" v-validate="{regex: '^\\+?([0-9]+)$' }" name="phone" />
        <span class="text-danger text-sm"  v-show="errors.has('phone')">{{ errors.first('phone') }}</span>

      </div>

      <div class="vx-col md:w-1/2 w-full">

        <div class="mt-4">
          <label class="vs-input--label">Durumu</label>
          <v-select disabled="" v-model="status_local" :clearable="false" :options="statusOptions" v-validate="'required'" name="status" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
          <span class="text-danger text-sm"  v-show="errors.has('status')">{{ errors.first('status') }}</span>
        </div>

        <vs-input class="w-full mt-4" disabled="" label="Adres" v-model="data.address" v-validate="'alpha_spaces'" name="address" />
        <span class="text-danger text-sm"  v-show="errors.has('address')">{{ errors.first('address') }}</span>

      </div>
    </div>


  </div>
</template>

<script>
import vSelect from 'vue-select'

export default {

  components: {
    vSelect
  },
  props: {
    data: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {

      data_local: JSON.parse(JSON.stringify(this.data)),

      statusOptions: [
        { label: "Active",  value: "active" },
        { label: "Blocked",  value: "blocked" },
        { label: "Deactivated",  value: "deactivated" },
      ],
      roleOptions: [
        { label: "Admin",  value: "1" },
        { label: "User",  value: "0" },
        { label: "Staff",  value: "staff" },
      ],
    }
  },
  computed: {
    status_local: {
      get() {
        return { label: this.data_local.status,  value: this.data_local.status  }
      },
      set(obj) {
        this.data_local.status = obj.value
      }
    },
    role_local: {
      get() {
        return { label: this.data_local.is_admin,  value: this.data_local.is_admin  }
      },
      set(obj) {
        this.data_local.is_admin = obj.value
      }
    },
    validateForm() {
      return !this.errors.any()
    }
  },
  methods: {
    // capitalize(str) {
    //   return str.slice(0,1).toUpperCase() + str.slice(1,str.length)
    // },
    save_changes() {
      if(!this.validateForm) return
      const payload = {
        id: this.data.id,
        name: this.data.name,
        address: this.data.address,
        email: this.data.email,
        phone: this.data.phone,
        status: this.status_local.value,
        is_admin: this.role_local.value,

      }
      this.$store.dispatch('userManagement/updateUser',payload)

    },

    reset_data() {
      this.data_local = JSON.parse(JSON.stringify(this.data))
    },
    update_avatar() {
      // You can update avatar Here
      // For reference you can check dataList example
      // We haven't integrated it here, because data isn't saved in DB
    }
  },
}
</script>
