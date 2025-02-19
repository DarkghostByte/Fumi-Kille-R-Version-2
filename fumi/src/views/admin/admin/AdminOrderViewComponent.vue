<template>
  <!-- Importar Iconos-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  <div>
    <div class="container mx-auto px-4">

      <!-- INICIO -->
      <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-semibold">Ordenes</h1>
        <div class="py-3">
          <router-link to="/admin/admin" class="el-button el-button--danger">
            <i class="fa fa-rotate-left" aria-hidden="true"
              style="margin-top: 5px; margin-left: -5px; margin-right:10px;"></i>
            Regresar
          </router-link>
        </div>

      </div>
      <div class="flex justify-between items-center mb-4" style="width: 100%;">
        <el-input class="px-2" placeholder="Buscar por nombre" v-model="searchQueryName" @input="filterDataName" />
        <el-input class="px-2" placeholder="Buscar por apellido" v-model="searchQueryLastname"
          @input="filterDataLastname" />
        <el-input class="px-2" placeholder="Buscar por direccion" v-model="searchQueryAddress"
          @input="filterDataAddress" />
        <el-date-picker class="px-2" v-model="selectedDate" @change="filterData" type="date" format="DD-MM-YYYY"
          value-format="DD-MM-YYYY" placeholder="Seleccionar fecha" style="width: 100%" />
      </div>
      <div class="flex justify-between items-center mb-4" style="width: 100%;">
        <el-date-picker class="px-2" v-model="selectedDate2" @change="filterData2" type="date" format="DD-MM-YYYY"
          value-format="DD-MM-YYYY" placeholder="Seleccionar fecha" style="width: 100%" />
        <el-input class="px-2" placeholder="Buscar por estado de orden" v-model="searchQueryStatus"
          @input="filterDataStatus" />
        <el-input class="px-2" placeholder="Buscar por estado de activacion" v-model="searchQueryInfo"
          @input="filterDataInfo" />
      </div>

      <!-- END INICIO -->

      <!-- TABLE -->
      <div class="flex" style="justify-content: center;">
        <el-table :data="filteredData" :default-sort="{ prop: 'name', order: 'descending' }" style="width: 100%" stripe>

          <el-table-column class="" label="">
            <template #default="{ row }">
              <button class="ml-5 px-5 h-3 w-3 rounded-full"
                :style="{ backgroundColor: row.infoorden_delete === 'Alta' ? 'Green' : 'Red' }"
                @click="handleEstadoClick(row)">
              </button>
            </template>
          </el-table-column>

          <!--BOTON PARA VISUALIZAR EL PDF DE LA ORDEN DE TRABAJO-->
          <el-table-column label="">
            <template #default="scope">
              <el-button sortable width="95" style="color:black" size="small" type="success" @click="pdf(scope.row)">
                <a :href="url + 'api/ordenTrabajo/' + scope.row.id" target="_blank">
                  <span class="material-symbols-outlined">lab_profile</span>
                </a>
              </el-button>
            </template>
          </el-table-column>

          <el-table-column prop="infoorden_delete" label="Estado" sortable width="95">
            <template #default="{ row }">
              <span v-if="row.infoorden_delete === 'Alta'">{{ row.infoorden_delete }}</span>
              <span v-else>{{ row.infoorden_delete }}</span>
            </template>
          </el-table-column>
          <!--FIN DEL BOTON PARA VISUALIZAR EL PDF DE LA ORDEN DE TRABAJO-->

          <!--VISUALIZACION DE LA TABLA-->
          <el-table-column label="Orden" sortable width="90">
            <template #default="scope">
              {{ scope.row.id }}
            </template>
          </el-table-column>
          <el-table-column label="Nombre" sortable width="200">
            <template #default="scope">
              {{ scope.row.name + ' ' + scope.row.lastname1 + ' ' + scope.row.lastname2 }}
            </template>
          </el-table-column>
          
          <el-table-column label="Direccion" sortable width="200">
            <template #default="scope">
              {{ scope.row.home + ' #' + scope.row.numAddress + ', ' + scope.row.colonia + ' #' + scope.row.codigoPostal
                + ', ' + scope.row.ciudad }}
            </template>
          </el-table-column>
          <el-table-column prop="statusOrder" label="Estado de orden" sortable width="160" />
          <el-table-column prop="date1" label="Fecha de orden" sortable width="150" />
          <el-table-column prop="date2" label="Fecha de fumigacion" sortable width="180" />
           <!-- Botones de acción -->
        <el-table-column label="">
          <template #default="scope">
            <router-link :to="'/admin/works/edit-work/' + scope.row.id">
              <el-button style="color:black" size="small" type="warning" @click="handleEdit()"><span
                  class="material-symbols-outlined">edit</span></el-button>
            </router-link>
          </template>
        </el-table-column>
          <!--FIN DE LA VISUALIZACION DE LA TABLA-->
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
import { ElNotification } from 'element-plus';


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
    searchQueryLastname: '',
    searchQueryAddress: '',
    searchQueryPhone: '',
    searchQueryStatus: '',
    searchQueryInfo: '',
    selectedDate: null,
    selectedDate2: null,
  }),
  mounted() {
    this.refresh();
  },
  methods: {
    refresh() {
      axios.get('orden').then(res => {
        this.tableData = res.data.data;
        this.filteredData = this.tableData;
      });
    },
    pdf(row) {
      console.log(row)
      this.selectedItem = row
      this.selectedItem = null
    },
    handleEdit() { },

    filterDataName() {
      this.filteredData = this.tableData.filter((orden) => {
        return orden.name.toLowerCase().includes(this.searchQueryName.toLowerCase());
      });
    },

    filterDataLastname() {
      this.filteredData = this.tableData.filter((orden) => {
        const combinedLastname = orden.lastname1.toLowerCase() + ' ' + orden.lastname2.toLowerCase();
        return combinedLastname.includes(this.searchQueryLastname.toLowerCase());
      });
    },

    filterDataAddress() {
      this.filteredData = this.tableData.filter((orden) => {
        const combinedAddress = orden.ciudad.toLowerCase() + ' ' + orden.colonia.toLowerCase() + ' ' + orden.home.toLowerCase() + ' ' + orden.codigoPostal.toLowerCase() + ' ' + orden.numAddress.toLowerCase();
        return combinedAddress.includes(this.searchQueryAddress.toLowerCase());
      });
    },

    filterDataPhone() {
      this.filteredData = this.tableData.filter((clientes) => {
        return clientes.cell_phone.toLowerCase().includes(this.searchQueryPhone.toLowerCase());
      });
    },

    filterDataStatus() {
      this.filteredData = this.tableData.filter((orden) => {
        return orden.statusOrder.toLowerCase().includes(this.searchQueryStatus.toLowerCase());
      });
    },

    filterDataInfo() {
      this.filteredData = this.tableData.filter((orden) => {
        return orden.infoorden_delete.toLowerCase().includes(this.searchQueryInfo.toLowerCase());
      });
    },

    filterData() {
      if (this.selectedDate) {
        // Filtra por la fecha seleccionada
        this.filteredData = this.tableData.filter(orden => orden.date1 === this.selectedDate);
        if (this.filteredData.length === 0) {
          ElNotification({
            title: 'Aviso',
            message: `No se encontraron datos para la fecha seleccionada (${this.selectedDate}).`,
            type: 'warning'
          });
        } else {
          ElNotification({
            title: 'Datos encontrados',
            message: `Se encontraron datos para la fecha seleccionada (${this.selectedDate}).`,
            type: 'success',
          });
        }
      } else {
        // Si no se selecciona ninguna fecha, muestra todos los datos
        this.filteredData = this.tableData;
        ElNotification({
          title: 'Mostrando todos los datos',
          message: 'Se estan mostrando todos los datos de la agenda.',
          type: 'info',
        });
      }
    },
    filterData2() {
      if (this.selectedDate2) {
        // Filtra por la fecha seleccionada
        this.filteredData = this.tableData.filter(orden => orden.date2 === this.selectedDate2);
        if (this.filteredData.length === 0) {
          ElNotification({
            title: 'Aviso',
            message: `No se encontraron datos para la fecha seleccionada (${this.selectedDate2}).`,
            type: 'warning'
          });
        } else {
          ElNotification({
            title: 'Datos encontrados',
            message: `Se encontraron datos para la fecha seleccionada (${this.selectedDate2}).`,
            type: 'success',
          });
        }
      } else {
        // Si no se selecciona ninguna fecha, muestra todos los datos
        this.filteredData = this.tableData;
        ElNotification({
          title: 'Mostrando todos los datos',
          message: 'Se estan mostrando todos los datos de la agenda.',
          type: 'info',
        });
      }
    },

    handleEstadoClick(row) {
      const updatedData = {
        infoorden_delete: row.infoorden_delete === 'Baja' ? 'Alta' : 'Baja'
      };

      axios.put(`desactivarOrden/${row.id}`, updatedData)
        .then(response => {
          console.log('Estado actualizado correctamente:', response.data);
          this.fetchData(); // Refresca los datos después de la actualización
          this.refresh();
          ElNotification({
            title: 'Actualización de datos',
            message: `Se actualizaron los datos.`,
            type: 'success'
          });
        })
        .catch(error => {
          console.error('Error al actualizar el estado:', error);
        });
    },

    async fetchData() {
      try {
        const responseOrdenes = await axios.get(this.urlApi + 'orden');
        responseOrdenes.data.data.filter(row => row.infoorden_delete !== 'Baja');
      } catch (error) {
        console.error('Error al obtener los datos:', error);
      }
    },

    completarOrden(row) {
      if (row && row.id) {
        console.log(row);
        this.$router.push({ path: `/admin/works/complete-works/${row.id}` });
      } else {
        console.error('Row is undefined or does not have an id:', row);
      }
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
