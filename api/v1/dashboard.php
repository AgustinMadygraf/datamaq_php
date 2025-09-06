<?php
/*
Path: public/dashboard_test.php
Description: Endpoint de prueba para el dashboard. Devuelve datos simulados.
*/

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Leer parámetros GET
$fecha = isset($_GET['fecha']) ? $_GET['fecha'] : date('Y-m-d');
$turno = isset($_GET['turno']) ? $_GET['turno'] : 'completo';

// Definir rangos de valores según el turno
switch ($turno) {
    case 'central':
        $min = 60; $max = 90;
        break;
    case 'manana':
        $min = 70; $max = 100;
        break;
    case 'tarde':
        $min = 50; $max = 80;
        break;
    case 'dia':
        $min = 60; $max = 110;
        break;
    case 'completo':
    default:
        $min = 50; $max = 120;
        break;
}

// Generar datos simulados para cada serie
function random_series($min, $max, $count = 288) {
    $arr = [];
    for ($i = 0; $i < $count; $i++) {
        $arr[] = rand($min, $max);
    }
    return $arr;
}

// Calcular cuántos intervalos de 5 minutos han pasado hoy
if ($fecha === date('Y-m-d')) {
    $now = getdate();
    $intervals = $now['hours'] * 12 + intval($now['minutes'] / 5);
    if ($intervals > 288) $intervals = 288;
} else {
    $intervals = 288;
}

// "hoy" solo hasta la hora actual, el resto null
$hoy_data = array_merge(
    random_series($min, $max, $intervals),
    array_fill(0, 288 - $intervals, null)
);

// "ayer" y "semana_anterior" siempre 288 valores completos
$ayer_data = random_series($min-10, $max-10, 288);
$semana_anterior_data = random_series($min-20, $max-20, 288);

$series = [
    "hoy" => [ "data" => $hoy_data ],
    "ayer" => [ "data" => $ayer_data ],
    "semana_anterior" => [ "data" => $semana_anterior_data ]
];

$response = [
    "meta" => [
        "title" => "Dashboard Test",
        "date" => $fecha,
        "turno" => $turno
    ],
    "series" => $series,
    "features" => [],
    "producto" => "Test Producto",
    "velocidad" => 100,
    "formato" => "22 x 10 x30",
    "anchoBobina" => 690,
    "debug_params" => ["fecha" => $fecha, "turno" => $turno]
];

echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>