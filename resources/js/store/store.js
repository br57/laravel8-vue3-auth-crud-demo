import { createStore } from 'vuex'
import { user, company, employee } from '@/store/modules'
import { isEmpty } from '@/utilities/helper'

export const Store = createStore({
  state: {
    isAuth: false,
  },
  getters: {
    isAuth: state => state.isAuth
  },
  actions: {
    isAuthCheck({ commit }){
      let isAuth = false
      const token = localStorage.getItem("token")
      const tokenExpiredAt = localStorage.getItem('tokenExpiredAt')
      let current = Number(new Date())
      if(current < tokenExpiredAt){
        if(!isEmpty(token)){
          isAuth = true
        }
      }
      commit('isAuth', isAuth)
    }
  },
  mutations: {
    isAuth: (state, value) => {
      state.isAuth = value
    }
  },
  modules: {
    user,
    company,
    employee,
  }
})