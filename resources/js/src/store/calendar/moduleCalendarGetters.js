/*=========================================================================================
  File Name: moduleCalendarGetters.js
  Description: Calendar Module Getters
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: https://www.dijitalreklam.org
==========================================================================================*/


export default {
  getEvent: state => (eventId) => state.events.find((event) => event.id == eventId),
}
