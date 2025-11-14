<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class TestEmailCommand extends Command
{
    protected $signature = 'email:test {email}';
    protected $description = 'Test email configuration by sending a test email';

    public function handle()
    {
        $email = $this->argument('email');

        try {
            $this->info('Probando configuracion de email...');
            $this->info('Host: ' . config('mail.mailers.smtp.host'));
            $this->info('Puerto: ' . config('mail.mailers.smtp.port'));
            $this->info('Encriptacion: ' . config('mail.mailers.smtp.encryption'));
            $this->info('Usuario: ' . config('mail.mailers.smtp.username'));

            Mail::raw('Este es un email de prueba desde ' . config('app.name'), function ($message) use ($email) {
                $message->to($email)
                       ->subject('Email de prueba - ' . config('app.name'));
            });

            $this->info('Email enviado exitosamente a: ' . $email);
            return 0;

        } catch (\Exception $e) {
            $this->error('Error enviando email: ' . $e->getMessage());
            Log::error('Error en test de email: ' . $e->getMessage());
            return 1;
        }
    }
}
