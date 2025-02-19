<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\formaContacto;
use Validator;

class FormaContactoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = formaContacto ::all();
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
        'formadeContacto' => 'required|min:1',
        'infodelete_Forma' => 'required|min:1',
    ]);
    if( $reglas -> fails()){
        return response()->json([
            'status'=>'failed',
            'message'=> 'Validation Error',
            'error' => $reglas->errors()
        ],201);
    }else{
        $data = new formaContacto();
        $data->formadeContacto = $request->formadeContacto;
        $data->infodelete_Forma = $request->infodelete_Forma;
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
        $data = formaContacto::find($id);
        $reglas = Validator::make($request->all(), [
            'formadeContacto' => 'required|min:1',
            'infodelete_Forma' => 'required|min:1',
        ]);
        if (!$data) {
            return response()->json([
                'status' => 'failed',
                'message' => 'formaContacto no encontrado'
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
            'message' => 'formaContacto actualizado correctamente',
            'data' => $data
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = formaContacto::find($id);
        if($data != null){
            $data -> delete();
        } return response()->json([
            'status'=>'success'
        ]);
    }

    public function verFormaDeContacto()
    {
        $data = formaContacto::where('infodelete_Forma', '!=', 'Baja')->get();
        return response()->json($data);
    }

    public function desactivarFormaDeContacto(Request $request, $id)
    {
    $data = formaContacto::find($id);

    if (!$data) {
        return response()->json([
        'status' => 'error',
        'message' => 'formaContacto no encontrado'
        ], 404);
    }

    $validator = Validator::make($request->all(), [
        'infodelete_Forma' => 'required|in:Alta,Baja',
    ]);

    if ($validator->fails()) {
        return response()->json([
        'status' => 'failed',
        'message' => 'Error de validación',
        'errors' => $validator->errors()
        ], 400);
    }

    $updatedData = [
        'infodelete_Forma' => $request->infodelete_Forma
    ];

    $data->update($updatedData);

    return response()->json([
        'status' => 'success',
        'message' => 'Activacion de ciudad cambiada exitosamente',
        'data' => $data
    ]);
    }
}
