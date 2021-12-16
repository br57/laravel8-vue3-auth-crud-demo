import 'vuetify/styles'
import { createApp } from 'vue'
import { createRouter, createWebHistory } from 'vue-router'
import Vuetify from '@/plugins/vuetify'
import { Store } from '@/store/store'
import routes from '@/router/routes'
import Application from '@/App.vue'

const App = createApp(Application)

const Router = createRouter({
    history: createWebHistory(),
    routes,
})
App.use(Vuetify)
App.use(Store)
App.use(Router)
App.mount('#app')
