/*=========================================================================================
  File Name: moduleCalendarActions.js
  Description: Calendar Module Actions
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: https://www.dijitalreklam.org
==========================================================================================*/

import axios from "../../plugins/axios.js"

export default {
  // addItem({ commit }, item) {
  //   return new Promise((resolve, reject) => {
  //     axios.post("/api/data-list/products/", {item: item})
  //       .then((response) => {
  //         commit('ADD_ITEM', Object.assign(item, {id: response.data.id}))
  //         resolve(response)
  //       })
  //       .catch((error) => { reject(error) })
  //   })
  // },
  fetchUsers({ commit }) {
    return new Promise((resolve, reject) => {
      axios.get("/api/users")
        .then((response) => {
          console.log('fetchUsers',response.data)
          commit('SET_USERS', response.data.data)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  fetchUser() {
    return new Promise((resolve, reject) => {
      axios.get(`/api/user`)
        .then((response) => {
          console.log('user',response)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  findUser({ commit }, userId) {
    return new Promise((resolve, reject) => {
      axios.get(`/api/users/${userId}`)
        .then((response) => {
          console.log('user',response)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },

 addUser(payload,data) {
    return new Promise((resolve, reject) => {
      console.log('payload',data)
      axios.post(`/api/users`,{
        name: data.name,
        email: data.email,
        phone: data.phone,
        password: data.password,
        user_total_debt: data.user_total_debt,
      })
        .then((response) => {
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  updateUser(payload,data) {
    return new Promise((resolve, reject) => {
      if(data.new_password !== data.confirm_new_password) {
        reject({message: "Password doesn't match. Please try again."})
      }
      console.log('payload',data)
      axios.patch(`/api/users/${data.id}`,{
        name: data.name,
        address: data.address,
        email: data.email,
        phone: data.phone,
        photo_url: data.photo_url,
        role: data.role,
        status: data.status,
        user_total_debt: data.user_total_debt,
        old_password: data.old_password,
        password: data.new_password,
      })
        .then((response) => {
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },

  updateStoreSettings(payload,data) {
    return new Promise((resolve, reject) => {
      if(data.new_password !== data.confirm_new_password) {
        reject({message: "Password doesn't match. Please try again."})
      }
      console.log('payload',data)
      axios.patch(`/api/store/${data.id}`,{
        store_name: data.store_name,
        store_debt_request_limit: data.store_debt_request_limit,
      })
        .then((response) => {
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  removeRecord({ commit }, userId) {
    return new Promise((resolve, reject) => {
      axios.delete(`/api/users/${userId}`)
        .then((response) => {
          commit('REMOVE_RECORD', userId)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },

  createPayment(payload,data) {
    return new Promise((resolve, reject) => {
      // console.log('payload',data)
      axios.post(`/api/createPayment`,{
        price: data.price,
        plan_name: data.plan_name,
      })
        .then((response) => {
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
}
