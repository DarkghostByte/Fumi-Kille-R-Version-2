<template>
  <!-- Importar Iconos-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <div>
    <div class="flex flex-col space-y-6 md:space-y-0 md:flex-row justify-start">
      <div class="flex flex-wrap items-start justify-end ">
        <router-link to="/admin/clients/agregarParticular-clients"
          class="inline-flex px-5 py-3 text-white bg-green-400 hover:bg-green-600 focus:bg-green-700 rounded-md ml-6 mb-3"
          style="color:black">
          <i class="fa fa-plus-circle" aria-hidden="true"
            style="margin-top: 5px; margin-left: -5px; margin-right:10px;"></i>
          Nuevo Cliente
        </router-link>
      </div>
    </div>
    <div class="">
      <h1 class="py-5 px-5 text-4xl font-semibold mb-2">Clientes</h1>
    </div>
    <!-- Campo de búsqueda -->
    <div class="flex justify-between items-center mb-4" style="width: 100%;">
      <el-input class="px-2" placeholder="Buscar por nombre" v-model="searchQueryName" @input="filterData" />
      <el-input class="px-2" placeholder="Buscar por apellido" v-model="searchQueryLastname"
        @input="filterData" />
      <el-input class="px-2" placeholder="Buscar por direccion" v-model="searchQueryAddress"
        @input="filterData" />
      <el-input class="px-2" placeholder="Buscar por celular" v-model="searchQueryPhone" @input="filterData" />
    </div>


    <!-- TABLE DATA -->
    <div class="flex">
      <el-table :data="filteredData" :default-sort="{ prop: 'name', order: 'descending' }" style="width: 100%" stripe>
        <!-- Columnas de la tabla -->
        <el-table-column label="">
          <template #default="scope">
            <el-button style="color:black" size="small" type="success" @click="seleccionar(scope.row)"><span
                class="material-symbols-outlined">visibility</span></el-button>
          </template>
        </el-table-column>

        <el-table-column label="">
          <template #default="scope">
            <router-link :to="'/admin/works/add-works/' + scope.row.id">
              <el-button style="color:black" size="small" type="warning" @click="handleEdit()"><span
                  class="material-symbols-outlined">bug_report</span></el-button>
            </router-link>
          </template>
        </el-table-column>

        <el-table-column label="">
          <template #default="scope">
            <el-button style="color:black" size="small" type="info" @click="historia(scope.row)"><span
                class="material-symbols-outlined">auto_stories</span></el-button>
          </template>
        </el-table-column>

        <!-- Agrega las demás columnas aquí -->

        <el-table-column label="Nombre" sortable width="240">
          <template #default="scope">
            {{ scope.row.name + ' ' + scope.row.lastname1 + ' ' + scope.row.lastname2 }}
          </template>
        </el-table-column>
        <el-table-column label="Dirección" sortable width="500">
          <template #default="scope">
            {{ scope.row.ciudad + ', ' + scope.row.colonia + ' #' + scope.row.codigoPostal + ', ' + scope.row.home + '#' + scope.row.numAddress }}
          </template>
        </el-table-column>
        <el-table-column prop="cell_phone" label="Numero Celular" sortable width="150" />

        <!-- Botones de acción -->
        <el-table-column label="">
          <template #default="scope">
            <router-link :to="'/admin/clients/edit-clients/' + scope.row.id">
              <el-button style="color:black" size="small" type="warning" @click="handleEdit()"><span
                  class="material-symbols-outlined">edit</span></el-button>
            </router-link>
          </template>
        </el-table-column>

        <el-table-column label="">
          <template #default="{ row }">
            <el-button style="color:black" size="small" type="danger" @click="eliminar(row)"><span
                class="material-symbols-outlined">close</span></el-button>
          </template>
        </el-table-column>
      </el-table>
    </div>
    <!-- END TABLE DATA -->

    <!-- MODAL 1 -->
    <el-dialog v-model="dialogVisible" title="Deseas desactivar el siguiente cliente?" width="600" height="500">
      <div class="clientInfo">
        <div class="details">
          <i class="fa fa-user fa-2x iconDelete"></i>
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
          <i class="fa fa-city fa-2x iconDelete"></i>
          <div>
            <p>
              <strong>Domicilio:</strong> {{ selectedItem.street }} {{ selectedItem.home }} #{{ selectedItem.numAddress
              }},
              {{ selectedItem.colonia }} #{{ selectedItem.codigoPostal }}, {{ selectedItem.ciudad }}
            </p>
            <p>
              <strong>Tipo de lugar:</strong> {{ selectedItem.comercio }}
            </p>
          </div>
        </div>
        <div class="details">
          <i class="fa fa-phone fa-2x iconDelete"></i>
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
          <i class="fa fa-location-dot fa-2x iconDelete"></i>
          <div>
            <p>
              <strong>Como llegar:</strong> {{ selectedItem.how_to_get }}
            </p>
            <p>
              <strong>Descripcion:</strong> {{ selectedItem.description }}
            </p>
          </div>
        </div>
      </div>
      <template #footer>
        <div class="dialog-footer">
          <el-button type="info" @click="dialogVisible = false">Cancelar</el-button>
          <el-button type="danger" @click="handleEstadoClick()">
            Confirmar
          </el-button>
        </div>
      </template>
    </el-dialog>
    <!-- END MODAL 1 -->

    <!-- MODAL 2 -->
    <el-dialog v-model="dialogVisibleView" title="Datos del cliente" width="600" height="500">
      <div class="clientInfo">
        <div class="details">
          <i class="fa fa-user fa-2x iconInfo"></i>
          <!-- END MODAL 2 <h2 class="client-details__title">Información del Cliente</h2>-->
          <div>
            <p>
              <strong>Nombre completo:</strong> {{ selectedItem1.name }} {{ selectedItem1.lastname1 }} {{
                selectedItem1.lastname2 }}
            </p>
            <p>
              <strong>Nombre comercial:</strong> {{ selectedItem1.tradename }}
            </p>
          </div>
        </div>
        <div class="details">
          <i class="fa fa-city fa-2x iconInfo"></i>
          <!-- END MODAL 2 <h2 class="client-details__title">Información del Cliente</h2>-->
          <div>
            <p>
              <strong>Domicilio:</strong> {{ selectedItem1.street }} {{ selectedItem1.home }} #{{
                selectedItem1.numAddress
              }},
              {{
                selectedItem1.colonia
              }} #{{ selectedItem1.codigoPostal }}, {{ selectedItem1.ciudad }}
            </p>
            <p>
              <strong>Tipo de lugar:</strong> {{ selectedItem1.comercio }}
            </p>
          </div>

        </div>
        <div class="details">
          <i class="fa fa-phone fa-2x iconInfo"></i>
          <div>
            <p>
              <strong>Numero de celular:</strong> {{ selectedItem1.cell_phone }}
            </p>
            <p>
              <strong>Número fijo:</strong> {{ selectedItem1.number_fixed_number }}
            </p>
          </div>
        </div>
        <div class="details">
          <i class="fa fa-location-dot fa-2x iconInfo"></i>
          <div>
            <p>
              <strong>Como llegar:</strong> {{ selectedItem1.how_to_get }}
            </p>
            <p>
              <strong>Descripcion:</strong> {{ selectedItem1.description }}
            </p>
          </div>
        </div>
        <div class="details">
          <i class="fa fa-file-contract fa-2x iconInfo"></i>
          <div>
            <p>
              <strong>Tipo de contratación:</strong>
              <span v-for="item in selectedItem1.recruitment_data" v-bind:key="item">{{ item }},&nbsp;</span>
            </p>
          </div>
        </div>
        <div class="details">
          <i class="fa fa-address-card fa-2x iconInfo"></i>
          <div>
            <p>
              <strong>Tipo de contratación:</strong>
              <span v-for="item in selectedItem1.requires" v-bind:key="item">{{ item }},&nbsp;</span>
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
    selectedItem1: {},
    searchQuery: '',
    searchQueryName: '',
    searchQueryLastname: '',
    searchQueryAddress: '',
    searchQueryPhone: '',
  }),
  mounted() {
    this.refresh();
  },
  methods: {
    refresh() {
      axios.get('clientes').then(res => {
        this.tableData = res.data.data.filter(row => row.infoclient_delete !== 'Baja');
        this.filteredData = this.tableData;
      });
    },
    handleEdit() { },
    handleDelete() {
      axios.delete('clientes/' + this.selectedItem.id).then(res => {
        console.log(res);
        this.dialogVisible = false;
      });
    },
    eliminar(row) {
      console.log(row);
      this.selectedItem = row;
      this.dialogVisible = true;
    },
    seleccionar(row) {
      console.log(row);
      this.selectedItem1 = row;

      try {
        this.selectedItem1.recruitment_data = JSON.parse(this.selectedItem1.recruitment_data);
        this.selectedItem1.requires = JSON.parse(this.selectedItem1.requires);
      } catch (error) {
        console.error("Error parsing JSON:", error);
        // Handle the error, e.g., display an error message to the user
        //this.$message.error("Error parsing data. Please check the data source.");
      }

      this.dialogVisibleView = true;
    },
    historia(row) {
      if (row && row.id) {
        console.log(row);
        this.$router.push({ path: `/admin/worksComplete/${row.id}` });
      } else {
        console.error('Row is undefined or does not have an id:', row);
      }
    },

    filterData() {
      this.filteredData = this.tableData.filter((clientes) => {
        const combinedLastname = clientes.lastname1.toLowerCase() + ' ' + clientes.lastname2.toLowerCase();
        const combinedAddress = clientes.ciudad.toLowerCase() + ' ' + clientes.colonia.toLowerCase() + ' ' + clientes.home.toLowerCase() + ' ' + clientes.codigoPostal.toLowerCase() + ' ' + clientes.numAddress.toLowerCase();

    // Check each condition based on search queries
    let shouldInclude = true; // Start with assuming inclusion

    if (this.searchQueryName) {
      shouldInclude = shouldInclude && clientes.name.toLowerCase().includes(this.searchQueryName.toLowerCase());
    }

    if (this.searchQueryLastname) {
      shouldInclude = shouldInclude && combinedLastname.includes(this.searchQueryLastname.toLowerCase());
    }

    if (this.searchQueryAddress) {
      shouldInclude = shouldInclude && combinedAddress.includes(this.searchQueryAddress.toLowerCase());
    }

    if (this.searchQueryPhone) {
      shouldInclude = shouldInclude && clientes.cell_phone.toLowerCase().includes(this.searchQueryPhone.toLowerCase());
    }

    return shouldInclude;
  });
},

    handleEstadoClick() {
      const newStatus = this.selectedItem.infoclient_delete === 'Alta' ? 'Baja' : 'Alta'; // Toggle status based on current value
      axios.put('desactivarCliente/' + this.selectedItem.id, { infoclient_delete: newStatus })
        .then(response => {
          console.log('El cliente se dio de baja:', response.data);
          this.refresh(); // Consider removing this line if refresh() is triggered elsewhere
          this.dialogVisible = false;
          ElNotification({
            title: 'Actualizacion de datos',
            message: `Se actualizaron los datos.`,
            type: 'success'
          });
        })
        .catch(error => {
          console.error('Error al dar de baja al cliente:', error.response.data);
        });
    },

    async fetchData() {
      try {
        const response = await axios.get(this.urlApi + 'clientes');
        // Verifica si la respuesta tiene un atributo 'data' que sea un array
        if (response.data && Array.isArray(response.data)) {
          this.tableData = response.data.filter(row => row.infoclient_delete !== 'Baja');
        } else {
          console.error('La respuesta de la API no tiene el formato esperado:', response.data);
        }
      } catch (error) {
        console.error('Error al obtener los datos:', error);
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
  align-items: center;
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
