<?php

final class MuebleReciclado extends MuebleBase{

    private int $porcentajeReciclado;
    private function __construct(string $nombre,
        string $fabricante = "FaMu:",
        string $pais = "ESPAÑA",
        int $anio = 2020,
        string $fechaIniVenta = "01/01/2020",
        string $fechaFinVenta = "31/12/2040",
        float $precio = 30
    ,int $porcentajeReciclado = 10)        
    {
        parent::__construct($nombre, $fabricante, $pais, $anio, $fechaIniVenta, $fechaFinVenta, 
        $precio);

        if(!$this->setPorcentajeReciclado($porcentajeReciclado)){
            $this->porcentajeReciclado;
        }
    }

    public function setPorcentajeReciclado(int $porcentajeReci){
        $valor = $porcentajeReci;

        if(!validaEntero($valor, 0, 100, 10)){
            return false;
        }
        $this->porcentajeReciclado=$valor;
        return true;
    }


    public function getPorcentajeReciclado(): int{
        return $this->porcentajeReciclado;
    }

    #[Override]
    public function damePropiedadesAdicionales(): array
    {
        return ["PorcentajeReciclado"];
    }

    #[Override]
    public function __toString(): string
    {
        return parent::__toString() . "Porcentaje Reciclado: " . $this->porcentajeReciclado;
    }
}