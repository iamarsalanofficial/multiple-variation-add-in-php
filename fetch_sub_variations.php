<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "client_project");

$variation_id = $_POST['variation_id'];

$query = "SELECT * FROM sub_variation WHERE var_sub_id = '$variation_id'";
$result = $conn->query($query);

$options = "<option value=''>Select Sub-Variation</option>";
while($row = $result->fetch_assoc()) {
    $options .= "<option value='".$row['id']."'>".$row['sub_var_name']." - $".$row['sub_var_price']."</option>";
}

echo $options;
?>
