<?php

// Ajusta la ruta a donde tengas \scripts\librerias
require_once dirname(__FILE__) . "/../../scripts/librerias/validacion.php";

abstract class MuebleBase
{
    private Caracteristicas $caracteristicas;
    const MAXIMO_MUEBLES = 100;

    private static int $mueblesCreados = 0;

    private string $nombre;
    private string $fabricante;
    private string $pais;
    private int $anio;
    private string $fechaIniVenta;
    private string $fechaFinVenta;
    private float $precio;

    public function __construct(
        string $nombre,
        string $fabricante = "FaMu:",
        string $pais = "ESPAÑA",
        int $anio = 2020,
        string $fechaIniVenta = "01/01/2020",
        string $fechaFinVenta = "31/12/2040",
        float $precio = 30
    ) {
        $quedan = 0;
        if (!self::puedeCrear($quedan)) {
            throw new Exception("Se ha superado el maximo de muebles (" . self::MAXIMO_MUEBLES . ")");
        }

        // El nombre es obligatorio: si falla, error
        if (!$this->setNombre($nombre)) {
            throw new Exception("El nombre del mueble no es valido");
        }

        // Para el resto, si falla el set se asigna el valor por defecto
        if (!$this->setFabricante($fabricante)) {
            $this->setFabricante("FaMu:");
        }
        if (!$this->setPais($pais)) {
            $this->setPais("ESPAÑA");
        }
        if (!$this->setAnio($anio)) {
            $this->setAnio(2020);
        }
        // Si falla la fecha de inicio se asigna 01/01/anio
        if (!$this->setFechaIniVenta($fechaIniVenta)) {
            $this->setFechaIniVenta("01/01/" . $this->anio);
        }
        if (!$this->setFechaFinVenta($fechaFinVenta)) {
            $this->setFechaFinVenta("31/12/2040");
        }
        if (!$this->setPrecio($precio)) {
            $this->setPrecio(30);
        }

        $this->caracteristicas = new Caracteristicas();
        self::$mueblesCreados++;
    }

    // No se permite la sobrecarga dinamica de propiedades
    public function __set(string $nombre, mixed $valor): void
    {
        throw new Error("No se permite crear la propiedad dinamica '" . $nombre . "' en " . static::class);
    }

    // ---------- SET ----------
    public function setNombre(string $nombre): bool
    {
        $valor = mb_strtoupper(mb_trim($nombre));
        if ($valor == "") {
            return false;
        }
        if (!validaCadena($valor, 40, "")) {
            return false;
        }
        $this->nombre = $valor;
        return true;
    }

    public function setFabricante(string $fabricante): bool
    {
        $valor = mb_trim($fabricante);
        if (mb_substr($valor, 0, 5) !== "FaMu:") {
            $valor = "FaMu:" . $valor;
        }
        $valor = mb_substr($valor, 0, 30);
        if (!validaCadena($valor, 30, "FaMu:")) {
            return false;
        }
        $this->fabricante = $valor;
        return true;
    }

    public function setPais(string $pais): bool
    {
        $valor = mb_trim($pais);
        if (!validaCadena($valor, 20, "ESPAÑA")) {
            return false;
        }
        $this->pais = $valor;
        return true;
    }

    public function setAnio(int $anio): bool
    {
        $valor = $anio;
        if (!validaEntero($valor, 2020, (int) date("Y"), 2020)) {
            return false;
        }
        $this->anio = $valor;
        return true;
    }

    public function setFechaIniVenta(string $fecha): bool
    {
        $valor = $fecha;
        if (!validaFecha($valor, "")) {
            return false;
        }
        // No puede ser anterior al 1 de enero del año de fabricacion
        $inicio = date_create_from_format("!d/m/Y", $valor);
        $minimo = date_create_from_format("!d/m/Y", "01/01/" . $this->anio);
        if ($inicio < $minimo) {
            return false;
        }
        $this->fechaIniVenta = $valor;
        return true;
    }

    public function setFechaFinVenta(string $fecha): bool
    {
        $valor = $fecha;
        if (!validaFecha($valor, "")) {
            return false;
        }
        // No puede ser anterior a la fecha de inicio de venta
        $fin = date_create_from_format("!d/m/Y", $valor);
        $inicio = date_create_from_format("!d/m/Y", $this->fechaIniVenta);
        if ($fin < $inicio) {
            return false;
        }
        $this->fechaFinVenta = $valor;
        return true;
    }

    public function setPrecio(float $precio): bool
    {
        $valor = $precio;
        if (!validaReal($valor, 30.0, PHP_FLOAT_MAX, 30.0)) {
            return false;
        }
        $this->precio = $valor;
        return true;
    }

    // ---------- GET ----------
    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getFabricante(): string
    {
        return $this->fabricante;
    }

    public function getPais(): string
    {
        return $this->pais;
    }

    public function getAnio(): int
    {
        return $this->anio;
    }

    public function getFechaIniVenta(): string
    {
        return $this->fechaIniVenta;
    }

    public function getFechaFinVenta(): string
    {
        return $this->fechaFinVenta;
    }

    public function getPrecio(): float
    {
        return $this->precio;
    }

    // Se redefinira en las clases hijas con el nombre de sus propiedades adicionales
    public function damePropiedadesAdicionales(): array
    {
        return [];
    }

    // Devuelve true si se pueden crear mas instancias y en $numero cuantas quedan
    public static function puedeCrear(int &$numero): bool
    {
        $numero = self::MAXIMO_MUEBLES - self::$mueblesCreados;
        return $numero > 0;
    }

    // Metodos agregados despues de la creacion de la clase caracteristicas
    // Recibe pares (nombre, valor). Si el numero de argumentos es impar, se desecha el ultimo
public function anadirCaracteristicas(mixed ...$pares): void
{
    $total = count($pares);
    for ($i = 0; $i + 1 < $total; $i += 2) {
        $nombre = $pares[$i];
        if (!is_string($nombre) || mb_trim($nombre) == "") {
            throw new InvalidArgumentException("El nombre de la caracteristica debe ser una cadena no vacia");
        }
        $this->caracteristicas->$nombre = $pares[$i + 1];
    }
}

public function getCaracteristicas(): Caracteristicas
{
    return $this->caracteristicas;
}

    public function __toString(): string
{
    return "MUEBLE de clase " . static::class
        . " con nombre " . $this->nombre
        . ", fabricante " . $this->fabricante
        . ", fabricado en " . $this->pais
        . " a partir del año " . $this->anio
        . ", vendido desde " . $this->fechaIniVenta
        . " hasta " . $this->fechaFinVenta
        . ", precio " . $this->precio
        . ", caracteristicas [" . $this->caracteristicas . "]";
}