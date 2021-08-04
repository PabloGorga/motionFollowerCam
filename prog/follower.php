<?php
$mtx = $argv;
// Valores obtenidos desde los parametros recibidos
$verticeX=$mtx[1];
$verticeY=$mtx[2];

$ancho=$mtx[3];
$alto=$mtx[4];

$seguir = 1;
require('configF.php');

// Verificar si el arLock testigo existe
if (!file_exists ($arLock)){
	// si no existe, moverse y crearlo

	$file = fopen($arLock,"w");
	fwrite($file,"Hello World. Testing!");
	fclose($file);


	// Verificar que el ancho Y el alto máximos no sean sobrepasados
	if ($ancho > $anchoMax){
		doLog("No se mueve en X por area muy grande - ".$ancho." \r\n");
		$doMovX=false;
	}

	if ($alto > $altoMax){
		doLog("No se mueve en Y por area muy grande - ".$alto."\r\n");
		$doMovY=false;
	}

	if ($doMovY==true && $doMovY==true)
	{
		$puntoX=$verticeX+($ancho/2);
		$puntoY=$verticeY+($alto/2);

		$tiempoMovX=1;
		$tiempoMovY=1;

		obtD_AXY_tiempoMov($centroX,$puntoX,$distAX,$tiempoMovX);
		obtD_AXY_tiempoMov($centroY,$puntoY,$distAY,$tiempoMovY);

		if ($distAX < ($centroX*$porcX/100)){
			doLog("No se mueve en X por solo ".$distAX." pxs \r\n");
			$doMovX=false;
		}

		if ($distAY < ($centroY*$porcY/100)){
			doLog("No se mueve en Y por solo ".$distAY." pxs \r\n");
			$doMovY=false;
		}

		if ($seguir==1){
			detenerDetec();

			// Movimiento en X
			if ($doMovX){
				if ($puntoX < $centroX){
					moverIzquierda();
				}else{
					moverDerecha();
				}
				@sleep($tiempoMovX);
				detener();
			}

			// Movimiento en Y
			if ($doMovY){
				if ($puntoY < $centroY){
					moverArriba();
				}else{
					moverAbajo();
				}
				@sleep($tiempoMovY);
				detener();
			}
			iniciarDetec();
		}

		doLog("X: ".$puntoX." - Ancho: ".$ancho." DAX: ".$distAX." | Y: ".$puntoY. " - Alto: ".$alto." DAY: ".$distAY."\r\n");

		if ($seguir == 1)
		{	
			//@sleep(1); 
		} else { 
			@sleep(0.5); 
		}
		doLog("terminado \r\n \r\n \r\n");
	}
	unlink($arLock);
}
/*
	Obtiene la distancia hasta el punto X o Y y la cantidad de tiempo que se debe mover
	el eje en cuestión para llegar a el.		
*/
function obtD_AXY_tiempoMov($centro,$punto,&$distA,&$tiempoMov)
{
	$distA = $centro - $punto;
	if ($distA < 0)
		$distA=$distA*-1;
	doLog("Dist. a mover: ".$distA." \r\n");
	$tiempoMov = $distA/65; // El tiempo
	$tiempoMov = round($tiempoMov,1);

	doLog("Tiempo a mover: ".$tiempoMov." \r\n");
}


function moverDerecha()
{
	global $mover_der;
	doLog("mov - Derecha \r\n");
	$xml = file_get_contents($mover_der);
}

function moverIzquierda()
{	
	global $mover_izq;
	doLog("mov - Izquierda \r\n");
	$xml = file_get_contents($mover_izq);
}

function moverArriba()
{	
	global $mover_arriba;
	doLog("mov - Arriba \r\n");
	$xml = file_get_contents($mover_arriba);
}

function moverAbajo()
{	
	global $mover_abajo;
	doLog("mov - Abajo \r\n");
	$xml = file_get_contents($mover_abajo);
}

function detener()
{
	global $mover_detener;
	$xml = file_get_contents($mover_detener);
	doLog("Detener mov - ".$xml." \r\n");
}

function detenerDetec()
{
	global $urlMotion;
	$xml = file_get_contents("http://".$urlMotion."/0/detection/pause");
	doLog("Detener Detección \r\n");
}

function iniciarDetec()
{
	global $urlMotion;
	$xml = file_get_contents("http://".$urlMotion."/0/detection/start");
	doLog("Iniciar Detección \r\n");
}


function doLog($texto)
{
	global $arLog;
	$file = fopen($arLog,"a+");
	fwrite($file,$texto);
	fclose($file);
}

/*
NOTA, la cam en .0.8 esta invertida,por eso los valores de los movimientos estan todos justo a la inversa

http://".$usuCam.":".$passCam."@".$ipCamDest."/decoder_control.cgi?command=2			- Abajo
http://".$usuCam.":".$passCam."@".$ipCamDest."/decoder_control.cgi?command=0			- Arriba

http://".$usuCam.":".$passCam."@".$ipCamDest."/decoder_control.cgi?command=6			- Izq
http://".$usuCam.":".$passCam."@".$ipCamDest."/decoder_control.cgi?command=1			- Detener
http://".$usuCam.":".$passCam."@".$ipCamDest."/decoder_control.cgi?command=4			- Der
http://".$usuCam.":".$passCam."@".$ipCamDest."/decoder_control.cgi?command=31	- Regresar a 1
*/
?>
