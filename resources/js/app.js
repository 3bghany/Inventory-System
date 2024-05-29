import './bootstrap';

import { createApp } from 'vue'
import { i18nVue } from 'laravel-vue-i18n'
import { trans } from 'laravel-vue-i18n';
import app from "./components/app.vue"
import router from "./routes.js"
import User from "./Helpers/User.js"
window.User=User
import Notifications from '@kyvg/vue3-notification'


// vuetify
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

const vuetify = createVuetify({
  components,
  directives,
})


// export const eventBus = new cre();
// export let eventBus=new createApp();

import Swal from 'sweetalert2'
window.Swal=Swal
const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.onmouseenter = Swal.stopTimer;
      toast.onmouseleave = Swal.resumeTimer;
    }
  });

  window.Toast=Toast

createApp(app).use(router).use(Notifications).use(vuetify).use(i18nVue, {
  resolve: async lang => {
      const langs = import.meta.glob('../../lang/*.json');
      return await langs[`../../lang/${lang}.json`]();
  }
}).mount('#app')

