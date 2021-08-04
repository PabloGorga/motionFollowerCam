<?php
/*---------------------------------------------------------------------------
  |
  | Archivo de configuración para "follower.php"
  |
  -------------------------------------------------------------------------- */

// Archivos auxiliares
$arLock = "./noMov.txt";		// Evitar otros procesos de PHP hasta no termine el que está corriendo
$arLog = "/tmp/autoC1_logPhp.log";	// El archivo de log

/* Datos camamra
 ---------------------------------------------- */
$ipCamDest = "192.168.0.7";
$usuCam = "admin";
$passCam = "p";

/* Datos imagen
 ---------------------------------------------- */
$tamX = 320;
$tamY = 240;

$centroX = $tamX/2;
$centroY = $tamY/2;

/* Tolerancias en porcentaje en la 
 | cual no se moverá por estar cerca del centro
 ---------------------------------------------- */
$porcX = 20;
$porcY = 20;

$anchoMax=80;
$altoMax=150;

$doMovX = true;
$doMovY = true;

/* Control de la detección del movimiento
 | (dirección del "motion" que controla la imagen
 | de esta camara)
 ---------------------------------------------- */
$urlMotion="127.0.0.1:8090";


/* variables de movimiento
 ---------------------------------------------- */
// Derecha
$mover_der="http://".$usuCam.":".$passCam."@".$ipCamDest."/decoder_control.cgi?command=6";
// Izquierda
$mover_izq="http://".$usuCam.":".$passCam."@".$ipCamDest."/decoder_control.cgi?command=4";
// Arriba
$mover_arriba="http://".$usuCam.":".$passCam."@".$ipCamDest."/decoder_control.cgi?command=0";
// Abajo
$mover_abajo="http://".$usuCam.":".$passCam."@".$ipCamDest."/decoder_control.cgi?command=2";
$mover_detener="http://".$usuCam.":".$passCam."@".$ipCamDest."/decoder_control.cgi?command=1";
?>
