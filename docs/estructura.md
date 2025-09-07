# Estructura y dependencias — Clean Architecture

## Visión general
Este proyecto sigue los principios de Clean Architecture, separando claramente las responsabilidades en capas independientes.

## Estructura de carpetas

- **entities/**: Entidades del dominio. Modelos puros sin dependencias externas.
- **use_cases/**: Casos de uso y servicios de aplicación. Orquestan la lógica de negocio.
- **interface_adapters/**:
  - **controller/**: Controladores HTTP/API. Reciben las peticiones y orquestan los casos de uso.
  - **gateway/**: Repositorios y adaptadores de acceso a datos. Implementan interfaces para la infraestructura.
  - **presenter/**: Presentadores y formateadores de salida.
- **infrastructure/**: Implementaciones técnicas (conexión a base de datos, configuración, etc). No contiene lógica de negocio.
- **api/**: Endpoints HTTP expuestos al exterior.
- **config/**: Configuración centralizada (opcional, recomendado).
- **docs/**: Documentación adicional.

## Flujo típico de una petición

1. **api/**: Recibe la petición HTTP.
2. **controller/**: El controlador correspondiente procesa la petición y orquesta el caso de uso.
3. **use_cases/**: El caso de uso ejecuta la lógica de negocio, interactuando con los repositorios a través de interfaces.
4. **gateway/**: Los repositorios acceden a la infraestructura (DB, archivos, etc) según sea necesario.
5. **presenter/**: El presentador da formato a la respuesta para la capa de presentación.
6. **api/**: Se retorna la respuesta al cliente.

## Principios clave

- **Independencia de capas**: Cada capa solo conoce la inmediatamente inferior a través de interfaces.
- **Inversión de dependencias**: Los casos de uso dependen de interfaces, no de implementaciones concretas.
- **Configuración centralizada**: Todas las variables sensibles y de entorno deben estar en archivos de configuración.
- **Controladores orquestan, no implementan lógica de negocio ni acceden a infraestructura directamente.**

## Diagrama simplificado

```
[api] → [controller] → [use_cases] → [gateway] → [infrastructure]
                                 ↓
                            [entities]
```

## Dependencias principales
- PHP >= 7.x
- MySQL/MariaDB
- Extensiones: mysqli

## Recomendaciones
- Mantener esta documentación actualizada ante cualquier cambio estructural.
- Seguir las convenciones de nombres y responsabilidades para facilitar el mantenimiento y la colaboración.

---

> Para dudas o contribuciones, consulta primero este documento y el `README.md`.
