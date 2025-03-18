<template>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  <div class="container mx-auto px-4">

    <div class="flex justify-between items-center mb-4">
      <h1 class="text-2xl font-semibold">Certificados Realizados</h1>
      <div class="flex flex-wrap items-start justify-end ">
        <router-link to="/admin/certificate" class="el-button el-button--danger">
          <i class="fa fa-rotate-left" aria-hidden="true"
            style="margin-top: 5px; margin-left: -5px; margin-right:10px;"></i>
          Regresar
        </router-link>
      </div>
    </div>

    <div class="flex mb-4" style="justify-content: center;">
      <div class="flex mb-4" style="width: 80%;">
        <el-input class="px-2" placeholder="Buscar por nombre" v-model="searchQueryName"
          @input="filterDataName" />
        <el-input class="px-2" placeholder="Buscar por direccion" v-model="searchQueryAddress"
          @input="filterDataAddress" />
        <el-input class="px-2" placeholder="Buscar por celular" v-model="searchQueryPhone"
          @input="filterDataPhone" />
      </div>
    </div>

    <div class="flex" style="justify-content: center;">
      <el-table :data="filteredData" :default-sort="{ prop: 'id', order: 'descending' }" style="width: 100%" stripe>
        <el-table-column label="" width="100">
          <template #default="scope">
            <el-button style="color:black" size="small" type="info" @click="pdf(scope.row)">
              <a :href="url + 'api/certificadoRealizado/' + scope.row.id" target="_blank">
                <span class="material-symbols-outlined">lab_profile</span>
              </a>
            </el-button>
          </template>
        </el-table-column>

        <el-table-column label="" width="100">
          <template #default="scope">
            <el-button style="color:black" size="small" type="success" @click="seleccionar(scope.row)"><span
                class="material-symbols-outlined">visibility</span></el-button>
          </template>
        </el-table-column>

        <el-table-column label="" width="100">
          <template #default="scope">
            <el-button style="color:black" size="small" type="primary" @click="editCertificate(scope.row)"><span
                class="material-symbols-outlined">edit</span></el-button>
          </template>
        </el-table-column>

        <el-table-column label="Folio" sortable>
          <template #default="scope">
            {{ 'No. ' + this.formatDate(scope.row.id) }}
          </template>
        </el-table-column>
        <el-table-column prop="certificateName" label="Nombre" sortable width="250" />
        <el-table-column label="Dirección" sortable width="550">
          <template #default="scope">
            {{ scope.row.ciudad + ', ' + scope.row.colonia + ' #' + scope.row.codigoPostal + ', ' + scope.row.home + ' #' + scope.row.numAddress }}
          </template>
        </el-table-column>
        <el-table-column prop="cell_phone" label="Numero Celular" sortable />

      </el-table>
    </div>
    <el-dialog v-model="dialogVisibleView" title="Datos del certificado" width="700" height="500">
      <div class="clientInfo">
        <div class="details">
          <i class="fa fa-file fa-2x iconInfo"></i>
          <div>
            <p>
              <strong>Folio:</strong> 0000{{ selectedItem.id }}
            </p>
          </div>
        </div>
        <div class="details">
          <i class="fa fa-file fa-2x iconInfo"></i>
          <div>
            <p>
              <strong>Certificado a:</strong> {{ selectedItem.certificateName }}
            </p>
          </div>
        </div>
        <div class="details">
          <i class="fa fa-city fa-2x iconInfo"></i>
          <div>
            <p>
              <strong>Domicilio:</strong> {{ selectedItem.street }} {{ selectedItem.home }} #{{ selectedItem.numAddress
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
          </div>
        </div>
        <div class="details">
          <i class="fa fa-bugs fa-2x iconInfo"></i>
          <div>
            <p>
              <strong>Producto interno:</strong> {{ selectedItem.productoInt }}
            </p>
            <p>
              <strong>Producto externo:</strong> {{ selectedItem.productoExt }}
            </p>
          </div>
        </div>
      </div>
      <template #footer>
        <div class="dialog-footer">
          <el-button type="primary" color="#ff7640" @click="dialogVisibleView = false">Listo</el-button>
        </div>
      </template>
    </el-dialog>
    <el-dialog v-model="dialogVisibleViewcertificado" title="Modificar certificado" width="40%">
      <el-form :model="form1" label-width="auto" style="max-width: 100%" ref="formRef" :rules="rules"
        :label-position="'top'">
        <div class="row" style="width:100%;">
          <p>Cliente: {{ selectedItem.name }} {{ selectedItem.lastname1 }} {{ selectedItem.lastname2 }}</p>
          <p>Negocio: {{ selectedItem.tradename }}</p><br>

          <div class="flex" style="width:100%;">
            <el-form-item prop="certificateName" label="A quien estara el certificado:" class="px-2">
              <el-radio-group v-model="form1.certificateName">
                <el-radio :value="selectedItem.name+' '+selectedItem.lastname1+' '+ selectedItem.lastname2" size="large" border>{{ selectedItem.name }} {{ selectedItem.lastname1 }} {{ selectedItem.lastname2 }}</el-radio>
                <el-radio :value="selectedItem.tradename" size="large" border>{{ selectedItem.tradename }}</el-radio>
              </el-radio-group>
            </el-form-item>
          </div>

          <div class="flex" style="width:100%;">
            <el-form-item prop="id_productoCertificadoInt1" label="Tipo de producto interno:" class="px-2"
              style="width: 100%;">
              <el-select v-model="form1.id_productoCertificadoInt1"
                placeholder="Selecciona el tipo de producto interno:" :disabled="!productoInternos.length">
                <el-option v-for="productoInt in productoInternos" :key="productoInt.id"
                  :label="productoInt.productoInt" :value="productoInt.id" />
              </el-select>
              <div v-if="!productoInternos.length">Loading productos internos...</div>
            </el-form-item>
            <el-form-item prop="id_productoCertificadoExt1" label="Tipo de producto externo:" class="px-2"
              style="width: 100%;">
              <el-select v-model="form1.id_productoCertificadoExt1"
                placeholder="Selecciona el tipo de producto externo:" :disabled="!productoExternos.length">
                <el-option v-for="productoExt in productoExternos" :key="productoExt.id"
                  :label="productoExt.productoExt" :value="productoExt.id" />
              </el-select>
              <div v-if="!productoExternos.length">Loading productos internos...</div>
            </el-form-item>
          </div>

        </div>
      </el-form>
      <template #footer>
        <span class="dialog-footer">
          <el-button @click="dialogVisibleViewcertificado = false">Cancelar</el-button>
          <el-button type="primary" @click="updateCertificate(selectedItem.id)">Actualizar</el-button>
        </span>
      </template>
    </el-dialog>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'AdminClientsComponent',
  data: () => ({
    dialogVisible: false,
    dialogVisibleView: false,
    dialogVisibleViewcertificado: false,
    url: process.env.VUE_APP_ROOT_ASSETS,
    urlApi: process.env.VUE_APP_ROOT_API,
    tableData: [],
    filteredData: [],
    selectedItem: {},
    selectedItem1: {},
    searchQuery: '',
    searchQueryName: '',
    searchQueryAddress: '',
    searchQueryPhone: '',
    form1: {
      certificateName: '',
      id_productoCertificadoInt1: '',
      id_productoCertificadoExt1: '',
    },
    productoInternos: [],
    productoExternos: [],
    rules: {
      certificateName: [{ required: true, message: 'Por favor selecciona un nombre', trigger: 'change' }],
      id_productoCertificadoInt1: [{ required: true, message: 'Por favor selecciona un producto interno', trigger: 'change' }],
      id_productoCertificadoExt1: [{ required: true, message: 'Por favor selecciona un producto externo', trigger: 'change' }],
    },
  }),
  mounted() {
    this.refresh();
    this.fetchProductos();
  },
  methods: {
    refresh() {
      axios.get('certificados').then(res => {
        this.tableData = res.data.data;
        this.filteredData = this.tableData;
        console.log(this.tableData);
      });
    },
    seleccionar(row) {
      console.log(row);
      this.selectedItem = row;
      this.dialogVisibleView = true;
    },
    pdf(row) {
      console.log(row)
      this.selectedItem1 = row
      this.selectedItem1 = null
    },
    filterDataName() {
      this.filteredData = this.tableData.filter((certificados) => {
        return certificados.certificateName.toLowerCase().includes(this.searchQueryName.toLowerCase());
      });
    },
    filterDataAddress() {
      this.filteredData = this.tableData.filter((clientes) => {
        const combinedAddress = clientes.ciudad.toLowerCase() + ' ' + clientes.colonia.toLowerCase() + ' ' + clientes.home.toLowerCase() + ' ' + clientes.codigoPostal.toLowerCase() + ' ' + clientes.numAddress.toLowerCase();
        return combinedAddress.includes(this.searchQueryAddress.toLowerCase());
      });
    },
    filterDataPhone() {
      this.filteredData = this.tableData.filter((clientes) => {
        return clientes.cell_phone.toLowerCase().includes(this.searchQueryPhone.toLowerCase());
      });
    },
    async fetchData() {
      try {
        const responseOrdenes = await axios.get(this.urlApi + 'certificados');
        this.tableData = responseOrdenes.data.data;
      } catch (error) {
        console.error('Error al obtener los datos:', error);
      }
    },
    formatDate(id, paddingLength = 5, paddingChar = '0') {
      const idString = String(id);
      paddingLength = Math.max(0, Math.floor(paddingLength));
      return idString.padStart(paddingLength, paddingChar);
    },
    async fetchProductos() {
      try {
        const internos = await axios.get('productosInternos');
        this.productoInternos = internos.data.data;
        const externos = await axios.get('productosExternos');
        this.productoExternos = externos.data.data;
      } catch (error) {
        console.error('Error al obtener productos:', error);
      }
    },
    editCertificate(row) {
      this.selectedItem = row;
      this.form1 = {
        certificateName: row.certificateName,
        id_productoCertificadoInt1: row.id_productoCertificadoInt1,
        id_productoCertificadoExt1: row.id_productoCertificadoExt1,
      };
      this.dialogVisibleViewcertificado = true;
    },
    async updateCertificate(id) {
      try {
        await axios.put(`certificados/${id}`, this.form1);
        this.dialogVisibleViewcertificado = false;
        this.refresh();
        this.$message({ type: 'success', message: 'Certificado actualizado con éxito' });
      } catch (error) {
        console.error('Error al actualizar el certificado:', error);
        this.$message({ type: 'error', message: 'Error al actualizar el certificado' });
      }
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
  color: #ff7640;
  margin-right: 10px;
}

.iconDelete {
  color: #f32222;
  margin-right: 10px;
}
</style>