<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductoInterno;
use Validator;

class ProductosInternosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = ProductoInterno ::all();
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
            'productoInt' => 'required|min:1',
            'infodelete_productoInt'=>'required|min:1',

        ]);
        if( $reglas -> fails()){
            return response()->json([
                'status'=>'failed',
                'message'=> 'Validation Error',
                'error' => $reglas->errors()
            ],201);
        }else{
            $data = new ProductoInterno();
            $data->productoInt = $request->productoInt;
            $data->infodelete_productoInt = $request->infodelete_productoInt;
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
        $data = ProductoInterno::find($id);
        $reglas = Validator::make($request->all(), [
            'productoInt' => 'required|min:1',
        ]);
        if (!$data) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Producto interno no encontrado'
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
            'message' => 'Producto interno actualizado correctamente',
            'data' => $data
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = ProductoInterno::find($id);
        if($data != null){
            $data -> delete();
        } return response()->json([
            'status'=>'success'
        ]);
    }

    public function desactivarProductoInterno(Request $request, $id)
    {
    $data = ProductoInterno::find($id);

    if (!$data) {
        return response()->json([
        'status' => 'error',
        'message' => 'Producto Interno no encontrado'
        ], 404);
    }

    $validator = Validator::make($request->all(), [
        'infodelete_productoInt' => 'required|in:Alta,Baja',
    ]);

    if ($validator->fails()) {
        return response()->json([
        'status' => 'failed',
        'message' => 'Error de validación',
        'errors' => $validator->errors()
        ], 400);
    }

    $updatedData = [
        'infodelete_productoInt' => $request->infodelete_productoInt
    ];

    $data->update($updatedData);

    return response()->json([
        'status' => 'success',
        'message' => 'Producto Interno desactivado exitosamente',
        'data' => $data
    ]);
    }

    public function verProductosInternos()
        {
            $productosInternos = ProductoInterno::where('infodelete_productoInt', '!=', 'Baja')->get();
            return response()->json($productosInternos);
        }
}