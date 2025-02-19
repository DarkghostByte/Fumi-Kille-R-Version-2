<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Orden;
use Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class ClientesController extends Controller
{
    public function index()
{
    $data = Cliente::select([
        'clientes.*', 
        'ciudades.ciudad', 
        'ciudades.estado', 
        'colonias.colonia',
        'colonias.codigoPostal', 
        'vias.tipoVia',
        'formaContacto.formadeContacto',])
        ->join('ciudades', 'clientes.id_city', '=', 'ciudades.id')
        ->join('colonias', 'clientes.id_colonia', '=', 'colonias.id')
        ->join('vias', 'clientes.id_vias', '=', 'vias.id')
        ->join('formaContacto', 'clientes.contact_form', '=', 'formaContacto.id')
        ->orderBy('clientes.id', 'DESC')
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
        $reglas = Validator::make($request->all(), [
            'name' => 'required|min:1',
            'lastname1' => 'required|min:1',
            'lastname2' => 'required|min:1',
            'tradename' => 'min:1',
            'id_vias' => 'required|min:1',
            'home' => 'required|min:1',
            'numAddress' => 'required|min:1',
            'id_colonia' => 'required|exists:colonias,id',
            'id_city' => 'required|exists:ciudades,id',
            'comercio' => 'required|min:1',
            'description' => 'min:1|max:200',
            'how_to_get' => 'min:1|max:200',
            'cell_phone' => 'required|min:10|max:13',
            'number_fixed_number' => 'min:1',
            'contact_form' => 'required|min:1',
            'specify' => 'min:1',
            'recruitment_data' => 'array|min:1',
            'infoclient_delete' => 'required|min:1',
            'requires' => 'array|required|min:1',
            'correo' => 'required|min:1',
        ]);

        if ($reglas->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation Error',
                'error' => $reglas->errors()
            ], 201);
        } else {
            $data = new Cliente();
            $data->name = $request->name;
            $data->lastname1 = $request->lastname1;
            $data->lastname2 = $request->lastname2;
            $data->tradename = $request->tradename;
            $data->correo = $request->correo;
            $data->id_vias = $request->id_vias;
            $data->home = $request->home;
            $data->numAddress = $request->numAddress;
            $data->id_colonia = $request->id_colonia;
            $data->id_city = $request->id_city;
            $data->comercio = $request->comercio;
            $data->description = $request->description;
            $data->how_to_get = $request->how_to_get;
            $data->cell_phone = $request->cell_phone;
            $data->number_fixed_number = $request->number_fixed_number;
            $data->contact_form = $request->contact_form;
            $data->specify = $request->specify;
            $data->recruitment_data = json_encode($request->recruitment_data);
            $data->infoclient_delete = $request->infoclient_delete;
            $data->requires = json_encode($request->requires);
            $data->save();

            return response()->json([
                'status' => 'success',
                'data' => $data
            ]);
        }
    }

    public function sendEmail($token,$name)
    {
        //
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Cliente::find($id);
        return response()->json([
            'status'=>'success',
            'data'=>$data
        ]);
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
        $cliente = Cliente::find($id);
        $reglas = Validator::make($request->all(), [
            'name' => 'required|min:1',
            'lastname1' => 'required|min:1',
            'lastname2' => 'required|min:1',
            'tradename' => 'min:1',
            'id_vias' => 'required|min:1',
            'home' => 'required|min:1',
            'numAddress' => 'required|min:1',
            'id_colonia' => 'required|exists:colonias,id',
            'id_city' => 'required|exists:ciudades,id',
            'comercio' => 'required|min:1',
            'description' => 'min:1|max:200',
            'how_to_get' => 'min:1|max:200',
            'cell_phone' => 'required|min:10|max:13',
            'number_fixed_number' => 'min:1',
            'contact_form' => 'required|min:1',
            'specify' => 'min:1',
            'recruitment_data' => 'array|min:1',
            'requires' => 'array|required|min:1',
            'correo' => 'required|min:1',
        ]);
        if (!$cliente) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Cliente no encontrado'
            ], 404);
        }
        if ($reglas->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Error de validación',
                'errors' => $reglas->errors()
            ], 400);
        }
        $cliente->fill($request->all());
        $cliente->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Cliente actualizado correctamente',
            'data' => $cliente
        ]);
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Cliente::find($id);
        if($data != null){
            $data -> delete();
        } return response()->json([
            'status'=>'success'
        ]);
    }

    public function upload(Request $request){
        /*
        if ($request->hasFile('file')){
            $file  = $request->file('file');
            $filename = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('products/'),$filename);

            return response()->json(['filename' =>  $filename]);
        }
        return response()->json(['error' => 'No se propocionó ningun archivo'],
        400);
        */
    }

    public function desactivarCliente(Request $request, $id)
    {
    $cliente = Cliente::find($id);

    if (!$cliente) {
        return response()->json([
        'status' => 'error',
        'message' => 'Cliente no encontrado'
        ], 404);
    }

    $validator = Validator::make($request->all(), [
        'infoclient_delete' => 'required|in:Alta,Baja',
    ]);

    if ($validator->fails()) {
        return response()->json([
        'status' => 'failed',
        'message' => 'Error de validación',
        'errors' => $validator->errors()
        ], 400);
    }

    $updatedData = [
        'infoclient_delete' => $request->infoclient_delete
    ];

    $cliente->update($updatedData);

    return response()->json([
        'status' => 'success',
        'message' => 'Cliente desactivado exitosamente',
        'data' => $cliente
    ]);
    }
}

