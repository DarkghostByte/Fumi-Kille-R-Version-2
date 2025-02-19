<template>
  <!-- Importar Iconos-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  <div>
    <div class="container mx-auto px-4">

      <!-- INICIO -->
      <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-semibold">Gestión de Remisiones</h1>
        <div class="py-3">
          <router-link to="/admin/admin" class="el-button el-button--danger">
            <i class="fa fa-rotate-left" aria-hidden="true"
              style="margin-top: 5px; margin-left: -5px; margin-right:10px;"></i>
            Regresar
          </router-link>
        </div>

      </div>
      <!-- Campo de búsqueda -->
    <div class="flex mb-4" style="justify-content: center;">
      <div class="flex mb-4" style="width: 80%;">
        <el-input class="px-2" placeholder="Buscar por nombre" v-model="searchQueryName" @input="filterDataName" />
        <el-input class="px-2" placeholder="Buscar por direccion" v-model="searchQueryAddress"
          @input="filterDataAddress" />
          <el-input class="px-2" placeholder="Buscar por celular" v-model="searchQueryPhone"
          @input="filterDataPhone" />
      </div>
    </div>

      <!-- END INICIO -->

      <!-- TABLE DATA -->
    <div class="flex" style="justify-content: center;">
      <el-table :data="filteredData" :default-sort="{ prop: 'id', order: 'descending' }" style="width: 100%" stripe>
        <!-- Columnas de la tabla -->

        <el-table-column label="" width="100" >
          <template #default="scope">
            <el-button style="color:black" size="small" type="info" @click="pdf(scope.row)">
              <a :href="url + 'api/remision/' + scope.row.id" target="_blank">
                <span class="material-symbols-outlined">lab_profile</span>
              </a>
            </el-button>
          </template>
        </el-table-column>

        <el-table-column label="" width="100" >
          <template #default="scope">
            <el-button style="color:black" size="small" type="success" @click="seleccionar(scope.row)"><span
                class="material-symbols-outlined">visibility</span></el-button>
          </template>
        </el-table-column>

        <!-- Agrega las demás columnas aquí -->
        <el-table-column label="Folio" sortable width="120">
          <template #default="scope">
            {{ 'No. ' + this.formatDate(scope.row.id) }}
          </template>
        </el-table-column>
        <el-table-column label="Dirección" sortable width="220">
          <template #default="scope">
            {{ scope.row.name + ' ' + scope.row.lastname1 + ' ' + scope.row.lastname2 }}
          </template>
        </el-table-column>
        <el-table-column label="Dirección" sortable width="550">
          <template #default="scope">
            {{ scope.row.ciudad + ', ' + scope.row.colonia + ' #' + scope.row.codigoPostal + ', ' + scope.row.home + ' #' + scope.row.numAddress }}
          </template>
        </el-table-column>
        <el-table-column prop="cell_phone" label="Numero Celular" sortable  />

      </el-table>
    </div>
    <!-- END TABLE DATA -->

      <!-- MODAL 2 -->
      <el-dialog v-model="dialogVisibleView" title="Datos del cliente" width="600" height="500">
        <div class="clientInfo">
          <div class="details">
            <i class="fa fa-user fa-2x iconInfo"></i>
            <!-- END MODAL 2 <h2 class="client-details__title">Información del Cliente</h2>-->
            <div>
              <p>
                <strong>Nombre completo:</strong> {{ selectedItem.name }} {{ selectedItem.lastname1 }} {{
                  selectedItem.lastname2 }}
              </p>
              <p>
                <strong>Nombre comercial:</strong> {{ selectedItem.tradename }}
              </p>
            </div>
          </div>
          <div class="details">
            <i class="fa fa-city fa-2x iconInfo"></i>
            <!-- END MODAL 2 <h2 class="client-details__title">Información del Cliente</h2>-->
            <div>
              <p>
                <strong>Domicilio:</strong> {{ selectedItem.street }} {{ selectedItem.home }} #{{
                  selectedItem.numAddress
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
            <i class="fa fa-phone fa-2x iconInfo"></i>
            <div>
              <p>
                <strong>Numero de celular:</strong> {{ selectedItem.cell_phone }}
              </p>
              <p>
                <strong>Número fijo:</strong> {{ selectedItem.number_fixed_number }}
              </p>
            </div>
          </div>
          <div class="details">
            <i class="fa fa-location-dot fa-2x iconInfo"></i>
            <div>
              <p>
                <strong>Como llegar:</strong> {{ selectedItem.how_to_get }}
              </p>
              <p>
                <strong>Descripcion:</strong> {{ selectedItem.description }}
              </p>
            </div>
          </div>
          <div class="details">
            <i class="fa fa-file-contract fa-2x iconInfo"></i>
            <div>
              <p>
                <strong>Tipo de contratación:</strong> {{ selectedItem.recruitment_data }}
              </p>
            </div>
          </div>


        </div>
        <template #footer>
          <div class="dialog-footer">
            <el-button type="primary" @click="dialogVisibleView = false">Listo</el-button>
          </div>
        </template>
      </el-dialog>
      <!-- END MODAL 2 -->

    </div>
  </div>
</template>

<script>
import axios from 'axios';
//import { ElNotification } from 'element-plus';

export default {
  name: 'AdminClientsComponent',
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
    searchQueryName: '',
    searchQueryAddress: '',
    searchQueryPhone: '',
  }),
  mounted() {
    this.refresh();
  },
  methods: {
    refresh() {
      axios.get('remisiones').then(res => {
        this.tableData = res.data.data;
        this.filteredData = this.tableData;
        console.log(this.filteredData);
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
    
    filterDataName() {
      this.filteredData = this.tableData.filter((clientes) => {
        return clientes.name.toLowerCase().includes(this.searchQueryName.toLowerCase());
      });
    },

    filterDataAddress() {
      this.filteredData = this.tableData.filter((clientes) => {
    const combinedAddress = clientes.ciudad.toLowerCase() + ' ' + clientes.colonia.toLowerCase() + ' ' + clientes.home.toLowerCase() + ' ' + clientes.codigoPostal.toLowerCase() + ' ' + clientes.numAddress.toLowerCase();
    return combinedAddress.includes(this.searchQueryAddress.toLowerCase());
  });
    },

    filterDataPhone() {
      this.filteredData = this.tableData.filter((clientes) => {
        return clientes.cell_phone.toLowerCase().includes(this.searchQueryPhone.toLowerCase());
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
    
    formatDate(id, paddingLength = 5, paddingChar = '0') {
  // Convert id to string in case it's a number
  const idString = String(id);

  // Ensure paddingLength is a positive integer
  paddingLength = Math.max(0, Math.floor(paddingLength));

  // Pad the string with paddingChar
  return idString.padStart(paddingLength, paddingChar);
},
  }
};
</script>
<style>
.clientInfo {
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

.iconInfo {
  color: #409eff;
  margin-right: 10px;
}

.iconDelete {
  color: #f32222;
  margin-right: 10px;
}
</style>
