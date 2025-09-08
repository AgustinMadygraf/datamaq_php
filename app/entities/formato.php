<?php
/*
Path: app/entities/formato.php
Entidad de dominio para representar un Formato.
*/

class Formato {
    public $id;
    public $nombre;
    public $fechaCreacion;
    public $datos;

    public function __construct($id, $nombre, $fechaCreacion, $datos = []) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->fechaCreacion = $fechaCreacion;
        $this->datos = $datos;
    }
}
