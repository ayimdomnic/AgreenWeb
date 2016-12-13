<?php
$servername = "localhost";
$dbname = "agreenweb";
$username = "root";
$password = "x76gft96";
$port="3306";

try{
    $cnx = new PDO('mysql:host='.$servername.';port='.$port.';dbname='.$dbname, $username, $password);
}
catch(PDOException $e)
{
    echo $e->getMessage();
}
$data = json_decode(file_get_contents('php://input'), true);
foreach ($data as $key => $value) {
    if (!is_array($value)) {
          http_response_code(500);
    } else {
        foreach ($value as $key => $val) {
         if ($key == "id") {
            $id = $val;
        }
        if ($key == "name") {
            $name = $val;
        }
        if ($key == "idUser") {
            $idUser = $val;
        }
        if ($key == "Lon") {
            $Lon = $val;
        }
        if ($key == "Lat") {
            $Lat = $val;
        }
        if ($key == "dateGPS") {
            $dateGPS = $val;
        }
        if ($key == "isInside") {
            $isInside = $val;
        }
        if ($key == "idParcelle") {
            $idParcelle = $val;
        }
        if ($key == "altitude") {
            $altitude = $val;
        }
    }
        try
        {
            echo "string";
            $req = $cnx->prepare("INSERT INTO events (idUser, idApp, name, lon, lat, dateGPS, isInside, idParcelle, altitude, isSync) VALUES (:idUser, :id, :name, :lon, :lat, :dateGPS, :isInsideParcelle, :idParcelle, :altitude, :isSync)");
            $req->execute(array(
                "idUser" => $idUser,
                "id" => $id,
                "name" => $name,
                "lon" => $Lon,
                "lat" => $Lat,
                "dateGPS" => $dateGPS,
                "isInsideParcelle" => $isInside,
                "idParcelle" => $idParcelle,
                "altitude" => $altitude,
                "isSync" => 0,
                ));
    $dateGPSSubstring = substr($dateGPS, 0, -9);
    $fileName = "" . $idUser . " " . $dateGPSSubstring ."";
    $txt = "" . $idUser . ";" .  $id .";" . $name .";" . $Lon .";" . $Lat .";" . $dateGPS .";" . $isInside .";" . $idParcelle .";". $altitude ."";
    $myfile = file_put_contents("".$fileName.".txt", $txt.PHP_EOL , FILE_APPEND);
        }
        catch (PDOException $e)
        {
            http_response_code(500);
            echo $e;
        }
}
}

?>
