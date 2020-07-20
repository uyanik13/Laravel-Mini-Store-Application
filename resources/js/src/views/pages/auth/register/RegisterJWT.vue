<!-- =========================================================================================
File Name: RegisterJWT.vue
Description: Register Page for JWT
----------------------------------------------------------------------------------------
Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
Author URL: https://www.dijitalreklam.org
========================================================================================== -->


<template>
  <div class="clearfix">
    <vs-input
      v-validate="'required|min:3'"
      data-vv-validate-on="blur"
      label-placeholder="Ad Soyad"
      name="displayName"
      placeholder="Ad Soyad Giriniz"
      v-model="displayName"
      class="w-full" />
    <span class="text-danger text-sm">{{ errors.first('displayName')? 'İsminiz Gerekli' : '' }}</span>

    <vs-input
      v-validate="'required|email'"
      data-vv-validate-on="blur"
      name="email"
      type="email"
      label-placeholder="E-Posta Adresinizi Giriniz"
      placeholder="E-Posta Adresi"
      v-model="email"
      class="w-full mt-6" />
    <span class="text-danger text-sm">{{ errors.first('email')? 'Email Gerekli' : '' }}</span>


    <vs-input
      v-validate="'required|min:10|max:12'"
      data-vv-validate-on="blur"
      name="phone"
      type="phone"
      label-placeholder="Telefon Numarası"
      placeholder="Telefon Numaranızı Giriniz"
      v-model="phone"
      class="w-full mt-6" />
    <span class="text-danger text-sm">{{ errors.first('phone') ? 'Telefon No Gerekli' : ''}}</span>

    <vs-input
      v-validate="'min:3'"
      data-vv-validate-on="blur"
      label-placeholder="İşletme Adı"
      name="store_name"
      placeholder="İşletmenizin Adını Yazınız"
      v-model="store_name"
      class="w-full" />


    <vs-input
      ref="password"
      type="password"
      data-vv-validate-on="blur"
      v-validate="'required|min:6|max:10'"
      name="password"
      label-placeholder="Parola"
      placeholder="Parolanızı Giriniz"
      v-model="password"
      class="w-full mt-6" />
    <span class="text-danger text-sm">{{ errors.first('password') ? 'Şifre Gerekli' : ''}}</span>

    <vs-input
      type="password"
      v-validate="'min:6|max:10|confirmed:password'"
      data-vv-validate-on="blur"
      data-vv-as="password"
      name="confirm_password"
      label-placeholder="Parola Onayı"
      placeholder="Parolanızı Tekrar Giriniz"
      v-model="confirm_password"
      class="w-full mt-6" />
    <span class="text-danger text-sm">{{ errors.first('confirm_password') ? 'Şifre Onayı Gerekli' : ''}}</span>

    <vs-checkbox v-model="isTermsConditionAccepted" class="mt-6">Şartlar Ve Koşulları Kabul Ediyorum.</vs-checkbox>
    <vs-button  type="border"  @click="loginUser()" class="mt-6">Girişe Dön</vs-button>
    <vs-button class="float-right mt-6" @click="registerUserJWt" :disabled="!validateForm">Kayıt Ol</vs-button>
  </div>
</template>

<script>
export default {
  created() {
    this.checkLogin ()
  },
    data() {
        return {
            displayName: '',
            email: '',
            phone: '',
            user_ref_number: '',
            store_name: '',
            password: '',
            confirm_password: '',
            isTermsConditionAccepted: true
        }
    },
    computed: {
        validateForm() {
            return !this.errors.any() && this.displayName != '' && this.email != '' && this.store_name != '' && this.phone != ''  && this.password != '' && this.confirm_password != '' && this.isTermsConditionAccepted === true;
        }
    },
    methods: {
      checkLogin () {
        // If user is already logged in notify
        if (this.$acl.check('store')) {
          this.$vs.notify({
            title: 'Uyarı',
            text: 'Zaten Giriş Yapmış Buluyorsun!',
            iconPack: 'feather',
            icon: 'icon-alert-circle',
            color: 'warning'
          })
          return this.$router.push('/dashboard')
        }
        return true
      },
        registerUserJWt() {
            if (!this.validateForm ) return
          this.$vs.loading()
            const payload = {
              userDetails: {
                name: this.displayName,
                phone:this.phone,
                user_ref_number:this.user_ref_number,
                store_name:this.store_name,
                email: this.email,
                password: this.password,
                confirmPassword: this.confirm_password
              },
              notify: this.$vs.notify
            }
            this.$store.dispatch('auth/registerUserJWT', payload)
              .then((response) => {
                this.$vs.loading.close()
                this.$vs.notify({
                  title: 'Başarılı',
                  text: 'Hesabınız Oluşturuldu',
                  iconPack: 'feather',
                  icon: 'icon-info',
                  color: 'success'
                })
                //console.log('rSTATUS', response.data.status)
                if(response.data.status === 'verification.sent') this.$router.push('/login')
              })
              .catch(error => {
                this.$vs.loading.close()
                this.$vs.notify({
                  title: 'Error',
                  text: error.message,
                  iconPack: 'feather',
                  icon: 'icon-alert-circle',
                  color: 'danger'
                })
              })
        },
      loginUser() {
        this.$router.push('/login').catch(() => {})
      }
    }
}
</script>
