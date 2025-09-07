<?php
// Entidad Dashboard: representa los datos del panel de control en el dominio
class Dashboard {
    public $velUlt;
    public $unixtime;
    public $rawdata;

    public function __construct($velUlt, $unixtime, $rawdata) {
        $this->velUlt = $velUlt;
        $this->unixtime = $unixtime;
        $this->rawdata = $rawdata;
    }
}
