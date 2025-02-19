<template>
  <!-- Importar Iconos-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <div>
        <div class="flex flex-col space-y-6 md:space-y-0 md:flex-row justify-start" >
          <div class="flex flex-wrap items-start justify-end ">

            <!--RUTAS ENTRES VISTAS-->
            <router-link to="/admin/works" class="inline-flex px-5 py-3 text-white bg-emerald-400 hover:bg-emerald-700 focus:bg-emerald-800 rounded-md ml-6 mb-3"
            style="color:black">
              <i class="fa fa-bookmark" aria-hidden="true" style="margin-top: 5px;
              margin-left: -5px; margin-right:10px;"></i>                
              Ver Ordenes
            </router-link>        
            <!--FIN DE RUTAS ENTRES VISTAS-->

          </div>
        </div>
        <div class="flex flex-col items-start">
          <h1 class="text-4xl font-bold mb-4 py-2">Ordenes de trabajo completas</h1>
        </div>

        <!-- TABLE DATA -->
        <div class="flex" style="justify-content: center;">
            <el-table
                :data="tableData"
                :default-sort="{ prop: 'id_orden', order: 'descending' }"
                style="width: 100%"
                stripe>

              <!--BOTON PARA VISUALIZAR EL PDF DE LA ORDEN DE TRABAJO-->
              <el-table-column label="" sortable width="80px">
                <template #default="scope">
                  <el-button style="color:black"
                    size="small"
                    type="success"
                    @click="pdf(scope.row)">
                    <a :href="url+'api/ordenTrabajoCompleta/'+scope.row.id" target="_blank">
                      <span class="material-symbols-outlined">lab_profile</span>
                      </a>
                  </el-button>
                </template>
            </el-table-column>
            <!--FIN DEL BOTON PARA VISUALIZAR EL PDF DE LA ORDEN DE TRABAJO-->

            <!--VISUALIZACION DE LA TABLA-->
            <el-table-column label="O. Trabajo" sortable width="115px">
              <template #default="scope">
                {{ 'No. ' + this.formatDate(scope.row.id_orden) }}
              </template>
            </el-table-column>
            <el-table-column label="Nombre" sortable width="190">
              <template #default="scope">
                {{ scope.row.name+' '+scope.row.lastname1+' '+scope.row.lastname2 }}
              </template>
            </el-table-column>
            <el-table-column label="Direccion" sortable width="280">
              <template #default="scope">
                {{ scope.row.home+' #'+scope.row.numAddress+', '+scope.row.colonia+' #'+scope.row.codigoPostal+', '+scope.row.ciudad }}
              </template>
            </el-table-column>
            <el-table-column prop="cell_phone" label="Celular" sortable width="100" />
            <el-table-column prop="date2" label="F. Fumigacion" sortable width="140" />
            <el-table-column prop="pago" label="Monto"  sortable width="100" />
            <el-table-column prop="requiere3" label="Datos" sortable width="90" />
            <el-table-column prop="ariasEmpleado1" label="Fumigador" sortable width="130"  />
            <!--FIN DE LA VISUALIZACION DE LA TABLA-->

            <!--BOTON PARA EDITAR LA ORDEN DE TRABAJO-->
            <el-table-column label="">
              <template #default="scope">
                <router-link :to="'/admin/works/edit-workComplete/'+scope.row.id">
                  <el-button style="color:black"
                    size="small"
                    type="warning"
                    @click="handleEdit()"
                    ><span class="material-symbols-outlined">edit</span></el-button
                  >
                </router-link>
              </template>
            </el-table-column>
                      
            
            <!--FIN DEL BOTON PARA  LA ORDEN DE TRABAJO-->
            </el-table>
        </div>
        <!-- END TABLE DATA -->
        
    </div>
  </template>
  
  <script>
      import axios from 'axios';
      export default {
          name:'AdminWorksCompleteComponent',
          data:()=>({
            url:process.env.VUE_APP_ROOT_ASSETS,
            urlApi:process.env.API,
            tableData:[],
            selectedItem: null,
            dialogVisibleView: false,
            dialogVisible: false,
          }),
          mounted(){
            this.refresh()
          },
          methods:{
            refresh(){
              this.tableData = []
              axios.get('completarOrden').then(res=>{
                this.tableData=res.data.data
              })
            },
            pdf(row){
            console.log(row)
            this.selectedItem=row
            this.selectedItem = null
            },
            confimarBaja(){
              axios.delete('completarOrden/'+this.selectedItem.id).then(res=>{
              console.log(res)
              this.refresh()
              this.dialogVisible=false
            })
            },
            bajaOrden(row){
              console.log(row)
              this.selectedItem=row
              this.dialogVisible=true
            },
            completarOrden(){},
            datos(row){
            console.log(row)
            this.selectedItem=row
            this.dialogVisibleView=true
            },
            handleEdit(){
            },
            formatDate(id_orden, paddingLength = 5, paddingChar = '0') {
  // Convert id to string in case it's a number
  const idString = String(id_orden);

  // Ensure paddingLength is a positive integer
  paddingLength = Math.max(0, Math.floor(paddingLength));

  // Pad the string with paddingChar
  return idString.padStart(paddingLength, paddingChar);
},
          }
      }
  </script>