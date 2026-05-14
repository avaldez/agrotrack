# AGROTRACK - MVP

Aplicación móvil de asistencia técnica agrícola con Laravel 11 + Livewire 3 + Tailwind CSS + PWA.

## Requisitos

- PHP 8.2+
- MySQL 8.0+
- Composer
- Node.js (para compilar assets con Vite)

## Instalación

```bash
# 1. Clonar e instalar dependencias
composer install
npm install && npm run build

# 2. Configurar base de datos
cp .env.example .env
# Editar .env con conexión MySQL (localhost)
php artisan key:generate

# 3. Migrar y poblar base de datos
php artisan migrate --seed

# 4. Iniciar servidor
php artisan serve
```

## Usuarios de prueba

| Email | Password | Rol |
|---|---|---|
| admin@agrotrack.com | admin123 | Admin |
| tecnico@agrotrack.com | tec123 | Técnico |
| tecnico2@agrotrack.com | tec123 | Técnico |
| consulta@agrotrack.com | con123 | Consulta |

## PWA

- La app es instalable en Android/iOS desde el navegador.
- `/public/sw.js` — Service Worker con cacheo de assets y API
- `/public/manifest.json` — Manifest PWA
- IndexedDB sincroniza datos offline automáticamente

## Funcionalidades MVP

- [x] RBAC (Admin / Técnico / Consulta)
- [x] Gestión de clientes y parcelas
- [x] Registro de recorridos y visitas
- [x] Recomendaciones con mezcla de tanque
- [x] Cálculo automático de costos
- [x] Generación de PDF (DomPDF)
- [x] Compartir por WhatsApp
- [x] PWA offline-first + IndexedDB sync
- [x] Catálogo de productos con precios
- [x] Histórico de visitas por parcela
