<?php
require "../vendor/autoload.php";
use \Firebase\JWT\JWT;
// required headers
header("Access-Control-Allow-Origin: https://localhost:3000");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once 'config.php';


// get posted data
$data = json_decode(file_get_contents("php://input"));

$password = $data->passwords;
$email = $data->email;

$sql = "SELECT * FROM users WHERE email='$email' && passwords=MD5('$password') ";

      $result = $conn->query($sql);
      $data_result = array();
      if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $id = $row['userId'];
            $userName  = $row['userName'];
            $email = $row['email'];

    
        $secret_key = "BIDHU_M_RENCHI";
        $issuer_claim = "BIDHU"; // this can be the servername
        $audience_claim = "THE_AUDIENCE";
        $issuedat_claim = time(); // issued at
        $notbefore_claim = $issuedat_claim + 10; //not before in seconds
        $expire_claim = $issuedat_claim + 5000; // expire time in seconds
        $token = array(
            "iss" => $issuer_claim,
            "aud" => $audience_claim,
            "iat" => $issuedat_claim,
            "nbf" => $notbefore_claim,
            "exp" => $expire_claim,
            "data" => array(
                "id" => $id,
                "name" => $userName,
                "email" => $email
        ));

      //   http_response_code(200);

        $jwt = JWT::encode($token, $secret_key,'HS256');
        echo json_encode(
            array(
                "message" => "Successful login.",
                "jwt" => $jwt,
                "email" => $email,
                "name" => $userName,
                "expireAt" => $expire_claim
            ));
    }
    else{
          http_response_code(401);
      echo json_encode(array("message" => "Login failed.", "password" => $password));
  }

?>





