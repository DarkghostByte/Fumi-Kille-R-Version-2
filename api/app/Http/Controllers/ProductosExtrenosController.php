<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductoExterno;
use Validator;

class ProductosExtrenosController extends Controller
{
    public function index()
    {
        $data = ProductoExterno ::all();
        return response()->json([
            'status'=>'success',
            'data'=>$data
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
            'productoExt' => 'required|min:1',
            'infodelete_productoExt' => 'required|min:1',
        ]);
        if( $reglas -> fails()){
            return response()->json([
                'status'=>'failed',
                'message'=> 'Validation Error',
                'error' => $reglas->errors()
            ],201);
        }else{
            $data = new ProductoExterno();
            $data->productoExt = $request->productoExt;
            $data->infodelete_productoExt = $request->infodelete_productoExt;
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
        //
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
        $data = ProductoExterno::find($id);
        $reglas = Validator::make($request->all(), [
            'productoExt' => 'required|min:1',
        ]);
        if (!$data) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Producto externo no encontrado'
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
            'message' => 'Producto externo actualizado correctamente',
            'data' => $data
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = ProductoExterno::find($id);
        if($data != null){
            $data -> delete();
        } return response()->json([
            'status'=>'success'
        ]);
    }

    public function desactivarProductoExterno(Request $request, $id)
    {
    $data = ProductoExterno::find($id);

    if (!$data) {
        return response()->json([
        'status' => 'error',
        'message' => 'Producto Externo no encontrado'
        ], 404);
    }

    $validator = Validator::make($request->all(), [
        'infodelete_productoExt' => 'required|in:Alta,Baja',
    ]);

    if ($validator->fails()) {
        return response()->json([
        'status' => 'failed',
        'message' => 'Error de validación',
        'errors' => $validator->errors()
        ], 400);
    }

    $updatedData = [
        'infodelete_productoExt' => $request->infodelete_productoExt
    ];

    $data->update($updatedData);

    return response()->json([
        'status' => 'success',
        'message' => 'Producto Externo desactivado exitosamente',
        'data' => $data
    ]);
    }

    public function verProductosExternos()
        {
            $productosExternos = ProductoExterno::where('infodelete_productoExt', '!=', 'Baja')->get();
            return response()->json($productosExternos);
        }
}