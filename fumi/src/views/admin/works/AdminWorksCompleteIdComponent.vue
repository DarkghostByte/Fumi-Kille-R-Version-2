<template>
  <!-- Importar Iconos-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  <div>
    <div class="flex flex-col space-y-6 md:space-y-0 md:flex-row justify-start">
      <div class="flex justify-end mb-4">
        <router-link to="/admin/clients"
          class="btn btn-red bg-red-500 hover:bg-red-700 text-black font-bold py-2 px-4 rounded">
          <i class="fa fa-rotate-left mr-2"></i> Devolver
        </router-link>
      </div>
    </div>
  </div>

  <div class="container mx-auto px-4">
    <div class="flex flex-col items-center">
      <h1 class="text-3xl font-bold mb-4">Ordenes completas</h1>
      <h2 class="text-xl font-semibold mb-8" v-if="tableData.length > 0">
        Nombre del Cliente: {{ clientName }}
      </h2>
      <h2 class="text-xl font-semibold mb-8" style="margin-top: -20px;" v-if="tableData.length > 0">
        Direccion: {{ clientAdress }}
      </h2>
      <h2 class="text-xl font-semibold mb-8" style="margin-top: -20px;" v-if="tableData.length > 0">
        Celular: {{ clientPhone }}
      </h2>



      <div class="flex" style="justify-content: center;">
        <el-table :data="tableData" :default-sort="{ prop: 'name', order: 'descending' }" style="width: 100%" stripe>
          
          <el-table-column label="O. Trabajo" sortable width="115">
            <template #default="scope">
              {{ 'No. ' + this.formatDate(scope.row.id_orden) }}
            </template>
          </el-table-column>
          <el-table-column prop="facturaOrden" label="N. Factura" sortable width="120" />


          <el-table-column prop="pago" label="Monto" sortable width="95" />
          <el-table-column prop="requiere3" label="Datos" sortable width="90" />
          <el-table-column prop="ariasEmpleado1" label="Fumigador" sortable width="120" />
          <el-table-column prop="date1" label="F. Orden" sortable width="130" />
          <el-table-column prop="date2" label="F. Fumigacion" sortable width="140" />
          <el-table-column label="">
            <template #default="scope">
              <router-link :to="'/admin/works/edit-workComplete/' + scope.row.id">
                <el-button style="color:black" size="small" type="warning">
                  <span class="material-symbols-outlined">edit</span>
                </el-button>
              </router-link>
            </template>
          </el-table-column>
          <!--          
          <el-table-column label="">
            <template #default="scope">
              <el-button style="color:black" size="small" type="danger" @click="bajaOrden(scope.row)">
                <span class="material-symbols-outlined">disabled_by_default</span>
              </el-button>
            </template>
          </el-table-column>
          -->

        </el-table>
      </div>

    </div>

    <el-dialog v-model="dialogVisible" title="Deseas dar de baja la siguente orden de trabajo" width="1200">
      <div class="h-72 overflow-scroll" style="font-size:22px; color:black;">
        Datos la orden de trabajo
        <br>
        Nombre: {{ selectedItem.name }} {{ selectedItem.lastname1 }} {{ selectedItem.lastname2 }}
        <br>
        Direccion: {{ selectedItem.city }}, {{ selectedItem.colonia }} #{{ selectedItem.codigoPostal }}, {{
          selectedItem.home }} #{{ selectedItem.numAddress }}
        <br>
        Dia de la orden: {{ selectedItem.date1 }}
        <br>
        Dia de de asistencia: {{ selectedItem.date2 }}
        <br>
        De: {{ selectedItem.time1 }}
        <br>
        A: {{ selectedItem.time2 }}
        <br><br>
      </div>
      <template #footer>
        <div class="dialog-footer">
          <el-button type="info" @click="dialogVisible = false">Cancelar</el-button>
          <el-button type="danger" @click="confimarBaja()">Confirmar</el-button>
        </div>
      </template>
    </el-dialog>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'AdminWorksCompleteIdComponent',
  data: () => ({
    url: process.env.VUE_APP_ROOT_ASSETS,
    urlApi: process.env.API,
    tableData: [],
    selectedItem: {},
    dialogVisibleView: false,
    dialogVisible: false,
    clientId: null
  }),

  mounted() {
    this.refresh();
    this.refresh1();
    this.refresh2();
    this.refresh3();
    this.clientId = this.$route.params.id;
  },
  methods: {
    refresh() {
      this.tableData = [];
      axios.get('completarOrden').then(res => {
        console.log(res);
        this.tableData = res.data.data.filter(order => order.id_cliente == this.clientId); if (this.tableData.length > 0) {
          this.clientName = `${this.tableData[0].name} ${this.tableData[0].lastname1} ${this.tableData[0].lastname2}`;
        } else {
          this.clientName = 'No se encontraron clientes';
        }
      });
    },
    refresh1() {
      this.tableData = [];
      axios.get('completarOrden').then(res => {
        this.tableData = res.data.data.filter(order => order.id_cliente == this.clientId); if (this.tableData.length > 0) {
          this.clientAdress = `${this.tableData[0].home} #${this.tableData[0].numAddress}, Col. ${this.tableData[0].colonia} #${this.tableData[0].codigoPostal}, ${this.tableData[0].ciudad}`;
        } else {
          this.clientAdress = 'No se encontraron clientes';
        }
      });
    },
    refresh2() {
      this.tableData = [];
      axios.get('completarOrden').then(res => {
        this.tableData = res.data.data.filter(order => order.id_cliente == this.clientId); if (this.tableData.length > 0) {
          this.clientPhone = `${this.tableData[0].cell_phone}`;
        } else {
          this.clientPhone = 'No se encontraron clientes';
        }
      });
    },
    refresh3() {
      this.tableData = [];
      axios.get('completarOrden').then(res => {
        this.tableData = res.data.data.filter(order => order.id_cliente == this.clientId);
      });
    },
    bajaOrden(row) {
      if (row) {
        this.selectedItem = row;
        this.dialogVisible = true;
      }
    },
    confimarBaja() {
      if (this.selectedItem.id) {
        axios.delete('completarOrden/' + this.selectedItem.id).then(() => {
          this.refresh();
          this.dialogVisible = false;
        }).catch(error => {
          console.error('Error deleting order:', error);
        });
      }
    },
    datos(row) {
      if (row) {
        this.selectedItem = row;
        this.dialogVisibleView = true;
      }
    },
    handleEdit() { },
    formatDate(id_orden, paddingLength = 5, paddingChar = '0') {
      // Convert id to string in case it's a number
      const idString = String(id_orden);

      // Ensure paddingLength is a positive integer
      paddingLength = Math.max(0, Math.floor(paddingLength));

      // Pad the string with paddingChar
      return idString.padStart(paddingLength, paddingChar);
    },
  }
};
</script>
