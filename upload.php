<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token");
	header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
$target_path = "js/";
 
$target_path = $target_path . basename( $_FILES['file']['name']);
 
if(move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {
    // header('Content-type: application/json');
    $data = ['success' => true, 'message' => 'Upload and move success'];
    echo json_encode( $data );
} else{
    // header('Content-type: application/json');
    $data = ['success' => false, 'message' => 'There was an error uploading the file, please try again!'];
    echo json_encode( $data );
}
 
?>