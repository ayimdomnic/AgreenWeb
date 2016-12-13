<?php
use App\Event;

$data = json_decode(file_get_contents('php://input'), true);
$fileName = "9999111";

foreach ($data as $result) {

    $fix_date = $result["3"];
    $fix_time = $result["4"];

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
    
    $event = new Event;
    $event->idApp = $result["0"];
    $event->idUser = $result["7"];
    $event->name = $result["6"];
    $event->lon = $result["2"];
    $event->lat = $result["1"];
    $event->dateGps = $dateGPS;
    $event->isInside = 0;
    $event->idParcelle = 0;
    $event->altitude = 0;
    $event->isSync = 0;
    $event->save();

    try
    {
        $dateGPSSubstring = substr($dateGPS, 0, -9);
        $fileName = "9999" . $dateGPSSubstring ."";
        $txt = "9999;" .  $id .";RaspBerry" . $Lon .";" . $Lat .";" . $dateGPS .";0;0;0";
        $myfile = file_put_contents("".$fileName.".txt", $txt.PHP_EOL , FILE_APPEND);
    }
    catch (PDOException $e)
    {
        http_response_code(500);
        echo "Insert text file exception" . $e . "";
    }
}

?>
