<?php
function codigo($codigo){
	//para ponerlo en una lugar donde se puedan escribir archivos
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    //html PNG prefijo de localización
    $PNG_WEB_DIR = 'temp/';
    include "qrlib.php";    
    //a webo que necesitas tener derechos para escribir y crear
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
    //nombre del archivo
    $filename = $PNG_TEMP_DIR.'test.png';
	    $errorCorrectionLevel = 'H';
	//Maximo del tamaño en puntos
    $matrixPointSize = 4;
	//Codigo
    if (isset($codigo)) { 
        //esto es muy importante!
        if (trim($codigo) == '')
            die('<h1>Error</h1>');
        // codigo de los boletos...
        $filename = $PNG_WEB_DIR.'QRCode'.md5($codigo.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
        QRcode::png($codigo, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
	return $PNG_WEB_DIR.basename($filename);
	}
}
?>