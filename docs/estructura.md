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
- **docs/**: Documentación adicional.


## Flujo de datos y dependencias (Clean Architecture)

### Secuencia de una petición típica

1. **api/**: Recibe la petición HTTP (por ejemplo, un endpoint REST).
2. **controller/**: El controlador interpreta la petición, extrae los parámetros y orquesta el caso de uso adecuado.
3. **use_cases/**: El caso de uso ejecuta la lógica de negocio, interactuando únicamente con interfaces de repositorio (no implementaciones concretas).
4. **gateway/**: El repositorio implementa la interfaz y accede a la infraestructura (DB, archivos, servicios externos, etc).
5. **infrastructure/**: Provee la implementación técnica (conexión a base de datos, configuración, etc).
6. **gateway (retorno)**: El repositorio retorna los datos al caso de uso a través de la interfaz.
7. **use_cases (retorno)**: El caso de uso retorna el resultado al controlador.
8. **presenter/**: El controlador delega el formateo de la respuesta al presentador, que la transforma al formato requerido (JSON, HTML, etc).
9. **api/**: El endpoint retorna la respuesta al cliente.

### Ejemplo de secuencia (v0)

```
Cliente HTTP
  ↓
[api/v0/dashboard.php]
  ↓
[DashboardControllerV0]
  ↓
[DashboardService / GetUltimoFormato]
  ↓
[DashboardRepositoryInterface / FormatoRepositoryInterface]
  ↓
[DashboardRepository / FormatoRepository]
  ↓
[Database / Infraestructura]
  ↑
[DashboardRepository / FormatoRepository]
  ↑
[DashboardService / GetUltimoFormato]
  ↑
[DashboardControllerV0]
  ↓
[DashboardPresenterV0]
  ↓
[api/v0/dashboard.php]
  ↓
Cliente HTTP
```

### Principios de dependencias

- Los **casos de uso** dependen solo de **interfaces** (no de implementaciones concretas).
- Los **controladores** orquestan, pero no contienen lógica de negocio ni acceden a infraestructura directamente.
- Los **presentadores** formatean la salida, desacoplando la lógica de presentación.
- La **infraestructura** nunca depende de las capas superiores.

### Notas sobre dependencias

- El uso de interfaces permite cambiar la fuente de datos (por ejemplo, de MySQL a API externa) sin modificar la lógica de negocio.
- Los tests unitarios pueden usar implementaciones dummy o mocks de las interfaces.

---

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
