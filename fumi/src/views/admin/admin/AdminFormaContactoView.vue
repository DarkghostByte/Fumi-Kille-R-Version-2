<template>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  <div>
    <div class="container mx-auto px-4">

      <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-semibold">Gestión de Formas de contacto</h1>
        <div class="py-3">
          <router-link to="/admin/admin" class="el-button el-button--danger">
            <i class="fa fa-rotate-left" aria-hidden="true"
              style="margin-top: 5px; margin-left: -5px; margin-right:10px;"></i>
            Regresar
          </router-link>
          <el-button @click="dialogVisibleCreate = true" class="ml-2 el-button el-button--primary">
            <i class="fa-solid fa-road" aria-hidden="true" style="margin-top: 5px; margin-left: -5px; margin-right:10px;"></i>
            Nueva Forma de Contacto
          </el-button>
        </div>
      </div>

      <div class="flex" style="justify-content: center;">
        <el-table :data="filteredData" :default-sort="{ prop: 'name', order: 'descending' }" style="width: 60%" stripe>
          <el-table-column label="">
            <template #default="scope">
              <el-button style="color:black" size="small" type="success" @click="pdf(scope.row)">
                <a :href="url + 'api/verEstadoCertificado/' + scope.row.id" target="_blank">
                  <span class="material-symbols-outlined">lab_profile</span>
                </a>
              </el-button>
            </template>
          </el-table-column>
          <el-table-column prop="formadeContacto" label="Forma de contacto" sortable width="auto" />
          <el-table-column prop="infodelete_Forma" label="Estado" sortable width="auto" />
          <el-table-column label="Acciones">
            <template #default="scope">
              <el-button size="small" type="primary" @click="handleEdit(scope.row)">Editar</el-button>
            </template>
          </el-table-column>
        </el-table>
      </div>
      <el-dialog v-model="dialogVisibleCreate" title="Agregar nueva forma de contacto" width="20%">
        <el-form :model="form1" label-width="auto" style="max-width: 100%" ref="formRef" :rules="rules"
          :label-position="'top'">
          <div class="row">
            <el-form-item prop="formadeContacto" label="Forma de contacto:">
              <el-input v-model="form1.formadeContacto" class="px-1" placeholder="Ingresa la forma de contacto" />
            </el-form-item>
          </div>
        </el-form>
        <template #footer>
          <span class="dialog-footer">
            <el-button @click="dialogVisibleCreate = false">Cancelar</el-button>
            <el-button type="primary" @click="createFormaContacto">Crear</el-button>
          </span>
        </template>
      </el-dialog>
      <el-dialog v-model="dialogVisibleEdit" title="Editar forma de contacto" width="20%">
        <el-form :model="editForm" label-width="auto" style="max-width: 100%" ref="editFormRef" :rules="rules"
          :label-position="'top'">
          <div class="row">
            <el-form-item prop="formadeContacto" label="Forma de contacto:">
              <el-input v-model="editForm.formadeContacto" class="px-1" placeholder="Ingresa la forma de contacto" />
            </el-form-item>
          </div>
        </el-form>
        <template #footer>
          <span class="dialog-footer">
            <el-button @click="dialogVisibleEdit = false">Cancelar</el-button>
            <el-button type="primary" @click="updateFormaContacto">Guardar</el-button>
          </span>
        </template>
      </el-dialog>
      </div>
  </div>
</template>

<script>
import axios from 'axios';
import { ElNotification } from 'element-plus';

export default {
  data() {
    return {
      dialogVisibleCreate: false,
      dialogVisibleEdit: false,
      form1: {
        formadeContacto: '',
        infodelete_Forma: 'Alta',
      },
      editForm: {
        id: null,
        formadeContacto: '',
        infodelete_Forma: 'Alta',
      },
      rules: {
        formadeContacto: [
          { required: true, message: 'La forma de contacto es requerida', trigger: 'blur' },
          { min: 1, max: 100, message: 'Longitud debería ser 1 a 100', trigger: 'blur' }
        ],
      },
      tableData: [],
      filteredData: [],
    };
  },
  methods: {
    createFormaContacto() {
      this.$refs.formRef.validate((valid) => {
        if (valid) {
          axios.post('formaContacto', this.form1)
            .then(res => {
              console.log(res);
              this.dialogVisibleCreate = false;
              this.refresh();
              this.$message.success('Forma de contacto agregada exitosamente');
              this.$refs.formRef.resetFields();
              ElNotification({
                title: 'Alerta',
                message: 'Registro insertado correctamente',
                type: 'success'
              });
            })
            .catch(error => {
              console.log(error);
              this.$message.error('Error al agregar la forma de contacto');
              ElNotification({
                title: 'Error',
                message: 'Favor de llenar los campos',
                type: 'error'
              });
            });
        } else {
          console.log('Validation failed');
          ElNotification({
            title: 'Error',
            message: 'Favor de llenar los campos',
            type: 'error'
          });
        }
      });
    },
    refresh() {
      axios.get('formaContacto').then(res => {
        this.tableData = res.data.data;
        this.filteredData = this.tableData;
      });
    },
    handleEdit(row) {
      this.editForm = { ...row };
      this.dialogVisibleEdit = true;
    },
    updateFormaContacto() {
      this.$refs.editFormRef.validate((valid) => {
        if (valid) {
          axios.put(`formaContacto/${this.editForm.id}`, this.editForm)
            .then(res => {
              console.log(res);
              this.dialogVisibleEdit = false;
              this.refresh();
              this.$message.success('Forma de contacto actualizada exitosamente');
              ElNotification({
                title: 'Alerta',
                message: 'Registro actualizado correctamente',
                type: 'success'
              });
            })
            .catch(error => {
              console.log(error);
              this.$message.error('Error al actualizar la forma de contacto');
              ElNotification({
                title: 'Error',
                message: 'Favor de llenar los campos',
                type: 'error'
              });
            });
        } else {
          console.log('Validation failed');
          ElNotification({
            title: 'Error',
            message: 'Favor de llenar los campos',
            type: 'error'
          });
        }
      });
    },
  },
  mounted() {
    this.refresh();
  },
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
