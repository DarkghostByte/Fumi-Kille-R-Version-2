<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vias;
use Validator;

class ViasController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Vias ::all();
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
            'tipoVia' => 'required|min:1',
            'infodelete_Vias' => 'required|min:1',
        ]);
        if( $reglas -> fails()){
            return response()->json([
                'status'=>'failed',
                'message'=> 'Validation Error',
                'error' => $reglas->errors()
            ],201);
        }else{
            $data = new Vias();
            $data->tipoVia = $request->tipoVia;
            $data->infodelete_Vias = $request->infodelete_Vias;
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
        $data = Vias::find($id);
        $reglas = Validator::make($request->all(), [
            'tipoVia' => 'required|min:1',
        ]);
        if (!$data) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Tipo de Via no encontrado'
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
            'message' => 'Tipo de Via actualizado correctamente',
            'data' => $data
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Vias::find($id);
        if($data != null){
            $data -> delete();
        } return response()->json([
            'status'=>'success'
        ]);
    }

    public function verVias()
    {
        $vias = Vias::where('infodelete_Vias', '!=', 'Baja')->get();
        return response()->json($vias);
    }


    public function desactivarVia(Request $request, $id)
    {
    $data = Vias::find($id);

    if (!$data) {
        return response()->json([
        'status' => 'error',
        'message' => 'Via no encontrado'
        ], 404);
    }

    $validator = Validator::make($request->all(), [
        'infodelete_Vias' => 'required|in:Alta,Baja',
    ]);

    if ($validator->fails()) {
        return response()->json([
        'status' => 'failed',
        'message' => 'Error de validación',
        'errors' => $validator->errors()
        ], 400);
    }

    $updatedData = [
        'infodelete_Vias' => $request->infodelete_Vias
    ];

    $data->update($updatedData);

    return response()->json([
        'status' => 'success',
        'message' => 'Activacion de via cambiada exitosamente',
        'data' => $data
    ]);
    }
}
