<template>
  <!-- Importar Iconos-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  <div class="container mx-auto px-4">
    
    <div class="flex justify-between items-center mb-4">
      <h1 class="text-2xl font-semibold">Gestión de Facturas Realizadas</h1>
      <div class="flex flex-wrap items-start justify-end ">
        <router-link to="/admin/facturas" class="el-button el-button--danger">
          <i class="fa fa-rotate-left" aria-hidden="true"
            style="margin-top: 5px; margin-left: -5px; margin-right:10px;"></i>
          Regresar
        </router-link>
      </div>
    </div>

    <!-- Campo de búsqueda -->
    <div class="flex mb-4" style="justify-content: center;">
      <div class="flex mb-4" style="width: 80%;">
        <el-input class="px-2" placeholder="Buscar por correo" v-model="searchQueryCorreo" @input="filterData" />
        <el-input class="px-2" placeholder="Buscar por persona moral" v-model="searchQueryTradename" @input="filterData" />
        <el-input class="px-2" placeholder="Buscar por persona fisica" v-model="searchQueryName"
          @input="filterData" />
        <el-input class="px-2" placeholder="Buscar por folio" v-model="searchQueryFolio"
          @input="filterData" />
      </div>
    </div>

    <!-- TABLE DATA -->
    <div class="flex" style="justify-content: center;">
      <el-table :data="filteredData" :default-sort="{ prop: 'id', order: 'ascending' }" style="width: 100%" stripe>
        <!-- Columnas de la tabla -->

        <el-table-column label="" width="100" >
          <template #default="scope">
            <el-button style="color:black" size="small" type="success" @click="seleccionar(scope.row)"><span
                class="material-symbols-outlined">visibility</span></el-button>
          </template>
        </el-table-column>

        <!-- Agrega las demás columnas aquí -->
        <el-table-column label="O. Trabajo" sortable width="115">
          <template #default="scope">
            {{ 'No. ' + this.formatDate(scope.row.id_orden) }}
          </template>
        </el-table-column>
        <el-table-column label="Folio" sortable  width="120">
          <template #default="scope">
            {{ 'No. ' + scope.row.facturaOrden }}
          </template>
        </el-table-column>
        <el-table-column label="Persona fisica" sortable width="180">
          <template #default="scope">
            {{ scope.row.name + ' ' + scope.row.lastname1 + ' ' + scope.row.lastname2 }}
          </template>
        </el-table-column>
        <el-table-column prop="tradename" label="Persona moral" sortable width="180" />
        <el-table-column prop="correo" label="Correo" sortable width="250" />
        <el-table-column prop="date2" label="F. Fumigacion" sortable width="150" />
        <el-table-column prop="pago" label="Monto" sortable width="auto" />

      </el-table>
    </div>
    <!-- END TABLE DATA -->

    <!-- MODAL 1 -->
    <el-dialog v-model="dialogVisibleView" title="Datos de la factura" width="700" height="500">
      <div class="FacturasInfo">
        <div class="details">
          <i class="fa fa-file fa-2x iconFacturasInfo"></i>
          <div>
            <p>
              <strong>Num. Orden de Trabajo:</strong> {{ formatOrdenNumber(selectedItem.id_orden) }}
            </p>
            <p>
              <strong>Num. Factura:</strong> {{ selectedItem.facturaOrden }}
            </p>
          </div>
        </div>
        <div class="details">
          <i class="fa fa-user fa-2x iconFacturasInfo"></i>
          <div>
            <p>
              <strong>Persona fisica:</strong> {{ selectedItem.name+' '+selectedItem.lastname1+' '+selectedItem.lastname2 }}
            </p>
            <p>
              <strong>Persona moral:</strong> {{ selectedItem.tradename }}            
            </p>
          </div>
        </div>
        <div class="details">
          <i class="fa fa-city fa-2x iconFacturasInfo"></i>
          <div>
            <p>
              <strong>Domicilio:</strong> {{ selectedItem.street }} {{ selectedItem.home }} #{{ selectedItem.numAddress
              }},
              {{
                selectedItem.colonia
              }} #{{ selectedItem.codigoPostal }}, {{ selectedItem.ciudad }}
            </p>
            <p>
              <strong>Tipo de lugar:</strong> {{ selectedItem.comercio }}
            </p>
          </div>
          
        </div>
        <div class="details">
          <i class="fa fa-envelope fa-2x iconFacturasInfo"></i>
          <div>
            <p>
              <strong>Correo:</strong> {{ selectedItem.correo }}
            </p>
            <p>
              <strong>Celular:</strong> {{ selectedItem.cell_phone }}
            </p>
          </div>
        </div>
        <div class="details">
          <i class="fa fa-money-bills fa-2x iconFacturasInfo"></i>
          <div>
            <p>
              <strong>F. Fumigacion:</strong> {{ selectedItem.date2 }}
            </p>
            <p>
              <strong>Monto:</strong> {{ '$ '+formatMoney(selectedItem.pago) }}
            </p>
          </div>
        </div>
      </div>
      <template #footer>
        <div class="dialog-footer">
          <el-button type="success" color="rgb(64, 255, 89);" @click="dialogVisibleView = false">Listo</el-button>
        </div>
      </template>
    </el-dialog>
    <!-- END MODAL 1 -->
  </div>
</template>

<script>
import axios from 'axios';
//import { ElNotification } from 'element-plus';

export default {
  name: 'AdminFacturasRepoComponent',
  data: () => ({
    dialogVisible: false,
    dialogVisibleView: false,
    dialogVisibleViewcertificado: false,
    url: process.env.VUE_APP_ROOT_ASSETS,
    urlApi: process.env.VUE_APP_ROOT_API,
    tableData: [],
    filteredData: [],
    selectedItem: {},
    selectedItem1: {},
    searchQuery: '',
    searchQueryCorreo: '',
    searchQueryTradename: '',
    searchQueryName: '',
    searchQueryFolio: '',
    searchQueryPhone: '',
  }),
  mounted() {
    this.refresh();
  },
  methods: {
    refresh() {
      axios.get('completarOrden').then(res => {
        this.tableData = res.data.data.filter(row => row.facturaOrden !== 'No aplica' && row.facturaOrden !== 'Pendiente');
        this.filteredData = this.tableData;
        console.log('Datos', this.tableData)
      });
    },
    seleccionar(row) {
      console.log(row);
      this.selectedItem = row;
      this.dialogVisibleView = true;
    },
    pdf(row) {
      console.log(row)
      this.selectedItem1 = row
      this.selectedItem1 = null
    },

    filterData() {
    this.filteredData = this.tableData.filter((facturas) => {
    const combinedName = facturas.name.toLowerCase() + ' ' + facturas.lastname1.toLowerCase() + ' ' + facturas.lastname2.toLowerCase();
    
    // Check each condition based on search queries
    let shouldInclude = true; // Start with assuming inclusion

    if (this.searchQueryTradename) {
      shouldInclude = shouldInclude && facturas.tradename.toLowerCase().includes(this.searchQueryTradename.toLowerCase());
    }

    if (this.searchQueryName) {
      shouldInclude = shouldInclude && combinedName.includes(this.searchQueryName.toLowerCase());
    }

    if (this.searchQueryCorreo) {
      shouldInclude = shouldInclude && facturas.correo.toLowerCase().includes(this.searchQueryCorreo.toLowerCase());
    }

    if (this.searchQueryFolio) {
      shouldInclude = shouldInclude && facturas.folioFactura.toLowerCase().includes(this.searchQueryFolio.toLowerCase());
    }



    return shouldInclude;
  });
},

    async fetchData() {
      try {
        const responseOrdenes = await axios.get(this.urlApi + 'remisiones');
        this.tableData = responseOrdenes.data.data;
      } catch (error) {
        console.error('Error al obtener los datos:', error);
      }
    },
    
    formatDate(id_orden, paddingLength = 5, paddingChar = '0') {
  // Convert id to string in case it's a number
  const idString = String(id_orden);

  // Ensure paddingLength is a positive integer
  paddingLength = Math.max(0, Math.floor(paddingLength));

  // Pad the string with paddingChar
  return idString.padStart(paddingLength, paddingChar);
},

formatOrdenNumber(id_orden) {
      return 'No. ' + id_orden.toString().padStart(5, '0');
    },

    formatMoney(amount) {
  return amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","); // O "," para usar comas
}

  }
};
</script>

<style>
.FacturasInfo {
  background-color: #f5f5f5;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  border-radius: 15px;
}

.details {
  padding: 20px;
  display: flex;
}

p {
  color: #000000;
}

.client-details__title {
  color: #000;
  font-weight: bold;
  margin-bottom: 15px;
}

.iconFacturasInfo {
  color: gold;
  margin-right: 10px;
}

.iconDelete {
  color: #f32222;
  margin-right: 10px;
}
</style>
