 <?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include 'config.php';

$custId = $_GET['custId'];
$prodId= $_GET['prodId'];

$sql = "SELECT * FROM wishLists WHERE customerId='$custId' AND productId='$prodId'";
    $result = $conn->query($sql);
    if ($result!= 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            if ($row['customerId'] == $custId && $row['productId'] == $prodId) {
                $check = 'true';
                break;
            } else {
                $check = 'false';
            }
        }
    }
    if ($check == 'true') {
        echo json_encode(array("result"=> "exists"));
    } else {
        // Inserting data into the database products table
        $sql = "INSERT INTO wishLists (customerId,productId)
           VALUES ('$custId', '$prodId')";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
    echo json_encode(array("result"=> "success"));
    }
    ?>