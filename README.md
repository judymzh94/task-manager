# Task Manager

Aplicación interna para gestionar tareas entre usuarios de un equipo.  
Permite crear, listar y actualizar tareas, asignarles estados (pendiente/completada) y asociarles palabras clave reutilizables.

## Requisitos

- **PHP** ^8.2
- **Composer** ^2.7
- **Laravel** ^12.x
- **MySQL** ^8.0
- **Node.js** ^22.12+
- **npm** ^10.x
- **Vue.js** ^3.5.13

## Instalación

1. **Clonar el repositorio**
   ```bash
   git clone https://github.com/judymzh94/task-manager.git
   cd taskmanager

2. **Instalar dependencias de Laravel**
   ```bash
   composer install

3. **Instalar dependencias de Node.js**
   ```bash
   npm install

4. **Configurar el archivo .env**
   
    Copiar el archivo de ejemplo y editarlo con las credenciales a la BD específicas:
   ```bash
   cp .env.example .env

5. **Crear la BD en MySQL**
   
    El nombre por defecto en el .env.example es "taskmanager"


6. **Generar la clave de la aplicación**
   ```bash
   php artisan key:generate

7. **Ejecutar las migraciones**
   ```bash
   php artisan migrate

8. **Iniciar el servidor web local**
   ```bash
   php artisan serve

8. **Compila los assets**
   ```bash
   npm run dev

## API Endpoints

- **GET** `/api/tasks` → Listar tareas con palabras clave
- **POST** `/api/tasks` → Crear nueva tarea
- **PATCH** `/api/tasks/{id}/toggle` → Cambiar estado de tarea
- **GET** `/api/keywords` → Listar palabras clave
- **POST** `/api/keywords` → Crear nueva palabra clave  
