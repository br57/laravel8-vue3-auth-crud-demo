import 'vuetify/styles'
import { createApp } from 'vue'
import { createRouter, createWebHistory } from 'vue-router'
import Vuetify from '@/plugins/vuetify'
import { Store } from '@/store/store'
import routes from '@/router/routes'
import Application from '@/App.vue'
import appMixins from '@/plugins/mixins'
import FormValidationMessage from '@/components/FormValidationMessage.vue'

const App = createApp(Application)

const Router = createRouter({
    history: createWebHistory(),
    scrollBehavior: (to, from, savedPosition) => ({
        top: 0,
        left: 0,
        behavior: 'smooth'
    }),
    routes,
})
App.use(Vuetify)
App.use(Store)
App.use(Router)
App.mixin(appMixins)
App.component('FormValidationMessage', FormValidationMessage)
App.mount('#app')
