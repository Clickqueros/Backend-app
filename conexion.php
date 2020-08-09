<?php 

// print_r($mysqli);// print_r($mysqli);// print_r($mysqli);

$mysqli = new mysqli("127.0.0.1","clickque_secure","Secure2020@","clickque_secure");
// print_r($mysqli);
if ($mysqli->connect_errno) {
	// "La conexión fallo";
	echo "Errno".$mysqli->connect_errno;
	//exit;
}
$resultado = $mysqli->query("SELECT document, names, email, mobile, policy FROM referencing");
// print_r($resultado);
$result = array();
while ($data = $resultado->fetch_assoc()) {
	array_push($result, array("document"=>$data["document"],"names"=>$data["names"],"email"=>$data["email"],"mobile"=>$data["mobile"],"policy"=>$data["policy"]));
}
print_r(json_encode($result));
// $response = new Object($resultado);
/*$response = $resultado->fetch_assoc();
print_r($response)*/
/*foreach ($resultado as $value) {
	print_r($value["names"]);
}
$sql = "SELECT document, names, email, mobile, policy FROM referencing";
if (!$resultado = $mysqli->$sql) {
	echo "Query: " . $sql . "\n";
    echo "Errno: " . $mysqli->errno . "\n";.
    //exit;
}
if ($resultado->num_rows === 0) {
	echo "Lo sentimos. No se pudo encontrar una coincidencia para el ID $aid. Inténtelo de nuevo.";
    //exit;
}
$refer = $resultado->fetch_assoc();
echo "A veces veo a " . $refer['names'] . " " . $refer['email'] . " en la TV.";
*/
?>