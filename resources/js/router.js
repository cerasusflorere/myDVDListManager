import { createRouter, createWebHistory } from 'vue-router'

// ページコンポーネントをインポートする
import createDVD from './pages/Create_DVD.vue'
import listDVD from './pages/List_DVD.vue'
import detailDVD from './pages/Detail_DVD.vue'
import listRent from './pages/List_Rent.vue'
import SystemError from './pages/errors/System.vue'
import NotFound from './pages/errors/NotFound.vue'
import { components } from 'vuetify/dist/vuetify-labs.js'


// パスとコンポーネントのマッピング
const routes = [
  {
    path: '/',
    component: listDVD
  },
  {
    path: '/create',
    component: createDVD
  },
  {
    path:'/detail/:propDVD',
    name:'detail',
    component: detailDVD,
    props: true
  },
  {
    path:'/rent',
    component: listRent
  },
  {
    path: '/500',
    component: SystemError
  },
  {
    path: '/:pathMatch(.*)*',
    component: NotFound
  }
]

// VueRouterインスタンスを作成する
const router = createRouter({
  history: createWebHistory(),
  routes
})

// VueRouterインスタンスをエクスポートする
// app.jsでインポートするため
export default router