


<!DOCTYPE html>
<html>
<head>
    <title>Customer Management - Item</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1 class="mt-4">Customer Management - Item</h1>

    <?php
    // Include the database connection configuration
    include('config.php');

    // Function to validate input data (you can implement more validations if needed)
    function validateInput($data) {
        return htmlspecialchars(trim($data));
    }

    // Add new item record
    if (isset($_POST['add_item'])) {
        $item_code = validateInput($_POST['item_code']);
        $item_name = validateInput($_POST['item_name']);
        $item_category = validateInput($_POST['item_category']);
        $item_subcategory = validateInput($_POST['item_subcategory']);
        $quantity = validateInput($_POST['quantity']);
        $unit_price = validateInput($_POST['unit_price']);

        // Insert the data into the item table
        $sql = "INSERT INTO `item` (`item_code`, `item_name`, `item_category`, `item_subcategory`, `quantity`, `unit_price`) 
                    VALUES ('$item_code', '$item_name', '$item_category', '$item_subcategory', '$quantity', '$unit_price')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            // Item added successfully
            echo '<div class="alert alert-success">Item added successfully!</div>';
        } else {
            // Error adding item
            echo '<div class="alert alert-danger">Error adding item!</div>';
        }
    }

    // Update item record
    if (isset($_POST['update_item'])) {
        $id = validateInput($_POST['id']);
        $item_code = validateInput($_POST['item_code']);
        $item_name = validateInput($_POST['item_name']);
        $item_category = validateInput($_POST['item_category']);
        $item_subcategory = validateInput($_POST["item_subcategory"]);
        $quantity = validateInput($_POST['quantity']);
        $unit_price = validateInput($_POST['unit_price']);


        // Update the item data in the item table
        $sql = "UPDATE `item` SET `item_code`='$item_code', `item_name`='$item_name', 
                    `item_category`='$item_category', `item_subcategory`='$item_subcategory', 
                    `quantity`='$quantity', `unit_price`='$unit_price' WHERE `id`='$id'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            // Item updated successfully
            echo '<div class="alert alert-success">Item updated successfully!</div>';
        } else {
            // Error updating item
            echo '<div class="alert alert-danger">Error updating item!</div>';
        }
    }

    // Delete item record
    if (isset($_GET['delete_item'])) {
        $id = $_GET['delete_item'];

        // Delete the item data from the item table
        $sql = "DELETE FROM `item` WHERE `id`='$id'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            // Item deleted successfully
            echo '<div class="alert alert-success">Item deleted successfully!</div>';
        } else {
            // Error deleting item
            echo '<div class="alert alert-danger">Error deleting item!</div>';
        }
    }

    // Fetch all item records for viewing the list
    $sql = "SELECT * FROM `item`";
    $result = mysqli_query($conn, $sql);
    $items = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Fetch all item categories for dropdown
    $sql = "SELECT DISTINCT `item_category` FROM `item`";
    $result = mysqli_query($conn, $sql);
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Fetch all item subcategories for dropdown
    $sql = "SELECT DISTINCT `item_subcategory` FROM `item`";
    $result = mysqli_query($conn, $sql);
    $subcategories = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Item search
    if (isset($_POST['search_item'])) {
        $search_query = validateInput($_POST['search_query']);

        // Perform the item search based on the item code or item name
        $sql = "SELECT * FROM `item` WHERE `item_code` LIKE '%$search_query%' OR `item_name` LIKE '%$search_query%'";
        $result = mysqli_query($conn, $sql);
        $items = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    // Close the database connection
    mysqli_close($conn);
    ?>

    <!-- Add Item Form -->
    <div class="mt-4">
        <h3>Add/Edit Item</h3>
        <form action="item.php" method="POST" onsubmit="return validateForm()">
            <input type="hidden" name="id" value="<?php echo isset($item['id']) ? $item['id'] : ''; ?>">
            <div class="form-group">
                <label>Item Code:</label>
                <input type="text" name="item_code" class="form-control" value="<?php echo isset($item['item_code']) ? $item['item_code'] : ''; ?>" required>
            </div>
            <div class="form-group">
                <label>Item Name:</label>
                <input type="text" name="item_name" class="form-control" value="<?php echo isset($item['item_name']) ? $item['item_name'] : ''; ?>" required>
            </div>
            <div class="form-group">
                <label>Item Category:</label>
                <select name="item_category" class="form-control" required>
                    <option value="">Select Category</option>
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?php echo $category['item_category']; ?>" <?php echo (isset($item['item_category']) && $item['item_category'] == $category['item_category']) ? 'selected' : ''; ?>><?php echo $category['item_category']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Item Subcategory:</label>
                <select name="item_subcategory" class="form-control" required>
                    <option value="">Select Subcategory</option>
                    <?php foreach ($subcategories as $subcategory) : ?>
                        <option value="<?php echo $subcategory['item_subcategory']; ?>" <?php echo (isset($item['item_subcategory']) && $item['item_subcategory'] == $subcategory['item_subcategory']) ? 'selected' : ''; ?>><?php echo $subcategory['item_subcategory']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Quantity:</label>
                <input type="text" name="quantity" class="form-control" value="<?php echo isset($item['quantity']) ? $item['quantity'] : ''; ?>" required>
            </div>
            <div class="form-group">
                <label>Unit Price:</label>
                <input type="text" name="unit_price" class="form-control" value="<?php echo isset($item['unit_price']) ? $item['unit_price'] : ''; ?>" required>
            </div>
            <button type="submit" name="add_item" class="btn btn-primary">Add Item</button>
            <button type="submit" name="update_item" class="btn btn-success">Update Item</button>
        </form>
    </div>

    <!-- Item List -->
    <div class="mt-4">
        <h3>Item List</h3>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Item Code</th>
                <th>Item Name</th>
                <th>Item Category</th>
                <th>Item Subcategory</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($items as $item) : ?>
                <tr>
                    <td><?php echo $item['item_code']; ?></td>
                    <td><?php echo $item['item_name']; ?></td>
                    <td><?php echo $item['item_category']; ?></td>
                    <td><?php echo $item['item_subcategory']; ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td><?php echo $item['unit_price']; ?></td>
                    <td>
                        <a href="item.php?id=<?php echo $item['id']; ?>" class="btn btn-info btn-sm">Edit</a>
                        <a href="item.php?delete_item=<?php echo $item['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Item Search Form -->
    <div class="mt-4">
        <h3>Search Items</h3>
        <form action="item.php" method="POST" class="form-inline">
            <div class="form-group mb-2">
                <input type="text" name="search_query" class="form-control" placeholder="Search by item code or item name">
            </div>
            <button type="submit" name="search_item" class="btn btn-primary mb-2 ml-2">Search</button>
        </form>
    </div>
</div>

<!-- Include Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="script.js"></script>
</body>
</html>
