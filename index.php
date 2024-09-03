<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product with Multiple Variations</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <h2>Add Product</h2>
        <form action="add_product.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="product_name" placeholder="Product Name" required>
            <input type="number" name="product_price" placeholder="Product Price" required>
            <input type="number" name="product_qty" placeholder="Product Quantity" required>
            <input type="text" name="product_code" placeholder="Product Code" required>
            <input type="file" name="product_image" required>

            <select name="category_id">
                <?php
                require('db.php');
                // Fetch categories from the database
                $categories = $conn->query("SELECT * FROM category");
                while ($row = $categories->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                }
                ?>
            </select>

            <div id="variationContainer">
                <!-- Variations will be added dynamically here -->
            </div>
            <button type="button" id="addVariationBtn">Add Variation</button>

            <button type="submit" name="add_product">Add Product</button>
        </form>
    </div>

    <script>
        // Your provided JavaScript code
        document.getElementById('addVariationBtn').addEventListener('click', function() {
            var newFieldSet = document.createElement('div');
            newFieldSet.className = 'variation-set mt-2';

            var selectVariation = document.createElement('select');
            selectVariation.className = 'form-select';
            selectVariation.name = 'var_id[]';
            selectVariation.innerHTML = '<option value="">Select Variation</option>';

            var selectSubVariation = document.createElement('select');
            selectSubVariation.className = 'form-select mt-2';
            selectSubVariation.name = 'sub_var_id[]';
            selectSubVariation.style.display = 'none';

            var emptyParagraph = document.createElement('p');
            emptyParagraph.className = 'mt-2';

            newFieldSet.appendChild(selectVariation);
            newFieldSet.appendChild(selectSubVariation);
            newFieldSet.appendChild(emptyParagraph);

            document.getElementById('variationContainer').appendChild(newFieldSet);

            fetchVariations(selectVariation);

            selectVariation.addEventListener('change', function() {
                var variationId = this.value;
                if (variationId) {
                    fetchSubVariations(variationId, selectSubVariation);
                    selectSubVariation.style.display = 'block';
                } else {
                    selectSubVariation.style.display = 'none';
                }
            });
        });

        function fetchVariations(selectVariation) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'fetch_variations.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    selectVariation.innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }

        function fetchSubVariations(variationId, selectSubVariation) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'fetch_sub_variations.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    selectSubVariation.innerHTML = xhr.responseText;
                }
            };
            xhr.send('variation_id=' + variationId);
        }
    </script>
</body>

</html>