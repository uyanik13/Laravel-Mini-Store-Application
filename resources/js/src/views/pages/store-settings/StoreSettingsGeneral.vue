<template>
  <vx-card no-shadow>


<!--    <vs-input class="w-full mb-base" name="username" disabled="" label-placeholder="Username" v-model="currentUserData.username"></vs-input>-->
    <vs-input class="w-full mb-base" name="name" label-placeholder="İşletme Adı" v-model="store.store_name"></vs-input>
    <vs-input class="w-full mb-base" name="name" label-placeholder="Ne Kadar Borçtan Sonra Kullanıcılara Bildirim Gönderilsin" v-model="store.store_debt_request_limit"></vs-input>
    <vs-input class="w-full mb-base" name="storeName" label-placeholder="Toplam Alacağım" disabled="" v-model="store.total_debt"></vs-input>
    <vs-input class="w-full mb-base" name="storeName" label-placeholder="Referans Numaram" disabled="" v-model="store.store_ref_number"></vs-input>



    <!-- Save & Reset Button -->
    <div class="flex flex-wrap items-center justify-end">
      <vs-button class="ml-auto mt-2" @click="save_changes">Kaydet</vs-button>
<!--      <vs-button class="ml-4 mt-2" type="border" color="warning">Reset</vs-button>-->
    </div>
  </vx-card>
</template>

<script>
  import axios from 'axios';
export default {
  created() {
    axios.get("/api/store")
      .then((response) => {
        console.log(response.data)
        this.store = response.data })
      .catch((error) => { console.log(error) })
    //console.log('PHOTOURL',this.photo_url)
  },
  data() {
    return {
      store : {},
    }
  },
  computed: {
    validateForm() {
      return !this.errors.any()
    },
  },
  methods:{
    save_changes() {
      if(!this.validateForm) return
      const payload = {
        id: this.store.id,
        store_name: this.store.store_name,
        store_debt_request_limit: this.store.store_debt_request_limit,

      }
      this.$store.dispatch('user/updateStoreSettings',payload)
        .then((response) => { this.$vs.loading.close()
          if(response.data)
            this.$vs.notify({
              title: 'Başarılı',
              text: 'Başarıyla Güncellendi',
              iconPack: 'feather',
              icon: 'icon-alert-circle',
              color: 'success'
            })
        })
        .catch(error => {
          this.$vs.loading.close()
          this.$vs.notify({
            title: 'Hata',
            text: error.message,
            iconPack: 'feather',
            icon: 'icon-alert-circle',
            color: 'danger'
          })
        })

    },

  }
}
</script>
