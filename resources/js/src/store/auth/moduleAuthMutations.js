/*=========================================================================================
  File Name: moduleAuthMutations.js
  Description: Auth Module Mutations
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: https://www.dijitalreklam.org
==========================================================================================*/

import axios from "../../plugins/axios.js"
import * as types from '../mutation-types'

export default {
  SET_BEARER(state, token) {
    axios.defaults.headers.common['Authorization'] = 'Bearer ' + token
  },

}
