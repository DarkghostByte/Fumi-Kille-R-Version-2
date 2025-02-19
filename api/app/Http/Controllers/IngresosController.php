<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingresos;
use Validator;

class IngresosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Ingresos ::all();
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
            'dateIngreso' => 'required|min:1',
            'descriptionIngreso' => 'required|min:1',
            'montoIngreso' => 'required|min:1',
            'dataIngreso' => 'required|min:1',
        ]);
        if( $reglas -> fails()){
            return response()->json([
                'status'=>'failed',
                'message'=> 'Validation Error',
                'error' => $reglas->errors()
            ],201);
        }else{
            $data = new Ingresos();
            $data->dateIngreso = $request->dateIngreso;
            $data->descriptionIngreso = $request->descriptionIngreso;
            $data->montoIngreso = $request->montoIngreso;
            $data->dataIngreso = $request->dataIngreso;
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
        $data = Ingresos::find($id);
        $reglas = Validator::make($request->all(), [
            'dateIngreso' => 'required|min:1',
            'descriptionIngreso' => 'required|min:1',
            'montoIngreso' => 'required|min:1',
            'dataIngreso' => 'required|min:1',
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
        $data = Ingresos::find($id);
        if($data != null){
            $data -> delete();
        } return response()->json([
            'status'=>'success'
        ]);
    }
}
