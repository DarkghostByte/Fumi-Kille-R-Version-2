<template>
  <!-- Importar Iconos-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  <div>
    <div class="container mx-auto px-4">

      <!-- INICIO -->
      <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-semibold">Gestion de Facturas</h1>
        <div class="py-3">
          <router-link to="/admin/home" class="el-button el-button--danger">
            <i class="fa fa-rotate-left" aria-hidden="true"
              style="margin-top: 5px; margin-left: -5px; margin-right:10px;"></i>
            Regresar
          </router-link>
        </div>

      </div>
      <div class="flex justify-between items-center mb-4" style="width: 100%;">
        <el-input class="px-2" placeholder="Buscar por nombre completo" v-model="searchQueryName" @input="filterDataName" />
        <el-input class="px-2" placeholder="Buscar por direccion" v-model="searchQueryAddress"
          @input="filterDataAddress" />
          <el-input type="number" class="px-2" placeholder="Buscar por monto" v-model="searchQueryMonto" @input="filterDataMonto" />
          <el-input class="px-2" placeholder="Buscar por datos" v-model="searchQueryDatos" @input="filterDataDatos" />
          <el-input class="px-2" placeholder="Buscar por responsable" v-model="searchQueryResponsable" @input="filterDataResponsable" />
      </div>

      <!-- END INICIO -->

      <!-- TABLE -->
      <div class="flex" style="justify-content: center;">
        <el-table :data="filteredData" :default-sort="{ prop: 'name', order: 'ascending' }" style="width: 100%" stripe>

          <!--BOTON PARA VISUALIZAR EL PDF DE LA ORDEN DE TRABAJO-->
          <el-table-column label="">
            <template #default="scope">
              <el-button style="color:black"
                size="small"
                type="success"
                @click="pdf(scope.row)">
                <a :href="url+'api/ordenTrabajoCompleta/'+scope.row.id" target="_blank">
                  <span class="material-symbols-outlined">lab_profile</span>
                  </a>
              </el-button>
            </template>
        </el-table-column>
        <!--FIN DEL BOTON PARA VISUALIZAR EL PDF DE LA ORDEN DE TRABAJO-->

        <!--VISUALIZACION DE LA TABLA-->
        <el-table-column label="Nombre" sortable width="250">
          <template #default="scope">
            {{ scope.row.name+' '+scope.row.lastname1+' '+scope.row.lastname2 }}
          </template>
        </el-table-column>
        <el-table-column label="Direccion" sortable width="400">
          <template #default="scope">
            {{ scope.row.home+' #'+scope.row.numAddress+', '+scope.row.colonia+' #'+scope.row.codigoPostal+', '+scope.row.ciudad }}
          </template>
        </el-table-column>
        <el-table-column prop="pago" label="Monto"  sortable width="" />
        <el-table-column prop="requiere3" label="Datos" sortable width="" />
        <el-table-column prop="ariasEmpleado1" label="Responsable" sortable width=""  />
        <!--FIN DE LA VISUALIZACION DE LA TABLA-->
        <el-table-column label="">
          <template #default="scope">
            <router-link :to="'/admin/works/edit-workFactComplete/'+scope.row.id">
              <el-button style="color:black"
                size="small"
                type="warning"
                @click="handleEdit()"
                ><span class="material-symbols-outlined">edit</span></el-button
              >
            </router-link>
          </template>
        </el-table-column>

        </el-table>
      </div>
      <!-- END TABLE -->
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
    url: process.env.VUE_APP_ROOT_ASSETS,
    urlApi: process.env.VUE_APP_ROOT_API,
    tableData: [],
    filteredData: [],
    selectedItem: {},
    searchQuery: '',
    searchQueryName: '',
    searchQueryAddress: '',
    searchQueryMonto: '',
    searchQueryDatos: '',
    searchQueryResponsable: '',
  }),
  mounted() {
    this.refresh();
  },
  methods: {
    refresh() {
      axios.get('completarOrden').then(res => {
        this.tableData = res.data.data.filter(row => row.facturaOrden === 'Pendiente');
        this.filteredData = this.tableData;
      });
    },
    pdf(row) {
      console.log(row)
      this.selectedItem = row
      this.selectedItem = null
    },

    filterDataName() {
      this.filteredData = this.tableData.filter((completarOrden) => {
        const combinedname = completarOrden.name.toLowerCase() + ' ' + completarOrden.lastname1.toLowerCase() + ' ' + completarOrden.lastname2.toLowerCase();
        return combinedname.includes(this.searchQueryName.toLowerCase());

      });
    },

    filterDataAddress() {
      this.filteredData = this.tableData.filter((completarOrden) => {
        const combinedAddress = completarOrden.ciudad.toLowerCase() + ' ' + completarOrden.colonia.toLowerCase() + ' ' + completarOrden.home.toLowerCase() + ' ' + completarOrden.codigoPostal.toLowerCase() + ' ' + completarOrden.numAddress.toLowerCase();
        return combinedAddress.includes(this.searchQueryAddress.toLowerCase());
      });
    },

    filterDataMonto() {
      this.filteredData = this.tableData.filter((completarOrden) => {
        return completarOrden.pago.toString().includes(this.searchQueryMonto.toLowerCase());
      });
    },

    filterDataDatos() {
      this.filteredData = this.tableData.filter((completarOrden) => {
        return completarOrden.requiere3.toLowerCase().includes(this.searchQueryDatos.toLowerCase());
      });
    },

    filterDataResponsable() {
      this.filteredData = this.tableData.filter((completarOrden) => {
        return completarOrden.ariasEmpleado1.toLowerCase().includes(this.searchQueryResponsable.toLowerCase());
      });
    },

    async fetchData() {
      try {
        const responseOrdenes = await axios.get(this.urlApi + 'completarOrden');
        responseOrdenes.data.data;
      } catch (error) {
        console.error('Error al obtener los datos:', error);
      }
    },
    handleEdit() {},
    formatDate(id_orden, paddingLength = 5, paddingChar = '0') {
      // Convert id to string in case it's a number
      const idString = String(id_orden);

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