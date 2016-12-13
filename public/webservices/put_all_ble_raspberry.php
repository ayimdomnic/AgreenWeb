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
$fileName = "9999222";

foreach ($data as $result) {
    $id = $result["0"];
    $name = $result["1"];
    $mac = $result["2"];
    $date_discovery = $result["3"];
   try
{
  $req = $cnx->prepare("INSERT INTO fittings (id, Mac, idUser, type, TimesFitting)VALUES (:id, :Mac, :idUser, :type, :times)");
  $req->execute(array(
    "id" => $id,
    "Mac" => $name,
    "idUser" => $mac, 
    "type" => "1",
    "times" => $date_discovery,
    ));

}
catch (PDOException $e)
{
    http_response_code(500);
    echo $e;
}
}
?>
