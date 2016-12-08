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

foreach ($arrayEvents as $key=>$val) {
	//LatLng du point à tester
	$latLng = "".$val['lat']. ", ".$val['lon']."";
	//IdEvent for insert and update
	$event = $val;

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


class pointLocation {
  var $pointOnVertex = true; // Check if the point sits exactly on one of the vertices?
  function pointLocation() {
  }
  function pointInPolygon($point, $polygon, $event, $connection, $idparcelleEvent, $pointOnVertex = true) {
  	$this->pointOnVertex = $pointOnVertex;
    // Transform string coordinates into arrays with x and y values
  	$point = $this->pointStringToCoordinates($point);
  	$vertices = array();
  	foreach ($polygon as $vertex) {
  		$vertices[] = $this->pointStringToCoordinates($vertex);
  	}
    // Check if the point sits exactly on a vertex
  	if ($this->pointOnVertex == true and $this->pointOnVertex($point, $vertices) == true) {
  		return "vertex";
  	}
    // Check if the point is inside the polygon or on the boundary
  	$intersections = 0;
  	$vertices_count = count($vertices);
  	for ($i=1; $i < $vertices_count; $i++) {
  		$vertex1 = $vertices[$i-1];
  		$vertex2 = $vertices[$i];
      if ($vertex1['y'] == $vertex2['y'] and $vertex1['y'] == $point['y'] and $point['x'] > min($vertex1['x'], $vertex2['x']) and $point['x'] < max($vertex1['x'], $vertex2['x'])) { // Check if point is on an horizontal polygon boundary
      	return "boundary";
      }
      if ($point['y'] > min($vertex1['y'], $vertex2['y']) and $point['y'] <= max($vertex1['y'], $vertex2['y']) and $point['x'] <= max($vertex1['x'], $vertex2['x']) and $vertex1['y'] != $vertex2['y']) {
      	$xinters = ($point['y'] - $vertex1['y']) * ($vertex2['x'] - $vertex1['x']) / ($vertex2['y'] - $vertex1['y']) + $vertex1['x'];
        if ($xinters == $point['x']) { // Check if point is on the polygon boundary (other than horizontal)
        	return "boundary";
        }
        if ($vertex1['x'] == $vertex2['x'] || $point['x'] <= $xinters) {
        	$intersections++;
        }
    }
}
    // If the number of edges we passed through is odd, then it's in the polygon.
if ($intersections % 2 != 0) {
	return 1;
} else {
	return 0;
}


}
function pointOnVertex($point, $vertices) {
	foreach($vertices as $vertex) {
		if ($point == $vertex) {
			return true;
		}
	}
}

function pointStringToCoordinates($pointString) {
	$coordinates = explode(" ", $pointString);
	return array("x" => $coordinates[0], "y" => $coordinates[1]);
}

function insertInPostGre($idparcelleEvent, $isInside, $event, $connection) {
	try {
		$req = $connection->prepare("INSERT INTO eventprocessed (id, idevent, idapp, iduser, accuracy, lon, lat, dategps, timedate, isinside, idparcelle, altitude) VALUES (:id, :idevent, :idapp, :iduser, :accuracy, :lon, :lat, :dategps, :timedate, :isinside, :idparcelle, :altitude)");
		$req->execute(array(
			"id" =>  $event['id'],
			"idevent" =>  $event['id'],
			"idapp" =>  $event['idApp'],
			"iduser" => $event['idUser'],
			"accuracy" =>  $event['name'],
			"lon" =>  $event['lon'],
			"lat" =>  $event['lat'],
			"dategps" =>  $event['dateGPS'],
			"timedate" => $event['timeDate'],
			"isinside" => $isInside,
			"idparcelle" => $idparcelleEvent,
			"altitude" => 100
			));
	} catch (Exception $e) {
		echo $e;
	}
	try {
		$req2 = $connection->prepare('UPDATE event SET issync = 1 WHERE id = :id');
		$req2->execute(array(
			'id' => $event['id']
			));
	} catch (Exception $e) {
		echo $e;
	}
	$req->closeCursor();
	$req2->closeCursor();
}
}
?>
