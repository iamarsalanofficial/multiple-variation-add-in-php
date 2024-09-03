<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "client_project");

$query = "SELECT * FROM variation";
$result = $conn->query($query);

$options = "<option value=''>Select Variation</option>";
while($row = $result->fetch_assoc()) {
    $options .= "<option value='".$row['id']."'>".$row['var_name']."</option>";
}

echo $options;
?>
