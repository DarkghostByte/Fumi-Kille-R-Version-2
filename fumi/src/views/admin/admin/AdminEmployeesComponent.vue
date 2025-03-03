<template>
  <!-- Importar Iconos-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />


  <div>
    <div class="container mx-auto px-4">

      <!-- INICIO -->
      <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-semibold">Gestión de Empleados</h1>
        <div class="flex" style="width: 50%;">
          <el-input class="px-2" placeholder="Buscar por nombre" v-model="searchQueryNameEmpleado"
            @input="filterDataNameEmpleado" />
          <el-input class="" placeholder="Buscar por apellido paterno" v-model="searchQueryLastnameEmpleado1"
            @input="filterDataLastnameEmpleado1" />
          <el-input class="px-2" placeholder="Buscar por apellido materno" v-model="searchQueryLastnameEmpleado2"
            @input="filterDataLastnameEmpleado2" />
          <el-input class="" placeholder="Buscar estado de activacion" v-model="searchQueryEstado"
            @input="filterDataEstado" />
        </div>
        <div>
          <router-link to="/admin/admin" class="el-button el-button--danger">
            <i class="fa fa-rotate-left" aria-hidden="true"
              style="margin-top: 5px; margin-left: -5px; margin-right:10px;"></i>
            Regresar
          </router-link>
          <el-button @click="dialogVisibleCreate = true" class="ml-2 el-button el-button--primary">
            <i class="fa-solid fa-users" aria-hidden="true"
              style="margin-top: 5px; margin-left: -5px; margin-right:10px;"></i>
            Nuevo Empleado
          </el-button>
        </div>
      </div>
      <!-- END INICIO -->

      <!-- TABLE -->
      <div class="flex" style="justify-content: center;">
        <el-table :data="filteredData" :default-sort="{ prop: 'empleados', order: 'ascending' }" style="width: 80%;">
          <el-table-column class="" label="">
            <template #default="{ row }">
              <button class="ml-5 px-5 h-3 w-3 rounded-full"
                :style="{ backgroundColor: row.infodelete_Empleados === 'Alta' ? 'Green' : 'Red' }"
                @click="handleEstadoClick(row)">
              </button>
            </template>
          </el-table-column>
          <el-table-column prop="infodelete_Empleados" label="Estado">
            <template #default="{ row }">
              <span v-if="row.infodelete_Empleados === 'Alta'">{{ row.infodelete_Empleados }}</span>
              <span v-else>{{ row.infodelete_Empleados }}</span>
            </template>
          </el-table-column>
          <el-table-column prop="ariasEmpleado" label="Arias" sortable />
          <el-table-column prop="nameEmpleado" label="Nombre" sortable />
          <el-table-column label="Apellidos" sortable>
            <template #default="scope">
              {{ scope.row.lastnameEmpleado1 + ' ' + scope.row.lastnameEmpleado2 }}
            </template>
          </el-table-column>
          <el-table-column prop="comercio" label="Departamento" sortable />
          <el-table-column label="Acciones">
            <template #default="scope">
              <div class="flex justify-around">
                <el-button style="color:black" size="small" type="warning" @click="handleEdit(scope.row)">
                  <span class="material-symbols-outlined">edit</span>
                </el-button>
              </div>
            </template>
          </el-table-column>
        </el-table>
      </div>
      <!-- END TABLE -->

      <!-- MODAL 1 -->
      <el-dialog v-model="dialogVisibleCreate" title="Agregar nuevo empleado" width="30%">
        <el-form :model="form1" label-width="auto" style="max-width: 100%" ref="formRef" :rules="rules"
          :label-position="'top'">
          <div class="row">
            <el-form-item prop="ariasEmpleado" label="Fumigador:">
              <el-input v-model="form1.ariasEmpleado" class="px-1" placeholder="Ingresa el fumigador" />
            </el-form-item>
            <el-form-item prop="nameEmpleado" label="Nombre:">
              <el-input v-model="form1.nameEmpleado" class="px-1" placeholder="Ingresa el nombre" />
            </el-form-item>
            <div class="flex">
              <el-form-item prop="lastnameEmpleado1" label="Apellido paterno:" style="width:50%;">
                <el-input v-model="form1.lastnameEmpleado1" class="px-1" placeholder="Ingresa el apellido paterno" />
              </el-form-item>
              <el-form-item prop="lastnameEmpleado2" label="Apellido materno:" style="width:50%;">
                <el-input v-model="form1.lastnameEmpleado2" class="px-1" placeholder="Ingresa el apellido materno" />
              </el-form-item>
            </div>
            <div class="flex" style="width: 100%;">
              <el-form-item prop="id_departamento" label="Departamento:" class="px-2" style="width: 300px;">
                <el-select v-model="form1.id_departamento" placeholder="Selecciona el departamento:">
                  <el-option v-for="selectDepartamento in departamentos" :key="selectDepartamento.id"
                    :label="selectDepartamento.comercio" :value="selectDepartamento.id" />
                </el-select>
              </el-form-item>
            </div>
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

      <!-- MODAL 2 -->
      <el-dialog v-model="dialogVisibleEdit" title="Editar Empleado" width="50%">
        <el-form :model="formEdit" label-width="auto" style="max-width: 100%" ref="formEditRef" :rules="rules"
          :label-position="'top'">
          <div class="clientInfo">
            <div class="detailsEmployees">
              <i class="fa-solid fa-money-check-dollar fa-2x iconEmployees"></i>
              <div class="flex" style="width: 50%;">
                <el-form-item prop="ariasEmpleado" label="Fumigador:" style="width: 100%;">
                  <el-input v-model="formEdit.ariasEmpleado" class="px-1" placeholder="Ingresa el fumigador" />
                </el-form-item>
              </div>
            </div>
            <div class="detailsEmployees">
              <i class="fa-solid fa-id-card fa-2x iconEmployees"></i>
              <div class="flex" style="width: 100%;">
                <el-form-item prop="nameEmpleado" label="Nombre:" style="width: 100%;">
                  <el-input v-model="formEdit.nameEmpleado" class="px-1" placeholder="Ingresa el nombre" />
                </el-form-item>
              </div>
              <div class="flex" style="width: 100%;">
                <el-form-item prop="lastnameEmpleado1" label="Apellido paterno:" style="width: 100%;">
                  <el-input v-model="formEdit.lastnameEmpleado1" class="px-1"
                    placeholder="Ingresa el apellido paterno" />
                </el-form-item>
              </div>
              <div class="flex" style="width: 100%;">
                <el-form-item prop="lastnameEmpleado2" label="Apellido materno:" style="width: 100%;">
                  <el-input v-model="formEdit.lastnameEmpleado2" class="px-1"
                    placeholder="Ingresa el apellido materno" />
                </el-form-item>
              </div>
            </div>
            <div class="flex" style="width: 100%;">
              <el-form-item prop="id_departamento" label="Departamento:" class="px-2" style="width: 300px;">
                <el-select v-model="formEdit.id_departamento" placeholder="Selecciona el departamento:">
                  <el-option v-for="selectDepartamento in departamentos" :key="selectDepartamento.id"
                    :label="selectDepartamento.comercio" :value="selectDepartamento.id" />
                </el-select>
              </el-form-item>
            </div>
          </div>
        </el-form>
        <template #footer>
          <span class="dialog-footer">
            <el-button @click="dialogVisibleEdit = false">Cancelar</el-button>
            <el-button type="warning" @click="ediyEmpleados">Actualizar</el-button>
          </span>
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
    searchQueryNameEmpleado: '',
    searchQueryLastnameEmpleado1: '',
    searchQueryLastnameEmpleado2: '',
    searchQueryEstado: '',
    departamentos: [],
    form1: {
      ariasEmpleado: '',
      nameEmpleado: '',
      lastnameEmpleado1: '',
      lastnameEmpleado2: '',
      infodelete_Empleados: 'Alta',
      id_departamento: '',

    },
    formEdit: {
      ariasEmpleado: '',
      nameEmpleado: '',
      lastnameEmpleado1: '',
      lastnameEmpleado2: '',
    },
    rules: {
      ariasEmpleado: [
        { required: true, message: 'El arias del fumigador es requerido', trigger: 'blur' },
        { min: 1, max: 100, message: 'Longitud debería ser 1 a 100', trigger: 'blur' }
      ],
      nameEmpleado: [
        { required: true, message: 'El nombre es requerido', trigger: 'blur' },
        { min: 1, max: 100, message: 'Longitud debería ser 1 a 100', trigger: 'blur' }
      ],
      lastnameEmpleado1: [
        { required: true, message: 'El apellido paterno es requerido', trigger: 'blur' },
        { min: 1, max: 100, message: 'Longitud debería ser 1 a 100', trigger: 'blur' }
      ],
      lastnameEmpleado2: [
        { required: true, message: 'El apellido materno es requerido', trigger: 'blur' },
        { min: 1, max: 100, message: 'Longitud debería ser 1 a 100', trigger: 'blur' }
      ],
    }
  }),
  mounted() {
    this.refresh();
    this.fetchDepartamento();
  },
  methods: {
    refresh() {
      axios.get('empleados').then(res => {
        this.tableData = res.data.data;
        this.filteredData = this.tableData;
      });
    },

    handleEdit(row) {
      console.log(row);
      this.formEdit = row;
      this.dialogVisibleEdit = true;
    },

    fetchDepartamento() {
      axios.get('verDepartamento')
        .then(response => {
          console.log('Departamento:', response.data);
          this.departamentos = response.data; // Assuming the data structure is correct
        })
        .catch(error => {
          console.error('Error fetching departamento:', error);
          ElNotification({
            title: 'Error',
            message: 'Error al recuperar departamento',
            type: 'error',
          });
        });
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
          axios.post('empleados', this.form1)
            .then(res => {
              console.log(res);
              this.dialogVisibleCreate = false;
              this.refresh();
              this.$message.success('El empleado se agrego exitosamente');
              this.$refs.formRef.resetFields();
              ElNotification({
                title: 'Alerta',
                message: 'Registro insertado correctamente',
                type: 'success'
              })
            })
            .catch(error => {
              console.log(error);
              this.$message.error('Error al agregar el empleado');
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

    filterDataNameEmpleado() {
      this.filteredData = this.tableData.filter((empleados) => {
        return empleados.nameEmpleado.toLowerCase().includes(this.searchQueryNameEmpleado.toLowerCase());
      });
    },

    filterDataLastnameEmpleado1() {
      this.filteredData = this.tableData.filter((empleados) => {
        return empleados.lastnameEmpleado1.toLowerCase().includes(this.searchQueryLastnameEmpleado1.toLowerCase());
      });
    },

    filterDataLastnameEmpleado2() {
      this.filteredData = this.tableData.filter((empleados) => {
        return empleados.lastnameEmpleado2.toLowerCase().includes(this.searchQueryLastnameEmpleado2.toLowerCase());
      });
    },

    filterDataEstado() {
      this.filteredData = this.tableData.filter((empleados) => {
        return empleados.infodelete_Empleados.toLowerCase().includes(this.searchQueryEstado.toLowerCase());
      });
    },

    ediyEmpleados() {
      this.$refs.formEditRef.validate((valid) => {
        if (valid) {
          console.log('Form is valid, sending PUT request');
          axios.put('empleados/' + this.formEdit.id, this.formEdit)
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
        infodelete_Empleados: row.infodelete_Empleados === 'Baja' ? 'Alta' : 'Baja'
      };
      axios.put(`desactivarEmpleado/${row.id}`, updatedData)
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

.detailsEmployees {
  padding: 10px;
  display: flex;
  align-items: center;

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

.iconEmployees {
  color: #e6a23c;
  margin-right: 10px;
}
</style>