<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\OrdensController;
use App\Http\Controllers\CiudadesController;
use App\Http\Controllers\ColoniasController;
use App\Http\Controllers\CompletarOrdenesController;
use App\Http\Controllers\ComerciosController;
use App\Http\Controllers\CertificadoController;
use App\Http\Controllers\ProductosInternosController;
use App\Http\Controllers\ProductosExtrenosController;
use App\Http\Controllers\EmpleadosController;
use App\Http\Controllers\ViasController;
use App\Http\Controllers\ProblematicasController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\IngresosController;
use App\Http\Controllers\EgresosController;
use App\Http\Controllers\PdfsController;
use App\Http\Controllers\RemisionesController;
use App\Http\Controllers\FacturasController;
use App\Http\Controllers\PdfsGastosController;
use App\Http\Controllers\ordenComprasController;
use App\Http\Controllers\FormaContactoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('certificados', [CertificadoController::class, 'index']);

//RUTAS PARA CONSULTAS
Route::resource('clientes', ClientesController::class);
Route::resource('orden', OrdensController::class);
Route::resource('ciudades', CiudadesController::class);
Route::resource('colonias', ColoniasController::class);
Route::resource('completarOrden', CompletarOrdenesController::class);
Route::resource('comercios', ComerciosController::class);
Route::resource('certificados', CertificadoController::class);
Route::resource('productosInternos', ProductosInternosController::class);
Route::resource('productosExternos', ProductosExtrenosController::class);
Route::resource('empleados', EmpleadosController::class);
Route::resource('vias', ViasController::class);
Route::resource('problematica', ProblematicasController::class);
Route::resource('ingresos', IngresosController::class);
Route::resource('egresos', EgresosController::class);
Route::resource('remisiones', RemisionesController::class);
Route::resource('facturas', FacturasController::class);
Route::resource('ordenCompra', ordenComprasController::class);
Route::resource('formaContacto', FormaContactoController::class);


//RUTAS PARA PDF
Route::get('/remision/{id}', [PdfsController::class, 'generarPDFRem']);
Route::get('/ordenTrabajo/{id}',[PdfsController::class,'generarOrdenPDF']);
Route::get('/ordenTrabajoCompleta/{id}',[PdfsController::class,'generarOrden']);
Route::get('/certificadoRealizado/{id}',[PdfsController::class,'generarCertificado']);
Route::get('/ventsinfact/{f1}/{f2}',[PdfsController::class,'generarVentSinFact']);
Route::get('/ventconfact/{f1}/{f2}',[PdfsController::class,'generarVentConFact']);
Route::get('/ventatotales/{f1}/{f2}',[PdfsController::class,'generarVentasTotales']);
Route::get('/creditos/{f1}/{f2}',[PdfsController::class,'generarCreditos']);
Route::get('/creditosPendientes/{f1}/{f2}',[PdfsController::class,'generarCreditosPendientes']);
Route::get('/creditossinfactura/{f1}/{f2}',[PdfsController::class,'generarCreditosSinFactura']);
Route::get('/creditosconfactura/{f1}/{f2}',[PdfsController::class,'generarCreditosConFactura']);
Route::get('/pdfBanco',[PdfsGastosController::class,'generarPDFSaldoBancosFinal']);
Route::get('/pdfIngreso/{f1}/{f2}',[PdfsGastosController::class,'generarPDFIngreso']);
Route::get('/pdfEgreso/{f1}/{f2}',[PdfsGastosController::class,'generarPDFEgreso']);
Route::get('/pdfSaldo',[PdfsGastosController::class,'generarPDFSaldo']);
Route::get('/pdfIngresosBanco/{f1}/{f2}', [PdfsGastosController::class, 'generarPDFIngresoBanco']);
Route::get('/pdfEgresoBanco/{f1}/{f2}', [PdfsGastosController::class, 'generarPDFEgresoBanco']);
Route::get('/pdfSaldoBanco', [PdfsGastosController::class, 'generarPDFSaldoBanco']);

Route::get('/ordenDeCompra/{id}',[PdfsController::class,'generarOrdendecompra']);


Route::get('/pdfSaldoCaja/{f1}/{f2}', [PdfsGastosController::class, 'generarPDFSaldo2']);
Route::get('/pdfBanco/{f1}/{f2}', [PdfsGastosController::class, 'generarPDFBancoFilt']);

Route::get('/empleados', [EmpleadosController::class, 'index']);


//VER OPCIONES
Route::get('/verCiudades',[CiudadesController::class,'verCiudades']);
Route::get('/verColonia',[ColoniasController::class,'verColonia']);
Route::get('/verDepartamento',[ComerciosController::class,'verDepartamento']);
Route::get('/verColoniaPorCiudad/{cityId}', [ColoniasController::class, 'verColoniaPorCiudad']);
Route::get('/verProductosInternos',[ProductosInternosController::class,'verProductosInternos']);
Route::get('/verProductosExternos',[ProductosExtrenosController::class,'verProductosExternos']);
Route::get('/verEmpleados',[EmpleadosController::class,'verEmpleados']);
Route::get('/verVias',[ViasController::class,'verVias']);
Route::get('/verProblematicas',[ProblematicasController::class,'verProblematicas']);
Route::get('/verFormaDeContacto',[FormaContactoController::class,'verFormaDeContacto']);


//CONTEOS
Route::get('/totales', [AdminController::class, 'totales']);
Route::get('/totalDinero', [AdminController::class, 'totalDinero']);
Route::get('/totalCaja', [AdminController::class, 'totalCaja']);

//RUTA PARA LA MODIFICACION
Route::put('actualizarEstado/{id}', [CompletarOrdenesController::class, 'actualizarEstado']);
Route::put('datoNuevo/{id}', [CompletarOrdenesController::class, 'datoNuevo']);
Route::put('desactivarCliente/{id}', [ClientesController::class, 'desactivarCliente']);
Route::put('desactivarOrden/{id}', [OrdensController::class, 'desactivarOrden']);
Route::put('verEstadoOrden/{id}', [OrdensController::class, 'verEstadoOrden']);
Route::put('verEstadoFacturacion/{id}', [OrdensController::class, 'verEstadoFacturacion']);
Route::put('verEstadoCertificado/{id}', [OrdensController::class, 'verEstadoCertificado']);
Route::put('desactivarProductoInterno/{id}', [ProductosInternosController::class, 'desactivarProductoInterno']);
Route::put('desactivarProductoExterno/{id}', [ProductosExtrenosController::class, 'desactivarProductoExterno']);
Route::put('desactivarEmpleado/{id}', [EmpleadosController::class, 'desactivarEmpleado']);
Route::put('desactivarVia/{id}', [ViasController::class, 'desactivarVia']);
Route::put('desactivarCiudad/{id}', [CiudadesController::class, 'desactivarCiudad']);
Route::put('desactivarProblematica/{id}', [ProblematicasController::class, 'desactivarProblematica']);
Route::put('desactivarFormaDeContacto/{id}', [FormaContactoController::class, 'desactivarFormaDeContacto']);
Route::put('creditoPermanente/{id}', [CompletarOrdenesController::class, 'creditoPermanente']);

//FILTRO DE FECHAS DE HOME
Route::get('/completarordenes/por-fecha', [CompletarOrdenesController::class, 'completarPorFecha']);