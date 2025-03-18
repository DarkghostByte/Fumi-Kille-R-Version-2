<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Remisiones;
use Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class RemisionesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Remisiones::select([
            'remisiones.*',
            'clientes.name',
            'clientes.lastname1',
            'clientes.lastname2',
            'clientes.tradename',
            'clientes.home',
            'clientes.numAddress',
            'clientes.id_colonia',
            'clientes.id_city',
            'clientes.comercio',
            'clientes.cell_phone',
            'clientes.number_fixed_number',
            'colonias.colonia',
            'colonias.codigoPostal',
            'ciudades.ciudad'
        ])
            ->join('orden', 'remisiones.id_cliente', '=', 'orden.id')
            ->join('clientes', 'orden.id_cliente', '=', 'clientes.id')
            ->join('colonias', 'clientes.id_colonia', '=', 'colonias.id')
            ->join('ciudades', 'clientes.id_city', '=', 'ciudades.id')
            ->orderBy('remisiones.id', 'DESC')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $reglas = Validator::make($request->all(), [
            'id_cliente' => 'min:1',
            'RemisionDate' => 'required|min:1',
            'RemisionCertificado' => 'required|min:1',
            'RemisionMonto' => 'required|min:1',
            'RemisionObservaciones' => 'required|min:1',
        ]);
        if ($reglas->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation Error',
                'error' => $reglas->errors()
            ], 201);
        } else {
            $data = new Remisiones();
            $data->id_cliente = $request->id_cliente;
            $data->RemisionDate = $request->RemisionDate;
            $data->RemisionCertificado = $request->RemisionCertificado;
            $data->RemisionMonto = $request->RemisionMonto;
            $data->RemisionObservaciones = $request->RemisionObservaciones;
            $data->save();

            return response()->json([
                'status' => 'success'
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $reglas = Validator::make($request->all(), [
            'id_cliente' => 'min:1',
            'RemisionDate' => 'required|min:1',
            'RemisionCertificado' => 'required|min:1',
            'RemisionMonto' => 'required|min:1',
            'RemisionObservaciones' => 'required|min:1',
        ]);

        if ($reglas->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation Error',
                'error' => $reglas->errors()
            ], 201);
        } else {
            $remision = Remisiones::find($id);
            if (!$remision) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Remision not found'
                ], 404);
            }

            $remision->update($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Remision updated successfully',
                'data' => $remision
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}