import { createRouter, createWebHistory } from 'vue-router'
import Dashboard from '../views/admin/DashboardBapenda.vue'
import Agenda from '../views/admin/AgendaBapenda.vue'
import Pegawai from '../views/admin/PegawaiBapenda.vue'
import Posisi from '../views/admin/PosisiPegawai.vue'
import Department from '../views/admin/DepartmentPegawai.vue'
import Kategori from '../views/admin/KategoriAgenda.vue'
import Ruang from '../views/admin/RuanganBapenda.vue'
import Grafik from '../views/admin/GrafikBapenda.vue'

const routes = [
  {
    path: '/',
    name: 'dashboard',
    component: Dashboard
  },
  {
    path: '/agendas',
    name: 'agendas',
    component: Agenda
  },
  {
    path: '/employees',
    name: 'employees',
    component: Pegawai
  },
  {
    path: '/positions',
    name: 'positions',
    component: Posisi
  },
  {
    path: '/departments',
    name: 'departments',
    component: Department
  },
  {
    path: '/categories',
    name: 'categories',
    component: Kategori
  },
  {
    path: '/rooms',
    name: 'rooms',
    component: Ruang
  },
  {
    path: '/charts',
    name: 'charts',
    component: Grafik
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
