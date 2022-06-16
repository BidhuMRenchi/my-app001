<?php
// required headers
// Allow from any origin
if (isset($_SERVER['HTTP_ORIGIN'])) {
    // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
    // you want to allow, and if so:
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400'); // cache for 1 day
}



// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {



    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        // may also be using PUT, PATCH, HEAD etc
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");



    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");



    exit(0);

    
}
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

        $sql = "SELECT wishLists.wishListId,wishLists.productId,
products.productName,
productImage.fileName,products.shortDescription FROM wishLists
INNER JOIN products ON wishLists.productid = products.productid
LEFT JOIN productImage ON productImage.productid = products.productid
WHERE wishLists.customerId = '$id'";
        // LEFT JOIN productImage on products.productId = productImage.productId 
        // UNION 
        // SELECT * from products
        // RIGHT JOIN productImage on products.productId = productImage.productId


        if ($result = $conn->query($sql)) {
            $data_result = array();

            if (mysqli_num_rows($result) > 0) {
                $i = 0;
                while ($row = $result->fetch_assoc()) {

                    $data_result[$i]['wid'] = $row['wishListId'];
                    $data_result[$i]['pid'] = $row['productId'];
                    $data_result[$i]['name'] = $row['productName'];
                    $data_result[$i]['shortDescription'] = $row['shortDescription'];
                    $data_result[$i]['image'] = $row['fileName'];
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
