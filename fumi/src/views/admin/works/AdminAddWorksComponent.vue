<template>
  <!-- Importar Iconos-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <div>
    <div class="flex flex-col space-y-6 md:space-y-0 md:flex-row justify-start">
      <div class="flex flex-wrap items-start justify-end">
        <router-link to="/admin/clients"
          class="inline-flex px-5 py-3 text-white bg-red-400 hover:bg-red-700 focus:bg-red-800 rounded-md ml-6 mb-3"
          style="color:black">
          <i class="fa fa-rotate-left" aria-hidden="true"
            style="margin-top: 5px; margin-left: -5px; margin-right:10px;"></i>
          Devolver
        </router-link>
      </div>
    </div>
    <div class="mr-6">
      <h1 class="text-4xl font-semibold mb-2">Orden de trabajo</h1>
      <p style="font-size: 24px;"> Cliente: {{ form.name + ' ' + form.lastname1 + ' ' + form.lastname2 }}</p>
      <p style="font-size: 24px;">Negocio: {{ form.tradename }}</p>

    </div>

    <!-- DATOS DE LA FILA DE CLIENTES -->

    <br>
    <!-- TABLE DATA -->
    <div class="flex ml-5">
      <el-form :model="form" label-width="auto" style="max-width: 100%" :label-position="'top'" ref="formRef"
        :rules="rules">


        <!-- FILA DE LAS DOSIS -->
        <p class="ordenDatos1">Dosis</p>
        <div class="flex" style="width:100%;">
          <el-form-item prop="nDosis" label="Otra dosis" class="px-2">
            <el-radio-group v-model="form.nDosis">
              <el-radio label="1ra Dosis" value="1ra Dosis" border />
              <el-radio label="2da Dosis" value="2da Dosis" border />
              <el-radio label="3ra Dosis" value="3ra Dosis" border />
              <el-radio label="4ta Dosis" value="4ta Dosis" border />
              <el-input v-model="form.nDosis" class="" placeholder="Ingresa el numero de dosis" style="width:250px;" />
            </el-radio-group>
          </el-form-item>
        </div>

        <!-- FILA DE LAS PLAGAS (PROBLEMATICA) -->
        <p class="ordenDatos1">Problematica</p>
        <div class="flex" style="width:100%;">
          <el-form-item prop="id_plague1" label="Problematica #1:" class="px-2" style="width: 300px;">
            <el-select v-model="form.id_plague1" filterable placeholder="Selecciona la problematica:">
              <el-option v-for="problematicaBug in problematicas1" :key="problematicaBug.id"
                :label="problematicaBug.problematica" :value="problematicaBug.id" />
            </el-select>
          </el-form-item>

          <el-form-item prop="id_plague2" label="Problematica #2:" class="px-2" style="width: 300px;">
            <el-select v-model="form.id_plague2" filterable placeholder="Selecciona la problematica:">
              <el-option v-for="problematicaBug2 in problematicas2" :key="problematicaBug2.id"
                :label="problematicaBug2.problematica" :value="problematicaBug2.id" />
            </el-select>
          </el-form-item>
        </div>

        <!-- FILA DE FECHAS -->
        <p class="ordenDatos1">Fecha</p>
        <div class="flex">
          <el-form-item prop="date1" class="px-2" label="Fecha de orden:">
            <el-col :span="11" style="width: 220px">
              <el-date-picker v-model="form.date1" type="date" placeholder="Orden" format="DD/MM/YYYY"
                value-format="DD-MM-YYYY" />
            </el-col>
          </el-form-item>
          <el-form-item prop="date2" class="px-7" label="Fecha para asistir:">
            <el-col :span="11" style="width: 220px">
              <el-date-picker v-model="form.date2" type="date" placeholder="Orden" format="DD/MM/YYYY"
                value-format="DD-MM-YYYY" />
            </el-col>
          </el-form-item>
        </div>

        <!-- FILA DE Hora -->
        <p class="ordenDatos1">Hora</p>
        <div class="flex">
          <el-form-item prop="time1" class="px-2" label="De hora:">
            <el-col :span="11" style="width: 220px">
              <el-time-select v-model="form.time1" style="width: 220px" start="06:00" step="00:15" end="23:00"
                format="hh:mm" placeholder="Seleccionar hora" />
            </el-col>
          </el-form-item>
          <el-form-item prop="time2" class="px-7" label="A hora:">
            <el-col :span="11" style="width: 220px">
              <el-time-select v-model="form.time2" style="width: 220px" start="06:00" step="00:15" end="23:00"
                format="hh:mm" placeholder="Seleccionar hora" />
            </el-col>
          </el-form-item>
          <el-form-item prop="infoorden_cell" label="Hablar antes de ir?" class="px-10">
            <el-radio-group v-model="form.infoorden_cell">
              <el-radio value="Si" size="large" border>Si</el-radio>
              <el-radio value="No" size="large" border>No</el-radio>
            </el-radio-group>
          </el-form-item>
        </div>

        <!-- FILA DE TIPO DE CONTRATACION -->
        <p class="ordenDatos1">Contratacion:</p>
        <div class="flex">
          <el-form-item prop="hiring" label="" class="px-2">
            <el-checkbox-group v-model="form.hiring">
              <el-checkbox label="Nada" value="Nada"></el-checkbox>
              <el-checkbox label="Presupuesto" value="Presupuesto"></el-checkbox>
              <el-checkbox label="Fumigar" value="Fumigar"></el-checkbox>
              <el-checkbox label="Garantia" value="Garantia"></el-checkbox>
              <el-checkbox label="Cortesia" value="Cortesia"></el-checkbox>
            </el-checkbox-group>
          </el-form-item>
        </div>

        <!-- FILA DE REQUIERE DE -->
        <p class="ordenDatos1">Requiere de:</p>
        <div class="flex">
          <el-form-item prop="infoorden_certificate" label="El cliente necesita certificado?" class="px-2">
            <!--<el-input v-model="form.infoorden_certificate" placeholder="Ingresa sus nombres" />-->
            <el-radio-group v-model="form.infoorden_certificate">
              <el-radio value="Si" size="large" border>Si</el-radio>
              <el-radio value="No" size="large" border>No</el-radio>
            </el-radio-group>
          </el-form-item>

          <el-form-item prop="infoorden_remision" label="El cliente necesita remision?" class="px-4">
            <el-radio-group v-model="form.infoorden_remision">
              <el-radio value="Si" size="large" border>Si</el-radio>
              <el-radio value="No" size="large" border>No</el-radio>
            </el-radio-group>
          </el-form-item>

          <el-form-item prop="infoorden_facturacion" label="El cliente necesita facturacion?" class="px-4">
            <el-radio-group v-model="form.infoorden_facturacion">
              <el-radio value="Si" size="large" border>Si</el-radio>
              <el-radio value="No" size="large" border>No</el-radio>
            </el-radio-group>
          </el-form-item>
        </div>

        <div style="color:white; display:flex; justify-content: center; transition:10s;">
          <el-form-item>
            <el-button type="primary" :disabled="isCreating" @click="submitForm">{{ isCreating ? 'Guardando...' :
              'Guardar' }}</el-button>
          </el-form-item>
        </div>
      </el-form>
    </div>
    <!-- END TABLE DATA -->
  </div>
</template>

<script>
import { ElNotification } from 'element-plus';
import { useRoute } from 'vue-router';
import axios from 'axios';
export default {
  name: 'AdminAddWorksComponent',
  data: () => ({
    tableData: [],
    formRef: undefined,
    uploadRef: undefined,
    url: process.env.VUE_APP_ROOT_ASSETS,
    urlApi: process.env.VUE_APP_ROOT_API,
    isCreating: false,
    problematicas1: [],
    problematicas2: [],
    form: {
      name: '',
      id_plague1: '',
      id_plague2: 1,
      date1: '',
      date2: '',
      time1: '',
      time2: '',
      hiring: [],
      infoorden_delete: 'Alta',
      statusOrder: 'Por realizar',
      infoorden_certificate: 'No',
      infoorden_remision: 'No',
      infoorden_facturacion: 'No',
      infoorden_cell: 'No',
      nDosis: '1ra Dosis',
    },
    rules: {
      id_plague1: [
        { required: true, message: 'El tipo de plaga es requerida', trigger: 'blur' },
      ],
      date1: [
        { required: true, message: 'La fecha deberia ser requerida', trigger: 'blur' },
      ],
      date2: [
        { required: true, message: 'La fecha deberia ser requerida', trigger: 'blur' },
      ],
      time1: [
        { required: true, message: 'La hora deberia ser requerida', trigger: 'blur' },
      ],
      time2: [
        { required: true, message: 'La hora deberia ser requerida', trigger: 'blur' },
      ],
      hiring: [
        { required: true, message: 'La contratacion deberia ser requeriada', trigger: 'blur' },
      ],
      infoorden_certificate: [
        { required: true, message: 'Este campo es requeriado', trigger: 'blur' },
      ],
      infoorden_remision: [
        { required: true, message: 'Este campo es requeriado', trigger: 'blur' },
      ],
      infoorden_facturacion: [
        { required: true, message: 'Este campo es requeriado', trigger: 'blur' },
      ],
      nDosis: [
        { required: true, message: 'Este campo es requeriado', trigger: 'blur' },
      ],
    }
  }),
  mounted() {
    if(!localStorage.getItem("token")){
      this.$router.push("/auth/index");
    }
    this.fetchProblematicaBug();
    this.fetchProblematicaBug2();
    this.refresh();
    const route = useRoute();
    this.id = route.params.id;
    axios.get('clientes/' + this.id).then(res => {
      console.log(res);
      let datos = res.data.data;
      const clienteData = res.data.data;
      this.form.id_cliente = clienteData.id;
      this.form.name = datos.name;
      this.form.lastname1 = datos.lastname1;
      this.form.lastname2 = datos.lastname2;
      this.form.tradename = datos.tradename;
    })
  },
  methods: {
    errorUpload(error) {
      console.log(error);
    },
    refresh() {
      this.tableData = [];
      axios.get('orden').then(res => {
        this.tableData = res.data.data;
      })
    },
    successUpload(response) {
      console.log(response);
      this.refresh();
      this.$router.push('/admin/works');
      ElNotification({
        title: 'Alerta',
        message: 'Registro insertado correctamente',
        type: 'success'
      });
    },
    submitForm() {
      this.$refs.formRef.validate((valid, fields) => {
        if (valid) {
          console.log(fields);
          this.isCreating = true
          axios.post('orden', this.form).then(response => {
            this.successUpload(response);
          }).catch(error => {
            console.log(error);
            ElNotification({
              title: 'Error',
              message: 'Favor de llenar los campos',
              type: 'error'
            });
          }).finally(() => {
            this.isCreating = false; // Habilitar el botón nuevamente
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
      })
    },
    fetchProblematicaBug() {
      axios.get('verProblematicas')
        .then(response => {
          console.log('Problematicas:', response.data);
          this.problematicas1 = response.data;
        })
        .catch(error => {
          console.error('Error fetching problematica:', error);
          ElNotification({
            title: 'Error',
            message: 'Error al recuperar problematicas',
            type: 'error',
          });
        });
    },

    fetchProblematicaBug2() {
      axios.get('verProblematicas')
        .then(response => {
          console.log('Problematicas:', response.data);
          this.problematicas2 = response.data; // Assuming the data structure is correct
        })
        .catch(error => {
          console.error('Error fetching problematica:', error);
          ElNotification({
            title: 'Error',
            message: 'Error al recuperar problematicas',
            type: 'error',
          });
        });
    },
  }
}
</script>

<style>
.ordenCliente1 {
  font-size: 28px;
  font-weight: bold;
  text-transform: capitalize;
}

.ordenDatos1 {
  font-size: 20px;
  font-weight: bold;
}
</style>