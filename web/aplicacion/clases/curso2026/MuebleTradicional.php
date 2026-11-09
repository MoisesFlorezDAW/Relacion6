<?php

final class MuebleTradicional extends MuebleBase{
    private float $peso;
    private string $serie;

    private function __construct(string $nombre,
        string $fabricante = "FaMu:",
        string $pais = "ESPAÑA",
        int $anio = 2020,
        string $fechaIniVenta = "01/01/2020",
        string $fechaFinVenta = "31/12/2040",
        float $precio = 30,
        float $peso=15, 
        string $serie="S01") {
        
        parent::__construct($nombre, $fabricante, $pais, $anio, $fechaIniVenta, $fechaFinVenta, $precio);      
        
        if(!$this->setPeso($peso)){
            $this->setPeso(15);
        }
        if(!$this->setSerie($serie)){
            $this->setSerie("S01");
        }
    }

    public function setPeso(float $peso): bool
    {
        $valor = $peso;
        if (!validaReal($valor, 15.0, 300.0, 15.0)) {
            return false;
        }
        $this->peso = $valor;
        return true;
    }

    public function setSerie(string $serie): bool
    {
        $valor = mb_trim($serie);
        if ($valor == "" || !validaCadena($valor, 255, "S01")) {
            return false;
        }
        $this->serie = $valor;
        return true;
    }

    public function getPeso(): float
    {
        return $this->peso;
    }

    public function getSerie(): string
    {
        return $this->serie;
    }

    #[Override]
    public function damePropiedadesAdicionales(): array
    {
        return ["Peso", "Serie"];
    }

    #[Override]
    public function __toString(): string
    {
        return parent::__toString() . "Peso: " . $this->peso . " Serie: " . $this->serie;
    }

}