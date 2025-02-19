<template>


    <aside id="Nav-Box" class="hidden sm:flex sm:flex-col">
      <router-link to="/auth/index" class="inline-flex items-center justify-center h-20 w-30 bg-orange-600 hover:bg-blue-800 focus:bg-blue-800">
          <img v-bind:src="url+'img/logofk.png'" class="flex items-center justify-center h-20">
        </router-link>
        <div  class="flex-grow flex flex-col justify-between text-gray-900 bg-orange-600" >
          <nav  class="flex flex-col mx-4 my-8 space-y-4 ">
            <router-link to="/admin/home" class="inline-flex items-center justify-center py-3  hover:text-gray-200 hover:bg-blue-700 focus:text-gray-400 focus:bg-blue-900 rounded-3xl">
              <span class="sr-only">Home</span>
              <span class="material-symbols-outlined">home</span>
              <p id="HTxt" class="">Inicio</p>
            </router-link>
            <router-link to="/admin/clients" class="inline-flex items-center justify-center py-3 hover:text-gray-200 hover:bg-blue-700 focus:text-gray-400 focus:bg-blue-900 rounded-3xl">
              <span class="sr-only">Clientes</span>
              <span class="material-symbols-outlined">group</span>
              <p id="HTxt" class="">Clientes</p>
            </router-link>
            <router-link to="/admin/works" class="inline-flex items-center justify-center py-3 hover:text-gray-200 hover:bg-blue-700 focus:text-gray-400 focus:bg-blue-900 rounded-3xl">
              <span class="sr-only">Ordenes de trabajo</span>
              <span class="material-symbols-outlined">bug_report</span>
              <p id="HTxt" class="">Ordenes</p>
            </router-link>
            <router-link to="/admin/calendar" class="inline-flex items-center justify-center py-3 hover:text-gray-200 hover:bg-blue-700 focus:text-gray-400 focus:bg-blue-900 rounded-3xl">
              <span class="sr-only">Agenda</span>
              <span class="material-symbols-outlined">calendar_clock</span>
              <p id="HTxt" class="">Agenda</p>
            </router-link>
            <router-link to="/admin/facturas" class="inline-flex items-center justify-center py-3 hover:text-gray-200 hover:bg-blue-700 focus:text-gray-400 focus:bg-blue-900 rounded-3xl">
              <span class="sr-only">Facturacion</span>
              <span class="material-symbols-outlined">paid</span>
              <p id="HTxt" class="">Facturacion</p>
            </router-link>
            <router-link to="/admin/creditos" class="inline-flex items-center justify-center py-3 hover:text-gray-200 hover:bg-blue-700 focus:text-gray-400 focus:bg-blue-900 rounded-3xl">
              <span class="sr-only">Creditos</span>
              <span class="material-symbols-outlined">credit_card</span>
              <p id="HTxt" class="">Creditos</p>
            </router-link>
            <router-link to="/admin/remisiones" class="inline-flex items-center justify-center py-3 hover:text-gray-200 hover:bg-blue-700 focus:text-gray-400 focus:bg-blue-900 rounded-3xl">
              <span class="sr-only">Remisiones</span>
              <span class="material-symbols-outlined">article</span>
              <p id="HTxt" class="">Remisiones</p>
            </router-link>
            <router-link to="/admin/certificate" class="inline-flex items-center justify-center py-3 hover:text-gray-200 hover:bg-blue-700 focus:text-gray-400 focus:bg-blue-900 rounded-3xl">
              <span class="sr-only">Certificados</span>
              <span class="material-symbols-outlined">verified</span>
              <p id="HTxt" class="">Certificados</p>
            </router-link>
            <router-link to="/admin/gastos" class="inline-flex items-center justify-center py-3 hover:text-gray-200 hover:bg-blue-700 focus:text-gray-400 focus:bg-blue-900 rounded-3xl">
              <span class="sr-only">Gastos</span>
              <span class="material-symbols-outlined">payments</span>
              <p id="HTxt" class="">Gastos</p>
            </router-link>
            <router-link to="/admin/ordenCompra" class="inline-flex items-center justify-center py-3 hover:text-gray-200 hover:bg-blue-700 focus:text-gray-400 focus:bg-blue-900 rounded-3xl">
              <span class="sr-only">Orden compra</span>
              <span class="material-symbols-outlined">docs</span>
              <p id="HTxt" class="">Orden compra</p>
            </router-link>
            <router-link to="/admin/admin" class="inline-flex items-center justify-center py-3 hover:text-gray-200 hover:bg-blue-700 focus:text-gray-400 focus:bg-blue-900 rounded-3xl">
              <span class="sr-only">Administracion</span>
              <span class="material-symbols-outlined">shield_person</span>
              <p id="HTxt" class="">Admin</p>
            </router-link>
          </nav>
          
        </div>
      </aside>
</template>


<style>
nav { 
  display: flex;
  flex-direction: column;
  justify-content: center;
  width: 50px;
  font-size: 0; 
  transition: width 0.75s ease-in-out, font-size 0.75s;  
  position: sticky;
  top: 0;

}
nav.span{
  margin-left: 15px;
}

span {
  color: black;
  display: inline-block;
}

nav:hover { 
  min-width: 50px;
  font-size: 15px;
  width: 150px;
  color: black;
  transition: width 0.75s, font-size 0.75s;  
} 

</style>


<script>
import { debounce } from 'lodash';

export default {
  name: 'AdminAsideComponent',
  data() {
    return {
      url: process.env.VUE_APP_ROOT_ASSETS,
      isExpanded: false,
    };
  },
  methods: {
    toggleExpanded() {
      this.isExpanded = !this.isExpanded;
    },
  },
  mounted() {
  const resizeObserver = new ResizeObserver(debounce(entries => {
    entries.forEach(entry => {
      if (entry.target === this.$el && window.innerWidth <= 768) { // Adjust breakpoint as needed
        this.isExpanded = false;
      }
    });
  }, 200));

  resizeObserver.observe(this.$el);
}
};
</script>