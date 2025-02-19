<template>
  <!-- Importar Iconos-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />


  <div>
    <div class="container mx-auto px-4">

      <!-- INICIO -->
      <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-semibold">Gestión de Colonias</h1>
        <div class="flex" style="width: 55%;">
          <el-input class="" placeholder="Buscar por nombre de la ciudad" v-model="searchQueryCity"
            @input="filterDataCity" />
          <el-input class="px-2" placeholder="Buscar por nombre de la colonia" v-model="searchQueryCologne"
            @input="filterDataCologne" />
          <el-input class="" placeholder="Buscar por codigo postal" v-model="searchQueryZip"
            @input="filterDataZip" />
        </div>
        <div>
          <router-link to="/admin/admin" class="el-button el-button--danger">
            <i class="fa fa-rotate-left" aria-hidden="true"
              style="margin-top: 5px; margin-left: -5px; margin-right:10px;"></i>
            Regresar
          </router-link>
          <el-button @click="dialogVisibleCreate = true" class="ml-2 el-button el-button--primary">
            <i class="fa-solid fa-map-location-dot" aria-hidden="true" style="margin-top: 5px; margin-left: -5px; margin-right:10px;"></i>
            Nueva Colonia
          </el-button>
        </div>
      </div>
      <!-- END INICIO -->

      <!-- TABLE -->
      <div class="flex" style="justify-content: center;">
        <el-table :data="filteredData" :default-sort="{ prop: 'ciudad', order: 'ascending' }" style="width: 65%;">
          <el-table-column prop="ciudad" label="Ciudad" sortable />
          <el-table-column prop="colonia" label="Colonia" sortable />
          <el-table-column label="Codigo postal" sortable>
            <template #default="scope">
              {{ '#' + scope.row.codigoPostal }}
            </template>
          </el-table-column>
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
      <el-dialog v-model="dialogVisibleCreate" title="Crear Nueva Colonia" width="20%">
        <el-form :model="form1" label-width="auto" style="max-width: 100%" ref="formRef" :rules="rules"
          :label-position="'top'">
          <div class="row">
            <el-form-item prop="id_ciudad" label="Ciudad:">
              <el-select v-model="form1.id_ciudad" placeholder="Selecciona la ciudad">
                <el-option v-for="ciudad in ciudades" :key="ciudad.id" :label="ciudad.ciudad" :value="ciudad.id" />
              </el-select>
            </el-form-item>
            <el-form-item prop="colonia" label="Colonia:">
              <el-input v-model="form1.colonia" class="px-1" placeholder="Ingresa la ciudad" />
            </el-form-item>
            <el-form-item prop="codigoPostal" label="Codigo postal:">
              <el-input v-model="form1.codigoPostal" class="px-1" placeholder="Ingresa el estado" />
            </el-form-item>
          </div>
        </el-form>
        <template #footer>
          <span class="dialog-footer">
            <el-button @click="dialogVisibleCreate = false">Cancelar</el-button>
            <el-button type="primary" @click="createCologne">Crear</el-button>
          </span>
        </template>
      </el-dialog>
      <!-- END MODAL 1 -->

      <!-- MODAL 2 -->
    <el-dialog v-model="dialogVisible" title="¿Deseas eliminar la siguente colonia?" width="20%">
      <div class="h-35" style="font-size: medium;">
        Ciudad: {{ selectedItem.ciudad }}
        <br>
        Colonia: {{ selectedItem.colonia }}
        <br>
        Codigo postal: {{ '#'+selectedItem.codigoPostal }}
        <br>
      </div>
      <template #footer>
        <div class="dialog-footer">
          <el-button type="info" @click="dialogVisible = false">Cancelar</el-button>
          <el-button type="danger" @click="handleDelete()">
            Confirmar
          </el-button>
        </div>
      </template>
    </el-dialog>
    <!-- END MODAL 2 -->

    <!-- MODAL 3 -->
    <el-dialog v-model="dialogVisibleEdit" title="Editar Colonia" width="30%">
      <el-form :model="formEdit" label-width="auto" style="max-width: 100%" ref="formEditRef" :rules="rules" :label-position="'top'">
        <div class="clientInfo">
          <div class="details">
            <i class="fa-solid fa-city fa-2x iconCologneEdit"></i>
            <div class="flex" style="width: 100%;">
              <el-form-item prop="id_ciudad" label="Ciudad:" style="width: 100%;">
                <el-select v-model="formEdit.id_ciudad" placeholder="Selecciona la ciudad">
                  <el-option v-for="ciudad in ciudades" :key="ciudad.id" :label="ciudad.ciudad" :value="ciudad.id" />
                </el-select>
              </el-form-item>
            </div>
          </div>
          <div class="details">
            <i class="fa-solid fa-location-dot fa-2x iconCologneEdit"></i>
            <div class="flex" style="width: 100%;">
              <el-form-item prop="colonia" label="Colonia:" style="width: 100%;">
                <el-input v-model="formEdit.colonia" class="px-1" placeholder="Ingresa la ciudad" />
              </el-form-item>
              <el-form-item prop="codigoPostal" label="Codigo postal:" style="width: 100%;">
                <el-input v-model="formEdit.codigoPostal" class="px-1" placeholder="Ingresa el estado" />
              </el-form-item>
            </div>
          </div>
        </div>
      </el-form>
      <template #footer>
        <span class="dialog-footer">
          <el-button @click="dialogVisibleEdit = false">Cancelar</el-button>
          <el-button type="warning" @click="editCologne">Actualizar</el-button>
        </span>
      </template>
    </el-dialog>
  <!-- END MODAL 3 -->

    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { ElNotification } from 'element-plus';

export default {
  name: 'AdminCologneComponent',
  data: () => ({
    formRef: undefined,
    formEditRef: undefined,
    dialogVisible: false,
    dialogVisibleView: false,
    dialogVisibleCreate: false,
    dialogVisibleEdit: false,
    url: process.env.VUE_APP_ROOT_ASSETS,
    urlApi: process.env.VUE_APP_ROOT_API,
    tableData: [],
    filteredData: [],
    selectedItem: {},
    searchQuery: '',
    searchQueryCity: '',
    searchQueryCologne: '',
    searchQueryZip: '',
    form1: {
      id_ciudad: '',
      colonia: '',
      codigoPostal: '',
    },
    formEdit: {
      id_ciudad: '',
      colonia: '',
      codigoPostal: '',
    },
    rules: {
      id_ciudad: [
        { required: true, message: 'La ciudad es requerida', trigger: 'blur' },
      ],
      colonia: [
        { required: true, message: 'El nombre de la colonia es requerida', trigger: 'blur' },
        { min: 1, max: 100, message: 'Longitud debería ser 1 a 100', trigger: 'blur' }
      ],
      codigoPostal: [
        { required: true, message: 'El codigo postal es requerido', trigger: 'blur' },
        { min: 1, max: 100, message: 'Longitud debería ser 1 a 100', trigger: 'blur' }
      ],
    }
  }),
  mounted() {
    this.refresh();
    this.fetchCiudades();
  },
  methods: {
    refresh() {
      axios.get('colonias').then(res => {
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
      axios.delete('colonias/' + this.selectedItem.id).then(res => {
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

    fetchCiudades() {
      axios.get('verCiudades')
        .then(response => {
          console.log('Ciudades:', response.data);
          this.ciudades = response.data;
        })
        .catch(error => {
          console.error('Error fetching ciudades:', error);
        });
    },

    createCologne() {
      this.$refs.formRef.validate((valid) => {
        if (valid) {
          axios.post('colonias', this.form1)
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
      this.filteredData = this.tableData.filter((colonia) => {
        return colonia.ciudad.toLowerCase().includes(this.searchQueryCity.toLowerCase());
      });
    },

    filterDataCologne() {
      this.filteredData = this.tableData.filter((colonia) => {
        return colonia.colonia.toLowerCase().includes(this.searchQueryCologne.toLowerCase());
      });
    },

    filterDataZip() {
      this.filteredData = this.tableData.filter((colonia) => {
        return colonia.codigoPostal.toLowerCase().includes(this.searchQueryZip.toLowerCase());
      });
    },

    editCologne() {
      this.$refs.formEditRef.validate((valid) => {
        if (valid) {
          console.log('Form is valid, sending PUT request');
          axios.put('colonias/'+this.formEdit.id,this.formEdit)
            .then(res => {
              console.log(res);
              this.refresh();
              this.dialogVisibleEdit = false;
              this.$message.success('Colonia actualizada exitosamente');
              this.$refs.formEditRef.resetFields();
              ElNotification({
                title: 'Alerta',
                message: 'Registro actualizado correctamente',
                type: 'success'
              })
            })
            .catch(error => {
              console.log(error);
              this.$message.error('Error al actualizar la colonia');
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

.iconCologne {
  color: #f32222;
  margin-right: 10px;
}

.iconCologneEdit {
  color: #e6a23c;
  margin-right: 10px;
}
</style>

