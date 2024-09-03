<?php
// process.php
include 'db.php';

// Handle Add Category
if(isset($_POST['add_category'])){
    $name = $_POST['name'];
    $img = $_FILES['img']['name'];
    $c_banner = $_FILES['c_banner']['name'];
    $c_desc = $_POST['c_desc'];

    // Handle image uploads
    move_uploaded_file($_FILES['img']['tmp_name'], "uploads/" . $img);
    move_uploaded_file($_FILES['c_banner']['tmp_name'], "uploads/" . $c_banner);

    $stmt = $conn->prepare("INSERT INTO category (name, img, c_banner, c_desc) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $img, $c_banner, $c_desc);
    $stmt->execute();
    $stmt->close();
    header("Location: index.php?category=success");
}

// Handle Add Variation
if(isset($_POST['add_variation'])){
    $var_name = $_POST['var_name'];
    $stmt = $conn->prepare("INSERT INTO variation (var_name) VALUES (?)");
    $stmt->bind_param("s", $var_name);
    $stmt->execute();
    $var_id = $stmt->insert_id;
    $stmt->close();

    // Handle Sub Variations
    if(isset($_POST['sub_var_name']) && is_array($_POST['sub_var_name'])){
        $sub_var_names = $_POST['sub_var_name'];
        $sub_var_prices = $_POST['sub_var_price'];
        foreach($sub_var_names as $key => $sub_var_name){
            $sub_var_price = $sub_var_prices[$key];
            $stmt = $conn->prepare("INSERT INTO sub_variation (sub_var_name, sub_var_price, var_sub_id) VALUES (?, ?, ?)");
            $stmt->bind_param("sdi", $sub_var_name, $sub_var_price, $var_id);
            $stmt->execute();
            $stmt->close();
        }
    }
    header("Location: index.php?variation=success");
}

// Handle Add Product
if(isset($_POST['add_product'])){
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_qty = $_POST['product_qty'];
    $product_code = $_POST['product_code'];
    $category_id = $_POST['category_id'];
    $var_id = $_POST['var_id'];
    $product_image = $_FILES['product_image']['name'];

    // Handle image upload
    move_uploaded_file($_FILES['product_image']['tmp_name'], "uploads/" . $product_image);

    $stmt = $conn->prepare("INSERT INTO product (product_name, product_price, product_qty, product_image, product_code, category_id, var_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sdisssi", $product_name, $product_price, $product_qty, $product_image, $product_code, $category_id, $var_id);
    $stmt->execute();
    $stmt->close();
    header("Location: index.php?product=success");
}

// Handle Delete Operations
if(isset($_GET['delete_category'])){
    $id = $_GET['delete_category'];
    $stmt = $conn->prepare("DELETE FROM category WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: index.php?delete=category_success");
}

if(isset($_GET['delete_variation'])){
    $id = $_GET['delete_variation'];
    $stmt = $conn->prepare("DELETE FROM variation WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: index.php?delete=variation_success");
}

if(isset($_GET['delete_product'])){
    $id = $_GET['delete_product'];
    $stmt = $conn->prepare("DELETE FROM product WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: index.php?delete=product_success");
}

// Similarly, you can add update operations
?>
