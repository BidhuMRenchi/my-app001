<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// required to decode jwt
include_once 'config.php';
require '../vendor/autoload.php';

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;


$authHeader = $_SERVER['HTTP_AUTHORIZATION'];

$arr = explode(" ", $authHeader);

$jwt = $arr[1];


// get posted data
// $data = json_decode(file_get_contents("php://input"));

$secret_key = "BIDHU_M_RENCHI";

// get jwt
// $jwt=isset($data->jwt) ? $data->jwt : "";


// print_r(json_decode(base64_decode(str_replace('_', '/', str_replace('-','+',explode('.', $jwt)[1])))));



// exit();
// if jwt is not empty
if ($jwt) {

    // if decode succeed, show user details
    try {

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







        // decode jwt
        // $decoded = JWT::decode($jwt,$secret_key, array('HS256'));
        $decoded = JWT::decode($jwt, new Key($secret_key, 'HS256'));

        // print($decoded);
        // set response code
        http_response_code(200);

        // show user details
        echo json_encode(array(
            "message" => "Access granted.",
            "data" => $decoded->data
        ));
    }

    // if decode fails, it means jwt is invalid
    catch (Exception $e) {

        // set response code
        http_response_code(401);

        // tell the user access denied  & show error message
        echo json_encode(array(
            "message" => "Access denied.",
            "error" => $e->getMessage(),
            // "data" => printf($decoded)

        ));
    }
}

// show error message if jwt is empty
else {

    // set response code
    http_response_code(401);

    // tell the user access denied
    echo json_encode(array("message" => "Access denied."));
}
