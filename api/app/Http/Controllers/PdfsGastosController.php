<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Validator;
use App\Models\Orden;
use App\Models\CompletarOrden;
use App\Models\Certificado;
use App\Models\Ingresos;
use App\Models\Egresos;
use App\Models\Remisiones;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class PdfsGastosController extends Controller
{
   
    public function generarPDFIngreso($f1, $f2) {
        // Convertir las fechas a Carbon con formato Y-m-d para comparaciones
        $f1 = Carbon::parse($f1)->startOfDay(); // 2025-02-01 00:00:00
        $f2 = Carbon::parse($f2)->endOfDay();   // 2025-02-28 23:59:59
        
        // 🔹 INGRESOS - Filtrar por dateIngreso (convertir a formato Y-m-d)
        $data = Ingresos::where('dataIngreso', 'Caja')
            ->whereBetween(DB::raw("STR_TO_DATE(dateIngreso, '%d-%m-%Y')"), [$f1, $f2])  // Convertir de DD-MM-YYYY a Y-m-d
            ->get();
        
        // 🔹 ORDENES DE TRABAJO - Filtrar por updated_at
        $dataCO = CompletarOrden::select([
            'completarordenes.*',
            'orden.updated_at as date1',
            'clientes.name',
            'clientes.lastname1',
            'clientes.lastname2',
        ])
        ->join('orden', 'completarordenes.id_orden', '=', 'orden.id')
        ->join('clientes', 'orden.id_cliente', '=', 'clientes.id')
        ->where('completarordenes.requiere3', 'Pagado/Efectivo')    
        ->whereBetween('orden.updated_at', [$f1, $f2]) // `updated_at` ya está en formato Y-m-d
        ->get();
        
        // 🔹 TOTAL PAGOS - Sumar pagos con filtro en updated_at
        $totalPagos = CompletarOrden::where('requiere3', 'Pagado/Efectivo')
            ->whereBetween('updated_at', [$f1, $f2]) // `updated_at` ya está en formato Y-m-d
            ->sum('pago');
        
        // 🔹 TOTAL INGRESOS ADICIONALES - Filtrar por dateIngreso (convertir a formato Y-m-d)
        $totalIngresosAdicionales = Ingresos::where('dataIngreso', 'Caja')
            ->whereBetween(DB::raw("STR_TO_DATE(dateIngreso, '%d-%m-%Y')"), [$f1, $f2])  // Convertir de DD-MM-YYYY a Y-m-d
            ->sum('montoIngreso');
        
        $totalCaja = $totalPagos + $totalIngresosAdicionales;
    
        // 🔹 Imagen del logo
        $path = public_path('img/membretadoFumi.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data_img = file_get_contents($path);
        $base64 = 'data:image/'.$type.';base64,'.base64_encode($data_img);
        
        // 🔹 Pasar los datos a la vista
        $pdf_data = compact('base64', 'data', 'dataCO', 'totalCaja', 'f1', 'f2');
        $pdf = Pdf::loadView('reports.repoIngresos', $pdf_data);
    
        return $pdf->stream();
    }

    // Otras funciones del controlador...


    public function generarPDFIngresoBanco($f1, $f2) {
        // Convertir las fechas a Carbon con formato Y-m-d para comparaciones
        $f1 = Carbon::parse($f1)->startOfDay(); // 2025-02-01 00:00:00
        $f2 = Carbon::parse($f2)->endOfDay();   // 2025-02-28 23:59:59
        
        // 🔹 INGRESOS - Filtrar por dateIngreso (convertir a formato Y-m-d)
        $data = Ingresos::where('dataIngreso', 'Banco')
            ->whereBetween(DB::raw("STR_TO_DATE(dateIngreso, '%d-%m-%Y')"), [$f1, $f2])  // Convertir de DD-MM-YYYY a Y-m-d
            ->get();
        
        // 🔹 ORDENES DE TRABAJO - Filtrar por updated_at
        $dataCO = CompletarOrden::select([
            'completarordenes.*',
            'orden.updated_at as date1',
            'clientes.name',
            'clientes.lastname1',
            'clientes.lastname2',
        ])
        ->join('orden', 'completarordenes.id_orden', '=', 'orden.id')
        ->join('clientes', 'orden.id_cliente', '=', 'clientes.id')
        ->where('completarordenes.requiere3', 'Pagado/Banco')    
        ->whereBetween('orden.updated_at', [$f1, $f2]) // `updated_at` ya está en formato Y-m-d
        ->get();
        
        // 🔹 TOTAL PAGOS - Sumar pagos con filtro en updated_at
        $totalPagos = CompletarOrden::where('requiere3', 'Pagado/Banco')
            ->whereBetween('updated_at', [$f1, $f2]) // `updated_at` ya está en formato Y-m-d
            ->sum('pago');
        
        // 🔹 TOTAL INGRESOS BANCARIOS - Filtrar por dateIngreso (convertir a formato Y-m-d)
        $totalIngresosBanco = Ingresos::where('dataIngreso', 'Banco')
            ->whereBetween(DB::raw("STR_TO_DATE(dateIngreso, '%d-%m-%Y')"), [$f1, $f2])  // Convertir de DD-MM-YYYY a Y-m-d
            ->sum('montoIngreso');
        
        // 🔹 TOTAL CAJA - Sumar total de pagos e ingresos bancarios
        $totalCaja = $totalPagos + $totalIngresosBanco;
    
        // 🔹 Imagen del logo
        $path = public_path('img/membretadoFumi.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data_img = file_get_contents($path);
        $base64 = 'data:image/'.$type.';base64,'.base64_encode($data_img);
        
        // 🔹 Pasar los datos a la vista para generar el PDF
        $pdf_data = compact('base64', 'data', 'dataCO', 'totalCaja', 'f1', 'f2');
        $pdf = Pdf::loadView('reports.repoIngresosBanco', $pdf_data);
    
        return $pdf->stream(); // Genera y muestra el PDF
    }



public function generarPDFEgreso($f1, $f2) {
    // Convertir las fechas a Carbon con formato Y-m-d para comparaciones
    $f1 = Carbon::parse($f1)->startOfDay(); // 2025-02-01 00:00:00
    $f2 = Carbon::parse($f2)->endOfDay();   // 2025-02-28 23:59:59
    
    // 🔹 EGRESOS - Filtrar por dateEgresos (convertir a formato Y-m-d)
    $dataEg = Egresos::select([
            'egresos.*',
            'comercios.comercio',
        ])
        ->join('comercios', 'egresos.id_departamento1', '=', 'comercios.id')
        ->where('dataEgresos', 'Caja')
        ->whereBetween(DB::raw("STR_TO_DATE(dateEgresos, '%d-%m-%Y')"), [$f1, $f2])  // Convertir de DD-MM-YYYY a Y-m-d
        ->get();
    
    // 🔹 TOTAL EGRESOS - Sumar montoEgresos con filtro en dateEgresos
    $totalEgresos = Egresos::where('dataEgresos', 'Caja')
        ->whereBetween(DB::raw("STR_TO_DATE(dateEgresos, '%d-%m-%Y')"), [$f1, $f2])  // Convertir de DD-MM-YYYY a Y-m-d
        ->sum('montoEgresos');
    
    // 🔹 Imagen del logo
    $path = public_path('img/membretadoFumi.png');
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data_img = file_get_contents($path);
    $base64 = 'data:image/'.$type.';base64,'.base64_encode($data_img);
    
    // 🔹 Pasar los datos a la vista
    $pdf_data = compact('base64', 'dataEg', 'totalEgresos', 'f1', 'f2');
    $pdf = Pdf::loadView('reports.repoEgreso', $pdf_data);

    return $pdf->stream();
}


public function generarPDFEgresoBanco($f1, $f2) {
    // Convertir las fechas a Carbon con formato Y-m-d para comparaciones
    $f1 = Carbon::parse($f1)->startOfDay(); // 2025-02-01 00:00:00
    $f2 = Carbon::parse($f2)->endOfDay();   // 2025-02-28 23:59:59
    
    // 🔹 EGRESOS - Filtrar por dateEgresos (convertir a formato Y-m-d)
    $dataEg = Egresos::select([
            'egresos.*',
            'comercios.comercio',
        ])
        ->join('comercios', 'egresos.id_departamento1', '=', 'comercios.id')
        ->where('dataEgresos', 'Banco')
        ->whereBetween(DB::raw("STR_TO_DATE(dateEgresos, '%d-%m-%Y')"), [$f1, $f2])  // Convertir de DD-MM-YYYY a Y-m-d
        ->get();
    
    // 🔹 TOTAL EGRESOS - Sumar montoEgresos con filtro en dateEgresos
    $totalEgresos = Egresos::where('dataEgresos', 'Banco')
        ->whereBetween(DB::raw("STR_TO_DATE(dateEgresos, '%d-%m-%Y')"), [$f1, $f2])  // Convertir de DD-MM-YYYY a Y-m-d
        ->sum('montoEgresos');
    
    // 🔹 Imagen del logo
    $path = public_path('img/membretadoFumi.png');
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data_img = file_get_contents($path);
    $base64 = 'data:image/'.$type.';base64,'.base64_encode($data_img);
    
    // 🔹 Pasar los datos a la vista
    $pdf_data = compact('base64', 'dataEg', 'totalEgresos', 'f1', 'f2');
    $pdf = Pdf::loadView('reports.repoEgresoBanco', $pdf_data);

    return $pdf->stream();
}
    public function generarPDFSaldo(){
        $data = Ingresos ::all()->where('dataIngreso', 'Caja');

        $dataCO = CompletarOrden::select([
            'completarordenes.*',
            'orden.date1',
            'clientes.name',
            'clientes.lastname1',
            'clientes.lastname2',
        ])
        ->join('orden', 'completarordenes.id_orden', '=', 'orden.id')
        ->join('clientes', 'orden.id_cliente', '=', 'clientes.id')
        ->where('completarordenes.requiere3', 'Pagado/Efectivo')
        ->get();

        // Obtener la suma total de 'pago' de CompletarOrden
        $totalPagos = CompletarOrden::where('requiere3', 'Pagado/Efectivo')->sum('pago');

        // Obtener la suma total de 'montoIngreso' de Ingresos
        $totalIngresosAdicionales = Ingresos::where('dataIngreso', 'Caja')->sum('montoIngreso');

        $totalCaja = $totalPagos + $totalIngresosAdicionales;

        $dataEg = Egresos ::select([
            'egresos.*',
            'comercios.comercio',
        ])
        ->join('comercios', 'egresos.id_departamento1', '=', 'comercios.id')
        ->where('dataEgresos', 'Caja')
        ->get();

        $totalEgresos = Egresos::where('dataEgresos', 'Caja')->sum('montoEgresos');


        $totalSaldo = $totalCaja - $totalEgresos;
    
        
        /* Imagen Del Logo */
        $path = public_path('img/membretadoFumi.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data_img = file_get_contents($path);
        $base64 = 'data:image/'.$type.';base64,'.base64_encode($data_img);
        //dd($base64);
        //$pdf_data = compact('data','clientes','base64');
        $pdf_data = compact('base64','data','dataCO','totalCaja','dataEg','totalEgresos','totalSaldo');
        $pdf = Pdf::loadView('reports.repoSaldo',$pdf_data);
        return $pdf->stream();
        return $pdf->download('invoice.pdf');
    }

    public function generarPDFSaldoBanco(){
        $data = Ingresos ::all()->where('dataIngreso', 'Banco');

        $dataCO = CompletarOrden::select([
            'completarordenes.*',
            'orden.date1',
            'clientes.name',
            'clientes.lastname1',
            'clientes.lastname2',
        ])
        ->join('orden', 'completarordenes.id_orden', '=', 'orden.id')
        ->join('clientes', 'orden.id_cliente', '=', 'clientes.id')
        ->where('completarordenes.requiere3', 'Pagado/Banco')
        ->get();

        // Obtener la suma total de 'pago' de CompletarOrden
        $totalPagos = CompletarOrden::where('requiere3', 'Pagado/Banco')->sum('pago');

        // Obtener la suma total de 'montoIngreso' de Ingresos
        $totalIngresosAdicionales = Ingresos::where('dataIngreso', 'Banco')->sum('montoIngreso');

        $totalCaja = $totalPagos + $totalIngresosAdicionales;

        $dataEg = Egresos ::select([
            'egresos.*',
            'comercios.comercio',
        ])
        ->join('comercios', 'egresos.id_departamento1', '=', 'comercios.id')
        ->where('dataEgresos', 'Banco')
        ->get();

        $totalEgresos = Egresos::where('dataEgresos', 'Banco')->sum('montoEgresos');


        $totalSaldo = $totalCaja - $totalEgresos;
    
        
        /* Imagen Del Logo */
        $path = public_path('img/membretadoFumi.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data_img = file_get_contents($path);
        $base64 = 'data:image/'.$type.';base64,'.base64_encode($data_img);
        //dd($base64);
        //$pdf_data = compact('data','clientes','base64');
        $pdf_data = compact('base64','data','dataCO','totalCaja','dataEg','totalEgresos','totalSaldo');
        $pdf = Pdf::loadView('reports.repoSaldoBanco',$pdf_data);
        return $pdf->stream();
        return $pdf->download('invoice.pdf');
    }

    public function generarPDFSaldo2($f1, $f2) {
        // Convertir fechas a Carbon con formato Y-m-d para comparaciones
        $f1 = Carbon::parse($f1)->startOfDay(); // 2025-02-01 00:00:00
        $f2 = Carbon::parse($f2)->endOfDay();   // 2025-02-28 23:59:59
        
        // 🔹 INGRESOS - Filtrar por dateIngreso (convertir a formato Y-m-d)
        $data = Ingresos::where('dataIngreso', 'Caja')
            ->whereBetween(DB::raw("STR_TO_DATE(dateIngreso, '%d-%m-%Y')"), [$f1, $f2])  // Convertir de DD-MM-YYYY a Y-m-d
            ->get();
        
        // 🔹 ORDENES DE TRABAJO - Filtrar por updated_at
        $dataCO = CompletarOrden::select([
                'completarordenes.*',
                'orden.updated_at as date1',
                'clientes.name',
                'clientes.lastname1',
                'clientes.lastname2',
            ])
            ->join('orden', 'completarordenes.id_orden', '=', 'orden.id')
            ->join('clientes', 'orden.id_cliente', '=', 'clientes.id')
            ->where('completarordenes.requiere3', 'Pagado/Efectivo')    
            ->whereBetween('orden.updated_at', [$f1, $f2]) // `updated_at` ya está en formato Y-m-d
            ->get();
        
        // 🔹 TOTAL PAGOS - Sumar pagos con filtro en updated_at
        $totalPagos = CompletarOrden::where('requiere3', 'Pagado/Efectivo')
            ->whereBetween('updated_at', [$f1, $f2]) // `updated_at` ya está en formato Y-m-d
            ->sum('pago');
        
        // 🔹 TOTAL INGRESOS ADICIONALES - Filtrar por dateIngreso (convertir a formato Y-m-d)
        $totalIngresosAdicionales = Ingresos::where('dataIngreso', 'Caja')
            ->whereBetween(DB::raw("STR_TO_DATE(dateIngreso, '%d-%m-%Y')"), [$f1, $f2])  // Convertir de DD-MM-YYYY a Y-m-d
            ->sum('montoIngreso');
        
        $totalCaja = $totalPagos + $totalIngresosAdicionales;
        
        // 🔹 EGRESOS - Filtrar por dateEgresos (convertir a formato Y-m-d)
        $dataEg = Egresos::where('dataEgresos', 'Caja')
            ->whereBetween(DB::raw("STR_TO_DATE(dateEgresos, '%d-%m-%Y')"), [$f1, $f2])  // Convertir de DD-MM-YYYY a Y-m-d
            ->get();
        
        // 🔹 TOTAL EGRESOS - Sumar montoEgresos con filtro en dateEgresos
        $totalEgresos = Egresos::where('dataEgresos', 'Caja')
            ->whereBetween(DB::raw("STR_TO_DATE(dateEgresos, '%d-%m-%Y')"), [$f1, $f2])  // Convertir de DD-MM-YYYY a Y-m-d
            ->sum('montoEgresos');
        
        $totalSaldo = $totalCaja - $totalEgresos;
        
        // 🔹 Imagen del logo
        $path = public_path('img/membretadoFumi.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data_img = file_get_contents($path);
        $base64 = 'data:image/'.$type.';base64,'.base64_encode($data_img);
        
        // 🔹 Generar PDF
        $pdf_data = compact('base64', 'data', 'dataCO', 'totalCaja', 'dataEg', 'totalEgresos', 'totalSaldo', 'f1', 'f2');
        $pdf = Pdf::loadView('reports.repoSaldoFilt', $pdf_data);
    
        return $pdf->stream();
    }
    public function generarPDFBancoFilt($f1, $f2) {
        // Convertir fechas a Carbon con formato Y-m-d para comparaciones
        $f1 = Carbon::parse($f1)->startOfDay(); // 2025-02-01 00:00:00
        $f2 = Carbon::parse($f2)->endOfDay();   // 2025-02-28 23:59:59
    
        // 🔹 INGRESOS - Filtrar por dateIngreso (convertir a formato Y-m-d)
        $data = Ingresos::where('dataIngreso', 'Banco')
            ->whereBetween(DB::raw("STR_TO_DATE(dateIngreso, '%d-%m-%Y')"), [$f1, $f2])  // Convertir de DD-MM-YYYY a Y-m-d
            ->get();
    
        // 🔹 ORDENES DE TRABAJO - Filtrar por updated_at
        $dataCO = CompletarOrden::select([
            'completarordenes.*',
            'orden.updated_at as date1',
            'clientes.name',
            'clientes.lastname1',
            'clientes.lastname2',
        ])
        ->join('orden', 'completarordenes.id_orden', '=', 'orden.id')
        ->join('clientes', 'orden.id_cliente', '=', 'clientes.id')
        ->where('completarordenes.requiere3', 'Pagado/Banco')    
        ->whereBetween('orden.updated_at', [$f1, $f2]) // `updated_at` ya está en formato Y-m-d
        ->get();
    
        // 🔹 TOTAL PAGOS - Sumar pagos con filtro en updated_at
        $totalPagos = CompletarOrden::where('requiere3', 'Pagado/Banco')
            ->whereBetween('updated_at', [$f1, $f2]) // `updated_at` ya está en formato Y-m-d
            ->sum('pago');
    
        // 🔹 TOTAL INGRESOS ADICIONALES - Filtrar por dateIngreso (convertir a formato Y-m-d)
        $totalIngresosAdicionales = Ingresos::where('dataIngreso', 'Banco')
            ->whereBetween(DB::raw("STR_TO_DATE(dateIngreso, '%d-%m-%Y')"), [$f1, $f2])  // Convertir de DD-MM-YYYY a Y-m-d
            ->sum('montoIngreso');
    
        $totalCaja = $totalPagos + $totalIngresosAdicionales;
    
        // 🔹 EGRESOS - Filtrar por dateEgresos (convertir a formato Y-m-d)
        $dataEg = Egresos::where('dataEgresos', 'Banco')
            ->whereBetween(DB::raw("STR_TO_DATE(dateEgresos, '%d-%m-%Y')"), [$f1, $f2])  // Convertir de DD-MM-YYYY a Y-m-d
            ->get();
    
        // 🔹 TOTAL EGRESOS - Sumar montoEgresos con filtro en dateEgresos
        $totalEgresos = Egresos::where('dataEgresos', 'Banco')
            ->whereBetween(DB::raw("STR_TO_DATE(dateEgresos, '%d-%m-%Y')"), [$f1, $f2])  // Convertir de DD-MM-YYYY a Y-m-d
            ->sum('montoEgresos');
    
        $totalSaldo = $totalCaja - $totalEgresos;
    
        // 🔹 Imagen del logo
        $path = public_path('img/membretadoFumi.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data_img = file_get_contents($path);
        $base64 = 'data:image/'.$type.';base64,'.base64_encode($data_img);
    
        // 🔹 Generar PDF
        $pdf_data = compact('base64', 'data', 'dataCO', 'totalCaja', 'dataEg', 'totalEgresos', 'totalSaldo', 'f1', 'f2');
        $pdf = Pdf::loadView('reports.repoBanco', $pdf_data);
    
        return $pdf->stream();
    }
}
