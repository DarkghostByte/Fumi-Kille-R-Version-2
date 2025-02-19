<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Colonia;
use Validator;

class ColoniasController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request) {
        $data = Colonia::select([
            'colonias.*',
            'ciudades.ciudad'
        ])
        ->join('ciudades', 'colonias.id_ciudad', '=', 'ciudades.id')
        ->orderBy('colonias.id', 'ASC')
        ->get();

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function verColoniaPorCiudad($cityId) {
        
        $colonias = Colonia::where('id_ciudad', $cityId)
        ->orderBy('colonias.colonia', 'ASC')
        ->get();
    
        if ($colonias->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No hay colonias para esta ciudad'
            ], 404);
        }
    
        return response()->json([
            'status' => 'success',
            'data' => $colonias
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
            'colonia' => 'required|min:1',
            'codigoPostal' => 'required|min:1',
            'id_ciudad' => 'required|min:1',

        ]);
        if( $reglas -> fails()){
            return response()->json([
                'status'=>'failed',
                'message'=> 'Validation Error',
                'error' => $reglas->errors()
            ],201);
        }else{
            $data = new Colonia();
            $data->colonia = $request->colonia;
            $data->codigoPostal = $request->codigoPostal;
            $data->id_ciudad = $request->id_ciudad;
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
        $data = Colonia::find($id);
        $reglas = Validator::make($request->all(), [
            'colonia' => 'required|min:1',
            'codigoPostal' => 'required|min:1',
            'id_ciudad' => 'required|min:1',
            
        ]);
        if (!$data) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Colonia no encontrado'
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
            'message' => 'Colonia actualizado correctamente',
            'data' => $data
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Colonia::find($id);
        if($data != null){
            $data -> delete();
        } return response()->json([
            'status'=>'success'
        ]);
    }

    public function verColonia()
    {
        $colonias = Colonia::all();
        return response()->json($colonias);
    }

    public function desactivarCiudad(Request $request, $id)
    {
    $data = Ciudad::find($id);

    if (!$data) {
        return response()->json([
        'status' => 'error',
        'message' => 'Ciudad no encontrado'
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
}
