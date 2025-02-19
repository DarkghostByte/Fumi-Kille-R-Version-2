<template>
  <!-- Importar Iconos-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- PANTALLA -->
  <div>
    <div class="container mx-auto px-4">

      <!-- INICIO -->
      <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-semibold">Gestión de Ciudades</h1>
        <div class="flex" style="width: 50%;">
          <el-input class="" placeholder="Buscar por ciudad" v-model="searchQueryCity"
            @input="filterDataCity" />
          <el-input class="px-2" placeholder="Buscar por estado" v-model="searchQueryState"
            @input="filterDataState" />
            <el-input class="px-2" placeholder="Buscar por estado de activacion" v-model="searchQueryStatus"
            @input="filterDataStatus" />
        </div>
        <div>
          <router-link to="/admin/admin" class="el-button el-button--danger">
            <i class="fa fa-rotate-left" aria-hidden="true"
              style="margin-top: 5px; margin-left: -5px; margin-right:10px;"></i>
            Regresar
          </router-link>
          <el-button @click="dialogVisibleCreate = true" class="ml-2 el-button el-button--primary">
            <i class="fa fa-city" aria-hidden="true" style="margin-top: 5px; margin-left: -5px; margin-right:10px;"></i>
            Nueva Ciudad
          </el-button>
        </div>
      </div>
      <!-- END INICIO -->

      <!-- TABLE -->
      <div class="flex" style="justify-content: center;">
        <el-table :data="filteredData" :default-sort="{ prop: 'ciudad', order: 'ascending' }" style="width: 65%;">
          <el-table-column class="" label="">
            <template #default="{ row }">
              <button 
                class="ml-5 px-5 h-3 w-3 rounded-full" 
                :style="{ backgroundColor: row.infodelete_Ciudad === 'Alta' ? 'Green' : 'Red' }"
                @click="handleEstadoClick(row)"
              >
              </button>
            </template>
          </el-table-column>
          <el-table-column prop="infodelete_Ciudad" label="Estado" >
            <template #default="{ row }">
              <span v-if="row.infodelete_Ciudad === 'Alta'">{{ row.infodelete_Ciudad }}</span>
              <span v-else>{{ row.infodelete_Ciudad }}</span>
            </template>
          </el-table-column>
          <el-table-column prop="ciudad" label="Ciudad" sortable />
          <el-table-column prop="estado" label="Estado" sortable />
          <el-table-column label="Acciones">
            <template #default="scope">
              <div class="flex justify-around">
                <el-button style="color:black" size="small" type="warning" @click="handleEdit(scope.row)">
                  <span class="material-symbols-outlined">edit</span>
                </el-button>
                <!--
                <el-button style="color:black" size="small" type="danger" @click="eliminar(scope.row)">
                  <span class="material-symbols-outlined">delete</span>
                </el-button>
                -->
              </div>
            </template>
          </el-table-column>
        </el-table>
      </div>
      <!-- END TABLE -->

      <!-- MODAL 1 -->
      <el-dialog v-model="dialogVisibleCreate" title="Crear Nueva Ciudad" width="20%">
        <el-form :model="form1" label-width="auto" style="max-width: 100%" ref="formRef" :rules="rules"
          :label-position="'top'">
          <div class="row">
            <el-form-item prop="ciudad" label="Ciudad:" style="width: 240px;">
              <el-input v-model="form1.ciudad" class="px-1" placeholder="Ingresa la ciudad" />
            </el-form-item>
            <el-form-item prop="estado" label="Estado:" style="width: 240px;">
              <el-input v-model="form1.estado" class="px-1" placeholder="Ingresa el estado" />
            </el-form-item>
          </div>
        </el-form>
        <template #footer>
          <span class="dialog-footer">
            <el-button @click="dialogVisibleCreate = false">Cancelar</el-button>
            <el-button type="primary" @click="createCity">Crear</el-button>
          </span>
        </template>
      </el-dialog>
      <!-- END MODAL 1 -->

      <!-- MODAL 3 -->
      <el-dialog v-model="dialogVisibleEdit" title="Editar Ciudad" width="40%">
        <el-form :model="formEdit" label-width="auto" style="max-width: 100%" ref="formEditRef" :rules="rules" :label-position="'top'">
          <div class="clientInfo">
            <div class="details">
              <i class="fa-solid fa-city fa-2x iconCityEdit"></i>
              <div class="flex" style="width: 100%;">
                <el-form-item prop="ciudad" label="Ciudad:" style="width: 100%;">
                  <el-input v-model="formEdit.ciudad" class="px-1" placeholder="Ingresa la ciudad" />
                </el-form-item>
                <el-form-item prop="estado" label="Estado:" style="width: 100%;">
                  <el-input v-model="formEdit.estado" class="px-1" placeholder="Ingresa el estado" />
                </el-form-item>
              </div>
            </div>
          </div>
        </el-form>
        <template #footer>
          <span class="dialog-footer">
            <el-button @click="dialogVisibleEdit = false">Cancelar</el-button>
            <el-button type="warning" @click="editCity">Actualizar</el-button>
          </span>
        </template>
      </el-dialog>
    <!-- END MODAL 3 -->



    </div>
  </div>
  <!-- END PANTALLA -->

</template>

<script>
import axios from 'axios';
import { ElNotification } from 'element-plus';

export default {
  name: 'AdminCityComponent',
  data: () => ({
    formRef: undefined,
    formEditRef: undefined,
    dialogVisible: false,
    dialogVisibleCreate: false,
    url: process.env.VUE_APP_ROOT_ASSETS,
    urlApi: process.env.VUE_APP_ROOT_API,
    tableData: [],
    filteredData: [],
    selectedItem: {},
    dialogVisibleEdit: false,
    searchQuery: '',
    searchQueryCity: '',
    searchQueryState: '',
    searchQueryStatus: '',
    form1: {
      ciudad: '',
      estado: '',
      infodelete_Ciudad: 'Alta',
    },
    formEdit: {
      ciudad: '',
      estado: '',
    },
    rules: {
      ciudad: [
        { required: true, message: 'El nombre de la ciudad es requerida', trigger: 'blur' },
        { min: 1, max: 100, message: 'Longitud debería ser 1 a 100', trigger: 'blur' }
      ],
      estado: [
        { required: true, message: 'El estado es requerido', trigger: 'blur' },
        { min: 1, max: 100, message: 'Longitud debería ser 1 a 100', trigger: 'blur' }
      ],
    }
  }),
  mounted() {
    this.refresh();
  },
  methods: {
    refresh() {
      axios.get('ciudades').then(res => {
        this.tableData = res.data.data;
        this.filteredData = this.tableData;
      });
    },

    handleEdit(row) {
      console.log(row);
      this.formEdit = row;
      this.dialogVisibleEdit = true;
    },

    handleDelete() {
      axios.delete('ciudades/' + this.selectedItem.id).then(res => {
        console.log(res);
        this.refresh();
        this.dialogVisible = false;
      });
    },

    eliminar(row) {
      console.log(row);
      this.selectedItem = row;
      this.dialogVisible = true;
    },

    createCity() {
      this.$refs.formRef.validate((valid) => {
        if (valid) {
          axios.post('ciudades', this.form1)
            .then(res => {
              console.log(res);
              this.dialogVisibleCreate = false;
              this.refresh();
              this.$message.success('Ciudad creada exitosamente');
              this.$refs.formRef.resetFields();
              ElNotification({
                title: 'Alerta',
                message: 'Registro insertado correctamente',
                type: 'success'
              })
            })
            .catch(error => {
              console.log(error);
              this.$message.error('Error al crear la ciudad');
              ElNotification({
                title: 'Error',
                message: 'Favor de llenar los campos',
                type: 'error'
              })
            });
        } else {
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

    filterDataCity() {
      this.filteredData = this.tableData.filter((city) => {
        return city.ciudad.toLowerCase().includes(this.searchQueryCity.toLowerCase());
      });
    },

    filterDataState() {
      this.filteredData = this.tableData.filter((city) => {
        return city.estado.toLowerCase().includes(this.searchQueryState.toLowerCase());
      });
    },

    filterDataStatus() {
      this.filteredData = this.tableData.filter((city) => {
        return city.infodelete_Ciudad.toLowerCase().includes(this.searchQueryStatus.toLowerCase());
      });
    },

    editCity() {
      this.$refs.formEditRef.validate((valid) => {
        if (valid) {
          console.log('Form is valid, sending PUT request');
          axios.put('ciudades/'+this.formEdit.id,this.formEdit)
            .then(res => {
              console.log(res);
              this.refresh();
              this.dialogVisibleEdit = false;
              this.$message.success('Ciudad actualizada exitosamente');
              this.$refs.formEditRef.resetFields();
              ElNotification({
                title: 'Alerta',
                message: 'Registro actualizado correctamente',
                type: 'success'
              })
            })
            .catch(error => {
              console.log(error);
              this.$message.error('Error al actualizar la ciudad');
              ElNotification({
                title: 'Error',
                message: 'Favor de verificar los datos',
                type: 'error'
              })
            });
        } else {
          console.log('Validation failed, check form errors');
          console.log('Validation failed');
          ElNotification({
            title: 'Error',
            message: 'Favor de llenar los campos',
            type: 'error'
          })
        }
      });
    },
    handleEstadoClick(row) {
  const updatedData = {
    infodelete_Ciudad: row.infodelete_Ciudad === 'Baja' ? 'Alta' : 'Baja'
  };
  axios.put(`desactivarCiudad/${row.id}`, updatedData)
    .then(response => {
      console.log('Estado actualizado correctamente:', response.data);
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
  display: flex;
  text-align: center;
}

.client-details__title {
  color: #000;
  font-weight: bold;
  margin-bottom: 15px;
}

.iconCity {
  color: #f32222;
  margin-right: 10px;
}

.iconCityEdit {
  color: #e6a23c;
  margin-right: 10px;
}
</style>
