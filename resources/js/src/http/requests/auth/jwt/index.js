import axios from "../../../../plugins/axios.js"



export default {

  init() {

  },

  login(email, pwd) {
    return axios.post("/api/login", {email: email, password: pwd})
  },
   fetchUser (){
    return axios.get("/api/user")
  },

  fetchStore(){
    return axios.get("/api/store")
  },

  fetchUsers() {
    return axios.get("/api/users")
  },
  registerUser(name, email, phone,user_ref_number,store_name, password, confirmPassword) {
    return axios.post("/api/register", {name: name, email: email, phone:phone, user_ref_number:user_ref_number,store_name:store_name,password: password, password_confirmation:confirmPassword})
  },
  emailVerifyApi(email) {
    return axios.post("/api/emailResendApi", {email: email})
  },

}
