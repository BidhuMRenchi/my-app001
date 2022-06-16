<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include("config.php");
$data = json_decode(file_get_contents("php://input"));

$id = $data->customerId;

//sql query

$sql = "SELECT productCarts.productCartId,productCarts.quantity,productCarts.productId,
products.productName,products.price,
productImage.fileName,products.shortDescription FROM productCarts
INNER JOIN products ON productCarts.productid = products.productid
LEFT JOIN productImage ON productImage.productid = products.productid
WHERE productCarts.customerId = '$id'";
// LEFT JOIN productImage on products.productId = productImage.productId 
// UNION 
// SELECT * from products
// RIGHT JOIN productImage on products.productId = productImage.productId


if ($result = $conn->query($sql)) {
    $data_result = array();

    if (mysqli_num_rows($result) > 0) {
        $i = 0;
        while ($row = $result->fetch_assoc()) {

            $data_result[$i]['cid'] = $row['productCartId'];
            $data_result[$i]['pid'] = $row['productId'];
            $data_result[$i]['quantity'] = $row['quantity'];
            $data_result[$i]['name'] = $row['productName'];
            $data_result[$i]['shortDescription'] = $row['shortDescription'];
            $data_result[$i]['image'] = $row['fileName'];
            $data_result[$i]['price'] = $row['price'];
            $i++;
        }
        echo json_encode(array("data" => $data_result));
    } else {
        echo json_encode(array("response" => '300'));
    }
} else {
    echo json_encode(array("response_code" => '301'));
}
