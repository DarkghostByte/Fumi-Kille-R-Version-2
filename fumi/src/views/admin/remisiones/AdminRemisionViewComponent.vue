<template>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  <div class="container mx-auto px-4">

    <div class="flex justify-between items-center mb-4">
      <h1 class="text-2xl font-semibold">Gestión de Remisiones Realizadas</h1>
      <div class="flex flex-wrap items-start justify-end ">
        <router-link to="/admin/remisiones" class="el-button el-button--danger">
          <i class="fa fa-rotate-left" aria-hidden="true"
            style="margin-top: 5px; margin-left: -5px; margin-right:10px;"></i>
          Regresar
        </router-link>
      </div>
    </div>

    <div class="flex mb-4" style="justify-content: center;">
      <div class="flex mb-4" style="width: 80%;">
        <el-input class="px-2" placeholder="Buscar por nombre" v-model="searchQueryName"
          @input="filterDataName" />
        <el-input class="px-2" placeholder="Buscar por direccion" v-model="searchQueryAddress"
          @input="filterDataAddress" />
        <el-input class="px-2" placeholder="Buscar por celular" v-model="searchQueryPhone"
          @input="filterDataPhone" />
      </div>
    </div>

    <div class="flex" style="justify-content: center;">
      <el-table :data="filteredData" :default-sort="{ prop: 'id', order: 'descending' }" style="width: 100%" stripe>
        <el-table-column label="" width="100">
          <template #default="scope">
            <el-button style="color:black" size="small" type="info" @click="pdf(scope.row)">
              <a :href="url + 'api/remision/' + scope.row.id" target="_blank">
                <span class="material-symbols-outlined">lab_profile</span>
              </a>
            </el-button>
          </template>
        </el-table-column>

        <el-table-column label="" width="100">
          <template #default="scope">
            <el-button style="color:black" size="small" type="success" @click="seleccionar(scope.row)"><span
                class="material-symbols-outlined">visibility</span></el-button>
          </template>
        </el-table-column>

        <el-table-column label="" width="100">
          <template #default="scope">
            <el-button style="color:black" size="small" type="warning" @click="openEditModal(scope.row)">
              <span class="material-symbols-outlined">edit</span>
            </el-button>
          </template>
        </el-table-column>

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
        <el-table-column prop="cell_phone" label="Numero Celular" sortable />

      </el-table>
    </div>
    <el-dialog v-model="dialogVisibleView" title="Datos del certificado" width="700" height="500">
      <div class="clientInfo">
        <div class="details">
          <i class="fa fa-file fa-2x iconInfo"></i>
          <div>
            <p>
              <strong>Certificado a:</strong> {{ selectedItem.name }}
            </p>
          </div>
        </div>
        <div class="details">
          <i class="fa fa-city fa-2x iconInfo"></i>
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
          </div>
        </div>
      </div>
      <template #footer>
        <div class="dialog-footer">
          <el-button type="primary" color="#ff7640" @click="dialogVisibleView = false">Listo</el-button>
        </div>
      </template>
    </el-dialog>

    <el-dialog v-model="dialogVisibleEditRemision" title="Editar Remisión" width="40%">
      <el-form :model="editForm" label-width="auto" style="max-width: 100%" ref="editFormRef" :rules="rules"
        :label-position="'top'">
        <div class="row" style="width:100%;">
          <p>Cliente: {{ editForm.name }} {{ editForm.lastname1 }} {{ editForm.lastname2 }}</p>
          <p>Negocio: {{ editForm.tradename }}</p>
          <br>

          <div class="flex" style="width:100%;">
            <el-form-item prop="RemisionDate" class="px-2" label="Fecha de la remisión:">
              <el-col :span="11">
                <el-date-picker v-model="editForm.RemisionDate" type="date" placeholder="Fecha de la remisión"
                  format="DD/MM/YYYY" value-format="DD-MM-YYYY" />
              </el-col>
            </el-form-item>

            <el-form-item prop="RemisionMonto" label="Monto:" class="px-2">
              <el-input v-model="editForm.RemisionMonto" placeholder="Ingresa el monto" />
            </el-form-item>
          </div>

          <div class="flex" style="width:100%;">
            <el-form-item style="width:100%;" prop="RemisionObservaciones" label="Observaciones:" class="px-2">
              <el-input v-model="editForm.RemisionObservaciones" type="textarea" maxlength="200" show-word-limit
                placeholder="Agrega las observaciones" />
            </el-form-item>
          </div>

        </div>
      </el-form>
      <template #footer>
        <span class="dialog-footer">
          <el-button @click="dialogVisibleEditRemision = false">Cancelar</el-button>
          <el-button type="primary" @click="updateRemision(editForm.id)">Guardar</el-button>
        </span>
      </template>
    </el-dialog>
  </div>
</template>

<script>
import axios from 'axios';

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
    dialogVisibleEditRemision: false,
    editForm: {
      id: null,
      name: '',
      lastname1: '',
      lastname2: '',
      tradename: '',
      RemisionDate: '',
      RemisionMonto: '',
      RemisionObservaciones: '',
    },
    editFormRef: null,
    rules: {
      RemisionDate: [{ required: true, message: 'Por favor selecciona la fecha', trigger: 'change' }],
      RemisionMonto: [{ required: true, message: 'Por favor ingresa el monto', trigger: 'blur' }],
    },
  }),
  mounted() {
    if(!localStorage.getItem("token")){
      this.$router.push("/auth/index");
    }
    this.refresh();
  },
  methods: {
    refresh() {
      axios.get('remisiones').then(res => {
        this.tableData = res.data.data;
        this.filteredData = res.data.data;
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
      const idString = String(id);
      paddingLength = Math.max(0, Math.floor(paddingLength));
      return idString.padStart(paddingLength, paddingChar);
    },

    openEditModal(row) {
      this.editForm = { ...row };
      this.dialogVisibleEditRemision = true;
    },

    updateRemision(id) {
      this.$refs.editFormRef.validate((valid) => {
        if (valid) {
          axios.put(`remisiones/${id}`, this.editForm)
            .then(() => {
              this.dialogVisibleEditRemision = false;
              // Actualizar los datos en tableData y filteredData
              const index = this.tableData.findIndex(item => item.id === id);
              if (index !== -1) {
                this.tableData.splice(index, 1, { ...this.editForm });
                this.filteredData = [...this.tableData]; // Actualizar filteredData
              }
              this.$message({
                type: 'success',
                message: 'Remisión actualizada correctamente',
              });
            })
            .catch(error => {
              console.error('Error al actualizar la remisión:', error);
              this.$message({
                type: 'error',
                message: 'Error al actualizar la remisión',
              });
            });
        } else {
          console.log('error submit!!');
          return false;
        }
      });
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
  color: #ff7640;
  margin-right: 10px;
}

.iconDelete {
  color: #f32222;
  margin-right: 10px;
}
</style>