<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ordenCompra;
use Validator;

class ordenComprasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = ordenCompra::select(['ordenCompra.*', ])
            ->orderBy('ordenCompra.id', 'DESC')
            ->get();
    
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
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
        
        $reglas = Validator::make($request->all(),[
            'fechaOrdenCompra' => 'required|min:1',
            'paraOrdenCompra' => 'required|min:1',
            'conceptoOrdenCompra' => 'required|min:1',
            'detalleOrdenCompra' => 'required|min:1',
            'empleadoOrdenCompra' => 'required|min:1',
            'importeOrdenCompra' => 'required|min:1',
            'autorizoOrdenCompra' => 'required|min:1',
        ]);
        if( $reglas -> fails()){
            return response()->json([
                'status'=>'failed',
                'message'=> 'Validation Error',
                'error' => $reglas->errors()
            ],201);
        }else{
            $data = new ordenCompra();
            $data->fechaOrdenCompra = $request->fechaOrdenCompra;
            $data->paraOrdenCompra = $request->paraOrdenCompra;
            $data->conceptoOrdenCompra = $request->conceptoOrdenCompra;
            $data->detalleOrdenCompra = $request->detalleOrdenCompra;
            $data->empleadoOrdenCompra = $request->empleadoOrdenCompra;
            $data->importeOrdenCompra = $request->importeOrdenCompra;
            $data->autorizoOrdenCompra = $request->autorizoOrdenCompra;
            $data->save();

            return response()->json([
                'status'=>'success'
            ]);
            
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = ordenCompra::find($id);
        return response()->json([
            'status'=>'success',
            'data'=>$data
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
        $data = ordenCompra::find($id);
        $reglas = Validator::make($request->all(), [
            'fechaOrdenCompra' => 'required|min:1',
            'paraOrdenCompra' => 'required|min:1',
            'conceptoOrdenCompra' => 'required|min:1',
            'detalleOrdenCompra' => 'required|min:1',
            'empleadoOrdenCompra' => 'required|min:1',
            'importeOrdenCompra' => 'required|min:1',
            'autorizoOrdenCompra' => 'required|min:1',
        ]);
        if (!$data) {
            return response()->json([
                'status' => 'failed',
                'message' => 'ordenCompra no encontrado'
            ], 404);
        }
        if ($reglas->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Error de validación',
                'errors' => $reglas->errors()
            ], 400);
        }
        $data->fill($request->all());
        $data->save();
        return response()->json([
            'status' => 'success',
            'message' => 'ordenCompra actualizado correctamente',
            'data' => $data
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = ordenCompra::find($id);
        if($data != null){
            $data -> delete();
        } return response()->json([
            'status'=>'success'
        ]);
    }
/*
    public function verCiudades()
    {
        $ciudades = ordenCompra::where('infodelete_Ciudad', '!=', 'Baja')->get();
        return response()->json($ciudades);
    }

    public function desactivarCiudad(Request $request, $id)
    {
    $data = ordenCompra::find($id);

    if (!$data) {
        return response()->json([
        'status' => 'error',
        'message' => 'ordenCompra no encontrado'
        ], 404);
    }

    $validator = Validator::make($request->all(), [
        'infodelete_Ciudad' => 'required|in:Alta,Baja',
    ]);

    if ($validator->fails()) {
        return response()->json([
        'status' => 'failed',
        'message' => 'Error de validación',
        'errors' => $validator->errors()
        ], 400);
    }

    $updatedData = [
        'infodelete_Ciudad' => $request->infodelete_Ciudad
    ];

    $data->update($updatedData);

    return response()->json([
        'status' => 'success',
        'message' => 'Activacion de ciudad cambiada exitosamente',
        'data' => $data
    ]);
    }
    */
}
