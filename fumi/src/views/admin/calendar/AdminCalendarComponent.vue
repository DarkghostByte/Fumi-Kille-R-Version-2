<template>
  <div>

    <router-link to="/admin/calendar/complete"
      class="inline-flex px-5 py-3 text-white bg-green-400 hover:bg-green-600 focus:bg-green-700 rounded-md ml-6 mb-3"
      style="color:black">
      <i class="fa-solid fa-calendar-check" aria-hidden="true" style="margin-top: 5px;
            margin-left: -5px; margin-right:10px;"></i>
      Agenda realizadas
    </router-link>
  </div>

  <div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-4">Agenda de trabajo por día</h1>



    <div class="flex justify-center items-center">
      <el-input class="px-2" placeholder="Buscar por nombre" v-model="searchQueryName" @input="filterData" style="width: 100%;"/>
      <el-input class="px-2" placeholder="Buscar por direccion" v-model="searchQueryAddress"
        @input="filterData" style="width: 100%;"/>
      <el-input class="px-2" placeholder="Buscar por celular" v-model="searchQueryPhone"
        @input="filterData" style="width: 100%;"/>
      <el-date-picker class="mx-2" v-model="selectedDate" @change="filterData" type="date" format="DD-MM-YYYY"
      value-format="DD-MM-YYYY" placeholder="Seleccionar F. de orden" style="width: 100%;"/>
    <el-date-picker class="mx-2" v-model="selectedDate1" @change="filterData" type="date" format="DD-MM-YYYY"
      value-format="DD-MM-YYYY" placeholder="Seleccionar F. de fumigación" style="width: 100%;"/>
    </div>

    
  </div>

  <div class="table-container">
    <el-table :data="filteredData" :default-sort="{ prop: 'date2', order: 'descending' }" stripe width="100%">
      <el-table-column label="PDF Orden" width="100px">
        <template #default="scope">
          <el-button style="color:black" type="success" @click="pdf(scope.row)">
            <a :href="url + 'api/ordenTrabajo/' + scope.row.id" target="_blank">
              <span class="material-symbols-outlined">lab_profile</span>
            </a>
          </el-button>
        </template>
      </el-table-column>
      <el-table-column label="O. Trabajo" sortable width="120">
        <template #default="scope">
          {{ 'No. ' + this.formatDate(scope.row.id) }}
        </template>
      </el-table-column>
      <el-table-column label="Nombre" width="200" sortable>
        <template #default="scope">
          {{ scope.row.name + ' ' + scope.row.lastname1 + ' ' + scope.row.lastname2 }}
        </template>
      </el-table-column>
      <el-table-column label="Dirección" width="300" sortable>
        <template #default="scope">
          {{ scope.row.home + ' #' + scope.row.numAddress + ', ' + scope.row.colonia + ' #' + scope.row.codigoPostal +
            ', ' + scope.row.ciudad }}
        </template>
      </el-table-column>
      <el-table-column label="Celular" prop="cell_phone" width="100px" sortable />
      <el-table-column label="F. Orden" prop="date1" width="150px" sortable />
      <el-table-column label="F. Fumigacion" prop="date2" width="180px" sortable />
      <el-table-column label="De" prop="time1" sortable />
      <el-table-column label="A" prop="time2" sortable />
    </el-table>
  </div>

  <!-- Importar Iconos-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

</template>

<script>
import axios from 'axios';
//import { ElNotification } from 'element-plus';
export default {
  name: 'AdminCalendarComponent',
  data: () => ({
    url: process.env.VUE_APP_ROOT_ASSETS,
    urlApi: process.env.API,
    tableData: [],
    dialogVisible: false,
    filteredData: [],
    selectedItem: {},
    selectedDate: null,
    selectedDate1: null,
    searchQuery: '',
    searchQueryName:'',
searchQueryAddress:'',
searchQueryPhone:'',
    today: new Date().toISOString().slice(0, 10),
  }),
  mounted() {
    if(!localStorage.getItem("token")){
      this.$router.push("/auth/index");
    }
    this.refresh()
  },
  methods: {
    refresh() {
      axios.get('orden').then(res => {
        this.tableData = res.data.data.filter(row => row.infoorden_delete !== 'Baja' && row.statusOrder === 'Por realizar');
        console.log('tableData:', this.tableData);
        console.log('filteredData:', this.filteredData);
        this.filteredData = this.tableData;
      })
    },

    pdf(row) {
      console.log(row)
      this.selectedItem = row
      this.selectedItem = null
    },

    parseDate(fecha) {
      var f1 = fecha.split("-")[2]
      f1 += "-" + fecha.split("-")[1]
      f1 += "-" + fecha.split("-")[0]
      return new Date(f1)
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

    if (this.searchQueryPhone) {
      shouldInclude = shouldInclude && orden.cell_phone.toLowerCase().includes(this.searchQueryPhone.toLowerCase());
    }

    if (this.selectedDate) {
      shouldInclude = shouldInclude && orden.date1.toLowerCase().includes(this.selectedDate.toLowerCase());
    }

    if (this.selectedDate1) {
      shouldInclude = shouldInclude && orden.date2.toLowerCase().includes(this.selectedDate1.toLowerCase());
    }

    return shouldInclude;
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
  },
}
</script>

<style>
.mainfiltros {
  width: 78%;
  margin-left: 11%;

  align-items: center;
}

.filtros {

  margin-left: -5px;
  padding: 1.5px;
  height: 20px;
  background-color: #b5b5b5;
}

.tamaño {
  width: 19.6%;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 2rem;
}

.table-container {
  overflow-x: auto;
}

.btn {
  margin: 10px;
  padding: 1rem 2rem;
  border-radius: 0.75rem 0rem;
  text-decoration: none;
  color: #000000;
  font-weight: bold;
  font-size: 17px;
}

.btn-primary {
  background-color: #1877f2;
}

.btn-success {
  background-color: #4caf50;
}
</style>