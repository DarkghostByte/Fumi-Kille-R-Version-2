<template>
    <div class="flex bg-gray-100 min-h-screen">
       <AdminAsideComponent />
       <div class="flex-grow text-gray-800">
        <!--  <AdminHeaderComponent /> -->
         <main class="p-6 sm:p-10 space-y-6">
            <router-view></router-view>
         </main>
         <AdminFooterComponent />
         <!-- Importar Iconos-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
  integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
  crossorigin="anonymous" referrerpolicy="no-referrer" />
       </div>
    </div>
 
 </template>
 
 <script>
     import AdminAsideComponent from '@/views/admin/layouts/AdminAsideComponent.vue'
     //import AdminHeaderComponent from '@/views/admin/layouts/AdminHeaderComponent.vue'
     import AdminFooterComponent from '@/views/admin/layouts/AdminFooterComponent.vue'
     export default {
         name:'AdminLayoutComponent',
         components:{
           AdminAsideComponent,
           //AdminHeaderComponent,
           AdminFooterComponent
         }
     }
 </script>