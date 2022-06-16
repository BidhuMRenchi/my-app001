<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include("config.php");


//sql query

$data = json_decode(file_get_contents("php://input"));

$id = $data->customerId;

//sql query
$sql = "SELECT * FROM customers WHERE customerId = '$id'";

if ($result = $conn->query($sql)) {
    $data_result = array();

    if (mysqli_num_rows($result) > 0) {
        $i = 0;
        while ($row = $result->fetch_assoc()) {

            $data_result[$i]['pid'] = $row['customerId'];
            $data_result[$i]['name'] = $row['customerName'];
            $data_result[$i]['email'] = $row['email'];
            $data_result[$i]['image'] = $row['profilePicture'];
            $data_result[$i]['gender'] = $row['gender'];
            $data_result[$i]['phoneNumber'] = $row['phoneNumber'];
            $data_result[$i]['address'] = $row['address'];
            $i++;
        }
        echo json_encode(array("data" => $data_result));
    } else {
        echo json_encode(array("response" => '300'));
    }
} else {
    echo json_encode(array("response_code" => '301'));
}
