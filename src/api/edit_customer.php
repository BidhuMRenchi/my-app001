<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include("config.php");


//sql query

$data = json_decode(file_get_contents("php://input"));

$id = $data->customerId;
$name = $data->customerName;
$email = $data->email;
$address = $data->address;
$phoneNumber = $data->phoneNumber;
$gender = $data->gender;


$sql = "UPDATE customers SET 
customerName = \"$name\", 
email = \"$email\",
phoneNumber = \"$phoneNumber\",
gender = \"$gender\",
address = \"$address\"
WHERE customerId=$id";
// $sql = 'UPDATE customers SET customerName="$name",
//    email="$email", phoneNumber="$phoneNumber",
//    gender="$gender", 
//    address="$address",
//    WHERE customerId=$id ';

if($conn->query($sql)===TRUE){
    echo "Hello {$name}, your record is saved.";
}else{
    echo "Could not save your data";
}