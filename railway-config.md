# Configuración para Railway

## Variables de entorno necesarias

Para que el envío de emails funcione correctamente en Railway, necesitas configurar las siguientes variables de entorno en tu proyecto de Railway:

### Configuración básica de la aplicación
```
APP_NAME="Gestor de Tareas"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tu-app.railway.app
```

### Configuración de base de datos (si usas MySQL en Railway)
```
DB_CONNECTION=mysql
DB_HOST=<tu-host-mysql>
DB_PORT=3306
DB_DATABASE=<tu-database>
DB_USERNAME=<tu-username>
DB_PASSWORD=<tu-password>
```

### Configuración de correo (Gmail)
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu-email@gmail.com
MAIL_PASSWORD=tu-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=tu-email@gmail.com
MAIL_FROM_NAME="Gestor de Tareas"
MAIL_TIMEOUT=60
MAIL_VERIFY_PEER=true
MAIL_VERIFY_PEER_NAME=true
MAIL_ALLOW_SELF_SIGNED=false
```

### Configuración de cola (Queue)
```
QUEUE_CONNECTION=database
```

### Configuración de sesión
```
SESSION_DRIVER=database
SESSION_LIFETIME=120
```

## Comandos necesarios en Railway

Para que las colas funcionen correctamente, necesitas:

1. **Ejecutar migraciones**: Railway debería ejecutar automáticamente `php artisan migrate`

2. **Ejecutar el worker de cola**: Necesitas configurar un worker separado que ejecute:
   ```bash
   php artisan queue:work --tries=3 --timeout=90
   ```

## Estructura de Procfile para Railway

Crea o modifica el archivo `Procfile` en la raíz de tu proyecto:

```
web: php artisan serve --host=0.0.0.0 --port=$PORT
worker: php artisan queue:work --tries=3 --timeout=90 --sleep=3 --max-jobs=1000
```

## Problemas comunes y soluciones

1. **Los emails no se envían**: 
   - Verifica que el worker de cola esté ejecutándose
   - Revisa los logs con `php artisan queue:failed`
   - Asegúrate de que la contraseña de app de Gmail sea correcta

2. **Timeout en el envío**:
   - Aumenta `MAIL_TIMEOUT` a 60 o más segundos
   - Verifica la configuración SSL/TLS

3. **Problemas de autenticación**:
   - Usa contraseñas de aplicación de Gmail, no la contraseña normal
   - Habilita "Acceso de aplicaciones menos seguras" si es necesario

## Comandos útiles para debugging

```bash
# Ver trabajos fallidos
php artisan queue:failed

# Reintentar trabajos fallidos
php artisan queue:retry all

# Limpiar trabajos fallidos
php artisan queue:flush

# Ver estado de las colas
php artisan queue:monitor

# Probar envío de email manualmente
php artisan tinker
>>> \Illuminate\Support\Facades\Mail::raw('Test', function($m) { $m->to('test@example.com')->subject('Test'); });
```
