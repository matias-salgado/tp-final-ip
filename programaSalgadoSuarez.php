<?php
include_once("memoria.php");

/**************************************/
/***** DATOS DE LOS INTEGRANTES *******/
/**************************************/

/*
    Salgado, Matias Ezequiel
    FAI-2530
    Tecnicatura Universitaria en Desarrollo Web
    https://github.com/matias-salgado

    Suárez, Brahian
    FAI-6121
    Tecnicatura Universitaria en Desarrollo Web
    https://github.com/suarez-brahian
*/

/**************************************/
/***** DEFINICION DE FUNCIONES ********/
/**************************************/

/**
 * Función encargada de cargar los datos iniciales del juego.
 * Declara una secuencia de juegos predefinidos dentro de un arreglo
 * indexado y los retorna.
 * @param array &$juegos La colección de juegos pasado como referencia
 * @return array El arreglo indexado que contiene los juegos precargados
 */
function cargarJuegos(&$juegos) {
    // array $juegos
    $juegos = [];

    $juegos[0] = ["jugador1" => "Matias", "aciertos1" => 2, "jugador2" => "Brahian", "aciertos2" => 2];
    $juegos[1] = ["jugador1" => "Samira", "aciertos1" => 3, "jugador2" => "Julian", "aciertos2" => 1];
    $juegos[2] = ["jugador1" => "Matias", "aciertos1" => 3, "jugador2" => "Samira", "aciertos2" => 1];
    $juegos[3] = ["jugador1" => "Brahian", "aciertos1" => 2, "jugador2" => "Julian", "aciertos2" => 2];
    $juegos[4] = ["jugador1" => "Samira", "aciertos1" => 2, "jugador2" => "Matias", "aciertos2" => 2];
    $juegos[5] = ["jugador1" => "Julian", "aciertos1" => 3, "jugador2" => "Brahian", "aciertos2" => 1];
    $juegos[6] = ["jugador1" => "Matias", "aciertos1" => 1, "jugador2" => "Julian", "aciertos2" => 3];
    $juegos[7] = ["jugador1" => "Brahian", "aciertos1" => 3, "jugador2" => "Samira", "aciertos2" => 1];
    $juegos[8] = ["jugador1" => "Julian", "aciertos1" => 2, "jugador2" => "Samira", "aciertos2" => 2];
    $juegos[9] = ["jugador1" => "Samira", "aciertos1" => 1, "jugador2" => "Brahian", "aciertos2" => 3];
}

/**
 * Solicita al usuario que ingrese un número entero dentro
 * de un rango de números pasados por parámetro
 * @param integer $min El número más chico que puede seleccionar
 * @param integer $max El número más alto que puede seleccionar
 * @return integer El valor numérico seleccionado entre el rango de números
 */
function pedirNumero($min, $max) {
    // integer $respuesta
    echo "Ingrese un número entre " . $min . " y " . $max . ": ";
    $respuesta = (integer)trim(fgets(STDIN));

    while ($respuesta < $min || $respuesta > $max) {
        echo "\033[31mValor no válido, ingrese un número entre " . $min . " y " . $max . "\033[0m: ";
        $respuesta = (integer)trim(fgets(STDIN));
    }

    return $respuesta;
}

/**
 * Función muestra las distintas opciones del programa
 * y solicita al usuario que ingrese una de las opciones.
 * El valor de la opción seleccionada (un número) es retornado.
 * @return integer El número de opción seleccionado
 */
function seleccionarOpcion() {
    // integer $PRIMERA_OPCION, $ULTIMA_OPCION, $respuesta
    $PRIMER_OPCION = 1;
    $ULTIMA_OPCION = 7;

    echo "\nA continuación las opciones del programa: \n\n";
    echo "Opción 1: Jugar a memoria\n";
    echo "Opción 2: Mostrar un juego\n";
    echo "Opción 3: Mostrar el primer juego ganado\n";
    echo "Opción 4: Mostrar porcentaje de juegos ganados\n";
    echo "Opción 5: Mostrar resumen de jugador\n";
    echo "Opción 6: Mostrar listado de juegos ordenado por jugador 2\n";
    echo "Opción 7: Salir\n\n";

    echo "Selección de opción\n";
    $respuesta = pedirNumero($PRIMER_OPCION, $ULTIMA_OPCION);

    return $respuesta;
}

/**
 * Función auxiliar que muestra el resultado de un juego dado
 * @param array $juego El juego del cual hay que calcular el resultado
 * @return string  El texto que muestra el resultado del juego
 */
function resultadoJuego($juego) {
    // string $resultado
    $resultado = "";

    if ($juego["aciertos1"] == $juego["aciertos2"]) {
        $resultado = "empate";
    } else if ($juego["aciertos1"] > $juego["aciertos2"]) {
        $resultado = "ganó jugador 1";
    } else {
        $resultado = "ganó jugador 2";
    }

    return $resultado;
}

/**
 * Función encargada de mostrar los resultados de un
 * juego dado según el número de juego (el índice)
 * y haciendo el recupero de datos de la colección de juegos.
 * @param array $juegos La colección de juegos de la cual se recupera un juego
 * @param integer $nroJuego El índice del juego al que hay que mostrar los datos
 * @return void
 */
function mostrarResultado($juegos, $nroJuego) {
    // array $juego
    $juego = $juegos[$nroJuego];

    echo "\n**************************************\n";
    echo "Juego MEMORIA: " . $nroJuego . " (". resultadoJuego($juego) . ")\n";
    echo "Jugador 1: " . $juego["jugador1"] . " obtuvo " . $juego["aciertos1"] . " aciertos\n";
    echo "Jugador 2: " . $juego["jugador2"] . " obtuvo " . $juego["aciertos2"] . " aciertos\n";
    echo "**************************************\n\n";
}

/**
 * Función se encarga de agregar un juego a la coleeción de juegos.
 * Retorna la colección con el juego nuevo agregado.
 * @param array $juegos La colección de juegos a la que se agregará el juego
 * @param array $juego El juego a ser agregado
 * @return array La nueva colección de juegos con el juego agregado
 */
function agregarJuego($juegos, $juego) {
    // integer $indiceDestino
    $indiceDestino = count($juegos);
    $juegos[$indiceDestino] = $juego;

    return $juegos;
}

/**
 * Función auxiliar optiene el jugador opuesto
 * a uno pasado por parámetro
 * @param integer $nroJugador El número del jugador al cuál obtener el opuesto
 */
function obtenerJugadorOpuesto($nroJugador) {
    return $nroJugador == 1 ? 2 : 1;
}

/**
 * Función se encarga de encontrar el índice del primer
 * juego ganado por un jugador pasado por parámetro
 * @param array $juegos La colección de juegos de donde se hará la búsqueda
 * @param string $jugador El nombre del jugador el cuál se buscará
 * @return integer El índice del juego encontrado o -1 si no fue encontrado
 */
function buscarPrimerGanado($juegos, $jugador) {
    // integer $indiceEncontrado, $cantJuegos, $i, $nroJugador, $jugadorOpuesto
    // boolean $encontrado
    // array $juego
    $indiceEncontrado = -1;
    $encontrado = false;
    $cantJuegos = count($juegos);
    $i = 0;

    while (!$encontrado && $i < $cantJuegos) {
        $juego = $juegos[$i];

        if ($juego["jugador1"] == $jugador || $juego["jugador2"] == $jugador) {
            $nroJugador = $juego["jugador1"] == $jugador ? 1 : 2;
            $jugadorOpuesto = obtenerJugadorOpuesto($nroJugador);

            if ($juego["aciertos" . $nroJugador] > $juego["aciertos" . $jugadorOpuesto]) {
                $encontrado = true;
                $indiceEncontrado = $i;
            }
        }

        $i++;
    }

    return $indiceEncontrado;
}

/**
 * Función calcula la cantidad de juegos que se
 * hayan ganado, independiente del jugador que haya ganado;
 * no se suman los empates.
 * @param array $juegos La colección de juegos de donde se calculará el dato
 * @return integer El total de juegos ganados por ambos jugadores
 */
function contarGanados($juegos) {
    // integer $cantJuegos, $cantGanadosTotal, $i
    // array $juego
    $cantJuegos = count($juegos);
    $cantGanadosTotal = 0;

    for ($i = 0; $i < $cantJuegos; $i++) {
        $juego = $juegos[$i];

        if ($juego["aciertos1"] > $juego["aciertos2"] || $juego["aciertos1"] < $juego["aciertos2"]) {
            $cantGanadosTotal++;
        }
    }

    return $cantGanadosTotal;
}

/**
 * Función obtiene la cantidad de juegos que un
 * número de jugador ha ganado en todos los juegos
 * @param array $juegos La colección de juegos de la que se hará el cálculo
 * @param integer $nroJugador El número de jugador al que se contaran las victorias
 */
function contarGanadosJugador($juegos, $nroJugador) {
    // integer $cantJuegos, $cantGanados, $jugadorOpuesto, $i
    // array $juego
    $cantJuegos = count($juegos);
    $cantGanados = 0;
    $jugadorOpuesto = obtenerJugadorOpuesto($nroJugador);

    for ($i = 0; $i < $cantJuegos; $i++) {
        $juego = $juegos[$i];

        if ($juego["aciertos" . $nroJugador] > $juego["aciertos" . $jugadorOpuesto]) {
            $cantGanados++;
        }
    }

    return $cantGanados;
}

/**
 * Función calcula el porcentaje de juegos ganados
 * por uno de los jugadoros (número) pasado por parámetro
 * @param array $juegos La colección de juegos del cual se calculará el porcentaje
 * @param integer $nroJugador El número de jugador (1 o 2) correspondiente a realizar el cálculo
 * @return float El porcentaje de juegos ganados por el jugador
 */
function porcentajeGanados($juegos, $nroJugador) {
    // integer $cantGanadosTotal, $cantGanadosJugador
    $cantGanadosTotal = contarGanados($juegos);
    $cantGanadosJugador = contarGanadosJugador($juegos, $nroJugador);

    return ($cantGanadosJugador / $cantGanadosTotal) * 100;
}

/**
 * Función encargada de mostrar un resumen de un jugador
 * que se pasa por parámetro. Se muestra la cantidad de juegos
 * ganados, perdidos, empatados y cantidad de aciertos en todos
 * los juegos jugados
 * @param array $juegos La colección de juegos de donde se hará el resumen
 * @param string $jugador El jugador al cuál se le hará el resumen
 * @return void
 */
function resumenJugador($juegos, $jugador) {
    // integer $cantJuegos, $i, $nroJugador, $jugadorOpuesto
    // boolean $jugadorEncontrado
    // array $resumenJugador, $juego
    $jugadorEncontrado = false;
    $cantJuegos = count($juegos);
    $resumenJugador = [
        "jugador" => $jugador,
        "ganados" => 0,
        "perdidos" => 0,
        "empatados" => 0,
        "aciertos" => 0,
    ];

    for ($i = 0; $i < $cantJuegos; $i++) {
        $juego = $juegos[$i];
        if ($juego["jugador1"] == $resumenJugador["jugador"] || $juego["jugador2"] == $resumenJugador["jugador"]) {
            $jugadorEncontrado = true;
            $nroJugador = $juego["jugador1"] == $resumenJugador["jugador"] ? 1 : 2;
            $jugadorOpuesto = obtenerJugadorOpuesto($nroJugador);

            if ($juego["aciertos" . $nroJugador] > $juego["aciertos" . $jugadorOpuesto]) {
                $resumenJugador["ganados"]++;
            }

            if ($juego["aciertos" . $nroJugador] < $juego["aciertos" . $jugadorOpuesto]) {
                $resumenJugador["perdidos"]++;
            }

            if ($juego["aciertos1"] == $juego["aciertos2"]) {
                $resumenJugador["empatados"]++;
            }

            $resumenJugador["aciertos"] += $juego["aciertos" . $nroJugador];
        }
    }

    if(!$jugadorEncontrado) {
        echo "\n\033[31mEl jugador " . $jugador . " no ha participado\033[0m\n";
        return;
    }

    echo "\n**************************************\n";
    echo "Jugador: " . $resumenJugador["jugador"] . "\n";
    echo "Ganó: " . $resumenJugador["ganados"] . " juegos\n";
    echo "Perdió: " . $resumenJugador["perdidos"] . " juegos\n";
    echo "Empató: " .  $resumenJugador["empatados"] . " juegos\n";
    echo "Total de aciertos acumulados: " .  $resumenJugador["aciertos"] . " aciertos\n";
    echo "**************************************\n";
}

/**
 * Función pensada para ser usada con uasort la cuál
 * compara lexicográficamente los nombres del jugador 2
 * de dos juegos
 * @param array $juegoA El juego A a comparar
 * @param array $juegoB El juego B a comparar
 * @return integer El resultado lexicográfico de la comparación de nombres del jugador 2
 */
function compararJugadores2($juegoA, $juegoB) {
    $resultado = 0;

    // Verificamos si hay igualdad entre los nombres
    if ($juegoA["jugador2"] == $juegoB["jugador2"]) {
        $resultado = 0;
    } 
    // Verificamos si el segundo nombre es menor lexicográficamente al primero
    else if ($juegoA["jugador2"] < $juegoB["jugador2"]) {
        $resultado = -1;
    } 
    // Sino es igual o menor entonces el primer nombre es lexicográficamente mayor
    else {
        $resultado = 1;
    }
    
    return $resultado;

    /*
        También se podría haber resuelto con strcmp() que realiza una
        comparación binaria segura de cadenas de texto.
        La comparación se realiza haciendo diferenciación entre mayúsculas y minúsculas.
        El primer parámetro en recibir es un string "string1" y un segundo y último string "string2".
        Retorna un valor menor a 0 si string1 es menor que string2; un valor
        mayor a 0 si string1 es mayor a string2 y 0 si son iguales.
        https://www.php.net/manual/en/function.strcmp.php
    */
    // return strcmp($juegoA["jugador2"], $juegoB["jugador2"]);
}

/**
 * Función muestra la colección de juegos con un ordenamiento
 * lexicográfico por el valor de jugador 2 en cada juego
 * @param array $juegos La colección de juegos a ordenar
 * @return void
 */
function ordenarJuegosPorJugador2($juegos) {
    /*
        uasort() ordena un arreglo con una función definida por el usuario y preserva
        la correlación de índices con los elementos con que está asociado.
        El primer parámetro en recibir es la referencia de un arreglo
        y un segundo y último es la función que se usará para comparar.
        El arreglo original es modificado directamente.
        https://www.php.net/manual/en/function.uasort.php
    */
    uasort($juegos, "compararJugadores2");

    echo "\n";

    /*
        print_r() muestra en pantalla información humana sobre una variable.
        Recibe por parámetro una expresión que será la que se muestre en pantalla.
        Para objetos y arreglos (como es el uso en este caso), los valores son
        presentados en un formato que muestra las claves/índices y los elementos.
        https://www.php.net/manual/en/function.print-r.php
    */
    print_r($juegos);
}

/**
 * Función auxiliar se encarga de obtener los nombres
 * (no repetidos) de jugadores en la colección de juegos
 * @param array $juegos La colección de juegos en la que se hará la búsqueda
 * @return array Un arreglo de nombres de jugadores no repetidos
 */
function obtenerJugadoresCargados($juegos) {
    // boolean $cargado
    // integer $i
    // array $jugadores
    $cargado = false;
    $i = 0;
    $jugadores = [];

    foreach ($juegos as $juego) {
        while (!$cargado && $i < count($jugadores)) {
            if ($juego["jugador1"] == $jugadores[$i]) {
                $cargado = true;
            }
            $i++;
        }

        if (!$cargado) {
            $jugadores[$i] = $juego["jugador1"];
        }

        $i = 0;
        $cargado = false;

        while (!$cargado && $i < count($jugadores)) {
            if ($juego["jugador2"] == $jugadores[$i]) {
                $cargado = true;
            }
            $i++;
        }

        if (!$cargado) {
            $jugadores[$i] = $juego["jugador2"];
        }

        $i = 0;
        $cargado = false;
    }

    return $jugadores;
}

/**
 * Función auxiliar se encarga de mostrar un arreglo
 * de nombres de jugadores como una lista de nombres
 * separados por coma
 * @param array $juegos La colección de juegos que contiene nombres de jugadores
 * @return string Los nombres de jugadores concatenados en una lista
 */
function listarJugadoresCargados($juegos) {
    // string $lista
    // array $jugadores
    // integer $ultimoJugador
    $lista = "";
    $jugadores = obtenerJugadoresCargados($juegos);
    $ultimoJugador = count($jugadores) - 1;

    foreach ($jugadores as $indice => $jugador) {

        if ($indice == $ultimoJugador) {
            $lista = $lista . $jugador;
        } else {
            $lista = $lista . $jugador . ", ";
        }
    }

    return $lista;
}

/**************************************/
/*********** PROGRAMA PRINCIPAL *******/
/**************************************/

// Declaración de variables:
// array $juegos, $juego
// integer $opcion, $cantJuegos, $nroJuego, $indiceEncontrado
// string $jugador
// float $porcentaje

$juegos = []; // El arreglo donde se cargará la colección de juegos

// Inicialización de variables:

cargarJuegos($juegos); // Iniciamos el programa con juegos precargados

do {

    $opcion = seleccionarOpcion();
    $juego = [];
    $cantJuegos = count($juegos);
    
    switch ($opcion) {
        case 1:
            $juego = jugarMemoria();

            $juegos = agregarJuego($juegos, $juego);

            break;

        case 2:
            echo "\nSe han jugado " . $cantJuegos . " juegos\n";
            $nroJuego = pedirNumero(0, $cantJuegos - 1);

            mostrarResultado($juegos, $nroJuego);

            break;

        case 3:
            echo "\n\033[33mJugadores cargados: " . listarJugadoresCargados($juegos) . "\033[0m\n";
            echo "Ingrese el nombre del jugador a buscar: ";
            /*
                strtolower() convierte los caracteres de una cadena de texto en minúscula.
                https://www.php.net/manual/en/function.strtolower.php

                ucfirst() convierte el primer caracter de una cadena de texto en mayúscula.
                https://www.php.net/manual/en/function.ucfirst.php
            */
            $jugador = ucfirst(strtolower(trim(fgets(STDIN))));

            $indiceEncontrado = buscarPrimerGanado($juegos, $jugador);

            if ($indiceEncontrado > -1) {
                mostrarResultado($juegos, $indiceEncontrado);
            } else {
                echo "\nEl jugador " . $jugador . " no ganó ningún juego\n\n";
            } 
            break;
        
        case 4:
            echo "\nSelección de jugador\n";
            $nroJugador = pedirNumero(1, 2);

            $porcentaje = porcentajeGanados($juegos, $nroJugador);

            echo "El Jugador " . $nroJugador . " ganó el " . $porcentaje . " de los juegos ganados\n\n";

            break;
        
        case 5:
            echo "\n\033[33mJugadores cargados: " . listarJugadoresCargados($juegos) . "\033[0m\n";
            echo "Ingrese el nombre del jugador a buscar: ";
            /*
                strtolower() convierte los caracteres de una cadena de texto en minúscula.
                https://www.php.net/manual/en/function.strtolower.php

                ucfirst() convierte el primer caracter de una cadena de texto en mayúscula.
                https://www.php.net/manual/en/function.ucfirst.php
            */
            $jugador = ucfirst(strtolower(trim(fgets(STDIN))));

            resumenJugador($juegos, $jugador);

            break;

        case 6:
            ordenarJuegosPorJugador2($juegos);

            break;
        
        case 7:
            echo "\n\033[34m+------------------------------------+\n";
            echo "|                                    |\n";
            echo "|         ¡Gracias por jugar!        |\n";
            echo "|                                    |\n";
            echo "+------------------------------------+\033[0m\n\n";

            break;
    }
} while ($opcion != 7);
