<?php
/*
Path: backend/core/Navigation.php
Clase para navegar entre las páginas
*/

class Navigation implements NavigationInterface {
    private $ls_periodos = [
        'semana' => 604800,
        'turno'  => 28800,
        'hora'   => 7200
    ];

    public function getPeriod(): string {
        if ($_GET && array_key_exists("periodo", $_GET) && array_key_exists($_GET["periodo"], $this->ls_periodos)) {
            return $_GET["periodo"];
        }
        return 'semana';
    }

    public function getConta(int $valorInicial): int {
        if ($_GET && array_key_exists("conta", $_GET) && $_GET["conta"] <= $valorInicial) {
            return intval($_GET["conta"]);
        }
        return $valorInicial;
    }
}