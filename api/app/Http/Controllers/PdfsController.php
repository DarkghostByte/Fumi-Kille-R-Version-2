<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // Importar la clase Log
use Validator;
use App\Models\Orden;
use App\Models\CompletarOrden;
use App\Models\Certificado;
use App\Models\Ingresos;
use App\Models\Egresos;
use App\Models\Remisiones;
use App\Models\ordenCompra;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;


class PdfsController extends Controller
{
    public function generarPDFRem($id) {
        $data = Remisiones::select([
            'remisiones.*',
            'clientes.name',
            'clientes.lastname1',
            'clientes.lastname2',
            'clientes.tradename',
            'clientes.home',
            'clientes.numAddress',
            'clientes.id_colonia',
            'clientes.id_city',
            'clientes.comercio',
            'clientes.cell_phone',
            'clientes.number_fixed_number',
            'colonias.colonia',
            'colonias.codigoPostal',
            'ciudades.ciudad'
        ])
        ->join('clientes', 'remisiones.id_cliente', '=', 'clientes.id')
        ->join('colonias', 'clientes.id_colonia', '=', 'colonias.id')
        ->join('ciudades', 'clientes.id_city', '=', 'ciudades.id')
        ->where('remisiones.id', $id)
        ->first();
    
        // Verificar si se encontró un registro
        if (!$data) {
            Log::error("No se encontraron datos para la remisión con ID: $id");
            return abort(404, 'No se encontraron datos.');
        }
    
        // Verificar si RemisionDate está presente
        if (!isset($data->RemisionDate)) {
            Log::error("RemisionDate no está presente para la remisión con ID: $id");
        }
    
        /* Imagen Del Logo */
        $path = public_path('img/membretadoFumioOrden.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data_img = file_get_contents($path);
        $base64 = 'data:image/'.$type.';base64,'.base64_encode($data_img);
        /* Imagen */
        $path1 = public_path('img/logofk.png');
        $type1 = pathinfo($path1, PATHINFO_EXTENSION);
        $data_img1 = file_get_contents($path1);
        $base641 = 'data:image/' . $type1 . ';base64,' . base64_encode($data_img1);
    
        setlocale(LC_ALL, 'es_MX.UTF-8','esp');
        date_default_timezone_set("America/Mexico_City"); // Establece el locale para español
    
        // Verificar si RemisionDate está presente
        if (isset($data->RemisionDate)) {
            $fecha = Carbon::parse($data->RemisionDate)->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY');
            str_replace('S?BADO','SÁBADO',$fecha);
        } else {
            $fecha = 'Fecha no disponible';
        }
    
        Carbon::setLocale('es');
        $pdf_data = compact('base64','base641','data','fecha');
        $pdf = Pdf::loadView('reports.repoRemision', $pdf_data)->setPaper('letter');     
        //$pdf = Pdf::loadView('reports.repoCer', $pdf_data)->setPaper('a4', 'landscape');
        return $pdf->stream();
    }

    public function generarOrdenPDF($id){        
        // Obtener datos del cliente junto con ciudad y colonia
        $orden = Orden::select([
            'orden.*',
            'clientes.name','clientes.lastname1','clientes.lastname2','clientes.tradename','clientes.home',
            'clientes.numAddress','clientes.id_colonia','clientes.id_city','clientes.cell_phone','clientes.how_to_get',
            'clientes.description','clientes.contact_form','clientes.recruitment_data','clientes.requires','clientes.comercio',
            'colonias.colonia','colonias.codigoPostal','ciudades.ciudad'
            ,'problematica1.problematica as plague1','problematica2.problematica as plague2',
        ])
        ->join('problematicas as problematica1', 'orden.id_plague1', '=', 'problematica1.id')
        ->join('problematicas as problematica2', 'orden.id_plague2', '=', 'problematica2.id')
        ->join('clientes', 'orden.id_cliente', '=', 'clientes.id')
        ->join('colonias', 'clientes.id_colonia', '=', 'colonias.id')
        ->join('ciudades', 'clientes.id_city', '=', 'ciudades.id')
        ->where('orden.id', $id)->first();
        //Datos de la base de datos
        if (!$orden) {
            return abort(404);
        }
        //PDF Orden de trabajo
        /* Imagen Del Logo */
        $path = public_path('img/membretadoFumi.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data_img = file_get_contents($path);
        $base64 = 'data:image/'.$type.';base64,'.base64_encode($data_img);
        /* Imagen */
        $path1 = public_path('img/logofk.png');
        $type1 = pathinfo($path1, PATHINFO_EXTENSION);
        $data_img1 = file_get_contents($path1);
        $base641 = 'data:image/' . $type1 . ';base64,' . base64_encode($data_img1);
        /* Fecha Date1 */
        $fecha=(strtoupper(strftime("%A,  %d de %B de %Y", strtotime($orden->date1))));
        str_replace('S?BADO','SÁBADO',$fecha);
        $fecha = Carbon::parse($orden->date1);
        /* Fecha Date2 */
        $fecha2=(strtoupper(strftime("%A,  %d de %B de %Y", strtotime($orden->date2))));
        str_replace('S?BADO','SÁBADO',$fecha2);
        $fecha2 = Carbon::parse($orden->date2);
        /* Localizacion */
        Carbon::setLocale('es');
        
        /* PDF */
        $pdf_data = compact('base64','base641','orden','fecha','fecha2');
        $pdf = Pdf::loadView('reports.reporteOrdenPdf',$pdf_data)->setPaper('letter');;
        $nombreArchivo = 'No_'.str_pad($orden->id, 5, '0', STR_PAD_LEFT) . '_' .$orden->name . '_' . $orden->lastname1 . '_' . $orden->lastname2 . '.pdf';
        return $pdf->stream($nombreArchivo);
    }

    public function generarOrden($id){        
        // Obtener datos del cliente junto con ciudad y colonia
        $ordenCompleta = CompletarOrden::select(
            'completarordenes.*',
            'problematica1.problematica as plague1','problematica2.problematica as plague2',
            'orden.date1','orden.date2','orden.time1','orden.time2','orden.id_cliente','clientes.requires','orden.hiring','orden.nDosis',
            'clientes.name','clientes.lastname1','clientes.lastname2','clientes.tradename','clientes.home',
            'clientes.numAddress','clientes.id_colonia','clientes.id_city','clientes.cell_phone','clientes.how_to_get',
            'clientes.description','clientes.contact_form','clientes.comercio','clientes.recruitment_data','colonias.colonia','colonias.codigoPostal','ciudades.ciudad',
            'productosInternos1.productoInt as productoInt1','productosInternos2.productoInt as productoInt2',
            'productosExternos1.productoExt as productoExt1','productosExternos2.productoExt as productoExt2',
            'empleados1.nameEmpleado as nameEmpleado1',
            'empleados2.nameEmpleado as nameEmpleado2',
            'empleados1.ariasEmpleado as ariasEmpleado1'

            )
            ->join('orden', 'completarordenes.id_orden', '=', 'orden.id')
            ->join('empleados as empleados1', 'completarordenes.id_empleado', '=', 'empleados1.id')
            ->join('empleados as empleados2', 'completarordenes.id_empleado2', '=', 'empleados2.id')
            ->join('productosInternos as productosInternos1', 'completarordenes.id_productosInternos', '=', 'productosInternos1.id')
            ->join('productosInternos as productosInternos2', 'completarordenes.id_productosInternos2', '=', 'productosInternos2.id')
            ->join('productosExternos as productosExternos1', 'completarordenes.id_productosExternos', '=', 'productosExternos1.id')
            ->join('productosExternos as productosExternos2', 'completarordenes.id_productosExternos2', '=', 'productosExternos2.id')
            ->join('problematicas as problematica1', 'orden.id_plague1', '=', 'problematica1.id')
            ->join('problematicas as problematica2', 'orden.id_plague2', '=', 'problematica2.id')    
            ->join('clientes', 'orden.id_cliente', '=', 'clientes.id')
            ->join('colonias', 'clientes.id_colonia', '=', 'colonias.id')
            ->join('ciudades', 'clientes.id_city', '=', 'ciudades.id')
            ->where('completarordenes.id', $id)
            ->first();
        //Datos de la base de datos
        if (!$ordenCompleta) {
            return abort(404);
        }
        
        //PDF Orden de trabajo
        /* Imagen Del Logo */
        $path = public_path('img/membretadoFumi.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data_img = file_get_contents($path);
        $base64 = 'data:image/'.$type.';base64,'.base64_encode($data_img);
        /* Imagen */
        $path1 = public_path('img/logofk.png');
        $type1 = pathinfo($path1, PATHINFO_EXTENSION);
        $data_img1 = file_get_contents($path1);
        $base641 = 'data:image/' . $type1 . ';base64,' . base64_encode($data_img1);
        /* Fecha Date1 */
        $fecha=(strtoupper(strftime("%A,  %d de %B de %Y", strtotime($ordenCompleta->date1))));
        str_replace('S?BADO','SÁBADO',$fecha);
        $fecha = Carbon::parse($ordenCompleta->date1);
        /* Fecha Date2 */
        $fecha2=(strtoupper(strftime("%A,  %d de %B de %Y", strtotime($ordenCompleta->date2))));
        str_replace('S?BADO','SÁBADO',$fecha2);
        $fecha2 = Carbon::parse($ordenCompleta->date2);
        /* Localizacion */
        Carbon::setLocale('es');
        /* PDF */
        $pdf_data = compact('base64','base641','ordenCompleta','fecha','fecha2');
        $pdf = Pdf::loadView('reports.reporteOrdenCompletaPDF',$pdf_data)->setPaper('letter');;
        $nombreArchivo = 'OrdenCompleta_No_'.str_pad($ordenCompleta->id, 5, '0', STR_PAD_LEFT) . '_' .$ordenCompleta->name . '_' . $ordenCompleta->lastname1 . '_' . $ordenCompleta->lastname2 . '.pdf';
        return $pdf->stream($nombreArchivo);
    }

    public function generarCertificado($id){
        $data = Certificado::select([
            'certificados.*',
            'clientes.name',
            'clientes.lastname1',
            'clientes.lastname2',
            'clientes.tradename',
            'clientes.home',
            'clientes.numAddress',
            'clientes.id_colonia',
            'clientes.id_city',
            'clientes.comercio',
            'clientes.cell_phone',
            'colonias.colonia',
            'colonias.codigoPostal',
            'ciudades.ciudad',
            'ciudades.estado',
            'orden.date1',
            'completarordenes.id_empleado',
            'productosInternos.productoInt',
            'productosExternos.productoExt',
            'empleados.nameEmpleado as nombre_empleado',          // Corregido: nameEmpleado
            'empleados.lastnameEmpleado1 as apellido_empleado1', // Corregido: lastnameEmpleado1
            'empleados.lastnameEmpleado2 as apellido_empleado2',
        ])
        ->join('productosInternos', 'certificados.id_productoCertificadoInt1', '=', 'productosInternos.id')
        ->join('productosExternos', 'certificados.id_productoCertificadoExt1', '=', 'productosExternos.id')
        ->join('orden', 'certificados.id_orden', '=', 'orden.id')
        ->join('clientes', 'orden.id_cliente', '=', 'clientes.id')
        ->join('colonias', 'clientes.id_colonia', '=', 'colonias.id')
        ->join('ciudades', 'clientes.id_city', '=', 'ciudades.id')
        ->join('completarordenes', 'orden.id', '=', 'completarordenes.id_orden')
        ->join('empleados', 'completarordenes.id_empleado', '=', 'empleados.id')
        ->where('certificados.id', $id)
        ->first();
    //Datos de la base de datos
    if (!$data) {
        return abort(404);
    }
    
        /* Imagen Del Logo */
        
        $path = public_path('img/membretadoFumioOrden.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data_img = file_get_contents($path);
        $base64 = 'data:image/'.$type.';base64,'.base64_encode($data_img);
        /* Imagen */
        $path1 = public_path('img/logofk.png');
        $type1 = pathinfo($path1, PATHINFO_EXTENSION);
        $data_img1 = file_get_contents($path1);
        $base641 = 'data:image/' . $type1 . ';base64,' . base64_encode($data_img1);
        
        //dd($base64);
        //$pdf_data = compact('data','clientes','base64');
        setlocale(LC_ALL, 'es_MX.UTF-8','esp');
        date_default_timezone_set("America/Mexico_City"); // Establece el locale para español
        $fecha=(strtoupper(strftime("%A,  %d de %B de %Y", strtotime($data->date1))));
        str_replace('S?BADO','SÁBADO',$fecha);
        $fecha = Carbon::parse($data->date1);
        Carbon::setLocale('es');
        
        $nombreCompletoEmpleado = $data->nombre_empleado . ' ' . $data->apellido_empleado1 . ' ' . $data->apellido_empleado2;
        $pdf_data = compact('base64','base641','data','fecha');
        $pdf_data = compact('base64', 'base641', 'data', 'fecha', 'nombreCompletoEmpleado');
        
        
        $nombreCompletoEmpleado = $data->nombre_empleado . ' ' . $data->apellido_empleado;
        $pdf = Pdf::loadView('reports.repoCertificadoRealizado',$pdf_data)->setPaper('letter ', 'landscape');     
        //$pdf = Pdf::loadView('reports.repoCer',$pdf_data)->setPaper('a4', 'landscape');
        //$nombreArchivo = $data->name . '.pdf';
        //return $pdf->save($nombreArchivo);       
        return $pdf->stream();
        return $pdf->download('invoice.pdf');
    }

    public function generarVentSinFact($f1,$f2) {
        // Realizar la consulta sin filtrar por 'id_cliente'
        $data = CompletarOrden::select([
            'completarordenes.*',
            'problematica1.problematica as plague1',
            'problematica2.problematica as plague2',
            'orden.date1',
            'orden.date2',
            'orden.id_cliente',
            'clientes.name',
            'clientes.lastname1',
            'clientes.lastname2',
            'clientes.tradename',
            'clientes.home',
            'clientes.numAddress',
            'clientes.id_colonia',
            'clientes.id_city',
            'colonias.colonia',
            'colonias.codigoPostal',
            'ciudades.ciudad',
            'productosInternos1.productoInt as productoInt1',
            'productosInternos2.productoInt as productoInt2',
            'productosExternos1.productoExt as productoExt1',
            'productosExternos2.productoExt as productoExt2',
            'empleados1.nameEmpleado as nameEmpleado1',
            'empleados2.nameEmpleado as nameEmpleado2',
        ])
        ->join('orden', 'completarordenes.id_orden', '=', 'orden.id')
        ->join('productosInternos as productosInternos1', 'completarordenes.id_productosInternos', '=', 'productosInternos1.id')
        ->join('productosInternos as productosInternos2', 'completarordenes.id_productosInternos2', '=', 'productosInternos2.id')
        ->join('productosExternos as productosExternos1', 'completarordenes.id_productosExternos', '=', 'productosExternos1.id')
        ->join('productosExternos as productosExternos2', 'completarordenes.id_productosExternos2', '=', 'productosExternos2.id')
        ->join('empleados as empleados1', 'completarordenes.id_empleado', '=', 'empleados1.id')
        ->join('empleados as empleados2', 'completarordenes.id_empleado2', '=', 'empleados2.id')
        ->join('clientes', 'orden.id_cliente', '=', 'clientes.id')
        ->join('colonias', 'clientes.id_colonia', '=', 'colonias.id')
        ->join('problematicas as problematica1', 'orden.id_plague1', '=', 'problematica1.id')
        ->join('problematicas as problematica2', 'orden.id_plague2', '=', 'problematica2.id')    
        ->join('ciudades', 'clientes.id_city', '=', 'ciudades.id')
        ->whereBetween("orden.date1", [$f1, $f2])
        ->where('completarordenes.facturaOrden', 'No aplica')
        ->orderBy('completarordenes.id', 'DESC')
        ->get();

        //Funcion para las fechas
        foreach ($data as &$item) {
            

            setlocale(LC_ALL, 'es_MX.UTF-8','esp');
            date_default_timezone_set("America/Mexico_City"); // Establece el locale para español

            $fecha1=((strftime("%d-%B-%Y", strtotime($item->date1))));
            $fecha1 = Carbon::parse($item->date1);

            $fecha2=(strtoupper(strftime("-%d-%B-%Y", strtotime($item->date2))));
            $fecha2 = Carbon::parse($item->date2);
        }
    
        // Verificar si la colección está vacía
        if ($data->isEmpty()) {
            return abort(404, 'No se encontraron datos.');
        }
    
        // Sumar todos los pagos
        $totalPago = $data->sum('pago');
        $totalVentasSinFactura = $data->sum('pago');
    
        // Generación del PDF
        /* Imagen Del Logo */
        $path = public_path('img/logofk.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data_img = file_get_contents($path);
        $base64 = 'data:image/'.$type.';base64,'.base64_encode($data_img);
    
        // Preparar los datos para la vista del PDF
        $pdf_data = compact('base64', 'data', 'totalPago','f1','f2','fecha1','fecha2'); // Incluimos $totalPago
        //$pdf = Pdf::loadView('reports.repoVentaSinFact', $pdf_data)->save('myfile.pdf');
        $pdf = Pdf::loadView('reports.repoVentaSinFact', $pdf_data)->setPaper('a4', 'landscape');
    
        // Mostrar el PDF al usuario
        return $pdf->stream();
    }
    

    public function generarVentConFact($f1,$f2) {
        
        // Realizar la consulta sin filtrar por 'id_cliente'
        //$f1 = Carbon::parse($f1);
        //$f2 = Carbon::parse($f2);
        $data = CompletarOrden::select([
            'completarordenes.*',
            'problematica1.problematica as plague1',
            'problematica2.problematica as plague2',
            'orden.date1',
            'orden.date2',
            'orden.id_cliente',
            'clientes.name',
            'clientes.lastname1',
            'clientes.lastname2',
            'clientes.tradename',
            'clientes.home',
            'clientes.numAddress',
            'clientes.id_colonia',
            'clientes.id_city',
            'colonias.colonia',
            'colonias.codigoPostal',
            'ciudades.ciudad',
            'productosInternos1.productoInt as productoInt1',
            'productosInternos2.productoInt as productoInt2',
            'productosExternos1.productoExt as productoExt1',
            'productosExternos2.productoExt as productoExt2',
            'empleados1.nameEmpleado as nameEmpleado1',
            'empleados2.nameEmpleado as nameEmpleado2',
        ])
        //->whereBetween('orden.date1', [$f1, $f2])
        //->where('clientes.infoclient_facturacion', 'Si')
        ->join('orden', 'completarordenes.id_orden', '=', 'orden.id')
        ->join('productosInternos as productosInternos1', 'completarordenes.id_productosInternos', '=', 'productosInternos1.id')
        ->join('productosInternos as productosInternos2', 'completarordenes.id_productosInternos2', '=', 'productosInternos2.id')
        ->join('productosExternos as productosExternos1', 'completarordenes.id_productosExternos', '=', 'productosExternos1.id')
        ->join('productosExternos as productosExternos2', 'completarordenes.id_productosExternos2', '=', 'productosExternos2.id')
        ->join('empleados as empleados1', 'completarordenes.id_empleado', '=', 'empleados1.id')
        ->join('empleados as empleados2', 'completarordenes.id_empleado2', '=', 'empleados2.id')
        ->join('clientes', 'orden.id_cliente', '=', 'clientes.id')
        ->join('colonias', 'clientes.id_colonia', '=', 'colonias.id')
        ->join('problematicas as problematica1', 'orden.id_plague1', '=', 'problematica1.id')
        ->join('problematicas as problematica2', 'orden.id_plague2', '=', 'problematica2.id')    
        ->join('ciudades', 'clientes.id_city', '=', 'ciudades.id')
        ->whereBetween('orden.date1', [$f1, $f2])
        ->whereNotIn('completarordenes.facturaOrden', ['No aplica'])     
        ->orderBy('completarordenes.id', 'DESC')
        ->get();
        //dd($data);
        //dd($f1);
        //dd($f2);
        //Funcion para las fechas
        

        // Verificar si la colección está vacía
        if ($data->isEmpty()) {
            // Manejar el caso cuando no hay datos
        } else {
            foreach ($data as &$item) {
            

                setlocale(LC_ALL, 'es_MX.UTF-8','esp');
                date_default_timezone_set("America/Mexico_City"); // Establece el locale para español
    
                $fecha1=((strftime("%d-%B-%Y", strtotime($item->date1))));
                $fecha1 = Carbon::parse($item->date1);
    
                $fecha2=(strtoupper(strftime("-%d-%B-%Y", strtotime($item->date2))));
                $fecha2 = Carbon::parse($item->date2);
    
    
                Carbon::setLocale('es');
            }

            $totalPago = $data->sum('pago');
    
            // Generación del PDF
            /* Imagen Del Logo */
            $path = public_path('img/logofk.png');
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data_img = file_get_contents($path);
            $base64 = 'data:image/'.$type.';base64,'.base64_encode($data_img);
        
            // Preparar los datos para la vista del PDF
            $pdf_data = compact('base64', 'data', 'totalPago','f1','f2','fecha1','fecha2'); // Incluimos $totalPago
            //$pdf = Pdf::loadView('reports.repoVentaConFact', $pdf_data)->save('myfile.pdf');
            $pdf = Pdf::loadView('reports.repoVentaConFact', $pdf_data)->setPaper('a4', 'landscape');
        
            // Mostrar el PDF al usuario
            return $pdf->stream();

        }
    
        // Sumar todos los pagos
        
    }

    public function generarVentasTotales($f1,$f2) {
        //$f1 = new Date ('01-01-2024');
        //$f2 = new Date ('30-12-2024');
        //$f1 = Carbon::parse($f1)->format('d-m-Y');
        //$f2 = Carbon::parse($f2)->format('d-m-Y');
        // Realizar la consulta sin filtrar por 'id_cliente'
        $data = CompletarOrden::select([
            'completarordenes.*',
            'problematica1.problematica as plague1',
            'problematica2.problematica as plague2',
            'orden.date1',
            'orden.date2',
            'orden.id_cliente',
            'clientes.name',
            'clientes.lastname1',
            'clientes.lastname2',
            'clientes.tradename',
            'clientes.home',
            'clientes.numAddress',
            'clientes.id_colonia',
            'clientes.id_city',
            'colonias.colonia',
            'colonias.codigoPostal',
            'ciudades.ciudad',
            'productosInternos1.productoInt as productoInt1',
            'productosInternos2.productoInt as productoInt2',
            'productosExternos1.productoExt as productoExt1',
            'productosExternos2.productoExt as productoExt2',
            'empleados1.nameEmpleado as nameEmpleado1',
            'empleados2.nameEmpleado as nameEmpleado2',
        ])
        ->join('orden', 'completarordenes.id_orden', '=', 'orden.id')
        ->join('productosInternos as productosInternos1', 'completarordenes.id_productosInternos', '=', 'productosInternos1.id')
        ->join('productosInternos as productosInternos2', 'completarordenes.id_productosInternos2', '=', 'productosInternos2.id')
        ->join('productosExternos as productosExternos1', 'completarordenes.id_productosExternos', '=', 'productosExternos1.id')
        ->join('productosExternos as productosExternos2', 'completarordenes.id_productosExternos2', '=', 'productosExternos2.id')
        ->join('empleados as empleados1', 'completarordenes.id_empleado', '=', 'empleados1.id')
        ->join('empleados as empleados2', 'completarordenes.id_empleado2', '=', 'empleados2.id')
        ->join('clientes', 'orden.id_cliente', '=', 'clientes.id')
        ->join('colonias', 'clientes.id_colonia', '=', 'colonias.id')
        ->join('problematicas as problematica1', 'orden.id_plague1', '=', 'problematica1.id')
        ->join('problematicas as problematica2', 'orden.id_plague2', '=', 'problematica2.id')    
        ->join('ciudades', 'clientes.id_city', '=', 'ciudades.id')
        ->whereBetween('orden.date1', [$f1, $f2])
        ->orderBy('completarordenes.id', 'DESC')
        ->get();


        //dd($base64);
        //$pdf_data = compact('data','clientes','base64');
        
    
        //Funcion para las fechas
        foreach ($data as &$item) {
            

            setlocale(LC_ALL, 'es_MX.UTF-8','esp');
            date_default_timezone_set("America/Mexico_City"); // Establece el locale para español

            $fecha1=((strftime("%d-%B-%Y", strtotime($item->date1))));
            $fecha1 = Carbon::parse($item->date1);

            $fecha2=(strtoupper(strftime("-%d-%B-%Y", strtotime($item->date2))));
            $fecha2 = Carbon::parse($item->date2);


            Carbon::setLocale('es');
        }

        // Verificar si la colección está vacía
        if ($data->isEmpty()) {
            return abort(404, 'No se encontraron datos.');
            
        }
    
        // Sumar todos los pagos
        $totalPago = $data->sum('pago');
    
        // Generación del PDF
        /* Imagen Del Logo */
        $path = public_path('img/logofk.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data_img = file_get_contents($path);
        $base64 = 'data:image/'.$type.';base64,'.base64_encode($data_img);
    
        // Preparar los datos para la vista del PDF
        $pdf_data = compact('base64', 'data', 'totalPago','f1','f2','fecha1','fecha2'); // Incluimos $totalPago
        $pdf = Pdf::loadView('reports.repoVentasTotales', $pdf_data)->setPaper('a4', 'landscape');
        
    
        // Mostrar el PDF al usuario
        return $pdf->stream();
    }

    public function generarCreditos($f1,$f2) {
        // Realizar la consulta sin filtrar por 'id_cliente'
        $data = CompletarOrden::select([
            'completarordenes.*',
            'problematica1.problematica as plague1',
            'problematica2.problematica as plague2',
            'orden.date1',
            'orden.date2',
            'orden.id_cliente',
            'clientes.name',
            'clientes.lastname1',
            'clientes.lastname2',
            'clientes.tradename',
            'clientes.home',
            'clientes.numAddress',
            'clientes.id_colonia',
            'clientes.id_city',
            'colonias.colonia',
            'colonias.codigoPostal',
            'ciudades.ciudad',
            'productosInternos1.productoInt as productoInt1',
            'productosInternos2.productoInt as productoInt2',
            'productosExternos1.productoExt as productoExt1',
            'productosExternos2.productoExt as productoExt2',
            'empleados1.nameEmpleado as nameEmpleado1',
            'empleados2.nameEmpleado as nameEmpleado2',
        ])
        ->join('orden', 'completarordenes.id_orden', '=', 'orden.id')
        ->join('productosInternos as productosInternos1', 'completarordenes.id_productosInternos', '=', 'productosInternos1.id')
        ->join('productosInternos as productosInternos2', 'completarordenes.id_productosInternos2', '=', 'productosInternos2.id')
        ->join('productosExternos as productosExternos1', 'completarordenes.id_productosExternos', '=', 'productosExternos1.id')
        ->join('productosExternos as productosExternos2', 'completarordenes.id_productosExternos2', '=', 'productosExternos2.id')
        ->join('empleados as empleados1', 'completarordenes.id_empleado', '=', 'empleados1.id')
        ->join('empleados as empleados2', 'completarordenes.id_empleado2', '=', 'empleados2.id')
        ->join('clientes', 'orden.id_cliente', '=', 'clientes.id')
        ->join('colonias', 'clientes.id_colonia', '=', 'colonias.id')
        ->join('problematicas as problematica1', 'orden.id_plague1', '=', 'problematica1.id')
        ->join('problematicas as problematica2', 'orden.id_plague2', '=', 'problematica2.id')    
        ->join('ciudades', 'clientes.id_city', '=', 'ciudades.id')
        ->whereBetween('orden.date1', [$f1, $f2])
        ->where('completarordenes.requiere4','=','1')
        ->orderBy('completarordenes.id', 'DESC')
        ->get();
    
        // Verificar si la colección está vacía
        if ($data->isEmpty()) {
            return abort(404, 'No se encontraron datos.');
        }
    
        //Funcion para las fechas
        foreach ($data as &$item) {
            

            setlocale(LC_ALL, 'es_MX.UTF-8','esp');
            date_default_timezone_set("America/Mexico_City"); // Establece el locale para español

            $fecha1=((strftime("%d-%B-%Y", strtotime($item->date1))));
            $fecha1 = Carbon::parse($item->date1);

            $fecha2=(strtoupper(strftime("-%d-%B-%Y", strtotime($item->date2))));
            $fecha2 = Carbon::parse($item->date2);


            Carbon::setLocale('es');
        }

        // Sumar todos los pagos
        $totalPago = $data->sum('pago');
    
        // Generación del PDF
        /* Imagen Del Logo */
        $path = public_path('img/logofk.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data_img = file_get_contents($path);
        $base64 = 'data:image/'.$type.';base64,'.base64_encode($data_img);
    
        // Preparar los datos para la vista del PDF
        $pdf_data = compact('base64', 'data', 'totalPago','f1','f2','fecha1','fecha2'); // Incluimos $totalPago
        //$pdf = Pdf::loadView('reports.repoCreditos', $pdf_data)->save('myfile.pdf');
        $pdf = Pdf::loadView('reports.repoCreditos', $pdf_data)->setPaper('a4', 'landscape');
    
        // Mostrar el PDF al usuario
        return $pdf->stream();
    }

    public function generarCreditosSinFactura($f1,$f2) {
        // Realizar la consulta sin filtrar por 'id_cliente'
        $data = CompletarOrden::select([
            'completarordenes.*',
            'problematica1.problematica as plague1',
            'problematica2.problematica as plague2',
            'orden.date1',
            'orden.date2',
            'orden.id_cliente',
            'clientes.name',
            'clientes.lastname1',
            'clientes.lastname2',
            'clientes.tradename',
            'clientes.home',
            'clientes.numAddress',
            'clientes.id_colonia',
            'clientes.id_city',
            'colonias.colonia',
            'colonias.codigoPostal',
            'ciudades.ciudad',
            'productosInternos1.productoInt as productoInt1',
            'productosInternos2.productoInt as productoInt2',
            'productosExternos1.productoExt as productoExt1',
            'productosExternos2.productoExt as productoExt2',
            'empleados1.nameEmpleado as nameEmpleado1',
            'empleados2.nameEmpleado as nameEmpleado2',
        ])
        ->join('orden', 'completarordenes.id_orden', '=', 'orden.id')
        ->join('productosInternos as productosInternos1', 'completarordenes.id_productosInternos', '=', 'productosInternos1.id')
        ->join('productosInternos as productosInternos2', 'completarordenes.id_productosInternos2', '=', 'productosInternos2.id')
        ->join('productosExternos as productosExternos1', 'completarordenes.id_productosExternos', '=', 'productosExternos1.id')
        ->join('productosExternos as productosExternos2', 'completarordenes.id_productosExternos2', '=', 'productosExternos2.id')
        ->join('empleados as empleados1', 'completarordenes.id_empleado', '=', 'empleados1.id')
        ->join('empleados as empleados2', 'completarordenes.id_empleado2', '=', 'empleados2.id')
        ->join('clientes', 'orden.id_cliente', '=', 'clientes.id')
        ->join('colonias', 'clientes.id_colonia', '=', 'colonias.id')
        ->join('problematicas as problematica1', 'orden.id_plague1', '=', 'problematica1.id')
        ->join('problematicas as problematica2', 'orden.id_plague2', '=', 'problematica2.id')    
        ->join('ciudades', 'clientes.id_city', '=', 'ciudades.id')
        ->whereBetween('orden.date1', [$f1, $f2])
        // Filtrar por órdenes no pagadas y clientes particulares
        ->where('completarordenes.requiere4','=','1')
        ->where('completarordenes.facturaOrden','=','No aplica')
        // Ordenar por ID de forma descendente
        ->orderBy('completarordenes.id', 'DESC')
        ->get();
    
        // Verificar si la colección está vacía
        if ($data->isEmpty()) {
            return abort(404, 'No se encontraron datos.');
        }
    
        //Funcion para las fechas
        foreach ($data as &$item) {
            

            setlocale(LC_ALL, 'es_MX.UTF-8','esp');
            date_default_timezone_set("America/Mexico_City"); // Establece el locale para español

            $fecha1=((strftime("%d-%B-%Y", strtotime($item->date1))));
            $fecha1 = Carbon::parse($item->date1);

            $fecha2=(strtoupper(strftime("-%d-%B-%Y", strtotime($item->date2))));
            $fecha2 = Carbon::parse($item->date2);


            Carbon::setLocale('es');
        }

        // Sumar todos los pagos
        $totalPago = $data->sum('pago');
    
        // Generación del PDF
        /* Imagen Del Logo */
        $path = public_path('img/logofk.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data_img = file_get_contents($path);
        $base64 = 'data:image/'.$type.';base64,'.base64_encode($data_img);
    
        // Preparar los datos para la vista del PDF
        $pdf_data = compact('base64', 'data', 'totalPago','f1','f2','fecha1','fecha2'); // Incluimos $totalPago
        //$pdf = Pdf::loadView('reports.repoCreditosSinFactura', $pdf_data)->save('myfile.pdf');
        $pdf = Pdf::loadView('reports.repoCreditosSinFactura', $pdf_data)->setPaper('a4', 'landscape');
    
        // Mostrar el PDF al usuario
        return $pdf->stream();
    }

    public function generarCreditosConFactura($f1,$f2) {
        // Realizar la consulta sin filtrar por 'id_cliente'
        $data = CompletarOrden::select([
            'completarordenes.*',
            'problematica1.problematica as plague1',
            'problematica2.problematica as plague2',
            'orden.date1',
            'orden.date2',
            'orden.id_cliente',
            'clientes.name',
            'clientes.lastname1',
            'clientes.lastname2',
            'clientes.tradename',
            'clientes.home',
            'clientes.numAddress',
            'clientes.id_colonia',
            'clientes.id_city',
            'colonias.colonia',
            'colonias.codigoPostal',
            'ciudades.ciudad',
            'productosInternos1.productoInt as productoInt1',
            'productosInternos2.productoInt as productoInt2',
            'productosExternos1.productoExt as productoExt1',
            'productosExternos2.productoExt as productoExt2',
            'empleados1.nameEmpleado as nameEmpleado1',
            'empleados2.nameEmpleado as nameEmpleado2',
        ])
        ->join('orden', 'completarordenes.id_orden', '=', 'orden.id')
        ->join('productosInternos as productosInternos1', 'completarordenes.id_productosInternos', '=', 'productosInternos1.id')
        ->join('productosInternos as productosInternos2', 'completarordenes.id_productosInternos2', '=', 'productosInternos2.id')
        ->join('productosExternos as productosExternos1', 'completarordenes.id_productosExternos', '=', 'productosExternos1.id')
        ->join('productosExternos as productosExternos2', 'completarordenes.id_productosExternos2', '=', 'productosExternos2.id')
        ->join('empleados as empleados1', 'completarordenes.id_empleado', '=', 'empleados1.id')
        ->join('empleados as empleados2', 'completarordenes.id_empleado2', '=', 'empleados2.id')
        ->join('clientes', 'orden.id_cliente', '=', 'clientes.id')
        ->join('colonias', 'clientes.id_colonia', '=', 'colonias.id')
        ->join('problematicas as problematica1', 'orden.id_plague1', '=', 'problematica1.id')
        ->join('problematicas as problematica2', 'orden.id_plague2', '=', 'problematica2.id')    
        ->join('ciudades', 'clientes.id_city', '=', 'ciudades.id')
        ->whereBetween('orden.date1', [$f1, $f2])
        ->where('completarordenes.requiere4','=','1')
        ->whereNotIn('completarordenes.facturaOrden', ['No aplica'])
        ->orderBy('completarordenes.id', 'DESC')
        ->get();
    
        // Verificar si la colección está vacía
        if ($data->isEmpty()) {
            return abort(404, 'No se encontraron datos.');
        }
    
        //Funcion para las fechas
        foreach ($data as &$item) {
            

            setlocale(LC_ALL, 'es_MX.UTF-8','esp');
            date_default_timezone_set("America/Mexico_City"); // Establece el locale para español

            $fecha1=((strftime("%d-%B-%Y", strtotime($item->date1))));
            $fecha1 = Carbon::parse($item->date1);

            $fecha2=(strtoupper(strftime("-%d-%B-%Y", strtotime($item->date2))));
            $fecha2 = Carbon::parse($item->date2);


            Carbon::setLocale('es');
        }

        // Sumar todos los pagos
        $totalPago = $data->where('requiere4', '1')->sum('pago');
        
    
        // Generación del PDF
        /* Imagen Del Logo */
        $path = public_path('img/logofk.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data_img = file_get_contents($path);
        $base64 = 'data:image/'.$type.';base64,'.base64_encode($data_img);
    
        // Preparar los datos para la vista del PDF
        $pdf_data = compact('base64', 'data', 'totalPago','f1','f2','fecha1','fecha2'); // Incluimos $totalPago
        $pdf = Pdf::loadView('reports.repoCreditosConFactura', $pdf_data)->setPaper('a4', 'landscape');
        //$pdf = Pdf::loadView('reports.repoCreditosConFactura', $pdf_data)->save('myfile.pdf');
    
        // Mostrar el PDF al usuario
        return $pdf->stream();
    }

    public function generarPDFCaja(){
        $data = Ingresos::where('dataIngreso', 'Caja')->get();

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
        // 2. Obtener los Ingresos con dataIngreso = 'Caja'
  

        // Obtener la suma total de 'pago' de CompletarOrden
        $totalPagos = CompletarOrden::where('requiere3', 'Pagado/Efectivo')->sum('pago');

        // Obtener la suma total de 'montoIngreso' de Ingresos
        $totalIngresosAdicionales = Ingresos::where('dataIngreso', 'Caja')->sum('montoIngreso');

        $totalCaja = $totalPagos + $totalIngresosAdicionales;

        $dataEg = Egresos::where('dataEgresos', 'Caja')->get();

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
        $pdf = Pdf::loadView('reports.repoCaja',$pdf_data);
        return $pdf->stream();
        return $pdf->download('invoice.pdf');
    }

    

    public function generarOrdendecompra($id) {
        $data = ordenCompra::select([
            'ordenCompra.*',
        ])
        ->where('ordenCompra.id', $id)
        ->first();
    //Datos de la base de datos
    if (!$data) {
        return abort(404);
    }
    

        /* Imagen Del Logo */
        $path = public_path('img/membretadoFumioOrden.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data_img = file_get_contents($path);
        $base64 = 'data:image/'.$type.';base64,'.base64_encode($data_img);
        /* Imagen */
        $path1 = public_path('img/logofk.png');
        $type1 = pathinfo($path1, PATHINFO_EXTENSION);
        $data_img1 = file_get_contents($path1);
        $base641 = 'data:image/' . $type1 . ';base64,' . base64_encode($data_img1);
        setlocale(LC_ALL, 'es_MX.UTF-8','esp');
        date_default_timezone_set("America/Mexico_City"); // Establece el locale para español
        $fecha=(strtoupper(strftime("%A,  %d de %B de %Y", strtotime($data->fechaOrdenCompra))));
        str_replace('S?BADO','SÁBADO',$fecha);
        $fecha = Carbon::parse($data->fechaOrdenCompra);
        Carbon::setLocale('es');
        $pdf_data = compact('base64','base641','data','fecha');
        $pdf = Pdf::loadView('reports.repoordencompra',$pdf_data)->setPaper('letter');     
        //$pdf = Pdf::loadView('reports.repoCer',$pdf_data)->setPaper('a4', 'landscape');
        return $pdf->stream();
        return $pdf->download('invoice.pdf');
    }

    public function generarCreditosPendientes($f1, $f2) {
        // Realizar la consulta filtrando por 'requiere3' igual a 'Credito'
        $data = CompletarOrden::select([
            'completarordenes.*',
            'problematica1.problematica as plague1',
            'problematica2.problematica as plague2',
            'orden.date1',
            'orden.date2',
            'orden.id_cliente',
            'clientes.name',
            'clientes.lastname1',
            'clientes.lastname2',
            'clientes.tradename',
            'clientes.home',
            'clientes.numAddress',
            'clientes.id_colonia',
            'clientes.id_city',
            'colonias.colonia',
            'colonias.codigoPostal',
            'ciudades.ciudad',
            'productosInternos1.productoInt as productoInt1',
            'productosInternos2.productoInt as productoInt2',
            'productosExternos1.productoExt as productoExt1',
            'productosExternos2.productoExt as productoExt2',
            'empleados1.nameEmpleado as nameEmpleado1',
            'empleados2.nameEmpleado as nameEmpleado2',
        ])
        ->join('orden', 'completarordenes.id_orden', '=', 'orden.id')
        ->join('productosInternos as productosInternos1', 'completarordenes.id_productosInternos', '=', 'productosInternos1.id')
        ->join('productosInternos as productosInternos2', 'completarordenes.id_productosInternos2', '=', 'productosInternos2.id')
        ->join('productosExternos as productosExternos1', 'completarordenes.id_productosExternos', '=', 'productosExternos1.id')
        ->join('productosExternos as productosExternos2', 'completarordenes.id_productosExternos2', '=', 'productosExternos2.id')
        ->join('empleados as empleados1', 'completarordenes.id_empleado', '=', 'empleados1.id')
        ->join('empleados as empleados2', 'completarordenes.id_empleado2', '=', 'empleados2.id')
        ->join('clientes', 'orden.id_cliente', '=', 'clientes.id')
        ->join('colonias', 'clientes.id_colonia', '=', 'colonias.id')
        ->join('problematicas as problematica1', 'orden.id_plague1', '=', 'problematica1.id')
        ->join('problematicas as problematica2', 'orden.id_plague2', '=', 'problematica2.id')    
        ->join('ciudades', 'clientes.id_city', '=', 'ciudades.id')
        ->whereBetween('orden.date1', [$f1, $f2])
        ->where('completarordenes.requiere3', 'Credito') // Filtrar por requiere3 igual a 'Credito'
        ->orderBy('completarordenes.id', 'DESC')
        ->get();
    
        // Verificar si la colección está vacía
        if ($data->isEmpty()) {
            return abort(404, 'No se encontraron datos.');
        }
    
        // Función para las fechas
        foreach ($data as &$item) {
            setlocale(LC_ALL, 'es_MX.UTF-8', 'esp');
            date_default_timezone_set("America/Mexico_City"); // Establece el locale para español
    
            $fecha1 = Carbon::parse($item->date1)->format('d-M-Y');
            $fecha2 = Carbon::parse($item->date2)->format('d-M-Y');
    
            Carbon::setLocale('es');
        }
    
        // Sumar todos los pagos
        $totalPago = $data->sum('pago');
    
        // Generación del PDF
        /* Imagen Del Logo */
        $path = public_path('img/logofk.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data_img = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data_img);
    
        // Preparar los datos para la vista del PDF
        $pdf_data = compact('base64', 'data', 'totalPago', 'f1', 'f2', 'fecha1', 'fecha2'); // Incluimos $totalPago
        $pdf = Pdf::loadView('reports.repoCreditos', $pdf_data)->setPaper('a4', 'landscape');
    
        // Mostrar el PDF al usuario
        return $pdf->stream();
    }
}