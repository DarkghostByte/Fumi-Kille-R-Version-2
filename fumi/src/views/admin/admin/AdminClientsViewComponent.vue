<template>
  <!-- Importar Iconos-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

    <div>
      <div class="container mx-auto px-4">
  
        <!-- INICIO -->
        <div class="flex justify-between items-center mb-4">
          <h1 class="text-2xl font-semibold">Gestión de Clientes</h1>
          <div class="py-3">
            <router-link to="/admin/admin" class="el-button el-button--danger">
              <i class="fa fa-rotate-left" aria-hidden="true"
                style="margin-top: 5px; margin-left: -5px; margin-right:10px;"></i>
              Regresar
            </router-link>
            <el-button class="ml-2 el-button el-button--primary">
              <router-link to="/admin/clients/agregarComercio-clients">
                <i class="fa fa-plus-circle" aria-hidden="true"
                  style="margin-top: 5px; margin-left: -5px; margin-right:10px;"></i>
                  Nuevo Cliente
              </router-link>
            </el-button>
          </div>
        </div>

        <div class="flex justify-between items-center mb-4" style="width: 100%;">
          <el-input class="px-2" placeholder="Buscar por nombre" v-model="searchQueryName"
            @input="filterDataName" />
          <el-input class="px-2" placeholder="Buscar por apellido" v-model="searchQueryLastname"
            @input="filterDataLastname" />
          <el-input class="px-2" placeholder="Buscar por direccion" v-model="searchQueryAddress"
            @input="filterDataAddress" />
            <el-input class="px-2" placeholder="Buscar por celular" v-model="searchQueryPhone"
            @input="filterDataPhone" />
            <el-input class="px-2" placeholder="Buscar por estado de activacion" v-model="searchQueryInfo"
            @input="filterDataInfo" />
        </div>
        
        <!-- END INICIO -->
  
        <!-- TABLE -->
        <div class="flex" style="justify-content: center;">
          <el-table :data="filteredData" :default-sort="{ prop: 'id', order: 'ascending' }" style="width: 100%" stripe>
            <!-- Columnas de la tabla -->
    
            <el-table-column class="" label="">
              <template #default="{ row }">
                <button 
                  class="ml-5 px-5 h-3 w-3 rounded-full" 
                  :style="{ backgroundColor: row.infoclient_delete === 'Alta' ? 'Green' : 'Red' }"
                  @click="handleEstadoClick(row)"
                >
                </button>
              </template>
            </el-table-column>
    
            <el-table-column prop="infoclient_delete" label="Estado" >
              <template #default="{ row }">
                <span v-if="row.infoclient_delete === 'Alta'">{{ row.infoclient_delete }}</span>
                <span v-else>{{ row.infoclient_delete }}</span>
              </template>
            </el-table-column>
    
            <el-table-column label="">
              <template #default="scope">
                <el-button style="color:black" size="small" type="success" @click="seleccionar(scope.row)"><span
                    class="material-symbols-outlined">visibility</span></el-button>
              </template>
            </el-table-column>
    
            <!-- Agrega las demás columnas aquí -->
    
            <el-table-column prop="name" label="Nombres" sortable width="120" />
            <el-table-column label="Apellidos" sortable width="140">
              <template #default="scope">
                {{ scope.row.lastname1 + ' ' + scope.row.lastname2 }}
              </template>
            </el-table-column>
            <el-table-column label="Dirección" sortable width="500">
              <template #default="scope">
                {{ scope.row.ciudad + ', ' + scope.row.colonia + ' #' + scope.row.codigoPostal + ', ' + scope.row.home + ' #' + scope.row.numAddress }}
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
    searchQueryInfo: '',
  }),
  mounted() {
    this.refresh();
  },
  methods: {
    refresh() {
      axios.get('clientes').then(res => {
        this.tableData = res.data.data;
        this.filteredData = this.tableData;
      });
    },  
    handleEdit() { },
    seleccionar(row) {
      console.log(row);
      this.selectedItem = row;
      this.dialogVisibleView = true;
    },

    filterDataName() {
      this.filteredData = this.tableData.filter((clientes) => {
        return clientes.name.toLowerCase().includes(this.searchQueryName.toLowerCase());
      });
    },

    filterDataLastname() {
  this.filteredData = this.tableData.filter((clientes) => {
    const combinedLastname = clientes.lastname1.toLowerCase() + ' ' + clientes.lastname2.toLowerCase();
    return combinedLastname.includes(this.searchQueryLastname.toLowerCase());
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

    filterDataInfo() {
      this.filteredData = this.tableData.filter((clientes) => {
        return clientes.infoclient_delete.toLowerCase().includes(this.searchQueryInfo.toLowerCase());
      });
    },


    handleEstadoClick(row) {
  const updatedData = {
    infoclient_delete: row.infoclient_delete === 'Baja' ? 'Alta' : 'Baja'
  };

  axios.put(`desactivarCliente/${row.id}`, updatedData)
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
        const responseOrdenes = await axios.get(this.urlApi + 'clientes');
        this.tableData = responseOrdenes.data.data.filter(row => row.infoclient_delete !== 'Baja');
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
  align-items:center;
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
