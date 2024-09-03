<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Client Project Management</title>
    <link rel="stylesheet" href="styles.css">
    <!-- You can include Bootstrap or any other CSS framework for better styling -->
    <style>
        /* Basic styles for tabs */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .tabs {
            display: flex;
            margin-bottom: 20px;
            cursor: pointer;
        }

        .tab {
            padding: 10px 20px;
            background: #f1f1f1;
            margin-right: 5px;
            border-radius: 5px 5px 0 0;
        }

        .tab.active {
            background: #ffffff;
            border-bottom: 2px solid #ffffff;
        }

        .tab-content {
            border: 1px solid #f1f1f1;
            padding: 20px;
            display: none;
            border-radius: 0 5px 5px 5px;
        }

        .tab-content.active {
            display: block;
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 100;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
            border-radius: 5px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 24px;
            font-weight: bold;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <h1>Client Project Management</h1>

    <div class="tabs">
        <div class="tab active" data-tab="add_product">Add Product</div>
        <div class="tab" data-tab="add_category">Add Category</div>
        <div class="tab" data-tab="add_variation">Add Variation</div>
    </div>

    <!-- Add Product Tab -->
    <div id="add_product" class="tab-content active">
        <h2>Add Product</h2>
        <form action="process.php" method="POST" enctype="multipart/form-data">
            <label>Product Name:</label><br>
            <input type="text" name="product_name" required><br><br>

            <label>Product Price:</label><br>
            <input type="number" step="0.01" name="product_price" required><br><br>

            <label>Product Quantity:</label><br>
            <input type="number" name="product_qty" required><br><br>

            <label>Product Image:</label><br>
            <input type="file" name="product_image" accept="image/*"><br><br>

            <label>Product Code:</label><br>
            <input type="text" name="product_code" required><br><br>

            <label>Category:</label><br>
            <select name="category_id" required>
                <option value="">Select Category</option>
                <?php
                include 'db.php';
                $result = $conn->query("SELECT * FROM category");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                }
                ?>
            </select><br><br>

            <label>Variation:</label><br>
            <select name="var_id" required>
                <option value="">Select Variation</option>
                <?php
                $result = $conn->query("SELECT * FROM variation");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . $row['var_name'] . "</option>";
                }
                ?>
            </select><br><br>

            <!-- Add more fields as needed for variations and sub variations -->

            <button type="submit" name="add_product">Add Product</button>
        </form>
    </div>

    <!-- Add Category Tab -->
    <div id="add_category" class="tab-content">
        <h2>Add Category</h2>
        <form action="process.php" method="POST" enctype="multipart/form-data">
            <label>Category Name:</label><br>
            <input type="text" name="name" required><br><br>

            <label>Category Image:</label><br>
            <input type="file" name="img" accept="image/*"><br><br>

            <label>Category Banner:</label><br>
            <input type="file" name="c_banner" accept="image/*"><br><br>

            <label>Category Description:</label><br>
            <textarea name="c_desc" rows="4" cols="50"></textarea><br><br>

            <button type="submit" name="add_category">Add Category</button>
        </form>
    </div>

    <!-- Add Variation Tab -->
    <div id="add_variation" class="tab-content">
        <h2>Add Variation</h2>
        <form id="variation_form">
            <label>Variation Name:</label><br>
            <input type="text" id="var_name" required><br><br>

            <button type="button" id="add_sub_variation">Add Sub Variation</button><br><br>

            <div id="sub_variations">
                <!-- Sub Variations will be appended here -->
            </div>

            <button type="submit">Submit Variation</button>
        </form>
    </div>

    <!-- Modal for Sub Variation (Optional if you want to use a modal) -->
    <!--
    <div id="subVariationModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <form id="sub_variation_form">
                <label>Sub Variation Name:</label><br>
                <input type="text" name="sub_var_name[]" required><br><br>

                <label>Sub Variation Price:</label><br>
                <input type="number" step="0.01" name="sub_var_price[]" required><br><br>

                <button type="button" id="save_sub_variation">Save</button>
            </form>
        </div>
    </div>
    -->

    <script>
        // Tab Switching
        const tabs = document.querySelectorAll('.tab');
        const tabContents = document.querySelectorAll('.tab-content');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                // Remove active class from all tabs and contents
                tabs.forEach(t => t.classList.remove('active'));
                tabContents.forEach(tc => tc.classList.remove('active'));

                // Add active class to current tab and corresponding content
                tab.classList.add('active');
                document.getElementById(tab.getAttribute('data-tab')).classList.add('active');
            });
        });

        // Handling Sub Variations in Add Variation Tab
        document.getElementById('variation_form').addEventListener('submit', function(e) {
            e.preventDefault();

            const var_name = document.getElementById('var_name').value;
            const sub_var_names = document.getElementsByName('sub_var_name[]');
            const sub_var_prices = document.getElementsByName('sub_var_price[]');

            // Create a form data to submit via AJAX
            let formData = new FormData();
            formData.append('add_variation', true);
            formData.append('var_name', var_name);

            sub_var_names.forEach((input, index) => {
                formData.append('sub_var_name[]', input.value);
                formData.append('sub_var_price[]', sub_var_prices[index].value);
            });

            fetch('process.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => window.location.href = 'index.php?variation=success')
                .catch(error => console.error('Error:', error));
        });

        // Add Sub Variation Fields
        document.getElementById('add_sub_variation').addEventListener('click', function() {
            const subVariationsDiv = document.getElementById('sub_variations');

            const div = document.createElement('div');
            div.innerHTML = `
                <label>Sub Variation Name:</label><br>
                <input type="text" name="sub_var_name[]" required><br><br>
                <label>Sub Variation Price:</label><br>
                <input type="number" step="0.01" name="sub_var_price[]" required><br><br>
            `;
            subVariationsDiv.appendChild(div);
        });
    </script>

</body>

</html>