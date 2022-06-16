<?php
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


require "../vendor/autoload.php";
use \Firebase\JWT\JWT;

include_once 'config.php';


// get posted data
$data = json_decode(file_get_contents("php://input"));

$password = $data->passwords;
$email = $data->email;

$sql = "SELECT * FROM customers WHERE email='$email' && passwords='$password' ";

      $result = $conn->query($sql);
      $data_result = array();
      if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $id = $row['customerId'];
            $userName  = $row['customerName'];
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
                "id" => $id,
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



