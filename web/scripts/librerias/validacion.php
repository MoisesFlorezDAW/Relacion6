<?php

require_once dirname(__FILE__) . "../../../aplicacion/clases/curso2026/MuebleBase.php";
require_once dirname(__FILE__) . "../../../aplicacion/clases/curso2026/MuebleReciclado.php";
require_once dirname(__FILE__) . "../../../aplicacion/clases/curso2026/MuebleTradicional.php";
require_once dirname(__FILE__) . "../../../aplicacion/clases/curso2026/Caracteristicas.php";

$muebles = [];

$muebles[1] = new MuebleReciclado("Sillon azul", "Ecoliving", "Portugal", 2022, "01/02/2022", "31/12/2035", 120.5, 75);
$muebles[1]->anadirCaracteristicas("color", "azul", "material", "plastico reciclado", "plegable", true);

$muebles[2] = new MuebleTradicional("Armario roble", "Maderas", "Francia", 2021, "01/01/2021", "31/12/2040", 400, 120.5, "S09");
$muebles[2]->anadirCaracteristicas("color", "marron", "material", "roble", "puertas", 3);

$muebles[3] = new MuebleReciclado("Mesa eco", "Reutiliza", "ESPAÑA", 2023, "15/03/2023", "31/12/2038", 85, 90);
$muebles[3]->anadirCaracteristicas("alto", 75, "ancho", 120, "extensible", false);

$muebles[4] = new MuebleTradicional("Cama nordica", "Nordik", "Suecia", 2020, "01/06/2020", "31/12/2040", 350, 60, "S02");
$muebles[4]->anadirCaracteristicas("color", "blanco", "colchon incluido", false, "ancho", 150);

$muebles[5] = new MuebleTradicional("Estanteria clasica", "Maderas", "ESPAÑA", 2024, "01/01/2024", "31/12/2040", 150, 40.5, "S05");
$muebles[5]->anadirCaracteristicas("baldas", 5, "material", "pino", "montaje", "facil");

function validaEntero(int &$var, int $min, int $max, int $defecto): bool {
    $r = filter_var($var, FILTER_VALIDATE_INT,
        ['options' => ['min_range' => $min, 'max_range' => $max]]);
    if ($r !== false) {         
        $var = $r;
        return true;
    }
    $var = $defecto;
    return false;
}

function validaReal(float &$var, float $min, float $max, float $defecto): bool {
    $r = filter_var($var, FILTER_VALIDATE_FLOAT,
        ['options' => ['min_range' => $min, 'max_range' => $max]]);
    if ($r !== false) {
        $var = $r;
        return true;
    }
    $var = $defecto;
    return false;
}

// FILTER no valida fechas: se usa FILTER_VALIDATE_REGEXP para el formato
// y checkdate() para que el día exista (igual que en la librería normal).
function validaFecha(string &$var, string $defecto): bool {
    $var = trim($var);
    $ok = filter_var($var, FILTER_VALIDATE_REGEXP,
        ['options' => ['regexp' => '/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/']]);
    if ($ok !== false) {
        [$d, $m, $a] = array_map('intval', explode('/', $var));
        if (checkdate($m, $d, $a)) {
            $var = sprintf('%02d/%02d/%04d', $d, $m, $a);
            return true;
        }
    }
    $var = $defecto;
    return false;
}

function validaHora(string &$var, string $defecto): bool {
    $var = trim($var);
    $ok = filter_var($var, FILTER_VALIDATE_REGEXP,
        ['options' => ['regexp' => '/^(\d{1,2}):(\d{1,2}):(\d{1,2})$/']]);
    if ($ok !== false) {
        [$h, $mi, $s] = array_map('intval', explode(':', $var));
        if ($h <= 23 && $mi <= 59 && $s <= 59) {
            $var = sprintf('%02d:%02d:%02d', $h, $mi, $s);
            return true;
        }
    }
    $var = $defecto;
    return false;
}

function validaEmail(string &$var, string $defecto): bool {
    $saneado = filter_var(trim($var), FILTER_SANITIZE_EMAIL);
    if (filter_var($saneado, FILTER_VALIDATE_EMAIL) !== false) {
        $var = $saneado;
        return true;
    }
    $var = $defecto;
    return false;
}

// No hay filtro de longitud: se sanea con FILTER y la longitud se comprueba a mano.
function validaCadena(string &$var, int $longitud, string $defecto): bool {
    $saneada = filter_var(trim($var), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if ($saneada !== false && mb_strlen(trim($var)) <= $longitud) {
        $var = $saneada;
        return true;
    }
    $var = $defecto;
    return false;
}

function validaExpresion(string &$var, string $expresion, string $defecto): bool {
    $r = filter_var($var, FILTER_VALIDATE_REGEXP,
        ['options' => ['regexp' => $expresion]]);
    if ($r !== false) {
        return true;
    }
    $var = $defecto;
    return false;
}

// Sin filtro equivalente: se copia la versión sin FILTER.
function validaRango(mixed $var, array $posibles, int $tipo = 1): bool {
    if ($tipo === 1) {
        return in_array($var, $posibles, true);
    }
    if ($tipo === 2) {
        return (is_int($var) || is_string($var)) && array_key_exists($var, $posibles);
    }
    return false;
}