<?php
/*
Path: backend/helpers/GradientHelper.php
Este archivo contiene la clase GradientHelper, que se encarga de calcular el degradado de advertencia.
*/

class GradientHelper {
    /**
     * Calcula el degradado de advertencia.
     *
     * @param int $pot Nivel de potencia.
     * @param int $levels Número de niveles (por defecto 4).
     * @param int $base Valor base para el cálculo (por defecto 350).
     * @param int $step Incremento de decremento entre niveles (por defecto 10).
     * @return array Lista de valores para el degradado.
     */
    public static function calculateGradient(int $pot, int $levels = 4, int $base = 350, int $step = 10): array {
        $gradient = [];
        for ($i = 0; $i < $levels; $i++) {
            $gradient[$i] = $base - $pot - $step * $i;
        }
        return $gradient;
    }
}
?>