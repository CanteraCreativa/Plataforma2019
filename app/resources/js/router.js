import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)


import Landing from './pages/Landing'
import SiteContent from './pages/SiteContent'
import Brands from './pages/Brands'
import Creators from './pages/Creators'
import CompleteProfile from './pages/CompleteProfile'
import UserProfileEdit from './pages/UserProfileEdit'
import Contests from './pages/Contests'
import ContestView from './pages/ContestView'
import UserProfile from './pages/UserProfile'
import VerifyEmail from './pages/VerifyEmail'
import Login from './pages/Login'
import ResetPassword from './pages/ResetPassword'


const router = new VueRouter({
    mode: 'history',
    hashbang: false,
    routes: [
        {
            path: '/',
            name: 'landing',
            component: Landing
        },
        {
            path: '/marcas',
            name: 'brands',
            component: Brands
        },
        {
            path: '/creativos',
            name: 'creators',
            component: Creators
        },
        {
            path: '/complete_profile',
            name: 'complete_profile',
            component: CompleteProfile
        },
        {
            path: '/profile_edit/:token?',
            name: 'profile_edit',
            component: UserProfileEdit
        },
        {
            path: '/contests',
            name: 'contests',
            component: Contests
        },
        {
            path: '/contests/:id',
            name: 'contest_view',
            component: ContestView
        },
        {
            path: '/profile/:id/:token?',
            name: 'profile_view',
            component: UserProfile
        },
        {
            path: '/verify/creative',
            name: 'verify_creative',
            component: VerifyEmail
        },
        {
            path: '/login',
            name: 'login',
            component: Login
        },
        {
            path: '/password_reset',
            name: 'password_reset',
            component: ResetPassword
        },

        {
            path: '/content/:slug',
            name: 'content',
            component: SiteContent
        },

    ]
})

export default router
