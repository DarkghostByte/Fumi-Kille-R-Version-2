<template>
  <!-- Importar Iconos-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  <div>
    <div class="container mx-auto px-4">

      <!-- INICIO -->
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

      <!-- END INICIO -->

      <!-- TABLE -->
      <div class="flex" style="justify-content: center;">
        <el-table :data="filteredData" :default-sort="{ prop: 'name', order: 'descending' }" style="width: 40%" stripe>
          <!--BOTON PARA VISUALIZAR EL PDF DE CERTIFICADO-->
          <el-table-column label="">
            <template #default="scope">
              <el-button style="color:black" size="small" type="success" @click="pdf(scope.row)">
                <a :href="url + 'api/verEstadoCertificado/' + scope.row.id" target="_blank">
                  <span class="material-symbols-outlined">lab_profile</span>
                </a>
              </el-button>
            </template>
          </el-table-column>
          <!--FIN DEL BOTON PARA VISUALIZAR EL PDF DE CERTIFICADO-->

          <!--VISUALIZACION DE LA TABLA-->
          <el-table-column prop="formadeContacto" label="Forma de contacto" sortable width="auto" />
          <el-table-column prop="infodelete_Forma" label="Estado" sortable width="auto" />
          <!--FIN DE LA VISUALIZACION DE LA TABLA-->
        </el-table>
      </div>
      <!-- END TABLE -->

      <!-- MODAL 1 -->
      <el-dialog v-model="dialogVisibleCreate" title="Agregar nueva forma de contacto" width="20%">
        <el-form :model="form1" label-width="auto" style="max-width: 100%" ref="formRef" :rules="rules" :label-position="'top'">
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
      <!-- END MODAL 1 -->

      <!-- MODAL 2 -->
      <el-dialog v-model="dialogVisibleView" title="Datos del cliente" width="600" height="500">
        <div class="clientInfo">
          <div class="details">
            <i class="fa fa-user fa-2x iconInfo"></i>
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
            <div>
              <p>
                <strong>Domicilio:</strong> {{ selectedItem.street }} {{ selectedItem.home }} #{{
                  selectedItem.numAddress
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
  data() {
    return {
      dialogVisibleCreate: false,
      form1: {
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
