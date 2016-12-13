<?php
use App\Fitting;

$data = json_decode(file_get_contents('php://input'), true);

foreach ($data as $result) {
    $fitting = new Fitting;
    $fitting->Mac = $result["1"];
    $fitting->idUser = $result["2"];
    $fitting->type = 1;
    $fitting->timesFitting = $result["3"];
    $fitting->isSync = 0;
    try {
    $fitting->save();
    } catch (Exception $e) {
    	return $e;
    }
}
?>


