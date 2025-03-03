<?php

namespace App\Http\Controllers;

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
        // Convertir las fechas a formato Y-m-d si no lo están
        $f1up=$f1;
        $f2up=$f2;
        $f1up = Carbon::parse($f1)->startOfDay()->format('Y-m-d H:i:s');
        $f2up = Carbon::parse($f2)->endOfDay()->format('Y-m-d H:i:s');
        

        // Filtrar ingresos donde dataIngreso sea 'Caja' y dentro del rango de fechas
        $data = Ingresos::where('dataIngreso', 'Caja')
            ->whereBetween('dateIngreso', [$f1, $f2])
            ->get();

        // Filtrar órdenes de trabajo donde requiere3 sea 'Pagado/Efectivo' y dentro del rango de fechas
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
        ->whereBetween('orden.updated_at', [$f1up, $f2up])
        ->get();

        // Obtener la suma total de 'pago' de CompletarOrden donde requiere3 sea 'Pagado/Efectivo'
        $totalPagos = CompletarOrden::where('requiere3', 'Pagado/Efectivo')
            ->whereBetween('updated_at', [$f1up, $f2up])
            ->sum('pago');

        // Obtener la suma total de 'montoIngreso' de Ingresos donde dataIngreso sea 'Caja'
        $totalIngresosAdicionales = Ingresos::where('dataIngreso', 'Caja')
            ->whereBetween('dateIngreso', [$f1, $f2])
            ->sum('montoIngreso');

        $totalCaja = $totalPagos + $totalIngresosAdicionales;

        /* Imagen Del Logo */
        $path = public_path('img/membretadoFumi.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data_img = file_get_contents($path);
        $base64 = 'data:image/'.$type.';base64,'.base64_encode($data_img);

        // Pasar los datos a la vista
        $pdf_data = compact('base64', 'data', 'dataCO', 'totalCaja', 'f1', 'f2');
        $pdf = Pdf::loadView('reports.repoIngresos', $pdf_data);

        return $pdf->stream();
    }

    // Otras funciones del controlador...


public function generarPDFIngresoBanco($f1, $f2) {
    // Convertir las fechas a formato Y-m-d si no lo están
    $f1 = Carbon::parse($f1)->format('Y-m-d');
    $f2 = Carbon::parse($f2)->format('Y-m-d');

    // Filtrar ingresos donde dataIngreso sea 'Banco' y dentro del rango de fechas
    $data = Ingresos::where('dataIngreso', 'Banco')
        ->whereBetween('dateIngreso', [$f1, $f2])
        ->get();

    // Filtrar órdenes de trabajo donde requiere3 sea 'Pagado/Banco' y dentro del rango de fechas
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
    ->whereBetween('orden.updated_at', [$f1, $f2])
    ->get();

    // Obtener la suma total de 'pago' de CompletarOrden donde requiere3 sea 'Pagado/Banco'
    $totalPagos = CompletarOrden::where('requiere3', 'Pagado/Banco')
        ->whereBetween('updated_at', [$f1, $f2])
        ->sum('pago');

    // Obtener la suma total de 'montoIngreso' de Ingresos donde dataIngreso sea 'Banco'
    $totalIngresosBanco = Ingresos::where('dataIngreso', 'Banco')
        ->whereBetween('dateIngreso', [$f1, $f2])
        ->sum('montoIngreso');

    $totalCaja = $totalPagos + $totalIngresosBanco;

    /* Imagen Del Logo */
    $path = public_path('img/membretadoFumi.png');
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data_img = file_get_contents($path);
    $base64 = 'data:image/'.$type.';base64,'.base64_encode($data_img);

    // Pasar los datos a la vista
    $pdf_data = compact('base64', 'data', 'dataCO', 'totalCaja', 'f1', 'f2');
    $pdf = Pdf::loadView('reports.repoIngresosBanco', $pdf_data);

    return $pdf->stream();
}
    



public function generarPDFEgreso($f1, $f2) {
    // Convertir las fechas a formato Y-m-d si no lo están

    // Filtrar egresos donde dataEgresos sea 'Caja' y dentro del rango de fechas
    $dataEg = Egresos::select([
        'egresos.*',
        'comercios.comercio',
    ])
    ->join('comercios', 'egresos.id_departamento1', '=', 'comercios.id')
    ->where('dataEgresos', 'Caja')
    ->whereBetween('dateEgresos', [$f1, $f2])
    ->get();

    // Obtener la suma total de 'montoEgresos' de Egresos
    $totalEgresos = Egresos::where('dataEgresos', 'Caja')
        ->whereBetween('dateEgresos', [$f1, $f2])
        ->sum('montoEgresos');

    /* Imagen Del Logo */
    $path = public_path('img/membretadoFumi.png');
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data_img = file_get_contents($path);
    $base64 = 'data:image/'.$type.';base64,'.base64_encode($data_img);

    // Pasar los datos a la vista
    $pdf_data = compact('base64', 'dataEg', 'totalEgresos', 'f1', 'f2');
    $pdf = Pdf::loadView('reports.repoEgreso', $pdf_data);

    return $pdf->stream();
}


    public function generarPDFEgresoBanco($f1, $f2) {
        
    
        // Filtrar egresos donde dataEgresos sea 'Banco' y dentro del rango de fechas
        $dataEg = Egresos::select([
            'egresos.*',
            'comercios.comercio',
        ])
        ->join('comercios', 'egresos.id_departamento1', '=', 'comercios.id')
        ->where('dataEgresos', 'Banco')
        ->whereBetween('dateEgresos', [$f1, $f2])
        ->get();
    
        // Obtener la suma total de 'montoEgresos' de Egresos
        $totalEgresos = Egresos::where('dataEgresos', 'Banco')
            ->whereBetween('dateEgresos', [$f1, $f2])
            ->sum('montoEgresos');
    
        /* Imagen Del Logo */
        $path = public_path('img/membretadoFumi.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data_img = file_get_contents($path);
        $base64 = 'data:image/'.$type.';base64,'.base64_encode($data_img);
    
        // Pasar los datos a la vista
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
        // Convertir las fechas a formato Y-m-d H:i:s si no lo están
        $f1up=$f1;
        $f2up=$f2;
        $f1up = Carbon::parse($f1)->startOfDay()->format('Y-m-d H:i:s');
        $f2up = Carbon::parse($f2)->endOfDay()->format('Y-m-d H:i:s');
    
        // Filtrar ingresos donde dataIngreso sea 'Caja' y dentro del rango de fechas
        $data = Ingresos::where('dataIngreso', 'Caja')
            ->where(function($query) use ($f1, $f2) {
                $query->whereBetween('dateIngreso', [$f1, $f2])
                      ->orWhere('dateIngreso', $f1)
                      ->orWhere('dateIngreso', $f2);
            })
            ->get();
    
        // Filtrar órdenes de trabajo donde requiere3 sea 'Pagado/Efectivo' y dentro del rango de fechas
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
        ->where(function($query) use ($f1up, $f2up) {
            $query->whereBetween('orden.updated_at', [$f1up, $f2up])
                  ->orWhere('orden.updated_at', $f1up)
                  ->orWhere('orden.updated_at', $f2up);
        })
        ->get();
    
        // Obtener la suma total de 'pago' de CompletarOrden donde requiere3 sea 'Pagado/Efectivo'
        $totalPagos = CompletarOrden::where('requiere3', 'Pagado/Efectivo')
        ->where(function($query) use ($f1up, $f2up) {
            $query->whereBetween('updated_at', [$f1up, $f2up])
                  ->orWhere('updated_at', $f1up)
                  ->orWhere('updated_at', $f2up);
        })
        ->sum('pago');
    
        // Obtener la suma total de 'montoIngreso' de Ingresos
        $totalIngresosAdicionales = Ingresos::where('dataIngreso', 'Caja')
            ->where(function($query) use ($f1, $f2) {
                $query->whereBetween('dateIngreso', [$f1, $f2])
                      ->orWhere('dateIngreso', $f1)
                      ->orWhere('dateIngreso', $f2);
            })
            ->sum('montoIngreso');
    
        $totalCaja = $totalPagos + $totalIngresosAdicionales;
    
        $dataEg = Egresos::select([
            'egresos.*',
            'comercios.comercio',
        ])
        ->join('comercios', 'egresos.id_departamento1', '=', 'comercios.id')
        ->where('dataEgresos', 'Caja')
        ->where(function($query) use ($f1, $f2) {
            $query->whereBetween('dateEgresos', [$f1, $f2])
                  ->orWhere('dateEgresos', $f1)
                  ->orWhere('dateEgresos', $f2);
        })
        ->get();
    
        $totalEgresos = Egresos::where('dataEgresos', 'Caja')
            ->where(function($query) use ($f1, $f2) {
                $query->whereBetween('dateEgresos', [$f1, $f2])
                      ->orWhere('dateEgresos', $f1)
                      ->orWhere('dateEgresos', $f2);
            })
            ->sum('montoEgresos');
    
        $totalSaldo = $totalCaja - $totalEgresos;
    
        /* Imagen Del Logo */
        $path = public_path('img/membretadoFumi.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data_img = file_get_contents($path);
        $base64 = 'data:image/'.$type.';base64,'.base64_encode($data_img);
    
        // Definir la función formatDate
        $formatDate = function($item) {
            if ($item->requiere3 === 'Pagado/Efectivo' || $item->requiere3 === 'Pagado/Banco') {
                return Carbon::parse($item->updated_at)->format('d-m-Y');
            }
            return 'Sin pago';
        };
    
        // Filtrar los datos de dataCO por la fecha formateada
        $dataCO = $dataCO->filter(function($item) use ($f1, $f2, $formatDate) {
            $formattedDate = $formatDate($item);
            $date = Carbon::createFromFormat('d-m-Y', $formattedDate);
            return $date->between(Carbon::parse($f1)->startOfDay(), Carbon::parse($f2)->endOfDay());
        });
    
        // Pasar los datos a la vista
        $pdf_data = compact('base64', 'data', 'dataCO', 'totalCaja', 'dataEg', 'totalEgresos', 'totalSaldo', 'formatDate', 'f1', 'f2');
        $pdf = Pdf::loadView('reports.repoSaldoFilt', $pdf_data);
    
        return $pdf->stream();
    }
public function generarPDFBancoFilt($f1, $f2) {
    // Convertir las fechas a formato Y-m-d si no lo están
    $f1 = Carbon::parse($f1)->format('Y-m-d');
    $f2 = Carbon::parse($f2)->format('Y-m-d');
    $f2 = Carbon::parse($f2)->format('Y-m-d');


    // Filtrar ingresos donde dataIngreso sea 'Banco' y dentro del rango de fechas
    $data = Ingresos::where('dataIngreso', 'Banco')
        ->whereBetween('dateIngreso', [$f1, $f2])
        ->get();

    // Filtrar órdenes de trabajo donde requiere3 sea 'Pagado/Banco' y dentro del rango de fechas
    $dataCO = CompletarOrden::select([
        'completarordenes.*',
        'orden.updated_at as date1', // Usar updated_at como date1
        'clientes.name',
        'clientes.lastname1',
        'clientes.lastname2',
    ])
    ->join('orden', 'completarordenes.id_orden', '=', 'orden.id')
    ->join('clientes', 'orden.id_cliente', '=', 'clientes.id')
    ->where('completarordenes.requiere3', 'Pagado/Banco')    
    ->whereBetween('orden.updated_at', [$f1, $f2]) // Filtrar por updated_at
    ->get();

    // Obtener la suma total de 'pago' de CompletarOrden
    $totalPagos = CompletarOrden::where('requiere3', 'Pagado/Banco')
        ->whereBetween('updated_at', [$f1, $f2]) // Filtrar por updated_at
        ->sum('pago');

    // Obtener la suma total de 'montoIngreso' de Ingresos
    $totalIngresosAdicionales = Ingresos::where('dataIngreso', 'Banco')
        ->whereBetween('dateIngreso', [$f1, $f2])
        ->sum('montoIngreso');

    $totalCaja = $totalPagos + $totalIngresosAdicionales;

    $dataEg = Egresos::where('dataEgresos', 'Banco')
        ->whereBetween('dateEgresos', [$f1, $f2])
        ->get();

    $totalEgresos = Egresos::where('dataEgresos', 'Banco')
        ->whereBetween('dateEgresos', [$f1, $f2])
        ->sum('montoEgresos');

    $totalSaldo = $totalCaja - $totalEgresos;

    /* Imagen Del Logo */
    $path = public_path('img/membretadoFumi.png');
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data_img = file_get_contents($path);
    $base64 = 'data:image/'.$type.';base64,'.base64_encode($data_img);

    // Pasar los datos a la vista
    $pdf_data = compact('base64', 'data', 'dataCO', 'totalCaja', 'dataEg', 'totalEgresos', 'totalSaldo', 'f1', 'f2');
    $pdf = Pdf::loadView('reports.repoBanco', $pdf_data);

    return $pdf->stream();
}
    

}
