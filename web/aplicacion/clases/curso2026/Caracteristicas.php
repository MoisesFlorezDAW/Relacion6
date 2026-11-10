<?php

class Caracteristicas implements IteratorAggregate
{
    // Caracteristicas en el orden en que se incorporaron
    private array $datos = [];

    // Se llama al asignar una propiedad que no existe (o inaccesible)
    public function __set(string $nombre, mixed $valor): void
    {
        $existe = array_key_exists($nombre, $this->datos);

        // Si ya se indico ULTIMA, no se pueden añadir nuevas, pero si modificar las existentes
        if (!$existe && array_key_exists("ULTIMA", $this->datos)) {
            throw new Error("No se puede añadir la caracteristica '" . $nombre . "': ya se indico ULTIMA");
        }
        $this->datos[$nombre] = $valor;
    }

    public function __get(string $nombre): mixed
    {
        if (!array_key_exists($nombre, $this->datos)) {
            throw new Error("La caracteristica '" . $nombre . "' no existe");
        }
        return $this->datos[$nombre];
    }

    public function __isset(string $nombre): bool
    {
        return isset($this->datos[$nombre]);
    }

    public function __unset(string $nombre): void
    {
        if ($nombre === "ULTIMA") {
            throw new Error("No se puede eliminar la caracteristica ULTIMA");
        }
        unset($this->datos[$nombre]);
    }

    // foreach: se recorren en orden inverso a como se incorporaron
    public function getIterator(): Iterator
    {
        return new ArrayIterator(array_reverse($this->datos, true));
    }

    // car1:valor1;car2:valor2;...
    public function __toString(): string
    {
        $cadena = "";
        foreach ($this->datos as $clave => $valor) {
            if ($cadena != "") {
                $cadena .= ";";
            }
            $cadena .= $clave . ":" . $valor;
        }
        return $cadena;
    }
}