import Vue from "vue"
import {AclInstaller, AclCreate, AclRule } from "vue-acl"
Vue.use(AclInstaller )
import router from "@/router"
let initialRole = 'guest'

let userInfo = JSON.parse(localStorage.getItem("userInfo"))
if(userInfo && userInfo.role) initialRole = userInfo.role





export default new AclCreate({
  initial: initialRole,
  notfound: "/login",
  router,
  acceptLocalRules: true,
  globalRules: {
    admin: new AclRule("admin").generate(),
    store: new AclRule("store").or("store").generate(),
    guest: new AclRule("guest").generate(),
    // public: new AclRule("public").or("admin").or("editor").generate(),
  },

})


