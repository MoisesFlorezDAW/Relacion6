<?php

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