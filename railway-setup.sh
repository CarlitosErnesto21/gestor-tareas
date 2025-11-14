#!/bin/bash

# Script para configurar variables de entorno en Railway
# Copia estos comandos y ejecútalos en tu terminal local donde tengas railway CLI

echo "Configurando variables de entorno para Railway..."

# Configuración básica
railway variables set APP_ENV=production
railway variables set APP_DEBUG=false
railway variables set APP_URL=https://gestor-tareas-production.up.railway.app

# Configuración de correo (CAMBIA POR TUS DATOS REALES)
railway variables set MAIL_MAILER=smtp
railway variables set MAIL_HOST=smtp.gmail.com
railway variables set MAIL_PORT=587
railway variables set MAIL_USERNAME=ernesto.rosales354@gmail.com
railway variables set MAIL_PASSWORD=zuepxthfmsylrybr
railway variables set MAIL_ENCRYPTION=tls
railway variables set MAIL_FROM_ADDRESS=ernesto.rosales354@gmail.com
railway variables set MAIL_FROM_NAME="Gestor de Tareas"

# Configuración de cola
railway variables set QUEUE_CONNECTION=database

echo "¡Variables configuradas! Ahora redeploya tu aplicación."
