<template>
  <div>
    <vs-input
        v-validate="'required|email|min:3'"
        data-vv-validate-on="blur"
        name="email"
        icon-no-border
        icon="icon icon-user"
        icon-pack="feather"
        label-placeholder="E-Posta Adresi"
        v-model="email"
        class="w-full"/>
    <span class="text-danger text-sm">{{ errors.first('email')? 'E-Posta Gerekli' : '' }}</span>

    <vs-input
        data-vv-validate-on="blur"
        v-validate="'required|min:6|max:10'"
        type="password"
        name="password"
        icon-no-border
        icon="icon icon-lock"
        icon-pack="feather"
        label-placeholder="Parola"
        v-model="password"
        class="w-full mt-6" />
    <span class="text-danger text-sm">{{ errors.first('password')? 'Şifre Gerekli' : '' }}</span>

    <div class="flex flex-wrap justify-between my-5">
        <vs-checkbox v-model="checkbox_remember_me" class="mb-3">Beni Hatırla</vs-checkbox>
        <router-link to="/password/email">Şifremi Unuttum?</router-link>
    </div>
    <div class="flex flex-wrap justify-between mb-3">
      <vs-button  type="border" @click="registerUser">Kayıt Ol</vs-button>
      <vs-button :disabled="!validateForm" @click="loginJWT">Giriş Yap</vs-button>
    </div>
  </div>
</template>

<script>



export default {
  created() {
    this.checkLogin ()
  },
  data() {
    return {
      email: '',
      password: '',
      checkbox_remember_me: false
    }
  },
  computed: {
    validateForm() {
      return !this.errors.any() && this.email !== '' && this.password !== '';
    },
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
    loginJWT() {
      this.$vs.loading()
      const payload = {
        checkbox_remember_me: this.checkbox_remember_me,
        userDetails: {
          email: this.email,
          password: this.password
        }
      }
       this.$store.dispatch('auth/loginJWT', payload)
         .then((response) => {
         this.$vs.loading.close()
         this.$acl.change(response.data.user.role)
           if(response.data) this.$router.push('/dashboard')
        })
        .catch(error => {
          this.$vs.loading.close()
          this.$vs.notify({
            title: 'Hata',
            text: 'Girmiş Olduğunuz Bilgiler Uyuşmamaktadır.',
            iconPack: 'feather',
            icon: 'icon-alert-circle',
            color: 'danger'
          })
        })
    },
    registerUser() {
      this.$router.push('/register').catch(() => {})
    }
  }
}

</script>

