<template>
  <!-- Importar Iconos-->
  <link rel="stylesheet" href=""
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <div>
    <div class="flex flex-col space-y-6 md:space-y-0 md:flex-row justify-start">

      <div class="flex flex-wrap items-start justify-end ">

        <router-link to="/admin/ordenCompra"
          class="inline-flex px-5 py-3 text-white bg-red-400 hover:bg-red-700 focus:bg-red-800 rounded-md ml-6 mb-3"
          style="color:black">
          <i class="fa fa-rotate-left" aria-hidden="true" style="margin-top: 5px;
            margin-left: -5px; margin-right:10px;"></i>
          Devolver
        </router-link>

      </div>

    </div>

    <div class="mr-6">
      <h1 class="py-6 px-2 text-4xl font-semibold mb-2">Nueva Orden De Compra</h1>
    </div>


    <!-- TABLE INSERT -->

    <!-- DATOS DEL LA TABLA -->
    <div class="flex">
      <el-form :model="form1" label-width="auto" style="max-width: 100%" ref="formRef" :rules="rules"
        :label-position="'top'">

        <!--  FILA DATOS DEL CLIENTE -->
        <p class="px-5">Datos de la orden de compra:</p>
        <div class="flex">
          <el-form-item prop="fechaOrdenCompra" label="Fecha:" class="px-5" style="width: 240px;">
            <el-input v-model="form1.fechaOrdenCompra" class="px-1" placeholder="Ingresa la fecha" />
          </el-form-item>
          <el-form-item prop="paraOrdenCompra" label="Para:" class="px-5">
            <el-input v-model="form1.paraOrdenCompra" class="px-1" placeholder="Ingresa para quien" />
          </el-form-item>
          <el-form-item prop="conceptoOrdenCompra" label="Concepto:" class="px-5">
            <el-input v-model="form1.conceptoOrdenCompra" class="px-1" placeholder="Ingresa el concepto" />
          </el-form-item>
        </div>

        <div class="flex">
          <el-form-item prop="detalleOrdenCompra" label="Detalles:" class="px-5">
            <el-input v-model="form1.detalleOrdenCompra" class="" placeholder="Ingresa el detalle" />
          </el-form-item>
          <el-form-item prop="empleadoOrdenCompra" label="Empleado:" class="px-5">
            <el-input v-model="form1.empleadoOrdenCompra" class="" placeholder="Ingresa el empleado" />
          </el-form-item>
          <el-form-item prop="importeOrdenCompra" label="Importe:" class="px-5">
            <el-input v-model="form1.importeOrdenCompra" class="" placeholder="Ingresa el importe" />
          </el-form-item>
        </div>

        <div class="flex">
          <el-form-item prop="autorizoOrdenCompra" label="Autorizo:" class="px-5">
            <el-input v-model="form1.autorizoOrdenCompra" class="" placeholder="Quien lo autorizo" />
          </el-form-item>
        </div>

        <div style="color:white; display:flex; justify-content: center; transition:10s;">
          <el-form-item>
            <el-button type="primary" @click="submitForm">Guardar</el-button>
            <el-button @click="resetForm">Reset</el-button>
          </el-form-item>
        </div>
      </el-form>
    </div>
    <!-- END TABLE DATA -->
  </div>

</template>

<script>
import { ElNotification } from 'element-plus';
import axios from 'axios';

export default {
  name: 'AdminAddClientsComponent',
  data: () => ({
    formRef: undefined,
    uploadRef: undefined,
    url: process.env.VUE_APP_ROOT_ASSETS,
    urlApi: process.env.VUE_APP_ROOT_API,
    form1: {
      fechaOrdenCompra: '',
      paraOrdenCompra: '',
      conceptoOrdenCompra: '',
      detalleOrdenCompra: '',
      empleadoOrdenCompra: '',
      importeOrdenCompra: '',
      autorizoOrdenCompra: '',
    },
    rules: {
      fechaOrdenCompra: [
        { required: true, message: 'El nombre es requerido', trigger: 'blur' },
        { min: 1, max: 100, message: 'Longitud debería ser 1 a 100', trigger: 'blur' }
      ],
      paraOrdenCompra: [
        { required: true, message: 'El apellido paterno es requerido', trigger: 'blur' },
        { min: 1, max: 100, message: 'Longitud debería ser 1 a 100', trigger: 'blur' }
      ],
      conceptoOrdenCompra: [
        { required: true, message: 'El apellido materno es requerido', trigger: 'blur' },
        { min: 1, max: 100, message: 'Longitud debería ser 1 a 100', trigger: 'blur' }
      ],
      detalleOrdenCompra: [
        { required: true, message: 'El comercio es requerido', trigger: 'blur' },
        { min: 1, max: 100, message: 'Longitud debería ser 1 a 100', trigger: 'blur' }
      ],
      empleadoOrdenCompra: [
        { required: true, message: 'El correo es requerido', trigger: 'blur' },
        { min: 1, max: 100, message: 'Longitud debería ser 1 a 100', trigger: 'blur' }
      ],
      importeOrdenCompra: [
        { required: true, message: 'El tipo de calle es requerido', trigger: 'blur' },
        { min: 1, max: 100, message: 'Longitud debería ser 1 a 100', trigger: 'blur' }
      ],
      autorizoOrdenCompra: [
        { required: true, message: 'El domicilio es requerido', trigger: 'blur' },
        { min: 1, max: 100, message: 'Longitud debería ser 1 a 100', trigger: 'blur' }
      ],
    }
  }),

  mounted() {
    this.refresh();
  },
  methods: {
    errorUpload(error) {
      console.log(error);
    },
    refresh() {
      this.tableData = [];
      axios.get('ordenCompra').then(res => {
        this.tableData = res.data.data;
      });
    },

    submitForm() {
      this.$refs.formRef.validate((valid) => {
        if (valid) {
          axios.post('ordenCompra', this.form1)
            .then(response => {
              console.log('Form submitted successfully:', response.data);
              this.$router.push('/admin/ordenCompra');
              ElNotification({
                title: 'Alerta',
                message: 'Registro insertado correctamente',
                type: 'success'
              })
            })
            .catch(error => {
              console.error('Error submitting form:', error);
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
    resetForm() {
      this.$refs.formRef.resetFields();
    },
  },
}

</script>