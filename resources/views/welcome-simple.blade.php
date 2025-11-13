<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Gestor de Tareas') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <div class="container mx-auto px-4 py-16">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-6xl font-bold text-gray-800 mb-6">
                🎉 ¡Aplicación Funcionando!
            </h1>
            <p class="text-xl text-gray-600 mb-8">
                Gestor de Tareas desplegado exitosamente en Railway
            </p>

            <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Panel de Control</h2>
                <div class="flex justify-center space-x-4">
                    <a href="/login" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                        Iniciar Sesión
                    </a>
                    <a href="/register" class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                        Registrarse
                    </a>
                </div>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">✅ Laravel {{ app()->version() }}</h3>
                    <p class="text-gray-600">Framework funcionando correctamente</p>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">🐘 PHP {{ PHP_VERSION }}</h3>
                    <p class="text-gray-600">Servidor web activo</p>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">🚀 Railway Deploy</h3>
                    <p class="text-gray-600">Aplicación en producción</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
