<?php
include_once(dirname(__FILE__) . "../../../../cabecera.php");
// Ajusta la ruta a donde tengas el fichero con el array (o ponlo en cabecera.php)
include_once(dirname(__FILE__) . "../../../../scripts/librerias/validacion.php");

$barraUbi = [
    [
        "TEXTO" => "Inicio",
        "LINK" => "/index.php"
    ],
    [
        "TEXTO" => "Relacion 6",
        "LINK" => "index.php"
    ]
];
//controlador
$seleccionado = 1;
$accion = "";
$errores = [];

if (isset($_POST["mostrar"]) || isset($_POST["modificar"])) {
    $accion = isset($_POST["mostrar"]) ? "mostrar" : "modificar";

    $indice = false;
    if (isset($_POST["mueble"]) && is_string($_POST["mueble"])) {
        $indice = filter_var($_POST["mueble"], FILTER_VALIDATE_INT);
    }
    if ($indice === false || !array_key_exists($indice, $muebles)) {
        $errores[] = "Debe seleccionarse un mueble valido";
        $accion = "";
    } else {
        $seleccionado = $indice;
    }
}
//dibuja la plantilla de la vista
inicioCabecera("APLICACION PRIMER TRIMESTRE");
cabecera();
finCabecera();
inicioCuerpo("Relacion 6 - Primer Trimestre", $barraUbi);
cuerpo($muebles, $seleccionado, $accion, $errores);  //llamo a la vista
finCuerpo();
// **********************************************************

//vista
function cabecera() {}

//vista
function cuerpo(array $muebles, int $seleccionado, string $accion, array $errores)
{
    echo "<a href='../../../aplicacion/principal/pruebas.php'  style='color: Red; font-weight: bold;
    position: relative; left: 75%;'>Prueba de librerias</a>";
    echo "<br><br><br>";

    ?>    
        <table>
        <thead>
            <tr>
                <th>Indice</th>
                <th>Nombre</th>
                <th>Tipo mueble</th>
                <th>Fabricante</th>
                <th>Pais</th>
                <th>Año</th>
            </tr>
        </thead>
        <tbody>
        <?php
        foreach ($muebles as $indice => $mueble) {
            echo "<tr>" . PHP_EOL;
            echo "<td>" . $indice . "</td>" . PHP_EOL;
            echo "<td>" . $mueble->getNombre() . "</td>" . PHP_EOL;
            echo "<td>" . get_class($mueble) . "</td>" . PHP_EOL;
            echo "<td>" . $mueble->getFabricante() . "</td>" . PHP_EOL;
            echo "<td>" . $mueble->getPais() . "</td>" . PHP_EOL;
            echo "<td>" . $mueble->getAnio() . "</td>" . PHP_EOL;
            echo "</tr>" . PHP_EOL;
        }
        ?>
        </tbody>
    </table>


    <form method="post" action="">

    
    <label for="mueble">Mueble: </label>
    <select name="mueble" id="mueble">
        <?php
        foreach ($muebles as $indice => $mueble) {
            $marcado = ($indice === $seleccionado) ? "selected" : "";
            echo "<option value='" . $indice . "' " . $marcado . ">"
                . $indice . " - " . $mueble->getNombre() . " (" . get_class($mueble) . ", " . $mueble->getAnio() . ")"
                . "</option>" . PHP_EOL;
        }
        ?> 
    </select>
    
    <input type="submit" name="mostrar" value="Mostrar mueble">
    <input type="submit" name="modificar" value="Modificar mueble">
   
    </form>

    <?php

    if($accion=="mostrar"){
        echo "<h3> Mueble seleccionado: </h3>" . PHP_EOL;
        echo $muebles[$seleccionado] . "<br>" . PHP_EOL;
    }
}