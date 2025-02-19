<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleados;
use Validator;

class EmpleadosController extends Controller
{
    public function index()
    {
        $empleados = Empleados::all();
        return response()->json($empleados);

        $data = Empleados::select([
            'empleados.*',
            'comercios.comercio',
        ])
        ->join('comercios', 'empleados.id_departamento', '=', 'comercios.id')
        ->orderBy('empleados.id', 'DESC')
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
            'nameEmpleado' => 'required|min:1',
            'lastnameEmpleado1' => 'required|min:1',
            'lastnameEmpleado2' => 'required|min:1',
            'ariasEmpleado' => 'required|min:1',
            'infodelete_Empleados' => 'required|min:1',
            'id_departamento' => 'required|min:1',
        ]);
        if( $reglas -> fails()){
            return response()->json([
                'status'=>'failed',
                'message'=> 'Validation Error',
                'error' => $reglas->errors()
            ],201);
        }else{
            $data = new Empleados();
            $data->nameEmpleado = $request->nameEmpleado;
            $data->lastnameEmpleado1 = $request->lastnameEmpleado1;
            $data->lastnameEmpleado2 = $request->lastnameEmpleado2;
            $data->ariasEmpleado = $request->ariasEmpleado;
            $data->infodelete_Empleados = $request->infodelete_Empleados;
            $data->id_departamento = $request->id_departamento;
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
        $data = Empleados::find($id);
        $reglas = Validator::make($request->all(), [
            'nameEmpleado' => 'required|min:1',
            'lastnameEmpleado1' => 'required|min:1',
            'lastnameEmpleado2' => 'required|min:1',
            'ariasEmpleado' => 'required|min:1',
        ]);
        if (!$data) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Empleado no encontrado'
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
            'message' => 'Empleado actualizado correctamente',
            'data' => $data
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Empleados::find($id);
        if($data != null){
            $data -> delete();
        } return response()->json([
            'status'=>'success'
        ]);
    }

    public function desactivarEmpleado(Request $request, $id)
    {
    $data = Empleados::find($id);

    if (!$data) {
        return response()->json([
        'status' => 'error',
        'message' => 'Empleado no encontrado'
        ], 404);
    }

    $validator = Validator::make($request->all(), [
        'infodelete_Empleados' => 'required|in:Alta,Baja',
    ]);

    if ($validator->fails()) {
        return response()->json([
        'status' => 'failed',
        'message' => 'Error de validación',
        'errors' => $validator->errors()
        ], 400);
    }

    $updatedData = [
        'infodelete_Empleados' => $request->infodelete_Empleados
    ];

    $data->update($updatedData);

    return response()->json([
        'status' => 'success',
        'message' => 'Empleado desactivado exitosamente',
        'data' => $data
    ]);
    }

    public function verEmpleados()
        {
            $empleados = Empleados::where('infodelete_Empleados', '!=', 'Baja')->get();
            return response()->json($empleados);
        }
}