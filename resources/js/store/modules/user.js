import api from '@/utilities/api'
import { 
    addNewFilter, 
    makeFormDataFromObject, 
    isEmpty, 
    addUpdateItem 
} from '@/utilities/helper'


function unpackCommon(commonData, commit) {
    commonData = JSON.parse(commonData)
    Object.keys(commonData).forEach(key => {
        let data = {}
        let value = commonData[key]
        if (!isEmpty(value)) data.success = true
        switch (key) {
            case "companies":
                data.companies = isEmpty(value) ? [] : value
                commit('company/getCompanies', data, { root: true })
                break
            case "statuses":
                data.statuses = isEmpty(value) ? [] : value
                commit('status/getStatuses', data, { root: true })
                break
            case "employees":
                data.employees = value
                commit('employee/getEmployees', data, { root: true })
                break
            case "users":
                data.users = isEmpty(value) ? [] : value
                commit('getUsers', data)
                break
        }
    })
}

function mapData(state, getters, rootState, rootGetters, data){
    if(isEmpty(data)) return {}
    let statusByUuid = rootGetters['status/statusByUuid'];
    if(!isEmpty(data.status_uuid)){
        data.status = statusByUuid(data.status_uuid)
    }
    return data
}

const moduleApiUrl = '/api/users'

const state = {
    users: [],
    user: [],
    allDataLoaded: false,
}

const getters = {
    users: (state, getters, rootState, rootGetters) => state.users.map(i => {
        return mapData(state, getters, rootState, rootGetters, i)
    }),
    user: (state, getters, rootState, rootGetters) => mapData(state, getters, rootState, rootGetters, state.user),
    userByUuid: (state, getters, rootState, rootGetters) => uuid => mapData(state, getters, rootState, rootGetters, state.users.find(i => i.uuid == uuid)),
    isUserDataLoaded: state => state.allDataLoaded
}

const actions = {
    async commonCall({ commit }){
        const response = await api(`/api/common-auth-call`)
        const { status, data } = response
        switch (status) {
            case 200:
                unpackCommon(data.common_data, commit)
                break
            // default:
            //     console.error(`commonCall()::API Failed with status code ${status}`, data)
            //     break
        }
        return response
    },
    async loginUser({ commit }, params) {
        let createData = makeFormDataFromObject(params)
        let reqData = {
            method: "POST",
            data: createData
        }
        const response = await api(`/api/login`, reqData)
        const { status, data } = response
        switch (status) {
            case 200:
                localStorage.setItem("token", data.token);
                let tokenExpiredAt = Number(new Date()) + parseInt(3600000)
                localStorage.setItem("tokenExpiredAt", tokenExpiredAt);
                unpackCommon(data.common_data, commit)
                break
            default:
                console.error(`loginUser()::API Failed with status code ${status}`, data)
                break
        }
        return response
    },
    async logOutUser() {
        let reqData = {
            method: "POST",
        }
        const response = await api(`/api/logout`, reqData)
        const { status, data } = response
        switch (status) {
            case 200:
                localStorage.removeItem("token");
                localStorage.removeItem("tokenExpiredAt");
                break
            default:
                console.error(`loginUser()::API Failed with status code ${status}`, data)
                break
        }
        return response
    },
    async getUsers({ commit }) {
        let reqData = {
            method: "GET"
        }
        const response = await api(`${moduleApiUrl}`, reqData)
        const { status, data } = response
        switch (status) {
            case 200:
                commit("getUsers", data)
                break
            default:
                console.error(`getUsers()::API Failed with status code ${status}`, data)
                break
        }
        return response
    },
    async getUser({ commit }, uuid) {
        let reqData = {
            method: "GET"
        }
        const response = await api(`${moduleApiUrl}/${uuid}`, reqData)
        const { status, data } = response
        switch (status) {
            case 200:
                commit("getUser", data)
                break
            default:
                console.error(`getUser()::API Failed with status code ${status}`, data)
                break
        }
        return response
    },
    async createUser({ commit }, params) {
        let createData = makeFormDataFromObject(params)
        let reqData = {
            method: "POST",
            data: createData
        }
        const response = await api(`${moduleApiUrl}`, reqData)
        const { status, data } = response
        switch (status) {
            case 200:
                commit("createUser", data)
                break
            default:
                console.error(`createUsers()::API Failed with status code ${status}`, data)
                break
        }
        return response
    },
    async updateUser({ commit }, params) {
        let editData = makeFormDataFromObject(params)
        editData.append("_method", "PATCH")
        let reqData = {
            method: "POST",
            data: editData
        }
        const response = await api(`${moduleApiUrl}/${params.uuid}`, reqData)
        const { status, data } = response

        switch (status) {
            case 200:
                commit("updateUser", data)
                break
            default:
                console.error(`updateUser()::API Failed with status code ${status}`, data)
                break
        }
        return response
    },
    async deleteUser({ commit }, uuid) {
        const reqData = {
            method: "DELETE"
        }
        const response = await api(`${moduleApiUrl}/${uuid}`, reqData)
        const { status, data } = response
        switch (status) {
            case 200:
                commit("deleteUser", uuid)
                break
            default:
                console.error(`deleteUser()::API Failed with status code ${status}`, data)
                break
        }
        return response
    }
}

const mutations = {
    getUsers(state, data) {
        state.users = addNewFilter(state.users, data.users)
        state.allDataLoaded = true
    },
    getUser(state, data) {
        state.user = data.user
        state.users = addUpdateItem(state.users, data.user)
    },
    createUser(state, data) {
        state.user = data.user
        state.users = addUpdateItem(state.users, data.user)
    },
    updateUser(state, data) {
        if(!isEmpty(state.user)){
            if(state.user.uuid == data.user.uuid){
                state.user = data.user
            }
        }
        state.users = addUpdateItem(state.users, data.user)
    },
    deleteUser(state, uuid) {
        if(!isEmpty(state.user)){
            if(state.user.uuid == uuid){
                state.user = []
            }
        }
        state.users = state.users.filter(i => i.uuid != uuid)
    },
}


export const user = {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}