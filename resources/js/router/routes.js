import { isEmpty } from '@/utilities/helper'
const ifAuthenticated = (to, from, next) => {
    let isAuth = false
    const token = localStorage.getItem("token")
    const tokenExpiredAt = localStorage.getItem('tokenExpiredAt')
    let current = Number(new Date())
    if (current < tokenExpiredAt) {
        if (!isEmpty(token)) {
            isAuth = true
        }
    }
    if (isAuth) {
        next()
    } else {
        next({ name: 'login' })
    }
}

const ifNotAuthenticates = (to, from, next) => {
    let isAuth = false
    const token = localStorage.getItem("token")
    const tokenExpiredAt = localStorage.getItem('tokenExpiredAt')
    let current = Number(new Date())
    if (current < tokenExpiredAt) {
        if (!isEmpty(token)) {
            isAuth = true
        }
    }
    if (isAuth) {
        next('/')
    } else {
        next()
    }
}


export default [
    {
        path: '/login',
        name: 'login',
        beforeEnter: ifNotAuthenticates,
        component: import("@/pages/login.vue")
    },
    {
        path: '/',
        name: 'root',
        beforeEnter: ifAuthenticated,
        component: import("@/pages/dashboard/dashboard.vue")
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        beforeEnter: ifAuthenticated,
        component: import("@/pages/dashboard/dashboard.vue")
    },

    {
        path: '/company',
        beforeEnter: ifAuthenticated,
        component: import("@/layouts/adminDefault.vue"),
        children: [
            {
                path: '/company',
                name: 'company-list',
                component: import("@/pages/company/list.vue"),
            },
            {
                path: '/company/add',
                name: 'company-add',
                component: import("@/pages/company/add.vue")
            },
            {
                path: '/company/:uuid',
                name: 'company-view',
                component: import("@/pages/company/view.vue")
            },
            {
                path: '/company/edit/:uuid',
                name: 'company-edit',
                component: import("@/pages/company/edit.vue")
            },
        ]
    },

    {
        path: '/employee',
        beforeEnter: ifAuthenticated,
        component: import("@/layouts/adminDefault.vue"),
        children: [
            {
                path: '/employee',
                name: 'employee-list',
                component: import("@/pages/employee/list.vue"),
            },
            {
                path: '/employee/add',
                name: 'employee-add',
                component: import("@/pages/employee/add.vue")
            },
            {
                path: '/employee/edit/:uuid',
                name: 'employee-edit',
                component: import("@/pages/employee/edit.vue")
            },
        ]
    },
    


    // {
    //     path: '/employee',
    //     name: 'employee-list',
    //     component: import("@/pages/employee/list.vue")
    // },
    // {
    //     path: '/employee/:uuid',
    //     name: 'employee-view',
    //     component: import("@/pages/employee/view.vue")
    // },
    // {
    //     path: '/employee/add',
    //     name: 'employee-add',
    //     component: import("@/pages/employee/add.vue")
    // },
    // {
    //     path: '/employee/edit/:uuid',
    //     name: 'employee-edit',
    //     component: import("@/pages/employee/edit.vue")
    // },
]