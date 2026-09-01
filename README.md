# 🍦 Ticketera de Helados

Sistema web de punto de venta para una heladería: gestión de productos (helados, toppings, bebidas, postres), control de stock, creación de tickets/pedidos, y reportes de ventas del día. Pensado para usarse en una tablet o pantalla táctil en el área de recepción.

Construido con **Laravel 13** + **Blade** + **Tailwind CSS** + **MySQL**.

---

## 👥 Roles del sistema

| Rol | Puede hacer |
|---|---|
| **Superadmin** | Todo lo del admin, + crear/editar/eliminar administradores, cambiar el rol de cualquier usuario |
| **Admin** | Gestionar productos y precios, ver ventas del día, crear y editar **vendedores** (su equipo) |
| **Vendedor** | Crear tickets, agregar productos, cerrar tickets, ver sus ventas del día |

Cualquier usuario (sin importar el rol) puede cambiar su propia contraseña desde el ícono 🔑 en la barra de navegación.

---

## ✅ Funcionalidades

- Autenticación con roles (superadmin / admin / vendedor)
- CRUD de productos por categoría (helado, topping, bebida, postre, otro), con activar/desactivar
- Control de stock por producto, con alertas de stock bajo y agotado
- Creación de tickets con trazabilidad (queda registrado quién lo hizo)
- Pantalla táctil para agregar productos al ticket (tarjetas grandes, filtro por categoría)
- Impresión de ticket en formato térmico (80mm)
- Dashboard de ventas del día: por trabajador y por producto
- Gestión de equipo: el admin agrega/edita vendedores, el superadmin gestiona a todos

---

## 🛠️ Requisitos previos

- PHP >= 8.3 con extensiones: `curl`, `mbstring`, `openssl`, `pdo_mysql`, `zip`, `fileinfo`
- Composer
- Node.js + npm
- MySQL (o MariaDB)
- (Opcional) XAMPP, si prefieres un entorno todo-en-uno en Windows

---

## 🚀 Instalación

### 1. Clonar el repositorio

```bash
git clone https://github.com/ApoBC/ticketera_helados.git
cd ticketera_helados
```

### 2. Instalar dependencias de PHP

```bash
composer install
```

### 3. Instalar dependencias de frontend

```bash
npm install
```

### 4. Configurar el entorno

```bash
cp .env.example .env
php artisan key:generate
```

Edita `.env` y completa los datos de tu base de datos MySQL:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ticketera_db
DB_USERNAME=root
DB_PASSWORD=
```

> ⚠️ Si tu contraseña de MySQL tiene caracteres especiales (`=`, `#`, espacios), ponla entre comillas: `DB_PASSWORD="tu-clave"`. De lo contrario Laravel no podrá leer el `.env`.

### 5. Crear la base de datos

Crea manualmente en MySQL una base de datos vacía con el nombre que pusiste en `DB_DATABASE` (por ejemplo `ticketera_db`).

### 6. Ejecutar migraciones y datos de ejemplo

```bash
php artisan migrate
php artisan db:seed --class=UserSeeder
php artisan db:seed --class=DatabaseSeeder
```

Esto crea los usuarios de prueba y algunos productos de ejemplo (incluyendo casos con stock bajo y agotado, para ver las alertas funcionando).

### 7. Compilar los assets del frontend

```bash
npm run build
```

Usa `npm run dev` en su lugar si vas a estar editando estilos/vistas seguido (recompila automáticamente).

### 8. Levantar el servidor

```bash
php artisan serve
```

Abre [http://localhost:8000](http://localhost:8000) en el navegador.

---

## 🔑 Usuarios de prueba (creados por el seeder)

| Rol | Email | Contraseña |
|---|---|---|
| Superadmin | `superadmin@heladeria.com` | `cambiar123` |
| Admin | `admin@heladeria.com` | `admin123` |
| Vendedor | `vendedor@heladeria.com` | `vendedor123` |
| Vendedor | `maria@heladeria.com` | `vendedor123` |

> ⚠️ Cambia estas contraseñas antes de usar el sistema en producción (puedes hacerlo desde el ícono 🔑 una vez logueado).

---

## 📁 Estructura relevante

```
app/Http/Controllers/
  AuthController.php        → login / registro / logout
  AccountController.php     → cambio de contraseña propia
  UserController.php        → gestión de equipo (admin/superadmin)
  ProductController.php     → CRUD de productos y stock
  TicketController.php      → tickets y sus ítems
  ReportController.php      → dashboard de ventas del día

database/migrations/        → historial de cambios de la base de datos
database/seeders/           → usuarios y productos de ejemplo

resources/views/
  auth/                      → login, registro
  admin/                     → panel admin, productos, equipo, reportes
  superadmin/                → panel superadmin
  vendedor/                  → dashboard del vendedor
  tickets/                   → crear, ver, imprimir tickets
  account/                   → cambio de contraseña
```

---

## 🌿 Flujo de ramas Git

- `main` → rama estable, solo código probado
- `desarrollo` → integración diaria de funcionalidades
- `feature/*` → una rama por funcionalidad nueva

```bash
git checkout desarrollo
git checkout -b feature/nombre-de-la-funcionalidad
# ... trabajar y hacer commits ...
git checkout desarrollo
git merge feature/nombre-de-la-funcionalidad
# cuando desarrollo esté estable:
git checkout main
git merge desarrollo
```

---

## ⚠️ Pendiente conocido

El carrito de la pantalla "Crear Ticket" arma la selección de productos en el navegador, pero el backend (`TicketController::store`) todavía no procesa ese carrito — solo crea el ticket vacío. Por ahora, los productos se agregan uno por uno desde la pantalla del ticket ya creado (que sí tiene la interfaz táctil completa).

---

## 🧰 Comandos útiles

```bash
php artisan migrate:fresh --seed   # Reinicia la base de datos desde cero con datos de ejemplo
php artisan route:list             # Ver todas las rutas registradas
php artisan tinker                 # Consola interactiva de Laravel
npm run dev                        # Modo desarrollo con recarga automática de assets
```
