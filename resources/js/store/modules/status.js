import api from '@/utilities/api'
import { 
    addNewFilter, 
    makeFormDataFromObject, 
    isEmpty, 
    addUpdateItem 
} from '@/utilities/helper'

const moduleApiUrl = '/api/statuses'

const state = {
    statuses: [],
    status: [],
    allDataLoaded: false,
}

const getters = {
    statuses: state => state.statuses,
    status: state => state.status,
    statusByUuid: state => uuid => state.statuses.find(i => i.uuid == uuid),
    isStatusDataLoaded: state => state.allDataLoaded
}


const actions = {
    async getStatuses({ commit }) {
        let reqData = {
            method: "GET"
        }
        const response = await api(`${moduleApiUrl}`, reqData)
        const { status, data } = response
        switch (status) {
            case 200:
                commit("getStatuses", data)
                break
            default:
                console.error(`getStatuses()::API Failed with status code ${status}`, data)
                break
        }
        return response
    },
    async getStatus({ commit }, uuid) {
        let reqData = {
            method: "GET"
        }
        const response = await api(`${moduleApiUrl}/${uuid}`, reqData)
        const { status, data } = response
        switch (status) {
            case 200:
                commit("getStatus", data)
                break
            default:
                console.error(`getStatus()::API Failed with status code ${status}`, data)
                break
        }
        return response
    },
    async createStatus({ commit }, params) {
        let createData = makeFormDataFromObject(params)
        let reqData = {
            method: "POST",
            data: createData
        }
        const response = await api(`${moduleApiUrl}`, reqData)
        const { status, data } = response
        switch (status) {
            case 200:
                commit("createStatus", data)
                break
            default:
                console.error(`createStatuses()::API Failed with status code ${status}`, data)
                break
        }
        return response
    },
    async updateStatus({ commit }, params) {
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
                commit("updateStatus", data)
                break
            default:
                console.error(`updateStatus()::API Failed with status code ${status}`, data)
                break
        }
        return response
    },
    async deleteStatus({ commit }, uuid) {
        const reqData = {
            method: "DELETE"
        }
        const response = await api(`${moduleApiUrl}/${uuid}`, reqData)
        const { status, data } = response
        switch (status) {
            case 200:
                commit("deleteStatus", uuid)
                break
            default:
                console.error(`deleteStatus()::API Failed with status code ${status}`, data)
                break
        }
        return response
    }
}

const mutations = {
    getStatuses(state, data) {
        state.statuses = addNewFilter(state.statuses, data.statuses)
        state.allDataLoaded = true
    },
    getStatus(state, data) {
        state.status = data.status
        state.statuses = addUpdateItem(state.statuses, data.status)
    },
    createStatus(state, data) {
        state.status = data.status
        state.statuses = addUpdateItem(state.statuses, data.status)
    },
    updateStatus(state, data) {
        if(!isEmpty(state.status)){
            if(state.status.uuid == data.status.uuid){
                state.status = data.status
            }
        }
        state.statuses = addUpdateItem(state.statuses, data.status)
    },
    deleteStatus(state, uuid) {
        if(!isEmpty(state.status)){
            if(state.status.uuid == uuid){
                state.status = []
            }
        }
        state.statuses = state.statuses.filter(i => i.uuid != uuid)
    },
}


export const status = {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}