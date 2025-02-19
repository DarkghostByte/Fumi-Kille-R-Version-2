<template>
  <!-- Importar Iconos-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <div>
    <div class="flex flex-col space-y-6 md:space-y-0 md:flex-row justify-start">

      <div class="flex flex-wrap items-start justify-end ">

        <router-link to="/admin/worksComplete"
          class="inline-flex px-5 py-3 text-white bg-red-400 hover:bg-red-700 focus:bg-red-800 rounded-md ml-6 mb-3"
          style="color:black">
          <i class="fa fa-rotate-left" aria-hidden="true" style="margin-top: 5px;
            margin-left: -5px; margin-right:10px;"></i>
          Devolver
        </router-link>

      </div>

    </div>

    <div class="mr-6">
      <h1 class="py-6 px-2 text-4xl font-semibold mb-2">Modificar orden de trabajo</h1>
    </div>


    <!-- TABLE INSERT -->
    <!-- TABLE DATA -->
    <div class="flex ml-5">
      <el-form :model="form" label-width="auto" style="max-width: 100%" :label-position="'top'" ref="formRef"
        :rules="rules">
        <!-- DATOS DE LA FILA DE CLIENTES -->
        <p style="font-size: 20px; font-weight: bold;">Persona Fisica: {{ form.name +' '+form.lastname1+' '+form.lastname2}}</p>
        <p style="font-size: 20px; font-weight: bold;">Persona Moral: {{ form.tradename }}</p>
        
        <!-- FILA DE LOS EMPLEADOS (RESPONSABLE Y AYUDANTE) -->
        <p style="font-size: 18px; font-weight: bold;">Fumigador</p>
        <div class="flex" style="width:100%;">
          <el-form-item prop="id_empleado" label="Responsable:" class="px-2" style="width: 300px;">
            <el-select v-model="form.id_empleado" filterable placeholder="Selecciona el responsable:"
              :disabled="!empleados.length">
              <el-option v-for="nameEmpleado in empleados" :key="nameEmpleado.id" :label="nameEmpleado.nameEmpleado"
                :value="nameEmpleado.id" />
            </el-select>
            <div v-if="!empleados.length">Loading empleados...</div>
          </el-form-item>
          <el-form-item prop="id_empleado2" label="Ayudante:" class="px-2" style="width: 300px;">
            <el-select v-model="form.id_empleado2" filterable placeholder="Selecciona el ayudante:" :disabled="!empleados2.length">
              <el-option v-for="nameEmpleado in empleados2" :key="nameEmpleado.id" :label="nameEmpleado.nameEmpleado"
                :value="nameEmpleado.id" />
            </el-select>
            <div v-if="!empleados2.length">Loading empleados...</div>
          </el-form-item>
        </div>

        <div class="flex" style="width:100%;">
          <div class="row">
            <p style="font-size: 18px; font-weight: bold;">Productos internos</p>
            <div class="flex" style="width:100%;">
              <el-form-item prop="id_productosInternos" label="Tipo de producto interno:" class="px-2"
                style="width: 300px;">
                <el-select v-model="form.id_productosInternos" filterable placeholder="Selecciona el tipo de producto interno:"
                  :disabled="!productoInternos.length">
                  <el-option v-for="productoInt in productoInternos" :key="productoInt.id" :label="productoInt.productoInt"
                    :value="productoInt.id" />
                </el-select>
                <div v-if="!productoInternos.length">Loading productos internos...</div>
              </el-form-item>
              <el-form-item prop="id_productosInternos2" label="Tipo de producto interno:" class="px-2"
                style="width: 300px;">
                <el-select v-model="form.id_productosInternos2" filterable placeholder="Selecciona el tipo de producto interno:"
                  :disabled="!productoInternos2.length">
                  <el-option v-for="productoInt in productoInternos2" :key="productoInt.id" :label="productoInt.productoInt"
                    :value="productoInt.id" />
                </el-select>
                <div v-if="!productoInternos2.length">Loading productos internos...</div>
              </el-form-item>
            </div>
          </div>
          <div class="row">
<!-- FILA DE LOS PRODUCTOS (EXTERNOS) -->
<p class="px-2" style="font-size: 18px; font-weight: bold;">Productos externos</p>
<div class="flex" style="width:100%;">
  <el-form-item prop="id_productosExternos" label="Tipo de producto externo:" class="px-4"
    style="width: 300px;">
    <el-select v-model="form.id_productosExternos" filterable placeholder="Selecciona el tipo de producto externo:"
      :disabled="!productoExternos.length">
      <el-option v-for="productoExt in productoExternos" :key="productoExt.id" :label="productoExt.productoExt"
        :value="productoExt.id" />
    </el-select>
    <div v-if="!productoExternos.length">Loading productos internos...</div>
  </el-form-item>
  <el-form-item prop="id_productosExternos2" label="Tipo de producto externo:" class="px-2"
    style="width: 300px;">
    <el-select v-model="form.id_productosExternos2" filterable placeholder="Selecciona el tipo de producto externo:"
      :disabled="!productoExternos2.length">
      <el-option v-for="productoExt in productoExternos2" :key="productoExt.id" :label="productoExt.productoExt"
        :value="productoExt.id" />
    </el-select>
    <div v-if="!productoExternos2.length">Loading productos internos...</div>
  </el-form-item>
</div>
          </div>
          
        
        </div>
        <!-- FILA DE LOS PRODUCTOS (INTERNOS) -->
        
        <!-- FILA DE RECOMENDACIONES -->
        <p style="font-size: 18px; font-weight: bold;">Recomendaciones</p>
        <div class="flex">
          <el-form-item prop="noTrapear" class="px-2" label="No trapear:">
            <el-input v-model="form.noTrapear" placeholder="A los cuantos dias" />
          </el-form-item>
          <el-form-item prop="noIngresar" class="px-7" label="No ingresar:">
            <el-input v-model="form.noIngresar" placeholder="Cuantas horas" />
          </el-form-item>

          <el-form-item prop="otraDosis" label="Otra dosis" class="px-2">
            <el-radio-group v-model="form.otraDosis">
              <el-date-picker class="px-2" v-model="form.otraDosis" type="date" placeholder="Otra dosis:"
                format="DD/MM/YYYY" value-format="DD-MM-YYYY" />
              <el-radio label="No aplica" value="No aplica" border />
            </el-radio-group>
          </el-form-item>
        </div>

        <!-- FILA DE FACTURAS -->
        <p style="font-size: 18px; font-weight: bold;">Factura</p>
        <div class="flex">
          <el-form-item prop="facturaOrden" label="Folio de la factura" class="px-2">
            <el-radio-group v-model="form.facturaOrden">
              <el-input class="px-2" v-model="form.facturaOrden" placeholder="Ingresa el numero de factura" style="width:250px;"/>
              <el-radio label="Pendiente" value="Pendiente" border />
              <el-radio label="No aplica" value="No aplica" border />
            </el-radio-group>
          </el-form-item>
        </div>

        <!-- FILA DE REQUIERE DE -->
        <p style="font-size: 18px; font-weight: bold;">Requiere de:</p>
        <div class="flex">
          <el-form-item prop="requiere1" label="" class="px-10">
            <el-checkbox-group v-model="form.requiere1">
              <el-checkbox label="Nada" value="Nada"></el-checkbox>
              <el-checkbox label="Factura" value="Factura"></el-checkbox>
              <el-checkbox label="Certificado" value="Certificado"></el-checkbox>
              <el-checkbox label="Remision" value="Remision"></el-checkbox>
            </el-checkbox-group>
          </el-form-item>
        </div>
        <!-- FILA DE DATO -->
        <p style="font-size: 18px; font-weight: bold;">Datos:</p>
        <div class="flex">
          <el-form-item prop="requiere2" label="" class="px-10">
            <el-checkbox-group v-model="form.requiere2" label="Requiere de">
              <el-checkbox label="Bitacora" value="Bitacora"></el-checkbox>
              <el-checkbox label="Agendar" value="Agendar"></el-checkbox>
              <el-checkbox label="Cancelar" value="Cancelar"></el-checkbox>
              <el-checkbox label="Ellos hablan" value="Ellos hablan"></el-checkbox>
              <el-checkbox label="Nada" value="Nada"></el-checkbox>
            </el-checkbox-group>
          </el-form-item>
        </div>
        <!-- FILA DE PAGO -->
        <p style="font-size: 18px; font-weight: bold;">Cobro:</p>
        <div class="flex">
          <el-form-item prop="pago" label="Monto:" class="px-2" style="width: 240px;">
            <el-input v-model="form.pago" class="px-1" placeholder="Ingresa el monto" type="number" />
          </el-form-item>
          <el-form-item prop="requiere3" label="Se pago?" class="px-10">
            <el-radio-group v-model="form.requiere3">
              <el-radio value="Pagado/Efectivo" size="large" border>Pagado/Efectivo</el-radio>
              <el-radio value="Pagado/Banco" size="large" border>Pagado/Banco</el-radio>
              <el-radio value="Credito" size="large" border>Credito</el-radio>
              <el-radio value="Cortesia" size="large" border>Cortesia</el-radio>
            </el-radio-group>
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
    formRef: undefined,
    uploadRef: undefined,
    url: process.env.VUE_APP_ROOT_ASSETS,
    urlApi: process.env.VUE_APP_ROOT_API,
    productoInternos: [],
    productoInternos2: [],
    productoExternos: [],
    productoExternos2: [],
    empleados: [],
    empleados2: [],
    form: {
      name: '',
      lastname1: '',
      lastname2: '',
      tradename: '',
      id_empleado: '',
      id_empleado2: '',
      id_productosInternos: '',
      id_productosInternos2: '',
      id_productosExternos: '',
      id_productosExternos2: '',
      noTrapear: '',
      noIngresar: '',
      otraDosis: '',
      hora: '',
      pago: '',
      requiere1: [],
      requiere2: [],
      requiere3: '',
      facturaOrden: ''
    },
    id: 0,
    rules: {
      id_empleado: [
        { required: true, message: 'El responsable es requerido', trigger: 'blur' },
      ],
      id_productosInternos: [
        { required: true, message: 'El producto interno es requerido', trigger: 'blur' },
      ],
      id_productosExternos: [
        { required: true, message: 'El producto externo es requerido', trigger: 'blur' },
      ],
      noTrapear: [
        { required: true, message: 'La fecha deberia ser requerida', trigger: 'blur' },
      ],
      noIngresar: [
        { required: true, message: 'La hora deberia ser requerida', trigger: 'blur' },
      ],
      otraDosis: [
        { required: true, message: 'La fecha deberia ser requerida', trigger: 'blur' },
      ],
      hora: [
        { required: true, message: 'La hora deberia ser requerida', trigger: 'blur' },
      ],
      requiere3: [
        { required: true, message: 'Este campo es requeriado', trigger: 'blur' },
      ],
      pago: [
        { required: true, message: 'El pago es requerido', trigger: 'blur' },
        { min: 1, max: 10, message: 'Longitud debería ser 1 a 10', trigger: 'blur' }
      ],
      facturaOrden: [
        { required: true, message: 'El campo es requerido', trigger: 'blur' },
        { min: 1, max: 10, message: 'Longitud debería ser 1 a 10', trigger: 'blur' }
      ],
    }
  }),
  methods: {
    refresh() {
      this.tableData = []
      axios.get('completarOrden').then(res => {
        this.tableData = res.data.data
      })
    },
    successUpload(response) {
      console.log('Datos enviados:', this.form)
      console.log(response)
      this.refresh()
      axios.patch('completarOrden/' + this.id, this.form).then(response => {
        console.log('Form submitted successfully:', response.data)
        console.log(response)
        this.$router.push('/admin/worksComplete');
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
    fetchProductosInternos() {
      axios.get('verProductosInternos')
        .then(response => {
          console.log('Productos Internos:', response.data);
          this.productoInternos = response.data;
          this.productoInternos2 = response.data;
        })
        .catch(error => {
          console.error('Error fetching productos interno:', error);
          ElNotification({
            title: 'Error',
            message: 'Error al recuperar productos internos',
            type: 'error',
          });
        });
    },

    

    fetchProductosExternos() {
      axios.get('verProductosExternos')
        .then(response => {
          console.log('Productos Externos:', response.data);
          this.productoExternos = response.data; // Assuming the data structure is correct
          this.productoExternos2 = response.data; // Assuming the data structure is correct

        })
        .catch(error => {
          console.error('Error fetching productos externos:', error);
          ElNotification({
            title: 'Error',
            message: 'Error al recuperar productos externos',
            type: 'error',
          });
        });
    },

    fetchEmpleados() {
      axios.get('verEmpleados')
        .then(response => {
          console.log('Empleados:', response.data);
          this.empleados = response.data; // Assuming the data structure is correct
          this.empleados2 = response.data; // Assuming the data structure is correct
        })
        .catch(error => {
          console.error('Error fetching empleados:', error);
          ElNotification({
            title: 'Error',
            message: 'Error al recuperar empleados',
            type: 'error',
          });
        });
    },

  },
  mounted() {
    this.fetchProductosInternos();
    this.fetchProductosExternos();
    this.fetchEmpleados();
    this.refresh();
    const route = useRoute();
    this.id = route.params.id;
    axios.get(`completarOrden/${this.id}`).then(res => {
      console.log(res);
      let datos = res.data.data;
      if (datos) {
        this.form.name = datos.name || '';
        this.form.lastname1 = datos.lastname1 || '';
        this.form.lastname2 = datos.lastname2 || '';
        this.form.tradename = datos.tradename || '';
        this.form.id_empleado = datos.id_empleado || '';
        this.form.id_empleado2 = datos.id_empleado2 || '';
        this.form.id_productosInternos = datos.id_productosInternos || '';
        this.form.id_productosInternos2 = datos.id_productosInternos2 || '';
        this.form.id_productosExternos = datos.id_productosExternos || '';
        this.form.id_productosExternos2 = datos.id_productosExternos2 || '';
        this.form.noTrapear = datos.noTrapear || '';
        this.form.noIngresar = datos.noIngresar || '';
        this.form.otraDosis = datos.otraDosis || '';
        this.form.pago = datos.pago || '';
        this.form.requiere1 = JSON.parse(datos.requiere1) || '';
        this.form.requiere2 = JSON.parse(datos.requiere2) || '';
        this.form.requiere3 = datos.requiere3 || '';
        this.form.requiere4 = datos.requiere4 || '';
        this.form.facturaOrden = datos.facturaOrden || '';
      }
    });
  }
}
</script>
