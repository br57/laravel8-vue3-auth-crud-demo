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
                path: '',
                name: 'company-list',
                component: import("@/pages/company/List.vue"),
            },
            {
                path: 'add',
                name: 'company-add',
                component: import("@/pages/company/Add.vue")
            },
            {
                path: ':uuid',
                name: 'company-view',
                component: import("@/pages/company/view.vue")
            },
            {
                path: 'edit/:uuid',
                name: 'company-edit',
                component: import("@/pages/company/Edit.vue")
            },
        ]
    },

    {
        path: '/employee',
        beforeEnter: ifAuthenticated,
        component: import("@/layouts/adminDefault.vue"),
        children: [
            {
                path: '',
                name: 'employee-list',
                component: import("@/pages/employee/List.vue"),
            },
            {
                path: 'add',
                name: 'employee-add',
                component: import("@/pages/employee/Add.vue")
            },
            {
                path: 'edit/:uuid',
                name: 'employee-edit',
                component: import("@/pages/employee/Edit.vue")
            },
        ]
    },

    {
        path: '/test',
        name: 'StaticTest',
        component: import("@/pages/TestPage.vue"),
    },
    {
        path: '/test/:jkl/:abc',
        name: 'dynamicTest',
        component: import("@/pages/TestPage.vue"),
    },
    
]