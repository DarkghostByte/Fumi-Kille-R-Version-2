<template>
  <!-- Importar Iconos-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <div>
    <div class="flex flex-col space-y-6 md:space-y-0 md:flex-row justify-start">

      <div class="flex flex-wrap items-start justify-end ">

        <router-link to="/admin/clients"
          class="inline-flex px-5 py-3 text-white bg-red-400 hover:bg-red-700 focus:bg-red-800 rounded-md ml-6 mb-3"
          style="color:black">
          <i class="fa fa-rotate-left" aria-hidden="true" style="margin-top: 5px;
            margin-left: -5px; margin-right:10px;"></i>
          Devolver
        </router-link>

        <router-link to="/admin/clients/agregarComercio-clients"
          class="inline-flex px-5 py-3 text-white bg-blue-400 hover:bg-blue-700 focus:bg-blue-800 rounded-md ml-6 mb-3"
          style="color:black">
          <i class="fa fa-shop" aria-hidden="true" style="margin-top: 5px;
            margin-left: -5px; margin-right:10px;"></i>
          Comercio
        </router-link>


      </div>

    </div>

    <div class="mr-6">
      <h1 class="py-6 px-2 text-4xl font-semibold mb-2">Particular</h1>
    </div>


    <!-- TABLE INSERT -->
    <!-- Primera Fila -->
    <div class="flex">
      <el-form :model="form1" label-width="auto" style="max-width: 100%" ref="formRef" :rules="rules"
        :label-position="'top'">

        <!--  Primera Fila -->
        <p class="px-5 datosCliente">Datos del cliente:</p>
        <div class="flex">
          <el-form-item prop="name" label="Nombres:" class="px-5" style="width: 240px;">
            <el-input v-model="form1.name" class="px-1" placeholder="Ingresa sus nombres" />
          </el-form-item>
          <el-form-item prop="lastname1" label="Apellidos Paterno:" class="px-5">
            <el-input v-model="form1.lastname1" class="px-1" placeholder="Ingresa su apellido paterno" />
          </el-form-item>
          <el-form-item prop="lastname2" label="Apellidos Materno:" class="px-5">
            <el-input v-model="form1.lastname2" class="px-1" placeholder="Ingresa su apellido materno" />
          </el-form-item>
          <el-form-item prop="correo" label="Correo:" class="px-5">
            <el-input v-model="form1.correo" class="" placeholder="Ingresa el correo" />
          </el-form-item>
        </div>

        <!-- Segunda Fila -->
        <p class="px-5 datosCliente">Domicilio:</p>
        <div class="flex">
          <el-form-item prop="id_vias" label="Tipo de via:" class="px-5">
            <el-select v-model="form1.id_vias" placeholder="Selecciona el tipo de via" @change="fetchTypeRoad" style="width: 150px;">
              <el-option v-for="via in vias" :key="via.id" :label="via.tipoVia" :value="via.id" />
            </el-select>
          </el-form-item>

          <el-form-item prop="home" label="Domicilio:" class="px-2" style="width: 300px;">
            <el-input v-model="form1.home" placeholder="Ingresa el domicilio" />
          </el-form-item>

          <el-form-item prop="numAddress" label="Numero de domicilio:" class=" px-2" >
            <el-input v-model="form1.numAddress" placeholder="N. de domicilio"
              type="number" style="width: auto;"/>
          </el-form-item>

          <el-form-item prop="id_city" label="Ciudad:" class="px-2">
            <el-select v-model="form1.id_city" filterable placeholder="Selecciona la ciudad" @change="fetchColoniasByCity" style="width: 200px;">
              <el-option v-for="ciudad in ciudades" :key="ciudad.id" :label="ciudad.ciudad" :value="ciudad.id" />
            </el-select>
          </el-form-item>

          <el-form-item prop="id_colonia" label="Colonia:" class="px-2">
            <el-select v-model="form1.id_colonia" filterable placeholder="Selecciona la colonia"
              style="width: 260px;" @change="selectColonia">
              <el-option v-for="colonia in filteredColonias" :key="'colonia' + colonia.id"
                :label="colonia.colonia + ' #' + colonia.codigoPostal" :value="colonia.id">
                {{ colonia.colonia }} #{{ colonia.codigoPostal }}
              </el-option>
            </el-select>
          </el-form-item>
        </div>


        <!-- Datos del domicilio Fila -->
        <p class="px-5 datosCliente">Datos del domicilio:</p>
        <div class="flex" style="">
          <el-form-item prop="how_to_get" label="Como llegar:" class="pt-2 px-5">
            <el-input v-model="form1.how_to_get" type="textarea" maxlength="100" show-word-limit
              placeholder="Agrega como llegar al domicilio" style="width: 550px;"/>
          </el-form-item>
          <el-form-item prop="description" label="Descripcion:" class="pt-2 px-5">
            <el-input v-model="form1.description" type="textarea" maxlength="100" show-word-limit
              placeholder="Agrega una descripcion" style="width: 550px;"/>
          </el-form-item>
        </div>

        <!-- Sexta Fila -->
        <p class="px-5 datosCliente">Contacto:</p>
        <div class="flex">
          <el-form-item prop="cell_phone" label="Numero de celular:" class="px-5">
            <el-input v-model="form1.cell_phone" placeholder="Celular" style="width: 220px;"/>
          </el-form-item>
          <el-form-item prop="number_fixed_number" label="Numero fijo:" class="px-5">
            <el-input v-model="form1.number_fixed_number" placeholder="Celular" style="width: 220px;"/>
          </el-form-item>
          <el-form-item prop="contact_form" label="Forma de contacto:" class="px-5">
            <el-select v-model="form1.contact_form" placeholder="Selecciona la forma" @change="fetchFormaContacto" style="width: 150px;">
              <el-option v-for="formadeContacto in formaContacto" :key="formadeContacto.id" :label="formadeContacto.formadeContacto" :value="formadeContacto.id" />
            </el-select>
          </el-form-item>
          <el-form-item prop="specify" label="Especificar:" class="px-5">
            <el-input v-model="form1.specify" placeholder="Especificar" style="width: 220px;"/>
          </el-form-item>
        </div>

        <!-- Septima fila -->
        <p class="px-5 datosCliente">Contratacion:</p>
        <div class="flex">
          <el-form-item prop="recruitment_data" label="Tipo de contratacion:" class="px-5">
            <el-checkbox-group v-model="form1.recruitment_data">
              <el-checkbox label="Nada" value="Nada"></el-checkbox>
              <el-checkbox label="Presupuesto" value="Presupuesto"></el-checkbox>
              <el-checkbox label="Fumigar" value="Fumigar"></el-checkbox>
              <el-checkbox label="Garantia" value="Garantia"></el-checkbox>
              <el-checkbox label="Cortesia" value="Cortesia"></el-checkbox>
            </el-checkbox-group>
          </el-form-item>
        </div>

        <p class="px-5 datosCliente">Requiere de:</p>
        <div class="flex">
          <el-form-item prop="requires" label="" class="px-5">
            <el-checkbox-group v-model="form1.requires" label="Requiere de">
              <el-checkbox label="Nada" value="Nada"></el-checkbox>
              <el-checkbox label="Factura" value="Factura"></el-checkbox>
              <el-checkbox label="Certificado" value="Certificado"></el-checkbox>
              <el-checkbox label="Remision" value="Remision"></el-checkbox>
            </el-checkbox-group>
          </el-form-item>
        </div>

        <div style="color:white; display:flex; justify-content: center; transition:10s;">
          <div style="color:white; display:flex; justify-content: center; transition:10s;">
            <el-form-item>
              <el-button type="primary" @click="submitForm">Guardar</el-button>
              <el-button @click="resetForm">Reset</el-button>
            </el-form-item>
          </div>
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
  name: 'AdminHomeComponent',
  data: () => ({
    formRef: undefined,
    uploadRef: undefined,
    url: process.env.VUE_APP_ROOT_ASSETS,
    urlApi: process.env.VUE_APP_ROOT_API,
    ciudades: [],
    colonias: [],
    vias: [],
    formaContacto: [],
    form1: {
      name: '',
      lastname1: '',
      lastname2: '',
      tradename: 'Particular',
      correo: 'Ninguno',
      id_vias: '',
      home: '',
      numAddress: '',
      id_colonia: '',
      id_city: '',
      comercio: 'Particular',
      description: '',
      how_to_get: '',
      cell_phone: '',
      number_fixed_number: 'Ninguno',
      contact_form: '',
      specify: 'Ninguno',
      recruitment_data: [],
      infoclient_delete: 'Alta',
      requires: [],
    },
    filteredColonias: [],
    loadingColonias: false,
    rules: {

      name: [
        { required: true, message: 'El nombre es requerido', trigger: 'blur' },
        { min: 1, max: 100, message: 'Longitud debería ser 1 a 100', trigger: 'blur' }
      ],
      lastname1: [
        { required: true, message: 'El apellido paterno es requerido', trigger: 'blur' },
        { min: 1, max: 100, message: 'Longitud debería ser 1 a 100', trigger: 'blur' }
      ],
      lastname2: [
        { required: true, message: 'El apellido materno es requerido', trigger: 'blur' },
        { min: 1, max: 100, message: 'Longitud debería ser 1 a 100', trigger: 'blur' }
      ],
      id_vias: [
        { required: true, message: 'El tipo de calle es requerido', trigger: 'blur' },
      ],
      home: [
        { required: true, message: 'El domilicio es requerido', trigger: 'blur' },
        { min: 1, max: 100, message: 'Longitud debería ser 1 a 100', trigger: 'blur' }
      ],
      numAddress: [
        { required: true, message: 'El numero de domilicio es requerido', trigger: 'blur' },
        { min: 1, max: 100, message: 'Longitud debería ser 1 a 100', trigger: 'blur' }
      ],
      id_colonia: [
        { required: true, message: 'La colonia es requerido', trigger: 'blur' },
      ],
      id_city: [
        { required: true, message: 'La ciudad es requerido', trigger: 'blur' },
      ],
      description: [
        { required: true, message: 'La descripcion es requerido', trigger: 'blur' },
        { min: 1, max: 200, message: 'Longitud debería ser 1 a 200', trigger: 'blur' }
      ],
      how_to_get: [
        { required: true, message: 'Como llegar es requerido', trigger: 'blur' },
        { min: 1, max: 200, message: 'Longitud debería ser 1 a 200', trigger: 'blur' }
      ],
      cell_phone: [
        { required: true, message: 'El numero de celular es requerido', trigger: 'blur' },
        { min: 10, max: 13, message: 'Longitud debería ser 10 a 13', trigger: 'blur' }
      ],
      contact_form: [
        { required: true, message: 'La forma de contacto es requerida', trigger: 'blur' },
      ],
      recruitment_data: [
        { required: true, message: 'Requiere de es requerido', trigger: 'blur' },
      ],
      requires: [
        { required: true, message: 'Requiere de deberia ser requerido', trigger: 'blur' },
      ],
    }

  }),
  mounted() {
    this.refresh();
    this.fetchCiudades();
    this.fetchTypeRoad();
    this.fetchFormaContacto();
  },
  methods: {
    errorUpload(error) {
      console.log(error)
    },
    refresh() {
      this.tableData = []
      axios.get('clientes').then(res => {
        this.tableData = res.data.data
      })
    },
    successUpload(response) {
      console.log(response)
      this.refresh()
      axios.post('clientes', this.form1).then(response => {
        console.log('Form submitted successfully:', response.data)
        console.log(response)
        this.$router.push('/admin/clients');
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
    submitForm() {
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
      })
    },
    resetForm() {
      this.$refs.formRef.resetFields();
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
    
    fetchTypeRoad() {
      axios.get('verVias')
        .then(response => {
          console.log('Via:', response.data);
          this.vias = response.data;
        })
        .catch(error => {
          console.error('Error fetching vias:', error);
        });
    },

    fetchFormaContacto() {
      axios.get('verFormaDeContacto')
        .then(response => {
          console.log('Forma de contacto:', response.data);
          this.formaContacto = response.data;
        })
        .catch(error => {
          console.error('Error fetching vias:', error);
        });
    },
    
    fetchColoniasByCity(cityId) {
  this.loadingColonias = true;
  axios.get(`verColoniaPorCiudad/${cityId}`) // Use template literal
    .then(response => {
      console.log('Respuesta de la API:', response.data); // Check response data
      this.filteredColonias = response.data.data;
      console.log('Filtered Colonias:', this.filteredColonias); // Verify data is assigned
    })
    .catch(error => {
      console.error('Error fetching colonias:', error);
      this.$message.error('Error al cargar las colonias. Por favor, inténtalo de nuevo.');
    })
    .finally(() => {
      this.loadingColonias = false;
    });
}
  }
}
</script>

<style>
.datosCliente{
  font-size: 20px;
  font-weight: bold;
}
</style>