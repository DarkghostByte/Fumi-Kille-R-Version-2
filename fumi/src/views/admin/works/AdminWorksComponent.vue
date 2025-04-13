<template>
  <!-- Importar Iconos-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <div>
    <div class="flex flex-col space-y-6 md:space-y-0 md:flex-row justify-start">
      <div class="flex flex-wrap items-start justify-end ">

        <!--RUTAS ENTRES VISTAS-->

        <router-link to="/admin/worksComplete"
          class="inline-flex px-5 py-3 text-white bg-green-400 hover:bg-green-700 focus:bg-green-800 rounded-md ml-6 mb-3"
          style="color:black">
          <i class="fa fa-clipboard-check" aria-hidden="true" style="margin-top: 5px;
            margin-left: -5px; margin-right:10px;"></i>
          Ver ordenes completas
        </router-link>
        <!--FIN DE RUTAS ENTRES VISTAS-->

      </div>
    </div>
    <div class="">
      <h1 class="py-5 px-5 text-4xl font-bold mb-2">Ordenes de trabajo</h1>
    </div>
    <div class="flex justify-between items-center mb-4" style="width: 100%;">
      <el-input class="px-2" placeholder="Buscar por nombre" v-model="searchQueryName" @input="filterData" />
      <el-input class="px-2" placeholder="Buscar por direccion" v-model="searchQueryAddress"
        @input="filterData" />
      <el-date-picker class="px-2" v-model="selectedDate" @change="filterData" type="date" format="DD-MM-YYYY"
        value-format="DD-MM-YYYY" placeholder="Seleccionar fecha de orden" style="width: 100%" />
      <el-date-picker class="px-2" v-model="selectedDate2" @change="filterData" type="date" format="DD-MM-YYYY"
        value-format="DD-MM-YYYY" placeholder="Seleccionar fecha de fumigacion" style="width: 100%" />
    </div>

    <!-- TABLE DATA -->
    <div class="flex" style="justify-content: center;">
      <el-table :data="filteredData" :default-sort="{ prop: 'id', order: 'descending' }" style="width: 100%" stripe>

        <!--BOTON PARA VISUALIZAR EL PDF DE LA ORDEN DE TRABAJO-->
        <el-table-column>
          <template #default="scope">
            <el-button style="color:black" size="small" type="success" @click="pdf(scope.row)">
              <a :href="url + 'api/ordenTrabajo/' + scope.row.id" target="_blank">
                <span class="material-symbols-outlined">lab_profile</span>
              </a>
            </el-button>
          </template>
        </el-table-column>
        <!--FIN DEL BOTON PARA VISUALIZAR EL PDF DE LA ORDEN DE TRABAJO-->

        <!--BOTON PARA TERMINAR LA ORDEN DE TRABAJO-->

        <el-table-column>
          <template #default="scope">
            <el-button style="color:black" size="small" type="warning" @click="completarOrden(scope.row)"><span
                class="material-symbols-outlined">priority</span></el-button>
          </template>
        </el-table-column>
        <!--FIN DEL BOTON PARA TERMINAR LA ORDEN DE TRABAJO-->


        <!--VISUALIZACION DE LA TABLA-->
        <el-table-column label="O. Trabajo" sortable width="115px">
          <template #default="scope">
            {{ 'No. ' + this.formatDate(scope.row.id) }}
          </template>
        </el-table-column>
        <el-table-column label="Nombre" sortable width="220px">
          <template #default="scope">
            {{ scope.row.name + ' ' + scope.row.lastname1 + ' ' + scope.row.lastname2 }}
          </template>
        </el-table-column>
        <el-table-column label="Direccion" sortable width="280px">
          <template #default="scope">
            {{ scope.row.home + ' #' + scope.row.numAddress + ', ' + scope.row.colonia + ' #' + scope.row.codigoPostal +
              ', ' + scope.row.ciudad }}
          </template>
        </el-table-column>
        <el-table-column prop="date1" label="F. Orden" sortable width="110px" />
        <el-table-column prop="date2" label="F. Fumigacion" sortable width="135px" />
        <el-table-column prop="time1" label="De" sortable width="90px" />
        <el-table-column prop="time2" label="A" sortable width="90px" />
        <!--FIN DE LA VISUALIZACION DE LA TABLA-->

        <!-- Botones de acción -->
        <el-table-column label="">
          <template #default="scope">
            <router-link :to="'/admin/works/edit-work/' + scope.row.id">
              <el-button style="color:black" size="small" type="warning" @click="handleEdit()"><span
                  class="material-symbols-outlined">edit</span></el-button>
            </router-link>
          </template>
        </el-table-column>
      </el-table>
    </div>
    <!-- END TABLE DATA -->

  </div>
</template>

<script>
import axios from 'axios';
import { ElNotification } from 'element-plus';

export default {
  name: 'AdminWorksComponent',
  data: () => ({
    url: process.env.VUE_APP_ROOT_ASSETS,
    urlApi: process.env.API,
    tableData: [],
    selectedItem: null,
    dialogVisible: false,
    searchQueryName: '',
    searchQueryAddress: '',
    filteredData: [],
    selectedDate: null,
    selectedDate2: null,
  }),
  mounted() {
    if(!localStorage.getItem("token")){
      this.$router.push("/auth/index");
    }
    this.refresh()
  },
  methods: {
    refresh() {
      this.tableData = [];
axios.get('orden').then(res => {
  this.tableData = res.data.data.filter(row => row.infoorden_delete !== 'Baja' && row.statusOrder === 'Por realizar');
  this.filteredData = this.tableData;
});

    },
    pdf(row) {
      console.log(row)
      this.selectedItem = row
      this.selectedItem = null
    },
    handleEdit() { },

    completarOrden(row) {
      if (row && row.id) {
        console.log(row);
        this.$router.push({ path: `/admin/works/complete-works/${row.id}` });
      } else {
        console.error('Row is undefined or does not have an id:', row);
      }
    },
    handleEstadoClick() {
      const newStatus = this.selectedItem.infoorden_delete === 'Alta' ? 'Baja' : 'Alta'; // Toggle status based on current value
      axios.put('desactivarOrden/' + this.selectedItem.id, { infoorden_delete: newStatus })
        .then(response => {
          console.log('La orden se dio de baja:', response.data);
          this.refresh(); // Consider removing this line if refresh() is triggered elsewhere
          this.dialogVisible = false;
          ElNotification({
            title: 'Actualizacion de datos',
            message: `Se actualizaron los datos.`,
            type: 'success'
          });
        })
        .catch(error => {
          console.error('Error al dar de baja la orden:', error.response.data);
        });
    },

    formatDate(id, paddingLength = 5, paddingChar = '0') {
  // Convert id to string in case it's a number
  const idString = String(id);

  // Ensure paddingLength is a positive integer
  paddingLength = Math.max(0, Math.floor(paddingLength));

  // Pad the string with paddingChar
  return idString.padStart(paddingLength, paddingChar);
},


filterData() {
  this.filteredData = this.tableData.filter((orden) => {
    const combinedName = orden.name.toLowerCase() + ' ' + orden.lastname1.toLowerCase() + ' ' + orden.lastname2.toLowerCase();
    const combinedAddress = orden.ciudad.toLowerCase() + ' ' + orden.colonia.toLowerCase() + ' ' + orden.home.toLowerCase() + ' ' + orden.codigoPostal.toLowerCase() + ' ' + orden.numAddress.toLowerCase();
    
    // Check each condition based on search queries
    let shouldInclude = true; // Start with assuming inclusion

    if (this.searchQueryName) {
      shouldInclude = shouldInclude && combinedName.includes(this.searchQueryName.toLowerCase());
    }

    if (this.searchQueryAddress) {
      shouldInclude = shouldInclude && combinedAddress.includes(this.searchQueryAddress.toLowerCase());
    }

    if (this.selectedDate) {
      shouldInclude = shouldInclude && orden.date1 === this.selectedDate;
    }

    if (this.selectedDate2) {
      shouldInclude = shouldInclude && orden.date2 === this.selectedDate2;
    }

    return shouldInclude;
  });
},
  }
}
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

.iconDeleteOrden {
  color: #f32222;
  margin-right: 10px;
}
</style>