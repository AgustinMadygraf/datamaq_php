<?php
/*
Path: app/entities/dashboard.php
*/

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
