<template>
  <!-- Importar Iconos-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />


  <div>
    <div class="container mx-auto px-4">

      <!-- INICIO -->
      <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-semibold">Gestión de Productos Externos</h1>
        <div class="flex" style="width: 25%;">
          <el-input class="" placeholder="Buscar por producto externo" v-model="searchQueryProductExt"
            @input="filterDataProductExt" />
        </div>
        <div>
          <router-link to="/admin/admin" class="el-button el-button--danger">
            <i class="fa fa-rotate-left" aria-hidden="true"
              style="margin-top: 5px; margin-left: -5px; margin-right:10px;"></i>
            Regresar
          </router-link>
          <el-button @click="dialogVisibleCreate = true" class="ml-2 el-button el-button--primary">
            <i class="fa-solid fa-house-medical-circle-check" aria-hidden="true" style="margin-top: 5px; margin-left: -5px; margin-right:10px;"></i>
            Nuevo Producto Externo
          </el-button>
        </div>
      </div>
      <!-- END INICIO -->

      <!-- TABLE -->
      <div class="flex" style="justify-content: center;">
        <el-table :data="filteredData" :default-sort="{ prop: 'productoExt', order: 'ascending' }" style="width: 55%;">
          <el-table-column class="" label="">
            <template #default="{ row }">
              <button 
                class="ml-5 px-5 h-3 w-3 rounded-full" 
                :style="{ backgroundColor: row.infodelete_productoExt === 'Alta' ? 'Green' : 'Red' }"
                @click="handleEstadoClick(row)"
              >
              </button>
            </template>
          </el-table-column>
          <el-table-column prop="infodelete_productoExt" label="Estado" >
            <template #default="{ row }">
              <span v-if="row.infodelete_productoExt === 'Alta'">{{ row.infodelete_productoExt }}</span>
              <span v-else>{{ row.infodelete_productoExt }}</span>
            </template>
          </el-table-column>
          <el-table-column prop="productoExt" label="Producto externo" sortable />
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
      <el-dialog v-model="dialogVisibleCreate" title="Agregar nuevo producto externo" width="20%">
        <el-form :model="form1" label-width="auto" style="max-width: 100%" ref="formRef" :rules="rules"
          :label-position="'top'">
          <div class="row">
            <el-form-item prop="productoExt" label="Producto Externo:">
              <el-input v-model="form1.productoExt" class="px-1" placeholder="Ingresa el producto externo" />
            </el-form-item>
          </div>
        </el-form>
        <template #footer>
          <span class="dialog-footer">
            <el-button @click="dialogVisibleCreate = false">Cancelar</el-button>
            <el-button type="primary" @click="createProductExt">Crear</el-button>
          </span>
        </template>
      </el-dialog>
      <!-- END MODAL 1 -->

<!--
    <el-dialog v-model="dialogVisible" title="¿Deseas eliminar el siguente producto externo?" width="25%" height="500">
      <div class="clientInfo">
        <div class="details">
          <i class="fa-solid fa-house-medical-circle-check fa-2x iconProductExt"></i>
        
          <div>
            <p>
              <strong>Producto externo: </strong> {{ selectedItem.productoExt }}
            </p>
          </div>
        </div>
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
  -->

    <!-- MODAL 3 -->
    <el-dialog v-model="dialogVisibleEdit" title="Editar Producto Externo" width="25%">
      <el-form :model="formEdit" label-width="auto" style="max-width: 100%" ref="formEditRef" :rules="rules" :label-position="'top'">
        <div class="clientInfo">
          <div class="details">
            <i class="fa-solid fa-house-medical-circle-check fa-2x iconProductExtEdit"></i>
            <!-- END MODAL 2 <h2 class="client-details__title">Información del Cliente</h2>-->
            <div class="flex" style="width: 100%;">
              <el-form-item prop="productoExt" label="Producto Externo:" style="width: 100%;">
                <el-input v-model="formEdit.productoExt" class="px-1" placeholder="Ingresa el producto externo" />
              </el-form-item>
            </div>
          </div>
        </div>
      </el-form>
      <template #footer>
        <span class="dialog-footer">
          <el-button @click="dialogVisibleEdit = false">Cancelar</el-button>
          <el-button type="warning" @click="editProductExt">Actualizar</el-button>
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
    searchQueryProductExt: '',
    form1: {
      productoExt: '',
      infodelete_productoExt: 'Alta',

    },
    formEdit: {
      productoExt: '',
    },
    rules: {
      productoExt: [
        { required: true, message: 'El producto externo es requerido', trigger: 'blur' },
        { min: 1, max: 100, message: 'Longitud debería ser 1 a 100', trigger: 'blur' }
      ],
    }
  }),
  mounted() {
    this.refresh();
  },
  methods: {
    refresh() {
      axios.get('productosExternos').then(res => {
        this.tableData = res.data.data;
        this.filteredData = this.tableData;
      });
    },

    handleEdit(row) {
      console.log(row);
      this.formEdit = row;
      this.dialogVisibleEdit = true;
    },

/*
    eliminar(row) {
      console.log(row);
      this.selectedItem = row;
      this.dialogVisible = true;
    },

    handleDelete() {
      axios.delete('productosExternos/' + this.selectedItem.id).then(res => {
        console.log(res);
        this.refresh();
        this.dialogVisible = false;
      ElNotification({
        title: 'Eliminacion',
        message: 'Registro se elimino correctamente',
        type: 'success'
      })
      });
    },
    */


    createProductExt() {
      this.$refs.formRef.validate((valid) => {
        if (valid) {
          axios.post('productosExternos', this.form1)
            .then(res => {
              console.log(res);
              this.dialogVisibleCreate = false;
              this.refresh();
              this.$message.success('El producto externo se agrego exitosamente');
              this.$refs.formRef.resetFields();
              ElNotification({
                title: 'Alerta',
                message: 'Registro insertado correctamente',
                type: 'success'
              })
            })
            .catch(error => {
              console.log(error);
              this.$message.error('Error al agregar el producto externo');
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

    filterDataProductExt() {
      this.filteredData = this.tableData.filter((productosExternos) => {
        return productosExternos.productoExt.toLowerCase().includes(this.searchQueryProductExt.toLowerCase());
      });
    },

    editProductExt() {
      this.$refs.formEditRef.validate((valid) => {
        if (valid) {
          console.log('Form is valid, sending PUT request');
          axios.put('productosExternos/'+this.formEdit.id,this.formEdit)
            .then(res => {
              console.log(res);
              this.refresh();
              this.dialogVisibleEdit = false;
              this.$message.success('Producto Externo actualizado exitosamente');
              this.$refs.formEditRef.resetFields();
              ElNotification({
                title: 'Alerta',
                message: 'Registro actualizado correctamente',
                type: 'success'
              })
            })
            .catch(error => {
              console.log(error);
              this.$message.error('Error al actualizar el producto externo');
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
    infodelete_productoExt: row.infodelete_productoExt === 'Baja' ? 'Alta' : 'Baja'
  };
  axios.put(`desactivarProductoExterno/${row.id}`, updatedData)
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

.iconProductExt {
  color: #f32222;
  margin-right: 10px;
}

.iconProductExtEdit {
  color: #e6a23c;
  margin-right: 10px;
}
</style>
