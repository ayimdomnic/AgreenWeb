<?php
$servername = "agreenbeta.quoram.fr";
$dbname = "agreenweb";
$username = "app";
$password = "x76gft96";
$port="3306";


//Instanciations
$Agregate = new Agregate();

//Connection au VPS
$connexion = $Agregate->connection($dbname, $servername, $dbuser, $dbpass);

$LastItem = -1;
$LastDate = 0;
$CountOutOfArea = 0;
$String = "";
$ArrayOfInserts = [];

$req = $connexion->prepare("SELECT idUser, CAST(SUBSTR(dategps, 1, 19) as date) as jour FROM eventsprocessed where issession = 0 group by iduser,jour order by iduser,jour limit 1");
$req->execute();
$arrayLastDate = $req->fetchAll();

foreach ($arrayLastDate as $value) {

	$iduser = $value['idUser'];
	$jour = $value['jour'];

	//Récupération des events
	$arrayEvents = array();
	$arrayEvents = $Agregate->getEvents($connexion, $iduser, $jour);

	if($arrayEvents != null){
		foreach ($arrayEvents as $key=>$val) {
			if($LastItem == -1){
				echo "mdadada";
				$String = "INSERT INTO gpssessions (iduser, idparcelle, startdate, enddate) VALUES (".$val['iduser'] .",".$val['idparcelle'] .", '".$val['dategps'] ."', '";
				$LastItem = $val['idparcelle'];
				$LastDate = $val['dategps'];
			}elseif($LastItem == $val['idparcelle']){
				$CountOutOfArea ++;
				if($CountOutOfArea > 10){
					$LastDate = $val['dategps'];
					$LastItem = $val['idparcelle'];
					$CountOutOfArea = 0;
				}
				$LastDate = $val['dategps'];
			}else{
				$CountOutOfArea ++;
				if($CountOutOfArea > 10){
					$LastDate = $val['dategps'];
					$String = $String . $LastDate . "')";
					array_push($ArrayOfInserts, $String);
					$LastItem = $val['idparcelle'];
					$String = "INSERT INTO gpssessions (iduser, idparcelle, startdate, enddate) VALUES (".$val['iduser'] .", ".$val['idparcelle'] .", '".$val['dategps'] ."', '";
					$CountOutOfArea = 0;
				}
			}
		}
	}
}
$String = $String . $LastDate . "')";
array_push($ArrayOfInserts, $String);
if(isset($val)){
$LastDate = $val['dategps'];
$LastItem = $val['idparcelle'];
$String = "INSERT INTO gpssessions (iduser, idparcelle, startdate, enddate) VALUES (".$val['iduser'] .", ".$val['idparcelle'] .", '".$val['dategps'] ."', '";
}

foreach ($ArrayOfInserts as $key=>$val) {
	echo $val;
	echo "</br>";
	try {
		$req = $connexion->prepare($val);
		$req->execute();
	} catch (Exception $e) {
		echo $e;
	}
	$req->closeCursor();
}

foreach ($arrayEvents as $key=>$val) {
	try {
		$req2 = $connexion->prepare("UPDATE eventsprocessed SET issession = 1 WHERE id = ".$val['idevent'] ."");
		$req2->execute();
	} catch (Exception $e) {
		echo $e;
	}
	$req2->closeCursor();
}

class Agregate {
	function Agregate() {
	}

	function connection($dbname, $servername, $dbuser, $dbpass){
		try {
			$connexion = new PDO('mysql:host='.$servername.';dbname='.$dbname, $dbuser, $dbpass);
		} catch (Exception $e) {
			echo $e;
		}
		return $connexion;
	}

	function getEvents($connexion, $iduser, $jour){
		$array = array();
		try {
			$req = $connexion->prepare("SELECT * FROM eventsprocessed WHERE issession = 0  AND  iduser = '".$iduser."' AND CAST(SUBSTR(dategps, 1, 19) as date) = '".$jour."' AND '".$jour."' <> DATE(NOW()) ORDER BY dategps ASC LIMIT 2880");
			$req->execute();
			$array = $req->fetchAll();
		} catch (Exception $e) {
			echo $e;
		}
		$req->closeCursor();
		return $array;
	}

}

$req->closeCursor();
?>
