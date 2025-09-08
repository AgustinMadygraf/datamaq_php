<?php
/*
Path: app/interface_adapters/presenter/initialize_database_cli_presenter.php
Responsable de formatear la salida CLI para la inicialización de la base de datos.
*/

class InitializeDatabaseCliPresenter
{
    public function present($result)
    {
        if (isset($result['error'])) {
            echo "[ERROR] {$result['error']}\n";
            return;
        }
        echo "[OK] Inicialización de tablas completada.\n";
        if (!empty($result['data_imported'])) {
            echo "[OK] Datos importados correctamente desde {$result['sql_file']}\n";
        } else {
            echo "[WARN] Archivo SQL no encontrado o no importado: {$result['sql_file']}\n";
        }
    }

    public function presentException($e)
    {
        if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
            echo "[WARN] Algunos datos ya existen en la base de datos. No se importaron duplicados.\n";
        } else {
            echo "[ERROR] " . $e->getMessage() . "\n";
        }
    }
}
