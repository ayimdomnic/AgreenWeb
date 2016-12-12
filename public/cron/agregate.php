<?php
$servername = "localhost";
$dbname = "agreenweb";
$username = "root";
$password = "x76gft96";
$port="3306";

//Instanciations
$pointLocation = new pointLocation();
$Agregate = new Agregate();

//Connection au VPS
$connection = $Agregate->connection($dbname, $servername, $dbuser, $dbpass);

//Récupération des events
$arrayEvents = array();
$arrayEvents = $Agregate->getEvents($connection);

//Récupération des parcelles
// $arrayParcelles = array();
// $arrayParcelles = $Agregate->getParcelles($connection);

//Récupération des points GPS des parcelles
// $arrayGPSParcelles = array();
// $arrayGPSParcelles = $Agregate->getGpsParcelles($connection);

//Récupération des points GPS des parcelles
// $arrayGPSParcellesSort = array();
// $arrayGPSParcellesSort = $Agregate->sortMultidimensionnal($arrayGPSParcelles, "idparcelle");

// foreach ($arrayEvents as $key=>$val) {
// 	//LatLng du point à tester
// 	$latLng = "".$val['lat']. ", ".$val['lon']."";
// 	//IdEvent for insert and update
// 	$event = $val;

try {
		// $req = $connection->prepare("SELECT idparcelle,(entreelat - ".$val['lat']. ") FROM parcelle ORDER BY (entreelat - ".$val['lat']. ")");
	$req = $connection->prepare("SELECT idparcelle,(entreelat - ".$val['lat']. ") FROM parcelle ORDER BY (entreelat - ".$val['lat']. ") ASC LIMIT 20");
	$req->execute();
	$arrayParcelles = $req->fetchAll();
	$req->closeCursor();
} catch (Exception $e) {
	echo $e;
}

$isPointInside = 0;
foreach ($arrayParcelles as $Parcelle) {
	try {
		$req = $connection->prepare("SELECT idparcelle, numero, latitude, longitude FROM parcelle_gps WHERE idparcelle = ".$Parcelle['idparcelle']. " ORDER BY numero ASC");
		$req->execute();
		$arrayPointsGPS = $req->fetchAll();
		$req->closeCursor();
	} catch (Exception $e) {
		echo $e;
	}
	
	$polygon = array();
	foreach ($arrayPointsGPS as $arraySS) {
		$latLngA = "" . $arraySS['latitude'] . ", ". $arraySS['longitude'] . "";
		$idparcelleEvent = $Parcelle['idparcelle'];
		array_push($polygon, $latLngA);
	}

	$isPointInside = $pointLocation->pointInPolygon($latLng, $polygon, $event, $connection, $Parcelle['idparcelle']);

	if ($isPointInside == 1) {
		$isInside = 1;
		$idparcelleEvent = $Parcelle['idparcelle'];
		$pointLocation->insertInPostGre($idparcelleEvent, $isInside, $event, $connection);
		break;
	}
	echo "1";
	echo "</br>";	
}
if ($isPointInside == 0) {
	$isInside = 0;
	$idparcelleEvent = 0;
	$pointLocation->insertInPostGre($idparcelleEvent, $isInside, $event, $connection);
	echo "0";
	echo "</br>";	
}
}

class Agregate {
	function Agregate() {
	}
	function connection($dbname, $servername, $dbuser, $dbpass){
		try {
			$connection = new PDO('mysql:host='.$servername.';dbname='.$dbname, $dbuser, $dbpass);
		} catch (Exception $e) {
			echo $e;
		}
		return $connection;
	}

	function getEvents($connection){
		$array = array();
		try {
			$req = $connection->prepare('SELECT * FROM event WHERE issync = 0 LIMIT 250');
			$req->execute();
			$array = $req->fetchAll();
			$req->closeCursor();
		} catch (Exception $e) {
			echo $e;
		}
		return $array;
	}

	function getParcelles($connection){
		$array = array();
		try {
			$req = $connection->prepare("SELECT idparcelle, libelle, description FROM parcelle order by idparcelle ASC");
			$req->execute();
			$array = $req->fetchAll();
			$req->closeCursor();
		} catch (Exception $e) {
			echo $e;
		}
		return $array;
	}

	function getGpsParcelles($connection){
		$array = array();
		try {
			$req = $connection->prepare("SELECT idparcelle, numero, latitude, longitude FROM parcelle_gps order by numero ASC");
			$req->execute();
			$array = $req->fetchAll();
			$req->closeCursor();
		} catch (Exception $e) {
			echo $e;
		}
		return $array;
	}

	function sortMultidimensionnal($items, $String){
		$templevel=0;
		$newkey=0;
		$grouparr[$templevel]="";
		foreach ($items as $key => $val) {
			if ($templevel==$val[$String]){
				$grouparr[$templevel][$newkey]=$val;
			} else {
				$grouparr[$val[$String]][$newkey]=$val;
			}
			$newkey++;
		}
		return $grouparr;
	}
}



?>
