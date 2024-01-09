require('./bootstrap');
window.Vue = require('vue');

import App from './App.vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import router from './router.js'
import Vuelidate from 'vuelidate'
import Vuetify from 'vuetify' // Import Vuetify to your project
import Multiselect from 'vue-multiselect'
import Toasted from 'vue-toasted'
import VueAuth from '@websanova/vue-auth'

Vue.component('multiselect', Multiselect)
Vue.use(Vuetify) // Add Vuetify as a plugin
Vue.use(Vuelidate)
Vue.use(require('vue-moment'))
Vue.use(VueAxios, axios)

let apiUrl = document.head.querySelector('meta[name="base-url"]').content
/*if (process.env.NODE_ENV === 'production') {
  apiUrl = 'https://canteracreativa.com/'
}*/
window.baseUrl = apiUrl;
Vue.axios.defaults.baseURL = apiUrl;
Vue.use(Toasted, {
  position: 'top-right',
  duration: 7000,
  action: {
    text: 'x',
    onClick: (e, toastObject) => {
      toastObject.goAway(0)
    }
  },
  icon: 'thumbs-up',
  iconPack: 'fontawesome'
})
Vue.router = router
Vue.use(VueAuth, {
  auth: {
    request: function (req, token) {
      this.options.http._setHeaders.call(this, req, {
        'Authorization': 'Bearer ' + token,
        'Content-Type': 'application/json'
      })
    },
    response: function (res) {
      // Get Token from response body
      return res.data.token
    }
  },
  http: require('@websanova/vue-auth/drivers/http/axios.1.x.js'),
  router: require('@websanova/vue-auth/drivers/router/vue-router.2.x.js'),
  loginData: { url: apiUrl+'/api/login', fetchUser: true },
  logoutData: { url: apiUrl+'/api/logout', redirect: '/', makeRequest: false },
  // No borra la session en laravel, poner la api bien y makeRequest en true
  refreshData: { enabled: false },
  fetchData: {
    url: apiUrl + '/api/user/'
  },
  tokenStore: ['localStorage', 'cookie'],
  tokenDefaultName: 'cantera_creativa_session',
  parseUserData (data) {
    if (!Object.keys(data).length) {
      return {}
    }
    return data
  },
})


function imprimirObjeto (objeto, calls) {
  if (calls < 10) {
    if (objeto.type === 'application/json') {
      // Blobs
      let reader = new window.FileReader(objeto)
      reader.readAsBinaryString(objeto)
      console.log(objeto)
      reader.addEventListener('loadend', function () {
        imprimirObjeto(JSON.parse(reader.result), calls + 1)
      })
    } else {
      Object.keys(objeto).forEach((keyError) => {
        if (typeof objeto[keyError] === 'object') {
          imprimirObjeto(objeto[keyError], calls + 1)
        } else {
            if(objeto[keyError] == 'The given data was invalid.')
                objeto[keyError] = 'Hay problemas con los datos cargados'
          Vue.toasted.show(objeto[keyError], {
            icon: 'exclamation-circle',
            theme: 'bubble'
          })
        }
      })
    }
  }
}

Vue.prototype.$days_remaining = (startDate, endDate) => {
  let today = new Date()
  today.setHours(0,0,0,0)
  let todayMoment = Vue.prototype.$moment(today)

  var days = Vue.prototype.$moment(startDate, 'YYYY-MM-DD').diff(todayMoment, 'days')

    if(days > 0)
        return 'Próximamente'

  var days = Vue.prototype.$moment(endDate, 'YYYY-MM-DD').diff(todayMoment, 'days')
    if(days == 0)
        return 'Cierra hoy'
    if(days < 0)
        return 'Convocatoria Cerrada'

    var response = 'Queda'
    if(days > 1)
        response += 'n'
    response += ' '+days
    response += ' día'
    if(days > 1)
        response += 's'
    return response
}


Vue.prototype.$emitirToastError = (fail) => {
  if (typeof fail === 'object') {
    if (!fail.response) {
      Vue.toasted.show('Hubo un problema en la red', {
        icon: 'plug',
        theme: 'bubble'
      })
    } else {
      if (fail.response.status === 403) {
        Vue.toasted.show('No tiene permisos para realizar esta acción', {
          icon: 'exclamation-circle',
          theme: 'bubble'
        })
        return
      }
      if (typeof fail.response.data === 'object') {
        imprimirObjeto(fail.response.data, 0)
      } else {
        Vue.toasted.show(fail.response.data, {
          icon: 'exclamation-circle',
          theme: 'bubble'
        })
      }
    }
  } else {
    Vue.toasted.show(fail, {
      icon: 'exclamation-circle',
      theme: 'bubble'
    })
  }
}

Vue.filter('string_limit', function (value, number) {
  if (!value) return ''
  else {
    if (number < value.length)
      return value.substring(0, number) + '...'
    else
      return value
  }
})

Vue.filter('formatDate', function(value) {
  if (value) {
    return Vue.prototype.$moment(value, 'YYYY-MM-DD').format('DD/MM/YYYY')
  }
})

Vue.filter('show_prize', function (value) {
  let final_string = ''
  if (!value)
    value = 0
  let n = value.toString();
  let accumulator = -1
  for (var i = n.length; i >= 0; i--) {

    final_string = n.charAt(i).concat(final_string)
    accumulator++
    if (accumulator === 3 && i!=0) {
      accumulator = 0
      final_string = '.'.concat(final_string)
    }
  }
  return 'AR$'.concat(final_string)
})

const app = new Vue({
    el: '#app',
    name: 'RootApp',
    router,
    components: {
        App
    },
});
