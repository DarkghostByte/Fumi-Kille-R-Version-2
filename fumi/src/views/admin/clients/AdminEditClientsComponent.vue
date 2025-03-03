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

      </div>

    </div>

    <div class="mr-6">
      <h1 class="py-6 px-2 text-4xl font-semibold mb-2">Modificar cliente</h1>
    </div>


    <!-- TABLE INSERT -->
    <!-- Primera Fila -->
    <div class="flex">
      <el-form :model="form" label-width="auto" style="max-width: 100%" ref="formRef" :rules="rules"
        :label-position="'top'">

        <!--  FILA DATOS DEL CLIENTE -->
        <p class="px-5 datosCliente2">Datos del cliente:</p>
        <div class="flex">
          <el-form-item prop="name" label="Nombres:" class="px-5" style="width: 240px;">
            <el-input v-model="form.name" class="px-1" placeholder="Ingresa sus nombres" />
          </el-form-item>
          <el-form-item prop="lastname1" label="Apellidos Paterno:" class="px-5">
            <el-input v-model="form.lastname1" class="px-1" placeholder="Ingresa su apellido paterno" />
          </el-form-item>
          <el-form-item prop="lastname2" label="Apellidos Materno:" class="px-5">
            <el-input v-model="form.lastname2" class="px-1" placeholder="Ingresa su apellido materno" />
          </el-form-item>
          <el-form-item prop="correo" label="Correo:" class="px-5">
            <el-input v-model="form.correo" class="" placeholder="Ingresa el correo" />
          </el-form-item>
        </div>

        <!--  FILA DATOS DEL negocio -->
        <p class="px-5 datosCliente2">Datos del negocio:</p>
        <div class="flex">
          <el-form-item prop="tradename" label="Nombre Comercial:" class="px-5" style="width: 400px;">
            <el-input v-model="form.tradename" class="" placeholder="Ingresa el nombre del comercio" />
          </el-form-item>
          <el-form-item prop="comercio" label="Tipo de comercio:" class="px-5" style="width: 350px;">
            <el-input v-model="form.comercio" class="px-1" placeholder="Ingresa el comercio" />
          </el-form-item>
        </div>

        <!-- Segunda Fila -->
        <p class="px-5 datosCliente2">Domicilio:</p>
        <div class="flex">
          <el-form-item prop="id_vias" label="Tipo de via:" class="px-5">
            <el-select v-model="form.id_vias" placeholder="Selecciona el tipo de via" @change="fetchTypeRoad"
              style="width: 150px;">
              <el-option v-for="via in vias" :key="via.id" :label="via.tipoVia" :value="via.id" />
            </el-select>
          </el-form-item>

          <el-form-item prop="home" label="Domicilio:" class="px-2" style="width: 300px;">
            <el-input v-model="form.home" placeholder="Ingresa el domicilio" />
          </el-form-item>

          <el-form-item prop="numAddress" label="Numero de domicilio:" class=" px-2">
            <el-input v-model="form.numAddress" placeholder="N. de domicilio" type="number" style="width: auto;" />
          </el-form-item>

          <el-form-item prop="id_city" label="Ciudad:" class="px-2">
            <el-select v-model="form.id_city" filterable placeholder="Selecciona la ciudad"
              @change="fetchColoniasByCity" style="width: 200px;">
              <el-option v-for="ciudad in ciudades" :key="ciudad.id" :label="ciudad.ciudad" :value="ciudad.id" />
            </el-select>
          </el-form-item>

          <el-form-item prop="id_colonia" label="Colonia:" class="px-2">
            <el-select v-model="form.id_colonia" filterable placeholder="Selecciona la colonia" style="width: 260px;"
              @change="selectColonia">
              <el-option v-for="colonia in colonias" :key="'colonia' + colonia.id"
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
            <el-input v-model="form.how_to_get" type="textarea" maxlength="100" show-word-limit
              placeholder="Agrega como llegar al domicilio" style="width: 550px;" />
          </el-form-item>
          <el-form-item prop="description" label="Descripcion:" class="pt-2 px-5">
            <el-input v-model="form.description" type="textarea" maxlength="100" show-word-limit
              placeholder="Agrega una descripcion" style="width: 550px;" />
          </el-form-item>
        </div>

        <!-- Sexta Fila -->
        <p class="px-5" datosCliente2>Contacto:</p>
        <div class="flex">
          <el-form-item prop="cell_phone" label="Numero de celular:" class="px-5">
            <el-input v-model="form.cell_phone" placeholder="Celular" style="width: 220px;" />
          </el-form-item>
          <el-form-item prop="number_fixed_number" label="Numero fijo:" class="px-5">
            <el-input v-model="form.number_fixed_number" placeholder="Celular" style="width: 220px;" />
          </el-form-item>
          <el-form-item prop="contact_form" label="Forma de contacto:" class="px-5">
            <el-select v-model="form.contact_form" placeholder="Selecciona la forma" @change="fetchFormaContacto"
              style="width: 150px;">
              <el-option v-for="formadeContacto in formaContacto" :key="formadeContacto.id"
                :label="formadeContacto.formadeContacto" :value="formadeContacto.id" />
            </el-select>
          </el-form-item>
          <el-form-item prop="specify" label="Especificar:" class="px-5">
            <el-input v-model="form.specify" placeholder="Especificar" style="width: 220px;" />
          </el-form-item>
        </div>

        <!-- Septima Fila -->
        <p class="px-5 datosCliente2">Contratacion:</p>
        <div class="flex">
          <el-form-item prop="recruitment_data" label="Tipo de contratacion:" class="px-5">
            <el-checkbox-group v-model="form.recruitment_data">
              <el-checkbox label="Nada" value="Nada"></el-checkbox>
              <el-checkbox label="Presupuesto" value="Presupuesto"></el-checkbox>
              <el-checkbox label="Fumigar" value="Fumigar"></el-checkbox>
              <el-checkbox label="Garantia" value="Garantia"></el-checkbox>
              <el-checkbox label="Cortesia" value="Cortesia"></el-checkbox>
            </el-checkbox-group>
          </el-form-item>
        </div>

        <p class="px-5 datosCliente2">Requiere de:</p>
        <div class="flex">
          <el-form-item prop="requires" label="" class="px-5">
            <el-checkbox-group v-model="form.requires" label="Requiere de">
              <el-checkbox label="Nada" value="Nada"></el-checkbox>
              <el-checkbox label="Factura" value="Factura"></el-checkbox>
              <el-checkbox label="Certificado" value="Certificado"></el-checkbox>
              <el-checkbox label="Remision" value="Remision"></el-checkbox>
            </el-checkbox-group>
          </el-form-item>
        </div>

        <div style="color:white; display:flex; justify-content: center; transition:10s;">
          <el-form-item>
            <el-button type="primary" :disabled="isCreating" @click="updateDatos">{{ isCreating ? 'Actualizando...' :
              'Actualizar' }}</el-button>

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
  name: 'AdminEditClientComponent',
  data: () => ({
    formRef: undefined,
    uploadRef: undefined,
    url: process.env.VUE_APP_ROOT_ASSETS,
    urlApi: process.env.VUE_APP_ROOT_API,
    isCreating: false,
    ciudades: [],
    colonias: [],
    formaContacto: [],
    vias: [],
    form: {
      name: '',
      lastname1: '',
      lastname2: '',
      tradename: '',
      correo: '',
      id_vias: '',
      home: '',
      numAddress: '',
      id_colonia: '',
      id_city: '',
      comercio: '',
      description: '',
      how_to_get: '',
      cell_phone: '',
      contact_form: '',
      number_fixed_number: 'Ninguno',
      recruitment_data: [],
      requires: [],

    },
    filteredColonias: [],
    loadingColonias: false,
    id: 0,
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
        { required: true, message: 'El tipo de calle es requerido', trigger: 'blur' }
      ],
      home: [
        { required: true, message: 'El domicilio es requerido', trigger: 'blur' },
        { min: 1, max: 100, message: 'Longitud debería ser 1 a 100', trigger: 'blur' }
      ],
      numAddress: [
        { required: true, message: 'El número de domicilio es requerido', trigger: 'blur' },
        { min: 1, max: 100, message: 'Longitud debería ser 1 a 100', trigger: 'blur' }
      ],
      id_colonia: [
        { required: true, message: 'La colonia es requerida', trigger: 'blur' }
      ],
      id_city: [
        { required: true, message: 'La ciudad es requerida', trigger: 'blur' }
      ],
      comercio: [
        { required: true, message: 'El tipo de comercio es requerido', trigger: 'blur' }
      ],
      description: [
        { required: true, message: 'La descripción es requerida', trigger: 'blur' },
        { min: 1, max: 200, message: 'Longitud debería ser 1 a 200', trigger: 'blur' }
      ],
      how_to_get: [
        { required: true, message: 'Cómo llegar es requerido', trigger: 'blur' },
        { min: 1, max: 200, message: 'Longitud debería ser 1 a 200', trigger: 'blur' }
      ],
      cell_phone: [
        { required: true, message: 'El número de celular es requerido', trigger: 'blur' },
        { min: 10, max: 13, message: 'Longitud debería ser 10 a 13', trigger: 'blur' }
      ],
      recruitment_data: [
        { required: true, message: 'Requiere de es requerido', trigger: 'blur' },
      ],
      contact_form: [
        { required: true, message: 'La forma de contacto es requerida', trigger: 'blur' },
      ],
      infoclient_certificate: [
        { required: true, message: 'Este campo es requeriado', trigger: 'blur' },
      ],
      requires: [
        { required: true, message: 'Requiere de deberia ser requerido', trigger: 'blur' },
      ],
    }
  }),
  methods: {
    refresh() {
      this.tableData = []
      axios.get('clientes').then(res => {
        this.tableData = res.data.data
      })
    },
    successUpload(response) {
      console.log('Datos enviados:', this.form)
      console.log(response)
      this.refresh()
      this.isCreating = true;
      axios.patch('clientes/' + this.id, this.form).then(response => {
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
        .finally(() => {
          this.isCreating = false; // Habilitar el botón nuevamente
        });
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

    fetchColoniasByCity() {
      axios.get('verColonia')
        .then(response => {
          console.log('Colonia:', response.data);
          this.colonias = response.data;
        })
        .catch(error => {
          console.error('Error fetching colonias:', error);
        });
    },

    selectColonia() {
      console.log(this.form)
    },
  },
  mounted() {
    this.refresh();
    this.fetchCiudades();
    this.fetchTypeRoad();
    this.fetchColoniasByCity();
    this.fetchFormaContacto();
    const route = useRoute();
    this.id = route.params.id;
    axios.get(`clientes/${this.id}`).then(res => {
      console.log(res);
      let datos = res.data.data;
      if (datos) {
        this.form.name = datos.name || '';
        this.form.lastname1 = datos.lastname1 || '';
        this.form.lastname2 = datos.lastname2 || '';
        this.form.tradename = datos.tradename || '';
        this.form.id_vias = datos.id_vias || '';
        this.form.home = datos.home || '';
        this.form.numAddress = datos.numAddress || '';
        this.form.id_colonia = datos.id_colonia || '';
        this.form.id_city = datos.id_city || '';
        this.form.comercio = datos.comercio || '';
        this.form.description = datos.description || '';
        this.form.how_to_get = datos.how_to_get || '';
        this.form.cell_phone = datos.cell_phone || '';
        this.form.number_fixed_number = datos.number_fixed_number || '';
        this.form.contact_form = datos.contact_form || '';
        this.form.specify = datos.specify || '';
        this.form.recruitment_data = JSON.parse(datos.recruitment_data) || '';
        this.form.requires = JSON.parse(datos.requires) || '';
        this.form.correo = datos.correo || '';
        this.form.contact_form = datos.contact_form || '';
      }
    });
  }
}
</script>

<style>
.datosCliente2 {
  font-size: 20px;
  font-weight: bold;
}
</style>
