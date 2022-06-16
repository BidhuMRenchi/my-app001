<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include 'config.php';

$data = json_decode(file_get_contents("php://input"));
$customerId = $data->customerId;
$oldPassword = $data->oldPassword;
$newPassword = $data->newPassword;
$query = "SELECT passwords FROM customers WHERE customerId=$customerId";
$result = $conn->query($query);
$row = $result->fetch_assoc();
$current = $row['passwords'];
if ($current !== $oldPassword) {
    echo json_encode(array("message" => "Your current password is incorrect", "response_code" => '300'));
} else if ($current === $newPassword) {
    echo json_encode(array("message" => "New password cannot be current password", "response_code" => '300'));
} else {
    $sql = "UPDATE customers SET
    passwords = \"$newPassword\"
    WHERE customerId=$customerId AND passwords=\"$oldPassword\"";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "Password updated.", "response_code" => '200'));
    } else {
        // display message: user was created
        echo json_encode(array("message" => "Password not updated.", "response_code" => '300'));
    }
}
