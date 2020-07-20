<template>
  <div class="the-navbar__user-meta flex items-center" v-if="activeUserInfo">

    <div class="text-right leading-tight hidden sm:block">
      <p class="font-semibold">{{ activeUserInfo.name }}</p>
      <small>{{ $t('Avaible') }}</small>
    </div>

    <vs-dropdown vs-custom-content vs-trigger-click class="cursor-pointer">

      <div class="con-img ml-3">
        <img v-if="activeUserInfo.photo_url" key="onlineImg" :src="activeUserInfo.photo_url" alt="user-img" width="40" height="40" class="rounded-full shadow-md cursor-pointer block" />
      </div>

      <vs-dropdown-menu class="vx-navbar-dropdown">
        <ul style="min-width: 9rem">

          <li
            class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white"
            @click="$router.push('/profile').catch(() => {})">
            <feather-icon icon="UserIcon" svgClasses="w-4 h-4" />
            <span class="ml-2">{{ $t('Profile') }}</span>
          </li>

<!--          <li-->
<!--            class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white"-->
<!--            @click="$router.push('/apps/email').catch(() => {})">-->
<!--            <feather-icon icon="MailIcon" svgClasses="w-4 h-4" />-->
<!--            <span class="ml-2">Inbox</span>-->
<!--          </li>-->

<!--          <li-->
<!--            class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white"-->
<!--            @click="$router.push('/apps/todo').catch(() => {})">-->
<!--            <feather-icon icon="CheckSquareIcon" svgClasses="w-4 h-4" />-->
<!--            <span class="ml-2">Tasks</span>-->
<!--          </li>-->

<!--          <li-->
<!--            class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white"-->
<!--            @click="$router.push('/apps/chat').catch(() => {})">-->
<!--            <feather-icon icon="MessageSquareIcon" svgClasses="w-4 h-4" />-->
<!--            <span class="ml-2">Chat</span>-->
<!--          </li>-->

<!--          <li-->
<!--            class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white"-->
<!--            @click="$router.push('/apps/eCommerce/wish-list').catch(() => {})">-->
<!--            <feather-icon icon="HeartIcon" svgClasses="w-4 h-4" />-->
<!--            <span class="ml-2">Wish List</span>-->
<!--          </li>-->

          <vs-divider class="m-1" />

          <li
            class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white"
            @click="logout">
            <feather-icon icon="LogOutIcon" svgClasses="w-4 h-4" />
            <span class="ml-2">Çıkış Yap</span>
          </li>
        </ul>
      </vs-dropdown-menu>
    </vs-dropdown>
  </div>
</template>

<script>
import Cookies from 'js-cookie'
import axios from 'axios';

export default {
  data() {
    return {

    }
  },
  computed: {
    activeUserInfo() {
      return this.$store.state.AppActiveUser

    }

  },
  methods: {
    logout() {
       this.$store.dispatch('auth/logout').then(response => {
         this.$acl.change('guest')
         this.$router.push('/login')
         // Change role on logout. Same value as initialRole of acj.js
       }).catch(error => { console.log(error) })
    },
  }
}
</script>
