<?php

//***********************FUNCIONES DE LA BD*************************************************************************
/**
 * funtion to connect to data base
 * 
 * @param string $cadena
 * @param strig $user
 * @param string $password
 * @return \PDO
 */
function connectionBBDD($cadena, $user = 'root', $password = '') {
    try {
        $bd = new PDO($cadena, $user, $password);
        return $bd;
    } catch (Exception $ex) {
        throw new Exception('La aplicación esta en labores de mantenimiento');
        exit();
    }
}



// Función para abrir la conexión a la base de datos

function abrirConexionBD() {
    try {
        $bd = connectionBBDD('mysql:dbname=videoclub;host=127.0.0.1', 'root', '');
        $bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $bd;
    } catch (PDOException $ex) {
        throw new Exception('Error al conectar a la base de datos: ' . $ex->getMessage());
        exit();
    }
}
// Función para cerrar la conexión a la base de datos
function cerrarConexionBD($bd) {
    $bd = null;
}


/**
 * funcion para hacer una consulta a la base de datos y devolver los valores de la consulta
 * 
 * @param PDO $bd
 * @param string $sql
 */
function statement($bd, $sql) {
    try {
        return $bd->query($sql);
    } catch (Exception $ex) {
        $errorCode = $ex->getCode();

        if ($errorCode == 23000) {//this error is to manage duplicate values as primary key
            displayError('Vaya, parece que ya hay un registro en la tabla con esa identificación');
            displayError('O si estas tratando de agragar una mascota cerciorate que el duenio esta registrado como cliente');
        }
        if ($errorCode == '21S01') {
            displayError('Alguno de tus datos excede el numero de caracteres, echa un vistazo a los valores permitidos');
        }
        if ($errorCode === 23503) {//this error is to manage foreign key violation
            displayError('Vaya, la mascota que estas intentando agregar no corredponde a ningún duenio registrado');
        }
    }
}

/**
 * funcion que devuelve un array con los valores de la consulta
 * 
 * @param type $array array of values
 * @return string keyWord to use in a statement as conditional
 */
function getKeyWord($array) {
    if (isset($array['mascotas'])) {
        return 'nombre';
    }
    if (isset($array['users'])) {
        return 'dni';
    }
}



//funtions about create element****************************************************************************************************************************************
/**
 * function to create input element snd set values given as parameters into it
 * 
 * @param string $name
 * @param string $value
 * @param boolean $disabled
 * @param boolean $hidden
 */
function createInput($name, $value, $type, $disabled = false, $hidden = false, $class = '', $placeholder = '', $maxlength) {
    $disabled = ($disabled) ? 'disabled' : '';
    $hidden = ($hidden) ? 'hidden' : '';
    if ($hidden === 'hidden') {
        ?>
        <input class='form__input <?= $class ?>' maxlength="<?= $maxlength ?>" required type='<?= $type ?>'  placeholder='<?= $placeholder ?>'  name="<?= $name ?>" value="<?= $value ?>" <?= $disabled ?> <?= $hidden ?>>
        <?php
    } else {
        ?>
        <td class="td">
            <input class='form__input' maxlength="<?= $maxlength ?>" required type='<?= $type ?>' <?= $class ?>'  placeholder='<?= $placeholder ?>'  name="<?= $name ?>" value="<?= $value ?>" <?= $disabled ?>>
        </td>
        <?php
    }
}



//funtions about errors
/**
 * funtion to show a error put in a p tag a explanation for the error given as parameter
 * 
 * @param string $content
 */
function displayError($content) {
    ?>
    <p class='error'><?= $content ?></p>
    <?php
}


 /////////***************************LOG************************ */

 function escribirLog($logMessage)
 {
     // Ruta del archivo de log
     $logFile = './logs/log.txt';
 
     try {
         // Formatea el mensaje con la fecha y hora actual
         $formattedMessage = date('Y-m-d H:i:s') . ' - ' . $logMessage . PHP_EOL;
 
         // Escribe el mensaje en el archivo
         file_put_contents($logFile, $formattedMessage, FILE_APPEND | LOCK_EX);
     } catch (Exception $e) {
         // Manejo de errores con excepciones
         error_log('Error al escribir en el archivo de log: ' . $e->getMessage(), 0);
     }
 }
 

function leerLog()
{
    // Ruta del archivo de log
    $logFile = 'logs/log.txt';

    // Intenta abrir el archivo en modo de lectura
    if ($fileHandle = fopen($logFile, 'r')) {
        // Lee todo el contenido del archivo
        $content = fread($fileHandle, filesize($logFile));

        // Cierra el archivo
        fclose($fileHandle);

        // Retorna el contenido leído
        return $content;
    } else {
        // Manejo de errores si no se puede abrir el archivo
        echo "Error al abrir el archivo de log.";
        return false;
    }
}
