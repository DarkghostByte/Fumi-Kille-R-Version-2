<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orden;
use Validator;
use App\Models\Certificado;
use Barryvdh\DomPDF\Facade\Pdf;

class OrdensController extends Controller
{
    public function index()
    {
        $data = Orden::select([
                'orden.*',
                'clientes.name',
                'clientes.lastname1',
                'clientes.lastname2',
                'clientes.tradename',
                'clientes.correo',
                'clientes.home',
                'clientes.numAddress',
                'clientes.id_colonia',
                'clientes.id_city',
                'clientes.comercio',
                'clientes.cell_phone',
                'colonias.colonia',
                'colonias.codigoPostal',
                'ciudades.ciudad',
                'problematica1.problematica as plague1',
                'problematica2.problematica as plague2',
            ])
            ->join('problematicas as problematica1', 'orden.id_plague1', '=', 'problematica1.id')
            ->join('problematicas as problematica2', 'orden.id_plague2', '=', 'problematica2.id')
            ->join('clientes', 'orden.id_cliente', '=', 'clientes.id')
            ->join('colonias', 'clientes.id_colonia', '=', 'colonias.id')
            ->join('ciudades', 'clientes.id_city', '=', 'ciudades.id')
            ->orderBy('orden.id', 'DESC')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
        /*
    $data = Orden::select(['orden.*','clientes.name','clientes.lastname1','clientes.lastname2'
    ])->join('clientes','orden.id_cliente','=','clientes.id')
    ->orderBy('orden.id','DESC')
    ->get();

    $all = [];
    foreach ($data as $item) {
        $products = ProductoPedido::select(['productos_pedidos.*','products.name','products.img','products.description'])
        ->join('products','productos_pedidos.id_product','=' ,'products.id')
        ->where('id_product',$item->id)
        ->get();

        $all [] = [
            'pedido'=>$item, 
            'productos'=>$products
        ];
        
    }

        return response()->json([
            'success'=>true,
            'data'=>$all
        ]);

        */

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    public function certificado()
    {
        return $this->hasOne(Certificado::class, 'id', 'id_orden'); // Ajusta los nombres de las columnas si son diferentes
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $reglas = Validator::make($request->all(),[
            'id_cliente' => 'min:1',
            'id_plague1' => 'required|min:1',
            'id_plague2' => '',
            'date1' => 'required|min:1',
            'date2' => 'required|min:1',
            'time1' => 'required|min:1',
            'time2' => 'required|min:1',
            'hiring' => 'array|required|min:1',
            'infoorden_delete' => 'required|min:1',
            'infoorden_certificate' => 'required|min:1',
            'infoorden_remision' => 'required|min:1',
            'infoorden_facturacion' => 'required|min:1',
            'infoorden_cell' => 'required|min:1',
            'statusOrder' => 'required|min:1',
            'nDosis' => 'required|min:1',
        ]);
        if( $reglas -> fails()){
            return response()->json([
                'status'=>'failed',
                'message'=> 'Validation Error',
                'error' => $reglas->errors()
            ],201);
        }else{
            $data = new Orden();
            $data->id_cliente = $request->id_cliente;
            $data->id_plague1 = $request->id_plague1;
            $data->id_plague2 = $request->id_plague2;
            $data->date1 = $request->date1;
            $data->date2 = $request->date2;            
            $data->time1 = $request->time1;
            $data->time2 = $request->time2;
            $data->hiring = json_encode($request->hiring);
            $data->infoorden_delete = $request->infoorden_delete;
            $data->infoorden_certificate = $request->infoorden_certificate;
            $data->infoorden_remision = $request->infoorden_remision;
            $data->infoorden_facturacion = $request->infoorden_facturacion;
            $data->infoorden_cell = $request->infoorden_cell;
            $data->statusOrder = $request->statusOrder;
            $data->nDosis = $request->nDosis;
            $data->save();

            return response()->json([
                'status'=>'success'
            ]);
            
        }
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
{
    $orden = Orden::with('cliente')->find($id);

    if (!$orden) {
        return response()->json(['message' => 'Orden no encontrada'], 404);
    }

    return response()->json(['data' => $orden], 200);
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
        $orden = Orden::find($id);
        $reglas = Validator::make($request->all(), [
            'id_cliente' => 'min:1',
            'id_plague1' => 'required|min:1',
            'id_plague2' => '',
            'date1' => 'required|min:1',
            'date2' => 'required|min:1',
            'time1' => 'required|min:1',
            'time2' => 'required|min:1',
            'hiring' => 'array|required|min:1',
            'infoorden_certificate' => 'required|min:1',
            'infoorden_remision' => 'required|min:1',
            'infoorden_facturacion' => 'required|min:1',
            'infoorden_cell' => 'required|min:1',
            'nDosis' => 'required|min:1',
        ]);
        if (!$orden) {
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
        $orden->fill($request->all());
        $orden->save();
        return response()->json([
            'status' => 'success',
            'message' => 'La orden se actualizo correctamente',
            'data' => $orden
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Orden::find($id);
        if($data != null){
            $data -> delete();
        } return response()->json([
            'status'=>'success'
        ]);
    }

    public function desactivarOrden(Request $request, $id)
    {
    $orden = Orden::find($id);

    if (!$orden) {
        return response()->json([
        'status' => 'error',
        'message' => 'Orden no encontrado'
        ], 404);
    }

    $validator = Validator::make($request->all(), [
        'infoorden_delete' => 'required|in:Alta,Baja',
    ]);

    if ($validator->fails()) {
        return response()->json([
        'status' => 'failed',
        'message' => 'Error de validación',
        'errors' => $validator->errors()
        ], 400);
    }

    $updatedData = [
        'infoorden_delete' => $request->infoorden_delete
    ];

    $orden->update($updatedData);

    return response()->json([
        'status' => 'success',
        'message' => 'Cliente desactivado exitosamente',
        'data' => $orden
    ]);
    }

    public function verEstadoOrden(Request $request, $id)
    {
    $orden = Orden::find($id);

    if (!$orden) {
        return response()->json([
        'status' => 'error',
        'message' => 'Orden no encontrado'
        ], 404);
    }

    $validator = Validator::make($request->all(), [
        'statusOrder' => 'required|in:Terminada,Por realizar',
    ]);

    if ($validator->fails()) {
        return response()->json([
        'status' => 'failed',
        'message' => 'Error de validación',
        'errors' => $validator->errors()
        ], 400);
    }

    $updatedData = [
        'statusOrder' => $request->statusOrder
    ];

    $orden->update($updatedData);

    return response()->json([
        'status' => 'success',
        'message' => 'Estado cambiado exitosamente',
        'data' => $orden
    ]);
    }


    public function verEstadoFacturacion(Request $request, $id)
    {
    $orden = Orden::find($id);

    if (!$orden) {
        return response()->json([
        'status' => 'error',
        'message' => 'Orden no encontrado'
        ], 404);
    }

    $validator = Validator::make($request->all(), [
        'infoorden_facturacion' => 'required|in:No,Si',
    ]);

    if ($validator->fails()) {
        return response()->json([
        'status' => 'failed',
        'message' => 'Error de validación',
        'errors' => $validator->errors()
        ], 400);
    }

    $updatedData = [
        'infoorden_facturacion' => $request->infoorden_facturacion
    ];

    $orden->update($updatedData);

    return response()->json([
        'status' => 'success',
        'message' => 'Estado cambiado exitosamente',
        'data' => $orden
    ]);
    }

    public function verEstadoCertificado(Request $request, $id)
    {
    $orden = Orden::find($id);

    if (!$orden) {
        return response()->json([
        'status' => 'error',
        'message' => 'Orden no encontrado'
        ], 404);
    }

    $validator = Validator::make($request->all(), [
        'infoorden_certificate' => 'required|in:No,Si',
    ]);

    if ($validator->fails()) {
        return response()->json([
        'status' => 'failed',
        'message' => 'Error de validación',
        'errors' => $validator->errors()
        ], 400);
    }

    $updatedData = [
        'infoorden_certificate' => $request->infoorden_certificate
    ];

    $orden->update($updatedData);

    return response()->json([
        'status' => 'success',
        'message' => 'Estado cambiado exitosamente',
        'data' => $orden
    ]);
    }
}
