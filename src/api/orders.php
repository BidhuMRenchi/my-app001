
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

// //sql query
// $sql = "SELECT orders.orderdate,orders.orderStatus,orders.orderId,orders.totalprice,
//                             orders.customerId,orderDetails.productId,orderDetails.price,orderDetails.quantity,orderDetails.orderId,products.productName,productImage.fileName
//                             FROM orders 
//                             INNER JOIN orderDetails on orders.orderId=orderDetails.orderId
//                             inner join products on products.productId=orderDetails.productId 
//                             inner join productImage on products.productId=productImage.productId
//                             where orders.customerId=$id
//                             order by orders.orderdate DESC";


$sql = "SELECT orders.orderId, customers.customerName, orders.orderdate,orders.totalprice,orders.orderStatus
                            FROM orders
                            INNER JOIN customers ON orders.customerId=customers.customerId
                            ORDER BY orders.orderId DESC;";


if ($result = $conn->query($sql)) {
    $data_result = array();

    if (mysqli_num_rows($result) > 0) {
        $i = 0;
        while ($row = $result->fetch_assoc()) {

            $data_result[$i]['date'] = $row['orderdate'];
            $data_result[$i]['status'] = $row['orderStatus'];
            $data_result[$i]['oid'] = $row['orderId'];
            $data_result[$i]['totalprice'] = $row['totalprice'];
            $data_result[$i]['name'] = $row['productName'];
            $data_result[$i]['image'] = $row['fileName'];
            $data_result[$i]['price'] = $row['price'];
            $data_result[$i]['quantity'] = $row['quantity'];
            $i++;
        }
        echo json_encode(array("data" => $data_result));
    } else {
        echo json_encode(array("response" => '300'));
    }
} else {
    echo json_encode(array("response_code" => '301'));
}
