<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "client_project");

$products = $conn->query("SELECT p.*, c.name as category_name FROM product p JOIN category c ON p.category_id = c.id");

while($product = $products->fetch_assoc()) {
    echo "<h2>".$product['product_name']."</h2>";
    echo "<p>Category: ".$product['category_name']."</p>";
    echo "<p>Price: ".$product['product_price']."</p>";
    echo "<p>Quantity: ".$product['product_qty']."</p>";
    echo "<p>Product Code: ".$product['product_code']."</p>";
    echo "<img src='uploads/".$product['product_image']."' alt='".$product['product_name']."' />";

    $variations = $conn->query("SELECT v.var_name, sv.sub_var_name, sv.sub_var_price FROM product_variation pv 
                                 JOIN variation v ON pv.var_id = v.id 
                                 JOIN sub_variation sv ON pv.sub_var_id = sv.id 
                                 WHERE pv.product_id = '".$product['id']."'");

    while($variation = $variations->fetch_assoc()) {
        echo "<h3>Variation: ".$variation['var_name']."</h3>";
        echo "<p>Sub-Variation: ".$variation['sub_var_name']." - $".$variation['sub_var_price']."</p>";
    }
}
?>
