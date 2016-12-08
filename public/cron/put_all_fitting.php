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
foreach ($data as $key => $value) {
    if (!is_array($value)) {
      http_response_code(500);
  } else {
   foreach ($value as $key => $val) {
      if ($key == "id") {
        $id = $val;
    }
    if ($key == "Mac") {
        $Mac = $val;
    }
    if ($key == "idUser") {
        $idUser = $val;
    }
    if ($key == "type") {
        $type = $val;
    }    
    if ($key == "Timestamp") {
        $times = $val;
    }
}
try
{
 echo $id;
 $req = $cnx->prepare("INSERT INTO fittings (id, Mac, idUser, type, TimesFitting)VALUES (:id, :Mac, :idUser, :type, :times)");
 $req->execute(array(
    "id" => $id,
    "Mac" => $Mac,
    "idUser" => $idUser, 
    "type" => $type,
    "times" => $times,
    ));

}
catch (PDOException $e)
{
    http_response_code(500);
    echo $e;
}
}
}
?>
