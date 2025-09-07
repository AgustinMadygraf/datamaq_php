# datamaq_php

Proyecto PHP basado en Clean Architecture para la gestión y visualización de datos de producción.

## Estructura principal

- `entities/` — Entidades del dominio (modelos de negocio puros).
- `use_cases/` — Casos de uso y servicios de aplicación.
- `interface_adapters/`
  - `controller/` — Controladores HTTP/API.
  - `gateway/` — Repositorios y adaptadores de acceso a datos.
  - `presenter/` — Presentadores y formateadores de salida.
- `infrastructure/` — Implementaciones técnicas (DB, configuración, etc).
- `api/` — Endpoints HTTP expuestos.
- `config/` — Configuración centralizada (opcional).
- `docs/` — Documentación adicional.

## Instalación

1. Clonar el repositorio.
2. Configurar el archivo `env.php` con las variables de entorno necesarias.
3. Revisar la configuración en `infrastructure/app_config.php`.
4. Asegurarse de que los permisos de los archivos y carpetas sean correctos.

## Ejecución

- Acceder a los endpoints en `api/v0/` o `api/v1/` según la versión deseada.
- Los controladores orquestan los casos de uso y nunca acceden directamente a la infraestructura.

## Documentación

- Ver `docs/estructura.md` para detalles sobre la arquitectura y dependencias.

---

> Proyecto alineado con los principios de Clean Architecture para máxima mantenibilidad y escalabilidad.
