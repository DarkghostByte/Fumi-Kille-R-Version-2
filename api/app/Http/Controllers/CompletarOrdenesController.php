<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompletarOrden;
use Carbon\Carbon;
use Validator;
use App\Models\Orden;
use Barryvdh\DomPDF\Facade\Pdf;


class CompletarOrdenesController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * 
     */
    public function index(Request $request)
    {
        $id_cliente = $request->query('id_cliente');

        $query = CompletarOrden::select([
            'completarordenes.*',
            'problematica1.problematica as plague1',
            'problematica2.problematica as plague2',
            'orden.infoorden_certificate',
            'orden.date1',
            'orden.date2',
            'orden.infoorden_facturacion',
            'orden.id_cliente',
            'clientes.name',
            'clientes.lastname1',
            'clientes.lastname2',
            'clientes.tradename',
            'clientes.correo',
            'clientes.home',
            'clientes.numAddress',
            'clientes.comercio',
            'clientes.id_colonia',
            'clientes.id_city',
            'clientes.cell_phone',
            'colonias.colonia',
            'colonias.codigoPostal',
            'ciudades.ciudad',
            'productosInternos1.productoInt as productoInt1',
            'productosInternos2.productoInt as productoInt2',
            'productosExternos1.productoExt as productoExt1',
            'productosExternos2.productoExt as productoExt2',
            'empleados1.nameEmpleado as nameEmpleado1',
            'empleados2.nameEmpleado as nameEmpleado2',
            'empleados1.ariasEmpleado as ariasEmpleado1',
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
            ->join('ciudades', 'clientes.id_city', '=', 'ciudades.id');


        if ($id_cliente) {
            $query->where('orden.id_cliente', $id_cliente);
        }

        $data = $query->orderBy('completarordenes.id_orden', 'DESC')->get();

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
    public function completarOrden()
    {
        $ordenes = Orden::with('certificado')->where('orden.id', 'orden.id')->get();
        return response()->json(['data' => $ordenes]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $reglas = Validator::make($request->all(), [
            'id_orden' => 'required|min:1',
            'id_empleado' => 'required|min:1',
            'id_empleado2' => '',
            'id_productosInternos' => 'required|min:1',
            'id_productosInternos2' => '',
            'id_productosExternos' => 'required|min:1',
            'id_productosExternos2' => '',
            'noTrapear' => 'required|min:1',
            'noIngresar' => 'required|min:1',
            'otraDosis' => 'required|min:1',
            'pago' => 'required|numeric',
            'requiere1' => 'array|min:1',
            'requiere2' => 'array|min:1',
            'requiere3' => 'required|min:1',
            'requiere4' => 'required',
            'facturaOrden' => 'required|min:1',
        ]);
        if ($reglas->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation Error',
                'error' => $reglas->errors()
            ], 422);
        } else {
            $data = new CompletarOrden();
            $data->id_orden = $request->id_orden;
            $data->id_empleado = $request->id_empleado;
            $data->id_empleado2 = $request->id_empleado2;
            $data->id_productosInternos = $request->id_productosInternos;
            $data->id_productosInternos2 = $request->id_productosInternos2;
            $data->id_productosExternos = $request->id_productosExternos;
            $data->id_productosExternos2 = $request->id_productosExternos2;
            $data->noTrapear = $request->noTrapear;
            $data->noIngresar = $request->noIngresar;
            $data->otraDosis = $request->otraDosis;
            $data->pago = $request->pago;
            $data->requiere1 = json_encode($request->requiere1);
            $data->requiere2 = json_encode($request->requiere2);
            $data->requiere3 = $request->requiere3;
            $data->requiere4 = $request->requiere4;
            $data->facturaOrden = $request->facturaOrden;
            $data->save();

            return response()->json([
                'status' => 'success'
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = CompletarOrden::select([
            'completarordenes.*',
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
            ->where('completarordenes.id', $id)
            ->first();

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $completarOrden = CompletarOrden::find($id);
        $reglas = Validator::make($request->all(), [
            'id_empleado' => 'required|min:1',
            'id_empleado2' => '',
            'id_productosInternos' => 'required|min:1',
            'id_productosInternos2' => '',
            'id_productosExternos' => 'required|min:1',
            'id_productosExternos2' => '',
            'noTrapear' => 'required|min:1',
            'noIngresar' => 'required|min:1',
            'otraDosis' => 'required|min:1',
            'pago' => 'required|numeric',
            'requiere1' => 'required|min:1',
            'requiere2' => 'required|min:1',
            'requiere3' => 'required|min:1',
            'facturaOrden' => 'required|min:1',
        ]);
        if (!$completarOrden) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Cliente no encontrado'
            ], 404);
        }
        if ($reglas->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Error de validación',
                'errors' => $reglas->errors()
            ], 400);
        }
        $completarOrden->fill($request->all());
        $completarOrden->save();
        return response()->json([
            'status' => 'success',
            'message' => 'La orden se actualizo correctamente',
            'data' => $completarOrden
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = CompletarOrden::find($id);
        if ($data != null) {
            $data->delete();
        }
        return response()->json([
            'status' => 'success'
        ]);
    }

    public function actualizarEstado(Request $request, $id)
    {
        $completarOrden = CompletarOrden::find($id);

        $validator = Validator::make($request->all(), [
            'requiere3' => 'required|in:Pagado,Credito',
        ]);

        if (!$completarOrden) {
            return response()->json([
                'status' => 'error',
                'message' => 'Orden no encontrada'
            ], 404);
        }

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 400);
        }

        // Actualizar el estado y el pago
        $completarOrden->requiere3 = $request->requiere3;
        $completarOrden->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Estado  actualizados correctamente',
            'data' => $completarOrden
        ]);
    }

    public function datoNuevo(Request $request, $id)
    {
        $completarOrden = CompletarOrden::find($id);

        $validator = Validator::make($request->all(), [
            'facturaOrden' => 'required|in:Pagado,Credito',
        ]);

        if (!$completarOrden) {
            return response()->json([
                'status' => 'error',
                'message' => 'Orden no encontrada'
            ], 404);
        }

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 400);
        }

        // Actualizar el estado y el pago
        $completarOrden->facturaOrden = $request->facturaOrden;
        $completarOrden->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Estado  actualizados correctamente',
            'data' => $completarOrden
        ]);
    }

    public function creditoPermanente(Request $request, $id)
    {
        $completarOrden = CompletarOrden::find($id);

        if (!$completarOrden) {
            return response()->json([
                'status' => 'error',
                'message' => 'Orden no encontrada'
            ], 404);
        }

        // Lógica para establecer requiere4 si requiere3 es 'Credito'
        if ($completarOrden->requiere3 == 'Credito') {
            $completarOrden->requiere4 = true; // Asegúrate de que sea un string 'True' para que pase la validación
            $completarOrden->save(); // Guarda inmediatamente para que la validación funcione correctamente
            return response()->json([
                'status' => 'success',
                'message' => 'Estado actualizados correctamente',
                'data' => $completarOrden
            ]);
        }

        $validator = Validator::make($request->all(), [
            'requiere4' => 'required|in:true,false',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 400);
        }

        $completarOrden->requiere4 = $request->requiere4;
        $completarOrden->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Estado actualizados correctamente',
            'data' => $completarOrden
        ]);
    }

    /* 
public function show($id)
{
    $ordenCompleta = OrdenCompleta::find($id);

    // Ensure creditomamalon becomes true if credito is true and cannot be changed back
    if ($ordenCompleta->requiere3 == 'Credito') {
        $ordenCompleta->creditomamalon = true;
    }
}


if ($ordenCompleta->requiere3 == 'Credito') {
            $ordenCompleta->requiere4 = true;
        }
*/
}
