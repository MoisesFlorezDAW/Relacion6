<?php
include_once(dirname(__FILE__) . "../../../cabecera.php");
$barraUbi = [
    [
        "TEXTO" => "Inicio",
        "LINK" => "/index.php"
    ],
    [
        "TEXTO" => "Relacion 6",
        "LINK" => "../../../aplicacion/clases/curso2026/index.php"
    ],
    [
        "TEXTO" => "Prueba Metodos",
        "LINK" => "./pruebas.php"
    ]
];

//controlador
//dibuja la plantilla de la vista
inicioCabecera("APLICACION PRIMER TRIMESTRE");
cabecera();
finCabecera();
inicioCuerpo("Relacion 4 - Primer Trimestre", $barraUbi);
cuerpo();  //llamo a la vista
finCuerpo();
// **********************************************************

//vista
function cabecera() {}

//vista
function cuerpo()
{

/**
     * Constructor con valores por defecto
     */
    echo "<p style='color: blue'>PRUEBA Mueble Reciclado (valores por defecto)<br><p>" . PHP_EOL;
    $muebleReciclado = new MuebleReciclado("Sillon azul");
    echo $muebleReciclado . "<br>" . PHP_EOL;

    echo "<p style='color: blue'>PRUEBA Mueble Tradicional (valores por defecto)<br><p>" . PHP_EOL;
    $muebleTradicional = new MuebleTradicional("Sillon tradicional rojo");
    echo $muebleTradicional . "<br>" . PHP_EOL;

    /**
     * Constructor con valores correctos
     */
    echo "<p style='color: blue'>PRUEBA Constructor con todos los valores correctos<br><p>" . PHP_EOL;
    $r = new MuebleReciclado("mesa eco", "Ecoliving", "Portugal", 2022, "01/02/2022", "31/12/2035", 120.5, 75);
    echo $r . "<br>" . PHP_EOL;
    $t = new MuebleTradicional("armario roble", "Maderas", "Francia", 2021, "01/01/2021", "31/12/2040", 400, 120.5, "S09");
    echo $t . "<br>" . PHP_EOL;

    echo "<p style='color: blue'>PRUEBA Constructor con valores incorrectos (se asignan los de por defecto)<br><p>" . PHP_EOL;
    $e = new MuebleReciclado("estanteria", "Fabrica con un nombre larguisimo de mas de treinta caracteres",
        "Pais con un nombre demasiado largo", 2010, "01/01/2015", "01/01/2000", 5, 150);
    echo $e . "<br>" . PHP_EOL;
    $e2 = new MuebleTradicional("estanteria", "", "", 2050, "31/02/2025", "31/12/2040", 10, 500, "");
    echo $e2 . "<br>" . PHP_EOL;

     /**
     * Constructor con nombre vacio (lanza excepcion, no se ejecuta)
     */
    echo "<p style='color: blue'>PRUEBA Constructor con nombre vacio<br><p>" . PHP_EOL;
    echo "new MuebleTradicional('   ') lanzaria una excepcion porque el nombre es obligatorio (se prueba con setNombre mas abajo)<br>" . PHP_EOL;

    /**
     * Metodos set de MuebleBase
     */
    echo "<p style='color: blue'>PRUEBA Metodos set de MuebleBase<br><p>" . PHP_EOL;
    $m = new MuebleTradicional("silla base");

    if ($m->setNombre("silla nordica")) {
        echo "setNombre('silla nordica') correcto. Nombre: " . $m->getNombre() . "<br>" . PHP_EOL;
    } else {
        echo "setNombre('silla nordica') incorrecto. Nombre: " . $m->getNombre() . "<br>" . PHP_EOL;
    }
    if ($m->setNombre("")) {
        echo "setNombre('') correcto. Nombre: " . $m->getNombre() . "<br>" . PHP_EOL;
    } else {
        echo "setNombre('') incorrecto, no se modifica. Nombre: " . $m->getNombre() . "<br>" . PHP_EOL;
    }

    if ($m->setFabricante("Ikea")) {
        echo "setFabricante('Ikea') correcto. Fabricante: " . $m->getFabricante() . "<br>" . PHP_EOL;
    } else {
        echo "setFabricante('Ikea') incorrecto. Fabricante: " . $m->getFabricante() . "<br>" . PHP_EOL;
    }
    if ($m->setFabricante("FaMu:Muebles")) {
        echo "setFabricante('FaMu:Muebles') correcto (no se duplica el prefijo). Fabricante: " . $m->getFabricante() . "<br>" . PHP_EOL;
    } else {
        echo "setFabricante('FaMu:Muebles') incorrecto. Fabricante: " . $m->getFabricante() . "<br>" . PHP_EOL;
    }

    if ($m->setPais("Italia")) {
        echo "setPais('Italia') correcto. Pais: " . $m->getPais() . "<br>" . PHP_EOL;
    } else {
        echo "setPais('Italia') incorrecto. Pais: " . $m->getPais() . "<br>" . PHP_EOL;
    }
    if ($m->setPais("Pais con un nombre demasiado largo")) {
        echo "setPais(largo) correcto. Pais: " . $m->getPais() . "<br>" . PHP_EOL;
    } else {
        echo "setPais(largo) incorrecto, no se modifica. Pais: " . $m->getPais() . "<br>" . PHP_EOL;
    }

    if ($m->setAnio(2023)) {
        echo "setAnio(2023) correcto. Anio: " . $m->getAnio() . "<br>" . PHP_EOL;
    } else {
        echo "setAnio(2023) incorrecto. Anio: " . $m->getAnio() . "<br>" . PHP_EOL;
    }
    if ($m->setAnio(2019)) {
        echo "setAnio(2019) correcto. Anio: " . $m->getAnio() . "<br>" . PHP_EOL;
    } else {
        echo "setAnio(2019) incorrecto, no se modifica. Anio: " . $m->getAnio() . "<br>" . PHP_EOL;
    }
    if ($m->setAnio(2090)) {
        echo "setAnio(2090) correcto. Anio: " . $m->getAnio() . "<br>" . PHP_EOL;
    } else {
        echo "setAnio(2090) incorrecto (posterior al año actual), no se modifica. Anio: " . $m->getAnio() . "<br>" . PHP_EOL;
    }

    if ($m->setFechaIniVenta("1/3/2023")) {
        echo "setFechaIniVenta('1/3/2023') correcto. Fecha: " . $m->getFechaIniVenta() . "<br>" . PHP_EOL;
    } else {
        echo "setFechaIniVenta('1/3/2023') incorrecto. Fecha: " . $m->getFechaIniVenta() . "<br>" . PHP_EOL;
    }
    if ($m->setFechaIniVenta("31/12/2022")) {
        echo "setFechaIniVenta('31/12/2022') correcto. Fecha: " . $m->getFechaIniVenta() . "<br>" . PHP_EOL;
    } else {
        echo "setFechaIniVenta('31/12/2022') incorrecto (anterior al 01/01/2023), no se modifica. Fecha: " . $m->getFechaIniVenta() . "<br>" . PHP_EOL;
    }

    if ($m->setFechaFinVenta("31/12/2030")) {
        echo "setFechaFinVenta('31/12/2030') correcto. Fecha: " . $m->getFechaFinVenta() . "<br>" . PHP_EOL;
    } else {
        echo "setFechaFinVenta('31/12/2030') incorrecto. Fecha: " . $m->getFechaFinVenta() . "<br>" . PHP_EOL;
    }
    if ($m->setFechaFinVenta("01/01/2023")) {
        echo "setFechaFinVenta('01/01/2023') correcto. Fecha: " . $m->getFechaFinVenta() . "<br>" . PHP_EOL;
    } else {
        echo "setFechaFinVenta('01/01/2023') incorrecto (anterior al inicio de venta), no se modifica. Fecha: " . $m->getFechaFinVenta() . "<br>" . PHP_EOL;
    }

    if ($m->setPrecio(99.99)) {
        echo "setPrecio(99.99) correcto. Precio: " . $m->getPrecio() . "<br>" . PHP_EOL;
    } else {
        echo "setPrecio(99.99) incorrecto. Precio: " . $m->getPrecio() . "<br>" . PHP_EOL;
    }
    if ($m->setPrecio(10)) {
        echo "setPrecio(10) correcto. Precio: " . $m->getPrecio() . "<br>" . PHP_EOL;
    } else {
        echo "setPrecio(10) incorrecto (minimo 30), no se modifica. Precio: " . $m->getPrecio() . "<br>" . PHP_EOL;
    }

    /**
     * Metodos set de MuebleReciclado
     */
    echo "<p style='color: blue'>PRUEBA Metodos set de MuebleReciclado<br><p>" . PHP_EOL;
    if ($r->setPorcentajeReciclado(100)) {
        echo "setPorcentajeReciclado(100) correcto. Porcentaje: " . $r->getPorcentajeReciclado() . "<br>" . PHP_EOL;
    } else {
        echo "setPorcentajeReciclado(100) incorrecto. Porcentaje: " . $r->getPorcentajeReciclado() . "<br>" . PHP_EOL;
    }
    if ($r->setPorcentajeReciclado(101)) {
        echo "setPorcentajeReciclado(101) correcto. Porcentaje: " . $r->getPorcentajeReciclado() . "<br>" . PHP_EOL;
    } else {
        echo "setPorcentajeReciclado(101) incorrecto, no se modifica. Porcentaje: " . $r->getPorcentajeReciclado() . "<br>" . PHP_EOL;
    }
    if ($r->setPorcentajeReciclado(-5)) {
        echo "setPorcentajeReciclado(-5) correcto. Porcentaje: " . $r->getPorcentajeReciclado() . "<br>" . PHP_EOL;
    } else {
        echo "setPorcentajeReciclado(-5) incorrecto, no se modifica. Porcentaje: " . $r->getPorcentajeReciclado() . "<br>" . PHP_EOL;
    }

    /**
     * Metodos set de MuebleTradicional
     */
    echo "<p style='color: blue'>PRUEBA Metodos set de MuebleTradicional<br><p>" . PHP_EOL;
    if ($t->setPeso(250.5)) {
        echo "setPeso(250.5) correcto. Peso: " . $t->getPeso() . "<br>" . PHP_EOL;
    } else {
        echo "setPeso(250.5) incorrecto. Peso: " . $t->getPeso() . "<br>" . PHP_EOL;
    }
    if ($t->setPeso(14)) {
        echo "setPeso(14) correcto. Peso: " . $t->getPeso() . "<br>" . PHP_EOL;
    } else {
        echo "setPeso(14) incorrecto (minimo 15), no se modifica. Peso: " . $t->getPeso() . "<br>" . PHP_EOL;
    }
    if ($t->setPeso(301)) {
        echo "setPeso(301) correcto. Peso: " . $t->getPeso() . "<br>" . PHP_EOL;
    } else {
        echo "setPeso(301) incorrecto (maximo 300), no se modifica. Peso: " . $t->getPeso() . "<br>" . PHP_EOL;
    }
    if ($t->setSerie("S15")) {
        echo "setSerie('S15') correcto. Serie: " . $t->getSerie() . "<br>" . PHP_EOL;
    } else {
        echo "setSerie('S15') incorrecto. Serie: " . $t->getSerie() . "<br>" . PHP_EOL;
    }
    if ($t->setSerie("")) {
        echo "setSerie('') correcto. Serie: " . $t->getSerie() . "<br>" . PHP_EOL;
    } else {
        echo "setSerie('') incorrecto, no se modifica. Serie: " . $t->getSerie() . "<br>" . PHP_EOL;
    }

    /**
     * damePropiedadesAdicionales
     */
    echo "<p style='color: blue'>PRUEBA damePropiedadesAdicionales<br><p>" . PHP_EOL;
    echo "MuebleReciclado:<br>" . PHP_EOL;
    foreach ($r->damePropiedadesAdicionales() as $propiedad) {
        echo "&nbsp;&nbsp;" . $propiedad . "<br>" . PHP_EOL;
    }
    echo "MuebleTradicional:<br>" . PHP_EOL;
    foreach ($t->damePropiedadesAdicionales() as $propiedad) {
        echo "&nbsp;&nbsp;" . $propiedad . "<br>" . PHP_EOL;
    }

    /**
     * Sobrecarga dinamica de propiedades (lanza Error, no se ejecuta)
     */
    echo "<p style='color: blue'>PRUEBA Propiedades dinamicas (no permitidas)<br><p>" . PHP_EOL;
    echo "\$r->colorFavorito = 'rojo' lanzaria un Error porque la clase no permite propiedades dinamicas<br>" . PHP_EOL;

    /**
     * Caracteristicas
     */
    echo "<p style='color: blue'>PRUEBA Caracteristicas de un mueble<br><p>" . PHP_EOL;
    $r->anadirCaracteristicas("saliente", true, "precio", 300, "sobrante");   // "sobrante" se desecha
    echo $r . "<br>" . PHP_EOL;

    echo "Recorrido de las caracteristicas (orden inverso):<br>" . PHP_EOL;
    foreach ($r->getCaracteristicas() as $clave => $valor) {
        echo "&nbsp;&nbsp;" . $clave . " => " . $valor . "<br>" . PHP_EOL;
    }

    echo "<p style='color: blue'>PRUEBA Caracteristicas con ULTIMA<br><p>" . PHP_EOL;
    $t->anadirCaracteristicas("color", "marron", "material", "roble", "ULTIMA", "si");
    echo "Cadena de caracteristicas: " . $t->getCaracteristicas() . "<br>" . PHP_EOL;
    echo "Añadir ahora una caracteristica nueva lanzaria un Error porque ya se indico ULTIMA<br>" . PHP_EOL;
    $t->anadirCaracteristicas("color", "negro");
    echo "Tras modificar 'color' (permitido): " . $t->getCaracteristicas() . "<br>" . PHP_EOL;

    /**
     * Control del maximo de muebles
     */
    echo "<p style='color: blue'>PRUEBA puedeCrear y maximo de muebles<br><p>" . PHP_EOL;
    $quedan = 0;
    if (MuebleBase::puedeCrear($quedan)) {
        echo "Se pueden crear mas muebles. Quedan: " . $quedan . "<br>" . PHP_EOL;
    } else {
        echo "No se pueden crear mas muebles. Quedan: " . $quedan . "<br>" . PHP_EOL;
    }

    echo "Creando muebles hasta llegar al maximo...<br>" . PHP_EOL;
    while (MuebleBase::puedeCrear($quedan)) {
        new MuebleTradicional("relleno");
    }
    if (MuebleBase::puedeCrear($quedan)) {
        echo "Se pueden crear mas muebles. Quedan: " . $quedan . "<br>" . PHP_EOL;
    } else {
        echo "No se pueden crear mas muebles. Quedan: " . $quedan . "<br>" . PHP_EOL;
    }
    echo "Un nuevo mueble lanzaria una excepcion porque se ha superado el maximo<br>" . PHP_EOL;

}