<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "client_project");

if(isset($_POST['add_product'])) {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_qty = $_POST['product_qty'];
    $product_code = $_POST['product_code'];
    $category_id = $_POST['category_id'];
    $product_image = $_FILES['product_image']['name'];

    move_uploaded_file($_FILES['product_image']['tmp_name'], "uploads/".$product_image);

    $conn->query("INSERT INTO product (product_name, product_price, product_qty, product_image, product_code, category_id) VALUES ('$product_name', '$product_price', '$product_qty', '$product_image', '$product_code', '$category_id')");
    $product_id = $conn->insert_id;

    foreach ($_POST['var_id'] as $var_index => $var_id) {
        if (!empty($var_id)) {
            $sub_var_id = $_POST['sub_var_id'][$var_index];
            if (!empty($sub_var_id)) {
                $conn->query("INSERT INTO product_variation (product_id, var_id, sub_var_id) VALUES ('$product_id', '$var_id', '$sub_var_id')");
            }
        }
    }

    echo "Product added successfully!";
}
?>
