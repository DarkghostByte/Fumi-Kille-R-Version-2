<template>
  <div>
    <div class="mr-6">
      <h1 class="py-10 px-5 text-4xl font-semibold mb-2">Administración</h1>
    </div>

    <div class="flex flex-wrap items-start justify-start">
      <router-link to="/admin/admin/city"
        class="inline-flex px-5 py-3 text-black hover:text-gray-200 bg-blue-600 hover:bg-blue-1000 focus:bg-blue-900 rounded-md ml-6 mb-5 shadow-lg"
        style="width:305px; height:100px; font-size:22px; text-align: center; ;">
        <i class="fa-solid fa-city" aria-hidden="true" style="margin-top: 10%;
            margin-left: -5px; margin-right:10px; font-size:20px;"></i>
        <h2>Ciudades ({{ totalCiudades }})</h2>
        <h3></h3>
      </router-link>

      <router-link to="/admin/admin/cologne"
        class="inline-flex px-5 py-3 text-black hover:text-gray-200 bg-green-600 hover:bg-green-1000 focus:bg-green-900 rounded-md ml-6 mb-5 shadow-lg"
        style="width:305px; height:100px; font-size:22px;">
        <i class="fa-solid fa-house" aria-hidden="true" style="margin-top: 10%; 
            margin-left: -5px; margin-right:10px; "></i>
        <h2>Colonias ({{ totalColonias }})</h2>
      </router-link>

      <router-link to="/admin/admin/settlements"
        class="inline-flex px-5 py-3 text-black hover:text-gray-200 bg-orange-600 hover:bg-orange-1000 focus:bg-orange-900 rounded-md ml-6 mb-5 shadow-lg"
        style="width:305px; height:100px; font-size:22px;">
        <i class="fa-solid fa-school-flag" aria-hidden="true" style="height:15px; margin-top: 10%; 
            margin-left: -5px; margin-right:10px; "></i>
        <h2>Departamentos ({{ totalAsentamientos }})</h2>
      </router-link>

      <router-link to="/admin/admin/roads"
        class="inline-flex px-5 py-3 text-black hover:text-gray-200 bg-purple-600 hover:bg-purple-1000 focus:bg-purple-900 rounded-md ml-6 mb-5 shadow-lg"
        style="width:305px; height:100px; font-size:22px;">
        <i class="fa-regular fa-address-card" aria-hidden="true" style="margin-top: 10%; 
            margin-left: -5px; margin-right:10px; "></i>
        <h2>Tipos de vias ({{ totalVias }})</h2>
      </router-link>

      <router-link to="/admin/admin/employees"
        class="inline-flex px-5 py-3 text-black hover:text-gray-200 bg-blue-500 hover:bg-blue-900 focus:bg-blue-800 rounded-md ml-6 mb-5 shadow-lg"
        style="width:305px; height:100px; font-size:22px;">
        <i class="fa-regular fa-address-card" aria-hidden="true" style="margin-top: 10%; 
            margin-left: -5px; margin-right:10px; "></i>
        <h2>Empleados ({{ totalEmpleados }})</h2>
      </router-link>

      <router-link to="/admin/admin/problematic"
        class="inline-flex px-5 py-3 text-black hover:text-gray-200 bg-green-500 hover:bg-green-900 focus:bg-green-800 rounded-md ml-6 mb-5 shadow-lg"
        style="width:305px; height:100px; font-size:22px;">
        <i class="fa-solid fa-bug" aria-hidden="true" style="margin-top: 10%; 
            margin-left: -5px; margin-right:10px; "></i>
        <h2>Tipo de plagas ({{ totalProblematica }})</h2>
      </router-link>

      <router-link to="/admin/admin/productInt"
        class="inline-flex px-5 py-3 text-black hover:text-gray-200 bg-orange-500 hover:bg-orange-900 focus:bg-orange-800 rounded-md ml-6 mb-5 shadow-lg"
        style="width:305px; height:100px; font-size:22px;">
        <i class="fa-solid fa-house-chimney-user" aria-hidden="true" style="margin-top: 10%; 
            margin-left: -5px; margin-right:10px; "></i>
        <h2>Productos Internos ({{ totalProductosInt }})</h2>
      </router-link>

      <router-link to="/admin/admin/productExt"
        class="inline-flex px-5 py-3 text-black hover:text-gray-200 bg-purple-500 hover:bg-purple-900 focus:bg-purple-800 rounded-md ml-6 mb-5 shadow-lg"
        style="width:305px; height:100px; font-size:22px;">
        <i class="fa-solid fa-house-circle-xmark" aria-hidden="true" style="margin-top: 10%; 
            margin-left: -5px; margin-right:10px; "></i>
        <h2>Productos Externos ({{ totalProductosExt }})</h2>
      </router-link>

      <router-link to="/admin/admin/clientsView"
        class="inline-flex px-5 py-3 text-black hover:text-gray-200 bg-blue-400 hover:bg-blue-800 focus:bg-blue-700 rounded-md ml-6 mb-5 shadow-lg"
        style="width:305px; height:100px; font-size:22px;">
        <i class="fa-solid fa-user" aria-hidden="true" style="margin-top: 10%; 
            margin-left: -5px; margin-right:10px; "></i>
        <h2>Clientes ({{ totalClientes }})</h2>
      </router-link>

      <router-link to="/admin/admin/orderView"
        class="inline-flex px-5 py-3 text-black hover:text-gray-200 bg-green-400 hover:bg-green-800 focus:bg-green-700 rounded-md ml-6 mb-5 shadow-lg"
        style="width:305px; height:100px; font-size:22px;">
        <i class="fa-solid fa-folder" aria-hidden="true" style="margin-top: 10%; 
            margin-left: -5px; margin-right:10px; "></i>
        <h2>Ordenes ({{ totalOrdenes }})</h2>
      </router-link>

      <router-link to="/admin/admin/ordercompleteView"
        class="inline-flex px-5 py-3 text-black hover:text-gray-200 bg-orange-400 hover:bg-orange-800 focus:bg-orange-700 rounded-md ml-6 mb-5 shadow-lg"
        style="width:305px; height:100px; font-size:22px;">
        <i class="fa-solid fa-folder-open" aria-hidden="true" style="margin-top: 10%; 
            margin-left: -5px; margin-right:10px; "></i>
        <h2>O. Terminadas ({{ totalOrdenesCompletadas }})</h2>
      </router-link>

      <router-link to="/admin/admin/formaContactoView"
        class="inline-flex px-5 py-3 text-black hover:text-gray-200 bg-purple-400 hover:bg-purple-800 focus:bg-purple-700 rounded-md ml-6 mb-5 shadow-lg"
        style="width:305px; height:100px; font-size:22px;">
        <i class="fa-solid fa-user" aria-hidden="true" style="margin-top: 10%; 
            margin-left: -5px; margin-right:10px; "></i>
        <h2>forma de contacto ({{ totalFormadecontacto }})</h2>
      </router-link>

      <router-link to="/admin/admin/certificadosView"
        class="inline-flex px-5 py-3 text-black hover:text-gray-200 bg-blue-300 hover:bg-blue-700 focus:bg-blue-600 rounded-md ml-6 mb-5 shadow-lg"
        style="width:305px; height:100px; font-size:22px;">
        <i class="fa-solid fa-user" aria-hidden="true" style="margin-top: 10%; 
            margin-left: -5px; margin-right:10px; "></i>
        <h2>Certificados ({{ totalCertificados }})</h2>
      </router-link>

      <router-link to="/admin/admin/facturasView"
        class="inline-flex px-5 py-3 text-black hover:text-gray-200 bg-green-300 hover:bg-green-700 focus:bg-green-600 rounded-md ml-6 mb-5 shadow-lg"
        style="width:305px; height:100px; font-size:22px;">
        <i class="fa-solid fa-folder" aria-hidden="true" style="margin-top: 10%; 
            margin-left: -5px; margin-right:10px; "></i>
        <h2>Facturas</h2>
      </router-link>

      <router-link to="/admin/admin/remisionesView"
        class="inline-flex px-5 py-3 text-black hover:text-gray-200 bg-orange-300 hover:bg-orange-700 focus:bg-orange-600 rounded-md ml-6 mb-5 shadow-lg"
        style="width:305px; height:100px; font-size:22px;">
        <i class="fa-solid fa-folder-open" aria-hidden="true" style="margin-top: 10%; 
            margin-left: -5px; margin-right:10px; "></i>
        <h2>Remisiones ({{ totalRemisiones }})</h2>
      </router-link>

      <router-link to="/admin/admin/ordenesCompraView"
        class="inline-flex px-5 py-3 text-black hover:text-gray-200 bg-purple-300 hover:bg-purple-700 focus:bg-purple-600 rounded-md ml-6 mb-5 shadow-lg"
        style="width:305px; height:100px; font-size:22px;">
        <i class="fa-solid fa-user" aria-hidden="true" style="margin-top: 10%; 
            margin-left: -5px; margin-right:10px; "></i>
        <h2>O. Compra ({{ totalOrdenCompra }})</h2>
      </router-link>

    </div>
  </div>




</template>

<script>
import axios from 'axios';
export default {
  name: 'AdminAdminComponent',
  data: () => ({
    dialogVisible: false,
    dialogVisibleView: false,
    url: process.env.VUE_APP_ROOT_ASSETS,
    urlApi: process.env.VUE_APP_ROOT_API,
    tableData: [],
    selectedItem: null,
    totalCiudades: 0,
    totalColonias: 0,
    totalAsentamientos: 0,
    totalProductosInt: 0,
    totalProductosExt: 0,
    totalClientes: 0,
    totalOrdenes: 0,
    totalEmpleados: 0,
    totalVias: 0,
    totalProblematica: 0,
    totalOrdenesCompletadas: 0,
    totalCertificados: 0,
    totalFacturas: 0,
    totalRemisiones: 0,
    totalOrdenCompra: 0,
  }),
  mounted() {
    if(!localStorage.getItem("token")){
      this.$router.push("/auth/index");
    }
    this.refresh(),
      this.fetchData();
  },
  methods: {
    refresh() {
      this.tableData = []
    },

    handleEdit() {
    },

    handleDelete() {
      axios.delete('clientes/' + this.selectedItem.id).then(res => {
        console.log(res)
        this.refresh()
        this.dialogVisible = false
      })
    },

    eliminar(row) {
      console.log(row)
      this.selectedItem = row
      this.dialogVisible = true
    },

    seleccionar(row) {
      console.log(row)
      this.selectedItem = row
      this.dialogVisibleView = true
    },

    pdf(row) {
      console.log(row)
      this.selectedItem = row
    },

    async fetchData() {
      try {
        const responseTotales = await axios.get(this.urlApi + 'totales');
        const {
          totalProductosExt,
          totalProductosInt,
          totalCiudades,
          totalColonias,
          totalProblematica,
          totalAsentamientos,
          totalClientes,
          totalOrdenes,
          totalEmpleados,
          totalVias,
          totalOrdenesCompletadas,
          totalCertificados,
          totalFacturas,
          totalRemisiones,
          totalOrdenCompra
        } = responseTotales.data; // Destructuring assignment

        this.totalProductosExt = totalProductosExt;
        this.totalProductosInt = totalProductosInt;
        this.totalCiudades = totalCiudades;
        this.totalColonias = totalColonias;
        this.totalProblematica = totalProblematica;
        this.totalAsentamientos = totalAsentamientos;
        this.totalClientes = totalClientes;
        this.totalOrdenes = totalOrdenes;
        this.totalEmpleados = totalEmpleados;
        this.totalVias = totalVias;
        this.totalOrdenesCompletadas = totalOrdenesCompletadas;
        this.totalCertificados = totalCertificados;
        this.totalFacturas = totalFacturas;
        this.totalRemisiones = totalRemisiones;
        this.totalOrdenCompra = totalOrdenCompra;

        console.log('Total productos externos', this.totalProductosExt);
        console.log('Total productos internos', this.totalProductosInt);
        console.log('Total ciudades', this.totalCiudades);
        console.log('Total colonias', this.totalColonias);
        console.log('Total problematicas', this.totalProblematica);
        console.log('Total comercios', this.totalAsentamientos);
        console.log('Total clientes', this.totalClientes);
        console.log('Total ordenes', this.totalOrdenes);
        console.log('Total empleados', this.totalEmpleados);
        console.log('Total vias', this.totalVias);
        console.log('Total ordenes completadas', this.totalOrdenesCompletadas);
        console.log('Total certificados', this.totalCertificados);
        console.log('Total facturas', this.totalFacturas);
        console.log('Total remisiones', this.totalRemisiones);
        console.log('Total ordenes compra', this.totalOrdenCompra);
        console.log('Totales', responseTotales.data);
      } catch (error) {
        console.error('Error al obtener los datos:', error);
      }
    },
  }
}
</script>

<style>
h2 {
  margin-top: 8%;
  text-align: center;
}

.box-item {
  position: absolute;
  text-align: center;
  justify-content: center;
  align-items: center;
}
</style>