<template>
  <!-- Importar Iconos-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
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
      <h1 class="py-6 px-2 text-4xl font-semibold mb-2">Modificar orden de compra</h1>
    </div>


    <!-- TABLE INSERT -->
    <!-- TABLE DATA -->
    <div class="flex ml-5">
      <el-form :model="form" label-width="auto" style="max-width: 100%" :label-position="'top'" ref="formRef"
        :rules="rules">
        <!--  FILA DATOS DEL CLIENTE -->
        <p class="px-5">Datos de la orden de compra:</p>
        <div class="flex">
          <el-form-item prop="fechaOrdenCompra" label="Fecha:" class="px-5" style="width: 240px;">
            <el-input v-model="form.fechaOrdenCompra" class="px-1" placeholder="Ingresa la fecha" />
          </el-form-item>
          <el-form-item prop="paraOrdenCompra" label="Para:" class="px-5">
            <el-input v-model="form.paraOrdenCompra" class="px-1" placeholder="Ingresa para quien" />
          </el-form-item>
          <el-form-item prop="conceptoOrdenCompra" label="Concepto:" class="px-5">
            <el-input v-model="form.conceptoOrdenCompra" class="px-1" placeholder="Ingresa el concepto" />
          </el-form-item>
        </div>

        <div class="flex">
          <el-form-item prop="detalleOrdenCompra" label="Detalles:" class="px-5">
            <el-input v-model="form.detalleOrdenCompra" class="" placeholder="Ingresa el detalle" />
          </el-form-item>
          <el-form-item prop="empleadoOrdenCompra" label="Empleado:" class="px-5">
            <el-input v-model="form.empleadoOrdenCompra" class="" placeholder="Ingresa el empleado" />
          </el-form-item>
          <el-form-item prop="importeOrdenCompra" label="Importe:" class="px-5">
            <el-input v-model="form.importeOrdenCompra" class="" placeholder="Ingresa el importe" />
          </el-form-item>
        </div>

        <div class="flex">
          <el-form-item prop="autorizoOrdenCompra" label="Autorizo:" class="px-5">
            <el-input v-model="form.autorizoOrdenCompra" class="" placeholder="Quien lo autorizo" />
          </el-form-item>
        </div>

        <div style="color:white; display:flex; justify-content: center; transition:10s;">
          <el-form-item>
            <el-button type="primary" @click="updateDatos">Modificar</el-button>
          </el-form-item>
        </div>
      </el-form>
    </div>
    <!-- END TABLE DATA -->
  </div>

</template>

<script>
import { useRoute } from 'vue-router';
import { ElNotification } from 'element-plus';
import axios from 'axios';

export default {
  name: 'AdminEditWorksCompleteComponent',
  data: () => ({
    tableData: [],
    formRef: undefined,
    uploadRef: undefined,
    url: process.env.VUE_APP_ROOT_ASSETS,
    urlApi: process.env.VUE_APP_ROOT_API,
    form: {
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
    const route = useRoute();
    this.id = route.params.id;
    axios.get(`ordenCompra/${this.id}`).then(res => {
      console.log(res);
      let datos = res.data.data;
      if (datos) {
        this.form.fechaOrdenCompra = datos.fechaOrdenCompra || '';
        this.form.paraOrdenCompra = datos.paraOrdenCompra || '';
        this.form.conceptoOrdenCompra = datos.conceptoOrdenCompra || '';
        this.form.detalleOrdenCompra = datos.detalleOrdenCompra || '';
        this.form.empleadoOrdenCompra = datos.empleadoOrdenCompra || '';
        this.form.importeOrdenCompra = datos.importeOrdenCompra || '';
        this.form.autorizoOrdenCompra = datos.autorizoOrdenCompra || '';
      }
    });
  },

  methods: {
    refresh() {
      this.tableData = []
      axios.get('ordenCompra').then(res => {
        this.tableData = res.data.data
      })
    },
    successUpload(response) {
      console.log('Datos enviados:', this.form)
      console.log(response)
      this.refresh()
      axios.patch('ordenCompra/' + this.id, this.form).then(response => {
        console.log('Form submitted successfully:', response.data)
        console.log(response)
        this.$router.push('/admin/ordenCompra');
        ElNotification({
          title: 'Alerta',
          message: 'Registro insertado correctamente',
          type: 'success'
        })
      }).catch(error => {
        console.log(error)
        ElNotification({
          title: 'Error',
          message: 'Favor de llenar los campos',
          type: 'error'
        })
      })
    },
    updateDatos() {
      this.$refs.formRef.validate((valid, fields) => {
        if (valid) {
          console.log(fields);
          this.successUpload();
        } else {
          console.log('Validation failed');
          ElNotification({
            title: 'Error',
            message: 'Favor de llenar los campos',
            type: 'error'
          })
          return false;
        }
      });
    },

  },
}
</script>
