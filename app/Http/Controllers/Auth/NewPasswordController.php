<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(Request $request): Response
    {
        // Mostrar mensaje de que está deshabilitado
        return Inertia::render('Auth/ResetPassword', [
            'email' => '',
            'token' => '',
            'disabled' => true,
            'message' => 'La recuperación de contraseña está temporalmente deshabilitada.'
        ]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Sistema deshabilitado
        return redirect()->route('login')->with('status', 'La recuperación de contraseña está temporalmente deshabilitada.');
    }
}
