import Vue from "vue";
import App from "./App.vue";

import router from "./router";
import './plugins/base'
import './plugins/chartist'
import './plugins/vue-world-map'

import store from "./store";
import vuetify from "./plugins/vuetify";
import VueTelInputVuetify from 'vue-tel-input-vuetify/lib';
import 'vue-event-calendar/dist/style.css' //^1.1.10, CSS has been extracted as one file, so you can easily update it.
import vueEventCalendar from 'vue-event-calendar';
import FunctionalCalendar from "vue-functional-calendar";

Vue.use(FunctionalCalendar, {
  dayNames: ["Mo", "Tu", "We", "Th", "Fr", "Sa", "Su"],
  isAutoCloseable: true,
  dateFormat:'dd/mm/yyyy',
});

Vue.use(vueEventCalendar, {locale: 'en'}) 


Vue.use(VueTelInputVuetify, {
  vuetify,
  placeholder: " ",
  label: " ",
});

Vue.config.productionTip = false;



new Vue({
  router,
  store,
  vuetify,
 
  render: (h) => h(App),
}).$mount("#app");
