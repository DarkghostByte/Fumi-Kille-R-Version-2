import * as VueRouter from 'vue-router'
import LoginComponent from '@/views/auth/LoginComponent.vue'

const adminRoutes = [
    {path: 'home', component: () => import('@/views/admin/home/AdminHomeComponent.vue')},

    {path: 'clients', component: () => import('@/views/admin/clients/AdminClientsComponent.vue')},
    {path: 'clients/agregarComercio-clients', component: () => import('@/views/admin/clients/AdminAddClientsComponent.vue')},
    {path: 'clients/agregarParticular-clients', component: () => import('@/views/admin/clients/AdminAddParticularClientsComponent.vue')},
    {path: 'clients/edit-clients/:id', component: () => import('@/views/admin/clients/AdminEditClientsComponent.vue')},

    {path: 'works', component: () => import('@/views/admin/works/AdminWorksComponent.vue')},
    {path: 'worksComplete', component: () => import('@/views/admin/works/AdminWorksCompleteComponent.vue')},
    {path: 'worksComplete/:id', component: () => import('@/views/admin/works/AdminWorksCompleteIdComponent.vue')},
    {path: 'works/add-works/:id', component: () => import('@/views/admin/works/AdminAddWorksComponent.vue')},
    {path: 'works/complete-works/:id', component: () => import('@/views/admin/works/AdminCompleteWorksComponent.vue')},
    {path: 'works/edit-workComplete/:id', component: () => import('@/views/admin/works/AdminEditWorksCompleteComponent.vue')},
    {path: 'works/edit-workCreditComplete/:id', component: () => import('@/views/admin/works/AdminEditWorksCreditoCompleteComponent.vue')},
    {path: 'works/edit-workFactComplete/:id', component: () => import('@/views/admin/works/AdminEditWorksFacturaCompleteComponent.vue')},
    
    {path: 'works/edit-work/:id', component: () => import('@/views/admin/works/AdminEditWorksComponent.vue')},

    {path: 'calendar', component: () => import('@/views/admin/calendar/AdminCalendarComponent.vue')},
    {path: 'calendar/complete', component: () => import('@/views/admin/calendar/AdminCalendarCompleteComponent.vue')},

    {path: 'admin', component: () => import('@/views/admin/admin/AdminAdminComponent.vue')},
    {path: 'admin/city', component: () => import('@/views/admin/admin/AdminCityComponent.vue')},
    {path: 'admin/cologne', component: () => import('@/views/admin/admin/AdminCologneComponent.vue')},
    {path: 'admin/settlements', component: () => import('@/views/admin/admin/AdminSettlementsComponent.vue')},
    {path: 'admin/roads', component: () => import('@/views/admin/admin/AdminRoadsComponent.vue')},
    {path: 'admin/productInt', component: () => import('@/views/admin/admin/AdminProductIntComponent.vue')},
    {path: 'admin/productExt', component: () => import('@/views/admin/admin/AdminProductExtComponent.vue')},
    {path: 'admin/employees', component: () => import('@/views/admin/admin/AdminEmployeesComponent.vue')},
    {path: 'admin/problematic', component: () => import('@/views/admin/admin/AdminProblematicComponent.vue')},
    {path: 'admin/clientsView', component: () => import('@/views/admin/admin/AdminClientsViewComponent.vue')},
    {path: 'admin/ordercompleteView', component: () => import('@/views/admin/admin/AdminOrderCompleteViewComponent.vue')},
    {path: 'admin/orderView', component: () => import('@/views/admin/admin/AdminOrderViewComponent.vue')},
    {path: 'admin/certificadosView', component: () => import('@/views/admin/admin/AdminCertificadosView.vue')},
    {path: 'admin/formaContactoView', component: () => import('@/views/admin/admin/AdminFormaContactoView.vue')},
    {path: 'admin/facturasView', component: () => import('@/views/admin/admin/AdminFacturasView.vue')},
    {path: 'admin/remisionesView', component: () => import('@/views/admin/admin/AdminRemisionesView.vue')},
    {path: 'admin/ordenesCompraView', component: () => import('@/views/admin/admin/AdminOrdenesCompraView.vue')},
    
    
    
    

    {path: 'certificate', component: () => import('@/views/admin/certificate/AdminCertificateViewComponent.vue')},
    {path: 'certificate/views/', component: () => import('@/views/admin/certificate/AdminViewComponent.vue')},

    {path: 'remisiones', component: () => import('@/views/admin/remisiones/AdminRemisionesViewComponent.vue')},
    {path: 'remisiones/views/', component: () => import('@/views/admin/remisiones/AdminRemisionViewComponent.vue')},

    {path: 'facturas', component: () => import('@/views/admin/facturas/AdminFacturasViewComponent.vue')},
    {path: 'creditos', component: () => import('@/views/admin/facturas/AdminCreditosViewComponent.vue')},
    {path: 'facturas/views/', component: () => import('@/views/admin/facturas/AdminFacturasRepoComponent.vue')},

    {path: 'gastos', component: () => import('@/views/admin/gastos/AdminGastosComponent.vue')},

    {path: 'ordenCompra', component: () => import('@/views/admin/ordenCompra/AdminOrdenCompraComponent.vue')},
    {path: 'ordenCompra/new', component: () => import('@/views/admin/ordenCompra/AdminAddOrdenCompraComponent.vue')},
    {path: 'ordenCompra/edit/:id', component: () => import('@/views/admin/ordenCompra/AdminEditOrdenCompraComponent.vue')},
]


const routes =[
    {path :'/auth/index',name :'index',component:LoginComponent},

    {path:'/admin',name:'admin-home',
    component: import('@/views/admin/layouts/AdminLayoutComponent.vue'),
    children: adminRoutes
    },

]

const router = VueRouter.createRouter({
    history:VueRouter.createWebHistory(),
    routes
})
export default router