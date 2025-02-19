<template>
  <!-- Importar Iconos-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <div>
    <div class="flex flex-col space-y-6 md:space-y-0 md:flex-row justify-start">
      <div class="flex flex-wrap items-start justify-end ">

        <router-link to="/admin/works"
          class="inline-flex px-5 py-3 text-white bg-red-400 hover:bg-red-700 focus:bg-red-800 rounded-md ml-6 mb-3"
          style="color:black">
          <i class="fa fa-rotate-left" aria-hidden="true" style="margin-top: 5px;
            margin-left: -5px; margin-right:10px;"></i>
          Devolver
        </router-link>



      </div>
    </div>
    <div class="mr-6">
      <h1 class="py-10 px-5 text-4xl font-semibold mb-2">Completar orden de trabajo</h1>
    </div>
    <!-- TABLE DATA -->
    <div class="flex ml-5">
      <el-form :model="form" label-width="auto" style="max-width: 100%" :label-position="'top'" ref="formRef"
        :rules="rules">
        <!-- DATOS DE LA FILA DE CLIENTES -->
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
              <el-date-picker class="px-2" v-model="form1.date2" type="date" placeholder="Otra dosis:"
                format="DD/MM/YYYY" value-format="DD-MM-YYYY" />
              <el-radio label="No aplica" value="No aplica" border />
            </el-radio-group>
          </el-form-item>

          <el-form-item class="px-10" label="Nueva orden:">
            <el-button :disabled="isButtonDisabled" @click="dialogVisibleOrdenNueva = true"
              class="el-button el-button--warning">
              <i class="fa-solid fa-calendar" aria-hidden="true"
                style="margin-top: 2px; margin-left: -5px; margin-right:10px;"></i>
              Otra dosis
            </el-button>
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
            <el-button type="primary" @click="submitForm">Guardar</el-button>
          </el-form-item>
        </div>
      </el-form>
    </div>
    <!-- END TABLE DATA -->
    <!-- MODAL 1 -->
    <el-dialog v-model="dialogVisibleOrdenNueva" title="Otra dosis:" width="80%">
      <el-form :model="form1" label-width="auto" style="max-width: 100%" ref="formRef2" :rules="rules2"
        :label-position="'top'">
        <div class="row">

          <p>Cliente {{ form1.name + ' ' + form1.lastname1 + ' ' + form1.lastname2 }}</p>

          <p class="ordenDatos1">Dosis</p>
          <div class="flex" style="width:100%;">
            <el-form-item prop="nDosis" label="Otra dosis" class="px-2">
              <el-radio-group v-model="form1.nDosis">
                <el-radio label="1ra Dosis" value="1ra Dosis" border />
                <el-radio label="2da Dosis" value="2da Dosis" border />
                <el-radio label="3ra Dosis" value="3ra Dosis" border />
                <el-radio label="4ta Dosis" value="4ta Dosis" border />
                <el-input v-model="form1.nDosis" class="" placeholder="Ingresa el numero de dosis" style="width:250px;"/>
              </el-radio-group>
            </el-form-item>
          </div>

          <p>Problematica</p>
          <div class="flex" style="width:100%;">
            <el-form-item prop="id_plague1" label="Problematica #1:" class="px-2" style="width: 300px;">
              <el-select v-model="form1.id_plague1" filterable placeholder="Selecciona la problematica:">
                <el-option v-for="problematicaBug in problematicas1" :key="problematicaBug.id"
                  :label="problematicaBug.problematica" :value="problematicaBug.id" />
              </el-select>
            </el-form-item>
            <el-form-item prop="id_plague2" label="Problematica #2:" class="px-2" style="width: 300px;">
              <el-select v-model="form1.id_plague2" filterable placeholder="Selecciona la problematica:">
                <el-option v-for="problematicaBug2 in problematicas2" :key="problematicaBug2.id"
                  :label="problematicaBug2.problematica" :value="problematicaBug2.id" />
              </el-select>
            </el-form-item>
          </div>

          <p>Fechas</p>
          <div class="flex">
            <el-form-item prop="date1" class="px-2" label="Fecha de orden:">
              <el-col :span="11" style="width: 220px">
                <el-date-picker v-model="form1.date1" type="date" placeholder="Orden" format="DD/MM/YYYY"
                  value-format="DD-MM-YYYY" />
              </el-col>
            </el-form-item>
            <el-form-item prop="date2" class="px-2" label="Fecha para asistir:">
              <el-col :span="11" style="width: 220px">
                <el-date-picker v-model="form1.date2" type="date" placeholder="Orden" format="DD/MM/YYYY"
                  value-format="DD-MM-YYYY" />
              </el-col>
            </el-form-item>
            <el-form-item prop="time1" class="px-2" label="De hora:">
              <el-col :span="11" style="width: 220px">
                <el-time-select v-model="form1.time1" style="width: 220px" start="08:30" step="00:15" end="20:30"
                  format="hh:mm A" placeholder="Seleccionar hora" />
              </el-col>
            </el-form-item>
            <el-form-item prop="time2" class="px-2" label="A hora:">
              <el-col :span="11" style="width: 220px">
                <el-time-select v-model="form1.time2" style="width: 220px" start="08:30" step="00:15" end="20:30"
                  format="hh:mm A" placeholder="Seleccionar hora" />
              </el-col>
            </el-form-item>
            <el-form-item prop="infoorden_cell" label="Hablar antes de ir?" class="px-2">
              <el-radio-group v-model="form1.infoorden_cell">
                <el-radio value="Si" size="large" border>Si</el-radio>
                <el-radio value="No" size="large" border>No</el-radio>
              </el-radio-group>
            </el-form-item>
          </div>

          <p>Contratacion:</p>
          <div class="flex">
            <el-form-item prop="hiring" label="" class="px-10">
              <el-checkbox-group v-model="form1.hiring">
                <el-checkbox label="Nada" value="Nada"></el-checkbox>
                <el-checkbox label="Presupuesto" value="Presupuesto"></el-checkbox>
                <el-checkbox label="Fumigar" value="Fumigar"></el-checkbox>
                <el-checkbox label="Garantia" value="Garantia"></el-checkbox>
                <el-checkbox label="Cortesia" value="Cortesia"></el-checkbox>
              </el-checkbox-group>
            </el-form-item>
          </div>

          <p>Requiere de:</p>
          <div class="flex">
            <el-form-item prop="infoorden_certificate" label="El cliente necesita certificado?" class="px-10">
              <el-radio-group v-model="form1.infoorden_certificate">
                <el-radio value="Si" size="large" border>Si</el-radio>
                <el-radio value="No" size="large" border>No</el-radio>
              </el-radio-group>
            </el-form-item>

            <el-form-item prop="infoorden_remision" label="El cliente necesita remision?" class="px-10">
              <el-radio-group v-model="form1.infoorden_remision">
                <el-radio value="Si" size="large" border>Si</el-radio>
                <el-radio value="No" size="large" border>No</el-radio>
              </el-radio-group>
            </el-form-item>

            <el-form-item prop="infoorden_facturacion" label="El cliente necesita facturacion?" class="px-10">
              <el-radio-group v-model="form1.infoorden_facturacion">
                <el-radio value="Si" size="large" border>Si</el-radio>
                <el-radio value="No" size="large" border>No</el-radio>
              </el-radio-group>
            </el-form-item>
          </div>

        </div>
      </el-form>
      <template #footer>
        <span class="dialog-footer">
          <el-button @click="dialogVisibleOrdenNueva = false">Cancelar</el-button>
          <el-button type="primary" @click="createNewOrder">Crear</el-button>
        </span>
      </template>
    </el-dialog>
  </div>


</template>

<script>
import { ElNotification } from 'element-plus';
import { useRoute } from 'vue-router';
import axios from 'axios';
export default {
  name: 'AdminCompleteWorksComponent',

  data: () => ({
    tableData: [],
    formRef: undefined,
    formRef2: undefined,

    uploadRef: undefined,
    url: process.env.VUE_APP_ROOT_ASSETS,
    urlApi: process.env.VUE_APP_ROOT_API,
    productoInternos: [],
    productoInternos2: [],
    productoExternos: [],
    productoExternos2: [],
    empleados: [],
    empleados2: [],
    dialogVisibleOrdenNueva: false,
    dialogVisibleFactura: false,
    problematicas1: [],
    problematicas2: [],
    selectedItem: {},
    form: {
      id_orden: '',
      id_empleado: '',
      id_empleado2: 1,
      id_productosInternos: '',
      id_productosInternos2: 1,
      id_productosExternos: '',
      id_productosExternos2: 1,
      noTrapear: '',
      noIngresar: '',
      otraDosis: 'No aplica',
      pago: '',
      requiere1: [],
      requiere2: [],
      requiere3: [],
      requiere4: true,
      facturaOrden: 'No aplica',
      name: '',
      lastname1: '',
      lastname2: '',
      tradename: ''
    },
    form1: {
      name: '',
      lastname1: '',
      lastname2: '',
      tradename: '',
      id_plague1: '',
      id_plague2: '',
      date1: '',
      date2: '',
      time1: '',
      time2: '',
      hiring: [],
      infoorden_delete: 'Alta',
      statusOrder: '',
      infoorden_certificate: 'No',
      infoorden_remision: 'No',
      infoorden_facturacion: 'No',
      infoorden_cell: 'No',
      nDosis: ''
    },

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
      requiere1: [
        { required: true, message: 'Este campo es requeriado', trigger: 'blur' },
      ],
      requiere2: [
        { required: true, message: 'Este campo es requeriado', trigger: 'blur' },
      ],
      requiere3: [
        { required: true, message: 'Este campo es requeriado', trigger: 'blur' },
      ],
      pago: [
        { required: true, message: 'El pago es requerido', trigger: 'blur' },
        { min: 1, max: 10, message: 'Longitud debería ser 1 a 10', trigger: 'blur' }
      ],
      facturaOrden: [
        { required: true, message: 'El pago es requerido', trigger: 'blur' },
        { min: 1, max: 10, message: 'Longitud debería ser 1 a 10', trigger: 'blur' }
      ],
    },
    rules2: {
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
    },
  }),
  mounted() {
    this.fetchProductosInternos();
    this.fetchProductosInternos2();
    this.fetchProductosExternos();
    this.fetchProductosExternos2();
    this.fetchEmpleados();
    this.fetchEmpleados2();
    this.refresh();
    this.fetchProblematicaBug();
    this.fetchProblematicaBug2();
    const route = useRoute();

    console.log('ID', route.params.id)
    console.log('ID Orden', route.params)

    if (route.params && route.params.id) {
      this.id = route.params.id;
      axios.get('orden/' + this.id).then(res => {
        console.log('Orden Response:', res.data);
        if (res.data && res.data.data) {
          let datos = res.data.data;
          console.log('Datos:', res.data.data); // Verifica aquí los datos del cliente
          console.log('Datos Cliente:', datos.cliente); // Verifica aquí los datos del cliente
          console.log('Datos De Orden:', datos); // Verifica aquí los datos del cliente
          this.form.id_orden = datos.id;
          if (datos.cliente) {
            this.clientId = datos.cliente.name;
            this.form.name = datos.cliente.name || '';
            this.form.lastname1 = datos.cliente.lastname1 || '';
            this.form.lastname2 = datos.cliente.lastname2 || '';
            this.form.tradename = datos.cliente.tradename || '';
            this.form.statusOrder = datos.cliente.statusOrder || '';
            this.form1.name = datos.cliente.name || '';
            this.form1.lastname1 = datos.cliente.lastname1 || '';
            this.form1.lastname2 = datos.cliente.lastname2 || '';
            this.form1.tradename = datos.cliente.tradename || '';
            this.form1.cell_phone = datos.cliente.cell_phone || '';
            this.form1.statusOrder = datos.statusOrder || '';
            this.form1.id_plague1 = datos.id_plague1 || '';
            this.form1.id_plague2 = datos.id_plague2 || '';
            this.form1.id_cliente = datos.id_cliente || '';
            this.form1.date1 = datos.date1 || '';
            this.form1.date2 = datos.date2 || '';
            this.form1.time1 = datos.time1 || '';
            this.form1.time2 = datos.time2 || '';
            this.form1.infoorden_cell = datos.infoorden_cell || '';
            this.form1.hiring = JSON.parse(datos.hiring) || '';
            this.form1.infoorden_certificate = datos.infoorden_certificate || '';
            this.form1.infoorden_remision = datos.infoorden_remision || '';
            this.form1.infoorden_facturacion = datos.infoorden_facturacion || '';
            this.form1.nDosis = datos.nDosis || '';
          }


        } else {
          console.error('Response data is undefined or null');
          ElNotification({
            title: 'Error',
            message: 'No se pudo recuperar la información de la orden',
            type: 'error'
          });
        }
      }).catch(error => {
        console.error('Error fetching orden data:', error);
        ElNotification({
          title: 'Error',
          message: 'Error al recuperar la información de la orden',
          type: 'error'
        });
      });
    } else {
      console.error('route.params.id is undefined');
    }

  },
  watch: {
    'form.requiere3': function (newValue) {
        if (newValue === 'Credito') {
            this.form.requiere4 = true;
        } else {
            this.form.requiere4 = false;
        }
    }
},
  methods: {
    refresh() {
      axios.get('orden').then(res => {
        this.tableData = res.data.data;
      });
    },

    fetchProductosInternos() {
      axios.get('verProductosInternos')
        .then(response => {
          console.log('Productos Internos:', response.data);
          this.productoInternos = response.data;
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

    fetchProductosInternos2() {
      axios.get('verProductosInternos')
        .then(response => {
          console.log('Productos Internos:', response.data);
          this.productoInternos2 = response.data; // Assuming the data structure is correct
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

    fetchProductosExternos2() {
      axios.get('verProductosExternos')
        .then(response => {
          console.log('Productos Externos:', response.data);
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

    fetchEmpleados2() {
      axios.get('verEmpleados')
        .then(response => {
          console.log('Empleados:', response.data);
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


    submitForm() {
  this.$refs.formRef.validate((valid) => {
    if (valid) {
      axios.post('completarOrden', this.form)
        .then(response => {
          console.log('Form submitted successfully:', response.data);
          this.$router.push('/admin/worksComplete');
          ElNotification({
            title: 'Éxito',
            message: 'Registro insertado correctamente',
            type: 'success'
          });

          const updatedData = {
            statusOrder: this.form.statusOrder === 'Terminada' ? 'Por realizar' : 'Terminada'
          };

          axios.put('verEstadoOrden/' + this.form.id_orden, updatedData)
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
        })
        .catch(error => {
          console.error('Error submitting form:', error.response ? error.response.data : error.message);
          ElNotification({
            title: 'Error',
            message: error.response && error.response.data ? error.response.data.message : 'Favor de llenar los campos correctamente',
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
      return false;
    }
  });
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

    createNewOrder() {
      this.$refs.formRef2.validate((valid) => {
        if (valid) {
          axios.post('orden', this.form1)
            .then(res => {
              console.log(res);
              this.refresh();
              this.$message.success('La otra dosis se creo correctamente');
              ElNotification({
                title: 'Alerta',
                message: 'Registro insertado correctamente',
                type: 'success'
              })
              this.dialogVisibleOrdenNueva = false;
            })
            .catch(error => {
              console.log(error);
              this.$message.error('Error al crear la segunda dosis');
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

    createFactura() {
      this.$refs.formRef3.validate((valid) => {
        if (valid) {
          axios.post('facturas', this.form2)
            .then(res => {
              console.log(res);
              this.refresh();
              this.$message.success('La factura se inserto correctamente');
              ElNotification({
                title: 'Alerta',
                message: 'Registro insertado correctamente',
                type: 'success'
              })
              this.dialogVisibleFactura = false;
            })
            .catch(error => {
              console.log(error);
              this.$message.error('Error al crear la factura');
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
  }
};
</script>

<style>
.label-negro {
  color: red;
  font-size: 16px;
  font-weight: bold;
}
</style>
