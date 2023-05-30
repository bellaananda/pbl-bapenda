import { createRouter, createWebHistory } from "vue-router";
import store from "../store";
import Footer from "../components/TheFooter.vue";
import Navbar from "../components/TheNavbar.vue";
import LandingPage from "../views/LandingPage.vue";
import Dashboard from "../views/DashboardPage.vue";
import Grafik from "../views/GrafikPage.vue";
import Login from "../views/LoginPage.vue";

//admin
import ReadAgenda from "../views/admin/AgendaRead.vue";
import MainPegawai from "../views/admin/MainPegawai.vue";
import Posisi from "../views/admin/PosisiPegawai.vue";
import Department from "../views/admin/DepartmentPegawai.vue";
import Kategori from "../views/admin/KategoriAgenda.vue";
import Ruang from "../views/admin/RuanganBapenda.vue";
import NavbarAdmin from "../components/NavbarAdmin.vue";
import SidebarAdmin from "../components/SidebarAdmin.vue";

//user
import NavbarUser from "../components/NavbarUser.vue";
import SidebarUser from "../components/SidebarUser.vue";
import Pengajuan from "../views/user/PengajuanAgenda.vue";
import History from "../views/user/HistoryPengajuan.vue";

//operator
import SidebarOperator from "../components/SidebarOperator.vue";
import MainAgenda from "../views/operator/MainAgenda.vue";
import StatusPengajuan from "../views/operator/StatusPengajuan.vue";
import ReadPegawai from "../views/operator/ReadPegawai.vue";
 

const routes = [
	{
		path: "/",
		name: "landing-page",
		components: {default: LandingPage, header: Navbar, footer: Footer},
	},
	{
		path: "/login",
		name: "login",
		component: Login,
		meta: {
			guestOnly: true
		  }
	},
	//admin
	{
		path: "/dashboard-admin",
		name: "dashboard-admin",
		components: {default: Dashboard, header: NavbarAdmin, sidebar: SidebarAdmin, footer: Footer},
		// meta: { requiresAuth: true, role: "admin" }
	},
	{
		path: "/agendas-admin",
		name: "agendas-admin",
		components: {default: ReadAgenda, header: NavbarAdmin, sidebar: SidebarAdmin, footer: Footer},
		// meta: { requiresAuth: true, requiredRole: "admin" }
	},
	{
		path: "/employees-admin",
		name: "employees-admin",
		components: {default: MainPegawai, header: NavbarAdmin, sidebar: SidebarAdmin, footer: Footer},
		// meta: { requiresAuth: true, requiredRole: "admin" }
	},
	{
		path: "/positions",
		name: "positions",
		components: {default: Posisi, header: NavbarAdmin, sidebar: SidebarAdmin, footer: Footer},
		// meta: { requiresAuth: true, requiredRole: "admin" }
	},
	{
		path: "/departments",
		name: "departments",
		components: {default: Department, header: NavbarAdmin, sidebar: SidebarAdmin, footer: Footer},
		// meta: { requiresAuth: true, requiredRole: "admin" }
	},
	{
		path: "/categories",
		name: "categories",
		components: {default: Kategori, header: NavbarAdmin, sidebar: SidebarAdmin, footer: Footer},
		// meta: { requiresAuth: true, requiredRole: "admin" }
	},
	{
		path: "/rooms",
		name: "rooms",
		components: {default: Ruang, header: NavbarAdmin, sidebar: SidebarAdmin, footer: Footer},
		// meta: { requiresAuth: true, requiredRole: "admin" }
	},
	{
		path: "/charts-admin",
		name: "charts-admin",
		components: {default: Grafik, header: NavbarAdmin, sidebar: SidebarAdmin, footer: Footer},
		// meta: { requiresAuth: true, requiredRole: "admin" }
	},

	//user
	{
		path: "/dashboard-user",
		name: "dashboarduser",
		components: {default: Dashboard, header: NavbarUser, sidebar: SidebarUser, footer: Footer},
		meta: { requiresAuth: true }
		
	},
	{
		path: "/suggestions-user",
		name: "suggestion-user",
		components: {default: Pengajuan, header: NavbarUser, sidebar: SidebarUser, footer: Footer},
		meta: { requiresAuth: true }
		
	},
	{
		path: "/history-user",
		name: "history-user",
		components: {default: History, header: NavbarUser, sidebar: SidebarUser, footer: Footer},
		meta: { requiresAuth: true }
	},

	//operator
	{
		path: "/dashboard-operator",
		name: "dashboard-operator",
		components: {default: Dashboard, header: NavbarUser, sidebar: SidebarOperator, footer: Footer},
		// meta: { requiresAuth: true, requiredRole: "operator" }
	},
	{
		path: "/agendas-operator",
		name: "agendas-operator",
		components: {default: MainAgenda, header: NavbarUser, sidebar: SidebarOperator},
		// meta: { requiresAuth: true, requiredRole: "operator" }
		
	},
	{
		path: "/pengajuan-operator",
		name: "pengajuan-operator",
		components: {default: StatusPengajuan, header: NavbarUser, sidebar: SidebarOperator, footer: Footer},
		// meta: { requiresAuth: true, requiredRole: "operator" }
	},
	{
		path: "/employees-operator",
		name: "employees-operator",
		components: {default: ReadPegawai, header: NavbarUser, sidebar: SidebarOperator, footer: Footer},
		// meta: { requiresAuth: true, requiredRole: "operator" }
	},
	{
		path: "/charts-operator",
		name: "charts-operator",
		components: {default: Grafik, header: NavbarUser, sidebar: SidebarOperator, footer: Footer},
		// meta: { requiresAuth: true, requiredRole: "operator" }
	},
	
];

const router = createRouter({
	history: createWebHistory(process.env.BASE_URL),
	routes
});

router.beforeEach((to, from, next) => {
	if (to.matched.some(record => record.meta.requiresAuth)) {
		if (!store.getters.isLoggedIn) {
		  next({ name: "login" });
		} else {
		  next();
		}
	  } else if (to.matched.some(record => record.meta.guestOnly)) {
		if (store.getters.isLoggedIn) {
		  next({ name: "dashboarduser" });
		} else {
		  next();
		}
	  } else {
		next();
	  }
  });



export default router;
