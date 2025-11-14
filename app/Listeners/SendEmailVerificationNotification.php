<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class SendEmailVerificationNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Registered $event): void
    {
        try {
            /** @var User $user */
            $user = $event->user;

            Log::info('Intentando enviar email de verificación para: ' . $user->email);

            // Configurar timeout apropiado para Railway
            if (function_exists('ini_set')) {
                ini_set('max_execution_time', 30);
            }

            if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail()) {
                $user->notify(new VerifyEmail);
                Log::info('Email de verificación encolado correctamente para: ' . $user->email);
            }
        } catch (\Exception $e) {
            /** @var User $user */
            $user = $event->user;

            // Log detallado del error
            Log::error('Error enviando email de verificación para ' . $user->email . ': ' . $e->getMessage(), [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Re-lanzar la excepción para que el job se reintente
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(Registered $event, \Throwable $exception): void
    {
        /** @var User $user */
        $user = $event->user;

        Log::error('Falló definitivamente el envío de email de verificación para usuario: ' . $user->email . '. Error: ' . $exception->getMessage());
    }
}
