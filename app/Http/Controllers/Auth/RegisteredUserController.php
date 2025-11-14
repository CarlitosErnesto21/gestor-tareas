<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                // Solo letras, espacios y tildes, sin números ni signos especiales
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñÜü\s]+$/u',
            ],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:'.User::class,
                // Estructura estricta: usuario@dominio.tld (solo letras, números, puntos, guiones y guion bajo en usuario y dominio)
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            ],
            'password' => [
                'required',
                'confirmed',
                // Mínimo 8, al menos una mayúscula, una minúscula, un número y un carácter especial
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!$#%&?@_"])[A-Za-z\d!$#%&?@_\"]{8,}$/',
            ],
        ], [
            'name.regex' => 'El nombre solo puede contener letras y espacios (puede llevar tildes, sin números ni signos especiales).',
            'email.regex' => 'El correo electrónico debe tener un formato válido (ejemplo: usuario@dominio.com).',
            'password.regex' => 'La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula, un número y un carácter especial.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(), // Marcar como verificado automáticamente
        ]);

        // Comentamos el evento para evitar envío de email
        // event(new Registered($user));

        // Hacer login automático después del registro
        Auth::login($user);

        return redirect(route('dashboard'))->with('status', 'Registro exitoso. ¡Bienvenido!');
    }
}
