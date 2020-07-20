import axios from 'axios'
import Cookies from 'js-cookie'
import Swal from 'sweetalert2'
import i18n from '../i18n/i18n'
import router from "@/router"
import moduleAuth from '../store/auth/moduleAuth.js'
import Vue from "vue"
import {AclInstaller, AclCreate, AclRule } from "vue-acl"
Vue.use(AclInstaller )

// Request interceptor
const token = Cookies.get('token')
// Request interceptor
axios.interceptors.request.use(request => {
  if (token) {
    request.headers.common['Authorization'] = `Bearer ${token}`
  }

  return request
})

// Response interceptor
axios.interceptors.response.use(response => response, error => {
  const { status } = error.response

  if (status >= 500) {
    Swal.fire({
      type: 'error',
      title: i18n.t('error_alert_title'),
      text: i18n.t('error_alert_text'),
      reverseButtons: true,
      confirmButtonText: i18n.t('ok'),
      cancelButtonText: i18n.t('cancel')
    }).then(r => console.log('axios',r))
  }

  if (status === 401 && moduleAuth.state.user) {
    Swal.fire({
      type: 'warning',
      title: i18n.t('token_expired_alert_title'),
      text: i18n.t('token_expired_alert_text'),
      reverseButtons: true,
      confirmButtonText: i18n.t('ok'),
    }).then((r) => {
      moduleAuth.actions.logout()
      acl => acl.change('guest')
      router.push(router.currentRoute.query.to || 'login')
    }).catch((error) => {
      console.log('ERROR:', error)
    });
  }

  return Promise.reject(error)
})



export default axios
