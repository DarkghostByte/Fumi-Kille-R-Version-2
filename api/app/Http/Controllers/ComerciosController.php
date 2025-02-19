<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comercio;
use Validator;

class ComerciosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Comercio ::all();
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
            'comercio' => 'required|min:1',
            'infodelete_departamento' => 'required|min:1',
        ]);
        if( $reglas -> fails()){
            return response()->json([
                'status'=>'failed',
                'message'=> 'Validation Error',
                'error' => $reglas->errors()
            ],201);
        }else{
            $data = new Comercio();
            $data->comercio = $request->comercio;
            $data->infodelete_departamento = $request->infodelete_departamento;
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Comercio::find($id);
        if($data != null){
            $data -> delete();
        } return response()->json([
            'status'=>'success'
        ]);
    }

    public function verComercio()
    {
        $comercios = Comercio::all();
        return response()->json($comercios);
    }

    public function verDepartamento()
    {
        $comercios = Comercio::where('infodelete_departamento', '!=', 'Baja')->get();
        return response()->json($comercios);
    }
}
