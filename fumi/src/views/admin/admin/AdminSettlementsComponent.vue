<template>
  <!-- Importar Iconos-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />


  <div>
    <div class="container mx-auto px-4">

      <!-- INICIO -->
      <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-semibold">Gestión de Departamnetos</h1>
        <div class="flex" style="width: 25%;">
          <el-input class="" placeholder="Buscar por departamento" v-model="searchQuerySettlements"
            @input="filterDataSettlements" />
        </div>
        <div>
          <router-link to="/admin/admin" class="el-button el-button--danger">
            <i class="fa fa-rotate-left" aria-hidden="true"
              style="margin-top: 5px; margin-left: -5px; margin-right:10px;"></i>
            Regresar
          </router-link>
          <el-button @click="dialogVisibleCreate = true" class="ml-2 el-button el-button--primary">
            <i class="fa-solid fa-school-flag" aria-hidden="true" style="margin-top: 5px; margin-left: -5px; margin-right:10px;"></i>
            Nuevo Departamento
          </el-button>
        </div>
      </div>
      <!-- END INICIO -->

      <!-- TABLE -->
      <div class="flex" style="justify-content: center;">
        <el-table :data="filteredData" :default-sort="{ prop: 'comercio', order: 'ascending' }" style="width: 35%;">
          <el-table-column prop="comercio" label="Departamneto" sortable />
          <el-table-column prop="infodelete_departamento" label="Estado" sortable />
        </el-table>
      </div>
      <!-- END TABLE -->

      <!-- MODAL 1 -->
      <el-dialog v-model="dialogVisibleCreate" title="Nuevo Departamento" width="20%">
        <el-form :model="form1" label-width="auto" style="max-width: 100%" ref="formRef" :rules="rules"
          :label-position="'top'">
          <div class="row">
            <el-form-item prop="comercio" label="Departamento:">
              <el-input v-model="form1.comercio" class="px-1" placeholder="Ingresa el departamento" />
            </el-form-item>
          </div>
        </el-form>
        <template #footer>
          <span class="dialog-footer">
            <el-button @click="dialogVisibleCreate = false">Cancelar</el-button>
            <el-button type="primary" @click="createDepartamento">Crear</el-button>
          </span>
        </template>
      </el-dialog>
      <!-- END MODAL 1 -->

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
    url: process.env.VUE_APP_ROOT_ASSETS,
    urlApi: process.env.VUE_APP_ROOT_API,
    tableData: [],
    filteredData: [],
    selectedItem: {},
    searchQuerySettlements: '',
    form1: {
      comercio: '',
      infodelete_departamento:'Alta',
    },
    rules: {
      comercio: [
        { required: true, message: 'El tipo de comercio es requerido', trigger: 'blur' },
        { min: 1, max: 100, message: 'Longitud debería ser 1 a 100', trigger: 'blur' }
      ],
    }
  }),
  mounted() {
    this.refresh();
  },
  methods: {
    refresh() {
      axios.get('comercios').then(res => {
        this.tableData = res.data.data;
        this.filteredData = this.tableData;
      });
    },

    createDepartamento() {
      this.$refs.formRef.validate((valid) => {
        if (valid) {
          axios.post('comercios', this.form1)
            .then(res => {
              console.log(res);
              this.dialogVisibleCreate = false;
              this.refresh();
              this.$message.success('Tipo de comercio creado exitosamente');
              /*ElNotification({
                title: 'Alerta',
                message: 'Registro insertado correctamente',
                type: 'success'
              })
                */
              this.$refs.formRef.resetFields();
            })
            .catch(error => {
              console.log(error);
              this.$message.error('Error al crear el tipo de comercio');
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

    filterDataSettlements() {
      this.filteredData = this.tableData.filter((comercios) => {
        return comercios.comercio.toLowerCase().includes(this.searchQuerySettlements.toLowerCase());
      });
    },
  }
};
</script>
