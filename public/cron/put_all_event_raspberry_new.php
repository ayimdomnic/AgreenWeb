<?php
$servername = "agreenbeta.quoram.fr";
$dbname = "agreenweb";
$username = "app";
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
$fileName = "9999111";


foreach ($data as $result) {
    $id = $result["0"];
    $Lat = $result["1"];
    $Lon = $result["2"];
    $fix_date = $result["3"];
    $fix_time = $result["4"];
    $name = $result["6"];
    $iduser = $result["7"];
    $fix_date_day = substr($fix_date, -6, 2);
    $fix_date_month = substr($fix_date, -4, 2);
    $fix_date_year = substr($fix_date, -2, 2);
    $dateTimeGPS = "20" . $fix_date_year . "-" . $fix_date_month .  "-" . $fix_date_day;
    $fix_time_hours = substr($fix_time, -10, 2);
    $fix_time_minutes = substr($fix_time, -8, 2);
    $fix_time_seconds = substr($fix_time, -6, 2);
    $heureGps = "" . $fix_time_hours . ":" . $fix_time_minutes .  ":" . $fix_time_seconds;
    $dateGPS = $dateTimeGPS . " " . $heureGps;
    $txt = "" . $iduser . "-". $id . ";" . $name . "-" . $Lon .";" . $Lat .";" . $dateGPS .";0;0;0";
    $myfile = file_put_contents("".$fileName.".txt", $txt.PHP_EOL , FILE_APPEND);
try
{
    $req = $cnx->prepare("INSERT INTO events (idUser, idApp, name, lon, lat, dateGPS, isInside, idParcelle, altitude, isSync) VALUES (:idUser, :id, :name, :lon, :lat, :dateGPS, :isInsideParcelle, :idParcelle, :altitude, :isSync)");
    $req->execute(array(
        "idUser" => $iduser,
        "id" => $id,
        "name" => $name,
        "lon" => $Lon,
        "lat" => $Lat,
        "dateGPS" => $dateGPS,
        "isInsideParcelle" => 0,
        "idParcelle" => 0,
        "altitude" => 0,
        "isSync" => 0,
        ));
    $dateGPSSubstring = substr($dateGPS, 0, -9);
    $fileName = "9999" . $dateGPSSubstring ."";
    $txt = "9999;" .  $id .";RaspBerry" . $Lon .";" . $Lat .";" . $dateGPS .";0;0;0";
    $myfile = file_put_contents("".$fileName.".txt", $txt.PHP_EOL , FILE_APPEND);
}
catch (PDOException $e)
{
    http_response_code(500);
    echo $e;
}
}

?>
