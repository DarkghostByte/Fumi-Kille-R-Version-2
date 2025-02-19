<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Egresos;
use Validator;

class EgresosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Egresos::select([
            'egresos.*',
            'comercios.comercio',
        ])
        ->join('comercios', 'egresos.id_departamento1', '=', 'comercios.id')
        ->orderBy('egresos.id', 'DESC')
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
            'dateEgresos' => 'required|min:1',
            'descriptionEgresos' => 'required|min:1',
            'montoEgresos' => 'required|min:1',
            'dataEgresos' => 'required|min:1',
            'id_departamento1' => 'required|min:1',
        ]);
        if( $reglas -> fails()){
            return response()->json([
                'status'=>'failed',
                'message'=> 'Validation Error',
                'error' => $reglas->errors()
            ],201);
        }else{
            $data = new Egresos();
            $data->dateEgresos = $request->dateEgresos;
            $data->descriptionEgresos = $request->descriptionEgresos;
            $data->montoEgresos = $request->montoEgresos;
            $data->dataEgresos = $request->dataEgresos;
            $data->id_departamento1 = $request->id_departamento1;
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
        $data = Egresos::find($id);
        $reglas = Validator::make($request->all(), [
            'dateEgresos' => 'required|min:1',
            'descriptionEgresos' => 'required|min:1',
            'montoEgresos' => 'required|min:1',
            'dataEgresos' => 'required|min:1',
            'id_departamento1' => 'required|min:1',
        ]);
        if (!$data) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Ingreso no encontrado'
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
            'message' => 'Ingreso actualizado correctamente',
            'data' => $data
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Egresos::find($id);
        if($data != null){
            $data -> delete();
        } return response()->json([
            'status'=>'success'
        ]);
    }
}
