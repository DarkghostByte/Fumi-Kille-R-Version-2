<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersController extends Controller
{
    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = User::all();
        return view('usuarios.index', compact('usuarios'));
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('usuarios.create');
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente.');
    }

    /**
     * Display the specified user.
     *
     * @param  \App\Models\User  $usuario
     * @return \Illuminate\Http\Response
     */
    public function show(User $usuario)
    {
        return view('usuarios.show', compact('usuario'));
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  \App\Models\User  $usuario
     * @return \Illuminate\Http\Response
     */
    public function edit(User $usuario)
    {
        return view('usuarios.edit', compact('usuario'));
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $usuario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $usuario->id,
            'password' => 'nullable|string|min:8',
        ]);

        $usuario->name = $request->name;
        $usuario->email = $request->email;

        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
        }

        $usuario->save();

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  \App\Models\User  $usuario
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $usuario)
    {
        $usuario->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente.');
    }

    /**
     * copy a user.
     *
     * @param  \App\Models\User  $usuario
     * @return \Illuminate\Http\Response
     */
    public function copy(User $usuario)
    {
        $newUser = $usuario->replicate();
        $newUser->email = $newUser->email . '_copy_' . time();
        $newUser->save();

        return redirect()->route('usuarios.index')->with('success', 'Usuario copiado correctamente.');
    }

    /**
     * Get all users in JSON format.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUsersJson()
    {
        $usuarios = User::all();
        return response()->json($usuarios);
    }

    /**
     * Handle user login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            $token = Str::random(60); // Genera un token aleatorio
    
            return response()->json([
                'token' => $token,
                'user' => $user,
            ]);
        }
    
        //return response()->json(['message' => 'Credenciales inválidas'], 401);
        return response()->json(['message' => 'Credenciales inválidas',
        "data"=>$user,
        "em"=>$credentials['email'],
        "pass2"=>$credentials['password'],
        "pass"=>Hash::make($credentials['password']),
    
    //$2y$12$dh24zKUPdHl5OM8WTH19x.JBPUt.5DN1B9EKH.6VfscM1xQpoD8wq
    ], 401);
    }
}