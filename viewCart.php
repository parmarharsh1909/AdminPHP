<?php
include 'connection.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

$response = array();

$sqlMen = "
    SELECT 
        p.id,
        p.product_name,
        p.description,
        p.price,
        p.purity,
        p.image,    
        p.addtoCart,
        s.name AS subcategory_name,
        m.maincatname AS maincategory_name
    FROM tbl_products p
    JOIN tbl_subcategory s ON p.sub_catid = s.id
    JOIN tbl_maincategory m ON s.maincat_id = m.id
    WHERE m.maincatname = 'Men Jewellery'
    AND p.addtoCart > 0
";

$resultMen = mysqli_query($conn, $sqlMen);

$response['men'] = [];
if ($resultMen && mysqli_num_rows($resultMen) > 0) {
    while ($row = mysqli_fetch_assoc($resultMen)) {
        $response['men'][] = $row;
    }
}

$sqlWomen = "
    SELECT 
        p.id,
        p.product_name,
        p.description,
        p.price,
        p.purity,
        p.image,
        p.addtoCart,
        s.name AS subcategory_name,
        m.maincatname AS maincategory_name
    FROM tbl_products p
    JOIN tbl_subcategory s ON p.sub_catid = s.id
    JOIN tbl_maincategory m ON s.maincat_id = m.id
    WHERE m.maincatname = 'Women Jewellery'
    AND p.addtoCart > 0
";

$resultWomen = mysqli_query($conn, $sqlWomen);

$response['women'] = [];
if ($resultWomen && mysqli_num_rows($resultWomen) > 0) {
    while ($row = mysqli_fetch_assoc($resultWomen)) {
        $response['women'][] = $row;
    }
}

$response['status'] = (!empty($response['men']) || !empty($response['women'])) ? "true" : "false";

echo json_encode($response);
$conn->close();
?>
