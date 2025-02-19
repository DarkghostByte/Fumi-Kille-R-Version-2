<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Problematicas;
use Validator;

class ProblematicasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Problematicas ::all();
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
            'problematica' => 'required|min:1',
            'infodelete_problematica' => 'required|min:1',
        ]);
        if( $reglas -> fails()){
            return response()->json([
                'status'=>'failed',
                'message'=> 'Validation Error',
                'error' => $reglas->errors()
            ],201);
        }else{
            $data = new Problematicas();
            $data->problematica = $request->problematica;
            $data->infodelete_problematica = $request->infodelete_problematica;
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
        $data = Problematicas::find($id);
        $reglas = Validator::make($request->all(), [
            'problematica' => 'required|min:1',
        ]);
        if (!$data) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Problematica no encontrada'
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
            'message' => 'Problematica actualizada correctamente',
            'data' => $data
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Problematicas::find($id);
        if($data != null){
            $data -> delete();
        } return response()->json([
            'status'=>'success'
        ]);
    }

    public function desactivarProblematica(Request $request, $id)
    {
    $data = Problematicas::find($id);

    if (!$data) {
        return response()->json([
        'status' => 'error',
        'message' => 'Problematica no encontrada'
        ], 404);
    }

    $validator = Validator::make($request->all(), [
        'infodelete_problematica' => 'required|in:Alta,Baja',
    ]);

    if ($validator->fails()) {
        return response()->json([
        'status' => 'failed',
        'message' => 'Error de validación',
        'errors' => $validator->errors()
        ], 400);
    }

    $updatedData = [
        'infodelete_problematica' => $request->infodelete_problematica
    ];

    $data->update($updatedData);

    return response()->json([
        'status' => 'success',
        'message' => 'Problematica desactivada exitosamente',
        'data' => $data
    ]);
    }

    public function verProblematicas()
        {
            $problematica = Problematicas::where('infodelete_problematica', '!=', 'Baja')->get();
            return response()->json($problematica);
        }
}