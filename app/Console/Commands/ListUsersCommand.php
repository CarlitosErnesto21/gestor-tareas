<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class ListUsersCommand extends Command
{
    protected $signature = 'users:list';
    protected $description = 'List all registered users';

    public function handle()
    {
        $users = User::orderBy('created_at', 'desc')->get();

        if ($users->isEmpty()) {
            $this->info('No hay usuarios registrados.');
            return 0;
        }

        $this->info('Usuarios registrados:');
        $this->info('====================');

        foreach ($users as $user) {
            $verified = $user->email_verified_at ? 'Verificado' : 'Sin verificar';
            $this->info("ID: {$user->id} | Nombre: {$user->name} | Email: {$user->email} | Estado: {$verified} | Registro: {$user->created_at}");
        }

        return 0;
    }
}
