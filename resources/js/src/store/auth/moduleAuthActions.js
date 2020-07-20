/*=========================================================================================
  File Name: moduleAuthActions.js
  Description: Auth Module Actions
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: https://www.dijitalreklam.org
==========================================================================================*/

import jwt from "../../http/requests/auth/jwt/index.js"
import * as types from '../mutation-types'
import Cookies from 'js-cookie'
import router from '@/router'
import axios from 'axios';
import {AclCreate} from "vue-acl";

export default {

    loginJWT({ commit }, payload) {
        return new Promise((resolve,reject) => {
            jwt.login(payload.userDetails.email, payload.userDetails.password)
                .then(response => {
                    if(response.data) {
                        resolve(response)
                        // Navigate User to homepage
                      commit("SET_BEARER", response.data.access_token)
                      Cookies.set('token', response.data.access_token, { expires: response.data.expires_in ? 365 : null })
                       jwt.fetchUser()
                        .then(response => {
                          //console.log('USER',response.data)
                          Cookies.set('role', response.data.role)
                          commit('UPDATE_USER_INFO', response.data, {root: true})
                        })
                        .catch(error => { console.log('ERROR jwt.fetchUser()',error) })
                      //router.push(router.currentRoute.query.to || 'dashboard')
                    }else {
                        reject({message: "Wrong Email or Password"})
                    }

                })
                .catch(error => { reject(error) })
        })
    },


    registerUserJWT({ commit }, payload) {

      const { name, email, phone,user_ref_number, store_name,password, confirmPassword } = payload.userDetails

      return new Promise((resolve,reject) => {

        // Check confirm password
        if(password !== confirmPassword) {
          reject({message: "Password doesn't match. Please try again."})
        }

        jwt.registerUser(name, email, phone,user_ref_number,store_name, password,confirmPassword)
          .then(response => {
            //router.push(router.currentRoute.query.to || 'login')
              resolve(response)
          })
          .catch(error => { reject(error) })
      })
    },



  saveToken ({ commit, dispatch }, payload) {
    commit(types.SAVE_TOKEN, payload)
  },


  async fetchOauthUrl (ctx, { provider }) {
    const { data } = await axios.post(`/api/oauth/${provider}`)
    return data.url
  },

  emailVerifyApi({ commit }, payload) {
    return new Promise((resolve,reject) => {

      jwt.emailVerifyApi(payload)
        .then(response => {
          resolve(response)
        })
        .catch(error => { reject(error) })
    })
  },

  fetchUser({ commit }) {
    return new Promise((resolve,reject) => {
      jwt.fetchUser()
        .then(response => {
          commit('UPDATE_USER_INFO', response.data, {root: true})
          return response.data
        })
        .catch(error => { reject(error) })
    })
  },

  fetchStore({ commit }) {
    return new Promise((resolve,reject) => {
      jwt.fetchStore()
        .then(response => {
          return response.data
        })
        .catch(error => { reject(error) })
    })
  },


  logout() {
      if(Cookies.get('token')) {
        axios.post('/api/logout')
        localStorage.removeItem('userInfo')
        Cookies.remove('token')
        Cookies.remove('role')
        console.log('LOGOUT')
      } else
      localStorage.removeItem('userInfo')
      Cookies.remove('token')
      Cookies.remove('role')
      console.log('LOGOUT')

  },


  updateUserRole({ dispatch }, payload) {
    // Change client side
    payload.aclChangeRole(payload.role)
    // Make API call to server for changing role
    // Change userInfo in localStorage and store
    dispatch('updateUserInfo', {role: payload.role})
  },


}
