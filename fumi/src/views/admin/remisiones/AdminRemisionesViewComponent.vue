<template>
  <!-- Importar Iconos-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  <div class="container mx-auto px-4">

    <div class="flex justify-between items-center mb-4">
      <h1 class="text-2xl font-semibold">Gestión de Remisiones (Clientes)</h1>
      <div class="flex flex-wrap items-start justify-end ">
        <router-link to="/admin/remisiones/views/" class="el-button el-button--success" style="color: black;">
          <i class="fa-solid fa-book" aria-hidden="true"
            style="margin-top: 5px; margin-left: -5px; margin-right:10px;"></i>
          Consultar Remisiones
        </router-link>
      </div>
    </div>

    <!-- Campo de búsqueda -->
    <div class="flex mb-4" style="justify-content: center;">
      <div class="flex mb-4" style="width: 80%;">
        <el-input class="px-2" placeholder="Buscar por nombre" v-model="searchQueryName" @input="filterDataName" />
        <el-input class="px-2" placeholder="Buscar por apellido" v-model="searchQueryLastname"
          @input="filterDataLastname" />
        <el-input class="px-2" placeholder="Buscar por direccion" v-model="searchQueryAddress"
          @input="filterDataAddress" />
        <el-input class="px-2" placeholder="Buscar por celular" v-model="searchQueryPhone" @input="filterDataPhone" />
      </div>
    </div>

    <!-- TABLE DATA -->
    <div class="flex" style="justify-content: center;">
      <el-table :data="filteredData" :default-sort="{ prop: 'id', order: 'ascending' }" style="width: 100%" stripe>
        <!-- Columnas de la tabla -->
        <el-table-column label="" width="100">
          <template #default="scope">
            <el-button @click="remision(scope.row)" class="ml-2 el-button el-button--primary" style="color:black">
              <span class="material-symbols-outlined">Description</span>
            </el-button>
          </template>
        </el-table-column>

        <!-- Agrega las demás columnas aquí -->
        <el-table-column label="O. Trabajo" sortable>
          <template #default="scope">
            {{ 'No. ' + this.formatDate(scope.row.id) }}
          </template>
        </el-table-column>

        <el-table-column prop="name" label="Nombres" sortable width="150" />
        <el-table-column label="Apellidos" sortable width="150">
          <template #default="scope">
            {{ scope.row.lastname1 + ' ' + scope.row.lastname2 }}
          </template>
        </el-table-column>
        <el-table-column label="Dirección" sortable width="500">
          <template #default="scope">
            {{ scope.row.ciudad + ', ' + scope.row.colonia + ' #' + scope.row.codigoPostal + ', ' + scope.row.home + '#'
              + scope.row.numAddress }}
          </template>
        </el-table-column>
        <el-table-column prop="cell_phone" label="Numero Celular" sortable />

      </el-table>
    </div>
    <!-- END TABLE DATA -->

    <!-- MODAL 1 -->
    <el-dialog v-model="dialogVisibleView" title="Datos del cliente" width="600" height="500">
      <div class="clientInfo">
        <div class="details">
          <i class="fa fa-user fa-2x iconInfo"></i>
          <!-- END MODAL 2 <h2 class="client-details__title">Información del Cliente</h2>-->
          <div>
            <p>
              <strong>Nombre completo:</strong> {{ selectedItem.name }} {{ selectedItem.lastname1 }}
              {{ selectedItem.lastname2 }}
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
                selectedItem.numAddress}},
              {{ selectedItem.colonia }} #{{ selectedItem.codigoPostal }}, {{ selectedItem.ciudad }}
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
    <!-- END MODAL 1 -->

    <!-- MODAL 2 -->
    <el-dialog v-model="dialogVisibleViewRemisiones" title="Crear Remision" width="40%">
      <el-form :model="form1" label-width="auto" style="max-width: 100%" ref="formRef" :rules="rules"
        :label-position="'top'">
        <div class="row" style="width:100%;">
          <p>Cliente: {{ selectedItem.name }} {{ selectedItem.lastname1 }} {{ selectedItem.lastname2 }}</p>
          <p>Negocio: {{ selectedItem.tradename }}</p>
          <br>

          <div class="flex" style="width:100%;">
            

            <el-form-item prop="RemisionDate" class="px-2" label="Fecha de la remisión:">
              <el-col :span="11">
                <el-date-picker v-model="form1.RemisionDate" type="date" placeholder="Fecha de la remisión"
                  format="DD/MM/YYYY" value-format="DD-MM-YYYY" />
              </el-col>
            </el-form-item>

            <el-form-item prop="RemisionMonto" label="Monto:" class="px-2">
              <el-input v-model="form1.RemisionMonto" placeholder="Ingresa el monto" />
            </el-form-item>
          </div>

          <div class="flex" style="width:100%;">
            <el-form-item style="width:100%;" prop="RemisionObservaciones" label="Observaciones:" class="px-2">
              <el-input v-model="form1.RemisionObservaciones" type="textarea" maxlength="200" show-word-limit
                placeholder="Agrega las observaciones" />
            </el-form-item>
          </div>

        </div>
      </el-form>
      <template #footer>
        <span class="dialog-footer">
          <el-button @click="dialogVisibleViewRemisiones = false">Cancelar</el-button>
          <el-button type="primary" @click="createRemision1(selectedItem.id)">Crear</el-button>
        </span>
      </template>
    </el-dialog>
    <!-- END MODAL 2 -->
  </div>
</template>

<script>
import axios from 'axios';
import { ElNotification } from 'element-plus';

export default {
  name: 'AdminRemisionesViewComponent',
  data: () => ({
    dialogVisible: false,
    dialogVisibleView: false,
    dialogVisibleViewRemisiones: false,
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
    form1: {
      RemisionDate: '',
      RemisionCertificado: 0,
      RemisionMonto: '',
      RemisionObservaciones: '',
    },
    rules: {
      RemisionDate: [
        { required: true, message: 'Este campo es requerido', trigger: 'blur' },
        { min: 1, max: 100, message: 'Longitud debería ser 1 a 100', trigger: 'blur' }
      ],
      RemisionCertificado: [
        { required: true, message: 'La fecha es requerida', trigger: 'blur' },
        { min: 1, max: 100, message: 'Longitud debería ser 1 a 100', trigger: 'blur' }
      ],
      RemisionMonto: [
        { required: true, message: 'La fecha es requerida', trigger: 'blur' },
        { min: 1, max: 100, message: 'Longitud debería ser 1 a 100', trigger: 'blur' }
      ],
      RemisionObservaciones: [
        { required: true, message: 'La fecha es requerida', trigger: 'blur' },
        { min: 1, max: 100, message: 'Longitud debería ser 1 a 100', trigger: 'blur' }
      ],

    }
  }),
  mounted() {
    if(!localStorage.getItem("token")){
      this.$router.push("/auth/index");
    }
    this.refresh();
  },
  methods: {
    refresh() {
      axios.get('orden').then(res => {
        this.tableData = res.data.data.filter(row => row.infoorden_remision !== 'No');
        this.filteredData = this.tableData;
      });
    },
    remision(row) {
      console.log(row);
      this.selectedItem = row;
      this.dialogVisibleViewRemisiones = true;
    },

    createRemision1() {
      this.$refs.formRef.validate(async (valid) => {
        if (valid) {
          try {
            const response = await axios.post('remisiones', {
              ...this.form1,
              id_cliente: this.selectedItem.id,
            });
            console.log(response);
            this.dialogVisibleViewRemisiones = false;
            this.refresh();
            this.$message.success('La remisión se creo correctamente');
            ElNotification({
              title: 'Alerta',
              message: 'Registro insertado correctamente',
              type: 'success'
            })
          } catch (error) {
            console.error('Error creating remisión:', error.response.data);
            this.$message.error('Error al crear la remisión1');
            ElNotification({
              title: 'Error',
              message: 'Favor de llenar los campos',
              type: 'error'
            })
            console.error('Error creating remisión:', error.response.data);
            this.$message.error('Error al crear la remisión');
          }
        } else {
          console.log('Validation failed');
          console.log('Validation failed');
          ElNotification({
            title: 'Error',
            message: 'Favor de llenar los campos',
            type: 'error'
          });
          return false;
        }
      });
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
        const responseOrdenes = await axios.get(this.urlApi + 'clientes');
        this.tableData = responseOrdenes.data.data.filter(row => row.infoclient_remision !== 'No');
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
