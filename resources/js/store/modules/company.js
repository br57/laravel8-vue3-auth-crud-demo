import api from '@/utilities/api'
import { 
    addNewFilter, 
    makeFormDataFromObject, 
    isEmpty, 
    addUpdateItem 
} from '@/utilities/helper'

const moduleApiUrl = '/api/companies'

const state = {
    companies: [],
    company: [],
    allDataLoaded: false,
}

function mapData(state, getters, rootState, rootGetters, data){
    if(isEmpty(data)) return {}
    let statusByUuid = rootGetters['status/statusByUuid'];
    let employeesByCompanyUuid = rootGetters['employee/employeesByCompanyUuid'];
    if(!isEmpty(data.status_uuid)){
        data.status = statusByUuid(data.status_uuid)
    }
    data.total_employees = employeesByCompanyUuid(data.uuid).length
    return data
}

const getters = {
    companies: state => state.companies.sort((a,b) =>  Number(new Date(a.created_at)) -  Number(new Date(b.created_at))),
    companiesMapped: (state, getters, rootState, rootGetters) => getters.companies.map(i => {
        return mapData(state, getters, rootState, rootGetters, i)
    }).sort((a,b) =>  Number(new Date(a.created_at)) -  Number(new Date(b.created_at))),
    company: (state, getters, rootState, rootGetters) => mapData(state, getters, rootState, rootGetters, state.company),
    companyByUuid: (state, getters, rootState, rootGetters) => uuid => mapData(state, getters, rootState, rootGetters, state.companies.find(i => i.uuid == uuid)),
    isCompanyDataLoaded: state => state.allDataLoaded
}


const actions = {
    async getCompanies({ commit }) {
        let reqData = {
            method: "GET"
        }
        const response = await api(`${moduleApiUrl}`, reqData)
        const { status, data } = response
        switch (status) {
            case 200:
                commit("getCompanies", data)
                break
            default:
                console.error(`getCompanies()::API Failed with status code ${status}`, data)
                break
        }
        return response
    },
    async getCompany({ commit }, uuid) {
        let reqData = {
            method: "GET"
        }
        const response = await api(`${moduleApiUrl}/${uuid}`, reqData)
        const { status, data } = response
        switch (status) {
            case 200:
                commit("getCompany", data)
                break
            default:
                console.error(`getCompany()::API Failed with status code ${status}`, data)
                break
        }
        return response
    },
    async createCompany({ commit }, params) {
        let createData = makeFormDataFromObject(params)
        let reqData = {
            method: "POST",
            data: createData
        }
        const response = await api(`${moduleApiUrl}`, reqData)
        const { status, data } = response
        switch (status) {
            case 200:
                commit("createCompany", data)
                break
            default:
                console.error(`createCompanies()::API Failed with status code ${status}`, data)
                break
        }
        return response
    },
    async updateCompany({ commit }, params) {
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
                commit("updateCompany", data)
                break
            default:
                console.error(`updateCompany()::API Failed with status code ${status}`, data)
                break
        }
        return response
    },
    async deleteCompany({ commit }, uuid) {
        const reqData = {
            method: "DELETE"
        }
        const response = await api(`${moduleApiUrl}/${uuid}`, reqData)
        const { status, data } = response
        switch (status) {
            case 200:
                commit("deleteCompany", uuid)
                break
            default:
                console.error(`deleteCompany()::API Failed with status code ${status}`, data)
                break
        }
        return response
    }
}

const mutations = {
    getCompanies(state, data) {
        state.companies = addNewFilter(state.companies, data.companies)
        state.allDataLoaded = true
    },
    getCompany(state, data) {
        state.company = data.company
        state.companies = addUpdateItem(state.companies, data.company)
    },
    createCompany(state, data) {
        state.company = data.company
        state.companies = addUpdateItem(state.companies, data.company)
    },
    updateCompany(state, data) {
        if(!isEmpty(state.company)){
            if(state.company.uuid == data.company.uuid){
                state.company = data.company
            }
        }
        state.companies = addUpdateItem(state.companies, data.company)
    },
    deleteCompany(state, uuid) {
        if(!isEmpty(state.company)){
            if(state.company.uuid == uuid){
                state.company = []
            }
        }
        state.companies = state.companies.filter(i => i.uuid != uuid)
    },
}


export const company = {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}