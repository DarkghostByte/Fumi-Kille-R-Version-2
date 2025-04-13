<template>
  <!-- Importar Iconos-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <div class="">
    <i class="fa fa-file-pdf-o" aria-hidden="true" style="color: black;"></i>
    <h1 style="text-align: center; font-family: 'Arial', sans-serif; font-size: 32px; font-weight: bold;">Reportes</h1>

    <div class="flex justify-center items-center mt-4">
      <el-date-picker v-model="f1" type="date" format="DD-MM-YYYY" value-format="DD-MM-YYYY"
        placeholder="Fecha inicial"></el-date-picker>
      <span class="mx-3"> - </span>
      <el-date-picker v-model="f2" type="date" format="DD-MM-YYYY" value-format="DD-MM-YYYY"
        placeholder="Fecha final"></el-date-picker>
      <button
        class="ml-3 px-3 py-2 bg-blue-500 hover:bg-orange-500 text-white hover:text-neutral-950 rounded-md border-2 border-neutral-950"
        @click="fetchDate">Buscar</button>
    </div>
    <!--
    <div class="flex justify-center mb-5">
      <h1 style="text-align: center; font-family: 'Arial', sans-serif; font-size: 32px; font-weight: bold;">{{ f1 }}</h1>
      <h1 class="mx-3" style="text-align: center; font-family: 'Arial', sans-serif; font-size: 32px; font-weight: bold;">-</h1>
      <h1 style="text-align: center; font-family: 'Arial', sans-serif; font-size: 32px; font-weight: bold;">{{ f2 }}</h1>
    </div>
    -->

    <!-- v-for="item in 4" :key="item"-->

    <el-carousel type="card" height="200px" class="m-5 border-radius:5 gb-gray prueba">
      <!--VENTAS SIN FACTURA-->
      <el-carousel-item class="h-auto">
        <div style="justify-content:center;" class="flex items-center p-8  shadow rounded-lg">
          <div
            class="inline-flex flex-shrink-0 items-center justify-center h-16 w-16 text-green-600 bg-green-100 rounded-full mr-6">
            <i class="fa-solid fa-money-bill fa-beat fa-xl"></i>
          </div>
          <div>
            <span class="block text-gray-500">Venta Sin Facturas</span>
            <span class="block text-2xl font-bold">${{ totalVentasSinFactura }}</span>
            <a :href="url + 'api/ventsinfact/' + f1 + '/' + f2" target="_blank">
              <span class="material-symbols-outlined">picture_as_pdf</span>
            </a>
          </div>
        </div>
      </el-carousel-item>
      <!--VENTAS CON FACTURA-->
      <el-carousel-item class="h-auto carousel">
        <div style="justify-content:center;" class="flex items-center p-8 shadow rounded-lg">
          <div
            class="inline-flex flex-shrink-0 items-center justify-center h-16 w-16 text-red-600 bg-red-100 rounded-full mr-6">
            <i class="fa-solid fa-file-invoice-dollar fa-beat fa-xl"></i>
          </div>
          <div>
            <span class="block text-gray-500">Venta Con Facturas</span>
            <span class="block text-2xl font-bold">${{ totalVentasConFactura }}</span>
            <a :href="url + 'api/ventconfact/' + f1 + '/' + f2" target="_blank">
              <span class="material-symbols-outlined">picture_as_pdf</span>
            </a>
          </div>
        </div>
      </el-carousel-item>
      <!--VENTAS TOTALES-->
      <el-carousel-item class=" h-auto">
        <div style="justify-content:center;" class="flex items-center p-8  shadow rounded-lg">
          <div
            class="inline-flex flex-shrink-0 items-center justify-center h-16 w-16 text-blue-600 bg-blue-100 rounded-full mr-6">
            <i class="fa-solid fa-wallet fa-beat fa-xl"></i>
          </div>
          <div>
            <span class="block text-gray-500">Ventas Totales</span>
            <span class="block text-2xl font-bold">${{ totalPagos }}</span>
            <a :href="url + 'api/ventatotales/' + f1 + '/' + f2" target="_blank">
              <span class="material-symbols-outlined">picture_as_pdf</span>
            </a>
          </div>
        </div>
      </el-carousel-item>
      <!--CREDITOS SIN FACTURA-->
      <el-carousel-item class=" h-auto">
        <div style="justify-content:center;" class="h-auto flex items-center p-8  shadow rounded-lg">
          <div
            class="inline-flex flex-shrink-0 items-center justify-center items-center h-16 w-16 text-orange-600 bg-orange-100 rounded-full mr-6">
            <i class="fa-solid fa-circle-dollar-to-slot fa-beat fa-xl"></i>
          </div>
          <div class="justify-center items-center">
            <span class="block text-gray-500">Creditos Sin Factura</span>
            <span class="block text-2xl font-bold">${{ totalCreditosSinFactura }}</span>
            <a :href="url + 'api/creditossinfactura/' + f1 + '/' + f2" target="_blank">
              <span class="material-symbols-outlined">picture_as_pdf</span>
            </a>
          </div>
        </div>
      </el-carousel-item>
      <!--CREDITOS CON FACTURA-->
      <el-carousel-item class=" h-auto">
        <div style="justify-content:center;" class="h-auto flex items-center p-8  shadow rounded-lg">
          <div
            class="inline-flex flex-shrink-0 items-center justify-center items-center h-16 w-16 text-yellow-600 bg-yellow-100 rounded-full mr-6">
            <i class="fa-solid fa-handshake fa-beat fa-xl"></i>
          </div>
          <div class="justify-center items-center">
            <span class="block text-gray-500">Creditos Con Factura</span>
            <span class="block text-2xl font-bold">${{ totalCreditosConFactura }}</span>
            <a :href="url + 'api/creditosconfactura/' + f1 + '/' + f2" target="_blank">
              <span class="material-symbols-outlined">picture_as_pdf</span>
            </a>
          </div>
        </div>
      </el-carousel-item>
      <!--CREDITOS TOTALES-->
      <el-carousel-item class=" h-auto">
        <div style="justify-content:center;" class="h-auto flex items-center p-8  shadow rounded-lg">
          <div
            class="inline-flex flex-shrink-0 items-center justify-center items-center h-16 w-16 text-purple-600 bg-purple-100 rounded-full mr-6">
            <i class="fa-solid fa-percent fa-beat fa-xl"></i>
          </div>
          <div class="justify-center items-center">
            <span class="block text-gray-500">Creditos Totales</span>
            <span class="block text-2xl font-bold">${{ totalCreditos }}</span>
            <a :href="url + 'api/creditos/' + f1 + '/' + f2" target="_blank">
              <span class="material-symbols-outlined">picture_as_pdf</span>
            </a>
          </div>
        </div>
      </el-carousel-item>
      <el-carousel-item class=" h-auto">
        <div style="justify-content:center;" class="h-auto flex items-center p-8  shadow rounded-lg">
          <div
            class="inline-flex flex-shrink-0 items-center justify-center items-center h-16 w-16 text-purple-600 bg-purple-100 rounded-full mr-6">
            <i class="fa-solid fa-credit-card fa-beat fa-xl"></i>
          </div>
          <div class="justify-center items-center">
            <span class="block text-gray-500">Creditos Pendientes de Pago</span>
            <span class="block text-2xl font-bold">${{ totalCreditosPP }}</span>
            <a :href="url + 'api/creditosPendientes/' + f1 + '/' + f2" target="_blank">
              <span class="material-symbols-outlined">picture_as_pdf</span>
            </a>
          </div>
        </div>
      </el-carousel-item>
      
    </el-carousel>
    <div class="flex justify-center">
      <p class="px-4" style="margin-top:-1%;">VSF</p>
      <p class="px-4" style="margin-top:-1%;">VCF</p>
      <p class="px-4" style="margin-top:-1%; font-weight: bold;">VT</p>
      <p class="px-4" style="margin-top:-1%;">CSF</p>
      <p class="px-4" style="margin-top:-1%;">CCF</p>
      <p class="px-4" style="margin-top:-1%; font-weight: bold;">CT</p>
      <p class="px-4" style="margin-top:-1%; font-weight: bold;">CPP</p>
    </div>


    <!-- END FILE -->
  </div>

  <div class="flex justify-center items-center mt-4">
    <el-button @click="dialogVisibleFilter = true" class="ml-2 el-button el-button--primary">
      <i class="fa fa-magnifying-glass" aria-hidden="true"
        style="margin-top: 5px; margin-left: -5px; margin-right:10px;"></i>
      Filtros
    </el-button>
  </div>




  <!-- TABLE DATA -->
  <div class="flex">
    <el-table :data="filteredData1" :default-sort="{ prop: 'id', order: 'ascending' }"
      style="width: 100%; margin: auto;" stripe>
      <el-table-column sortable width="90">
        <template #default="{ row }">
          <div class="h-3 w-8 rounded-full" :style="{
            backgroundColor:
              row.requiere3 === 'Credito' ? 'red' :
                row.requiere3 === 'Pagado/Efectivo' ? 'green' :
                  row.requiere3 === 'Pagado/Banco' ? 'blue' :
                    row.requiere3 === 'Cortesia' ? 'orange' : 'white'
          }">
          </div>
        </template>
      </el-table-column>
      <el-table-column label="Nombre" sortable width="250">
        <template #default="scope">
          {{ scope.row.name + ' ' + scope.row.lastname1 + ' ' + scope.row.lastname2 }}
        </template>
      </el-table-column>
      <el-table-column prop="tradename" label="Negocio" sortable width="150" />
      <el-table-column label="Direccion" sortable width="300">
        <template #default="scope">
          {{ scope.row.home + ' #' + scope.row.numAddress + ', ' + scope.row.colonia + ' #' + scope.row.codigoPostal +
            ', ' + scope.row.ciudad }}
        </template>
      </el-table-column>
      <!-- facturaOrden -->
      <el-table-column prop="infoorden_facturacion" label="Facturacion" sortable width="125" />
      <el-table-column prop="facturaOrden" label="No. Factura" sortable width="125" />
      <el-table-column prop="pago" label="Monto" sortable width="125" />
      <el-table-column prop="requiere3" label="Estado" sortable width="125">
        <template #default="{ row }">
          <span v-if="row.requiere3 === 'Credito'">{{ row.requiere3 }}</span>
          <span v-else>{{ row.requiere3 }}</span>
        </template>
      </el-table-column>
      <el-table-column label="Fecha" sortable width="90">
        <template #default="scope">
          <span class="text-xs text-gray-600">
            {{ scope.row.facturaOrden === 'No aplica' || scope.row.facturaOrden === 'Pendiente' ? 'Sin factura' :
              `${scope.row.updated_at.slice(8,
                10)}-${scope.row.updated_at.slice(5,
                  7)}-${scope.row.updated_at.slice(0,
                    4)}` }}
          </span>
        </template>
      </el-table-column>
    </el-table>
    <!-- MODAL 1 -->
    <el-dialog v-model="dialogVisibleFilter" title="Filtros" width="30%">
      <el-form label-width="auto" style="max-width: 100%" ref="formRef" :rules="rules" :label-position="'top'">
        <el-collapse v-model="activeNames">
          <el-collapse-item title="Informacion General">
            <div class="row">
              <div class="col-md-6">
                <el-input placeholder="Buscar por nombre" v-model="searchQuery1" @input="filterData" />
              </div>
              <div class="col-md-6">
                <el-input placeholder="Buscar por negocio" v-model="searchQuery2" @input="filterData" />
              </div>
              <div class="col-md-12">
                <el-input placeholder="Buscar por dirección" v-model="searchQuery3" @input="filterData" />
              </div>
            </div>
          </el-collapse-item>
          <el-collapse-item title="Informacion Financiera">
            <div class="row">
              <div class="col-md-6">
                <el-select placeholder="Buscar si tiene facturacion" v-model="searchQuery4" @change="filterData">
                  <el-option label="Si" value="Si" />
                  <el-option label="No" value="No" />
                </el-select>
              </div>
              <div class="col-md-6">
                <el-input placeholder="Buscar por facturación" v-model="searchQuery5" @input="filterData" />
              </div>
              <div class="col-md-6">
                <el-input placeholder="Buscar monto" v-model="searchQuery6" @input="filterData" />
              </div>
              <div class="col-md-6">
                <el-select placeholder="Buscar por estado" v-model="searchQuery7" @change="filterData">
                  <el-option label="Pagado/Efectivo" value="Pagado/Efectivo" />
                  <el-option label="Pagado/Banco" value="Pagado/Banco" />
                  <el-option label="Credito" value="Credito" />
                  <el-option label="Cortesia" value="Cortesia" />
                </el-select>
              </div>
            </div>
          </el-collapse-item>
          <el-collapse-item title="Fechas">
            <div class="row">
              <div class="col-md-12">
                <el-date-picker class="px-2" v-model="selectedDate" @change="filterData" type="date" format="DD-MM-YYYY"
                  value-format="DD-MM-YYYY" placeholder="Seleccionar el rango de fecha" style="width: 100%;" />
              </div>
            </div>
          </el-collapse-item>
        </el-collapse>
      </el-form>
      <template #footer>
        <span class="dialog-footer">
          <el-button type="primary" @click="dialogVisibleFilter = false">Buscar</el-button>
          <el-button @click="resetFilters">Limpiar</el-button>
        </span>
      </template>
    </el-dialog>
    <!-- END MODAL 1 -->
  </div>

  <!-- END TABLE DATA -->


</template>

<script>
import axios from 'axios';
import { ElNotification } from 'element-plus';

export default {
  name: 'AdminHomeComponent',

  data: () => ({
    tableData: [],
    url: process.env.VUE_APP_ROOT_ASSETS,
    urlApi: process.env.VUE_APP_ROOT_API,
    totalPagos: 0,
    totalCreditos: 0,
    totalCreditosPP: 0,
    totalVentasSinFactura: 0,
    totalVentasConFactura: 0,
    totalCreditosSinFactura: 0,
    totalCreditosConFactura: 0,
    f1: '01-01-2024',
    f2: '30-12-2024',
    searchQuery1: '',
    searchQuery2: '',
    searchQuery3: '',
    searchQuery4: '',
    searchQuery5: '',
    searchQuery6: '',
    searchQuery7: '',
    searchQuery8: '',
    filteredData1: [],
    selectedDate: null,
    dialogVisibleFilter: false,

  }),
  mounted() {
    if(!localStorage.getItem("token")){
      this.$router.push("/auth/index");
    }
    this.fetchData();
    this.refresh();
  },
  methods: {
    refresh() {
      axios.get('completarOrden').then(res => {
        this.tableData = res.data.data;
        this.filteredData1 = this.tableData;
        console.log(res.data.data);
      });
    },

    handleEstadoClick(row) {
      row.requiere3 = row.requiere3 === 'Pagado' ? 'Credito' : 'Pagado';
      axios.put(`actualizarEstado/${row.id}`, { requiere3: row.requiere3 })
        .then(response => {
          console.log('Estado actualizado correctamente:', response.data);
          this.fetchData();
          ElNotification({
            title: 'Actualizacion de datos',
            message: `Se actualizaron los datos.`,
            type: 'success'
          });
        })
        .catch(error => {
          console.error('Error al actualizar el estado:', error);
        });
    },

    fetchDate() {
      if (this.f1 === null && this.f2 === null) {
        ElNotification({
          title: 'Aviso',
          message: `No se realizó el filtro de las fechas seleccionadas.`,
          type: 'warning'
        });
      } else if (this.f1 === null) {
        ElNotification({
          title: 'Aviso',
          message: `No se realizó el filtro de la fecha inicial.`,
          type: 'warning'
        });
      } else if (this.f2 === null) {
        ElNotification({
          title: 'Aviso',
          message: `No se realizó el filtro de la fecha final.`,
          type: 'warning'
        });
      } else {
        ElNotification({
          title: 'Filtro realizado',
          message: `Se realizó el filtro con las fechas seleccionadas (${this.f1} - ${this.f2}).`,
          type: 'success'
        });
      }
    },

    async fetchData() {
      try {
        const responseOrdenes = await axios.get(this.urlApi + 'completarOrden');
        this.tableData = responseOrdenes.data.data.filter(row => row.tradename !== 'Particular');

        const responseTotalDinero = await axios.get(this.urlApi + 'totalDinero');
        const {
          totalPagos,
          totalCreditos,
          totalCreditosPP,
          totalVentasSinFactura,
          totalCreditosSinFactura,
          totalCreditosConFactura,
          totalVentasConFactura,
        } = responseTotalDinero.data; // Destructuring assignment

        this.totalPagos = totalPagos;
        this.totalCreditos = totalCreditos;
        this.totalCreditosPP = totalCreditosPP;
        this.totalVentasSinFactura = totalVentasSinFactura;
        this.totalCreditosSinFactura = totalCreditosSinFactura;
        this.totalCreditosConFactura = totalCreditosConFactura;
        this.totalVentasConFactura = totalVentasConFactura;

        console.log('Total pagos', this.totalPagos);
        console.log('Total creditos', this.totalCreditos);
        console.log('Total ventas sin factura', this.totalVentasSinFactura);
        console.log('Total creditos sin factura', this.totalCreditosSinFactura);
        console.log('Total creditos con factura', this.totalCreditosConFactura);
        console.log('Total ventas con factura', this.totalVentasConFactura);
        console.log('Totales', responseTotalDinero.data);
      } catch (error) {
        console.error('Error al obtener los datos:', error);
      }
    },

    filterData() {
      this.filteredData1 = this.tableData.filter((completarOrden) => {
        const combinedName = completarOrden.name.toLowerCase() + ' ' + completarOrden.lastname1.toLowerCase() + ' ' + completarOrden.lastname2.toLowerCase();
        const tradeName = completarOrden.tradename.toLowerCase();
        const combinedAddress = completarOrden.ciudad.toLowerCase() + ' ' + completarOrden.colonia.toLowerCase() + ' ' + completarOrden.home.toLowerCase() + ' ' + completarOrden.codigoPostal.toLowerCase() + ' ' + completarOrden.numAddress.toLowerCase();
        const idString = completarOrden.id.toString();

        // Check each condition based on search queries
        let shouldInclude = true; // Start with assuming inclusion

        if (this.searchQuery1) {
          shouldInclude = shouldInclude && combinedName.includes(this.searchQuery1.toLowerCase());
        }

        if (this.searchQuery2) {
          shouldInclude = shouldInclude && tradeName.includes(this.searchQuery2.toLowerCase());
        }

        if (this.searchQuery3) {
          shouldInclude = shouldInclude && combinedAddress.includes(this.searchQuery3.toLowerCase());
        }

        if (this.searchQuery4) {
          shouldInclude = shouldInclude && completarOrden.infoorden_facturacion.toLowerCase().includes(this.searchQuery4.toLowerCase());
        }

        if (this.searchQuery5) {
          shouldInclude = shouldInclude && idString.toLowerCase().includes(this.searchQuery5.toLowerCase());
        }

        if (this.searchQuery6) {
          shouldInclude = shouldInclude && completarOrden.pago.toLowerCase().includes(this.searchQuery6.toLowerCase());
        }

        if (this.searchQuery7) {
          shouldInclude = shouldInclude && completarOrden.requiere3.toLowerCase().includes(this.searchQuery7.toLowerCase());
        }
        // Similar checks for other search queries...

        if (this.selectedDate) {
          shouldInclude = shouldInclude && completarOrden.date1 === this.selectedDate;
        }

        return shouldInclude;
      });
    },

    resetFilters() {
      // Limpiar campos de búsqueda
      this.searchQuery1 = '';
      this.searchQuery2 = '';
      this.searchQuery3 = '';
      this.searchQuery4 = '';
      this.searchQuery5 = '';
      this.searchQuery6 = '';
      this.searchQuery7 = '';
      // ... limpiar otros campos de búsqueda ...

      // Restablecer valores predeterminados
      this.selectedDate = null;

      // Actualizar la lista filtrada
      this.filteredData1 = this.tableData;
    },
  }
}
</script>

<style>
.el-carousel__item {
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  border-radius: 10px;
  /* Added rounded corners */
  margin: 10px 0px;
  /* Added spacing between items */

}

.el-carousel__item h3 {
  color: #475669;
  opacity: 0.75;
  line-height: 200px;
  text-align: center;
  font-family: 'Arial', sans-serif;
  font-size: 24px;


}

.el-carousel__item:nth-child(2n) {
  border-radius: 10px;
  background-color: white;



}

.el-carousel__item:nth-child(2n+1) {
  border-radius: 10px;
  background-color: rgb(255, 255, 255);


}

.el-carousel__button:nth-child(2n+1) {
  width: 45px;
  background-color: transparent;
  position: relative;
  /* Necessary for absolute positioning of the text */
  height: 25px;
  margin-left: 7px;
  margin-bottom: -25%;
  border-bottom: 3px solid #464646;
}


.el-carousel__item.is-active {
  opacity: 1;
  transform: scale(1);

}

.el-carousel__item:not(.is-active) {
  opacity: 0.25;
  transform: scale(0.9);

}

.el-table-column label {
  color: #333;
  /* Darker text color for headers */
}

.prueba {
  margin-bottom: -15px;
}
</style>