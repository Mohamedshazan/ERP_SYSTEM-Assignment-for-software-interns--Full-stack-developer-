


<!DOCTYPE html>
<html>
<head>
    <title>Customer Management</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>
<body>

<div class="container">
    <h1 class="mt-4">ERP Management</h1>

    <div>

        <!-- Button container without vertical alignment -->
        <div class="button-container">
            <form action="item.php" class="d-inline-block me-2">
                <button type="submit" class="btn btn-primary">Go to Item</button>
            </form>
            <form action="report.php" class="d-inline-block">
                <button type="submit" class="btn btn-primary">Go to Report </button>
            </form>
        </div>
    </div>

    <?php
    // Include the database connection configuration
    include('config.php');

    // Function to validate input data (you can implement more validations if needed)
    function validateInput($data) {
        return htmlspecialchars(trim($data));
    }

    // Add new customer record
    if (isset($_POST['add_customer'])) {
        $title = validateInput($_POST['title']);
        $first_name = validateInput($_POST['first_name']);
        $last_name = validateInput($_POST['last_name']);
        $contact_no = validateInput($_POST['contact_no']);
        $district = validateInput($_POST['district']);

        // Insert the data into the customer table
        $sql = "INSERT INTO `customer` (`title`, `first_name`, `last_name`, `contact_no`, `district`) 
                    VALUES ('$title', '$first_name', '$last_name', '$contact_no', '$district')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            // Customer added successfully
            echo '<div class="alert alert-success">Customer added successfully!</div>';
        } else {
            // Error adding customer
            echo '<div class="alert alert-danger">Error adding customer!</div>';
        }
    }

    // Update customer record
    if (isset($_POST['update_customer'])) {
        $id = validateInput($_POST['id']);
        $title = validateInput($_POST['title']);
        $first_name = validateInput($_POST['first_name']);
        $last_name = validateInput($_POST['last_name']);
        $contact_no = validateInput($_POST['contact_no']);
        $district = validateInput($_POST['district']);

        // Update the customer data in the customer table
        $sql = "UPDATE `customer` SET `title`='$title', `first_name`='$first_name', `last_name`='$last_name', 
                    `contact_no`='$contact_no', `district`='$district' WHERE `id`='$id'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            // Customer updated successfully
            echo '<div class="alert alert-success">Customer updated successfully!</div>';
        } else {
            // Error updating customer
            echo '<div class="alert alert-danger">Error updating customer!</div>';
        }
    }

    // Delete customer record
    if (isset($_GET['delete_customer'])) {
        $id = $_GET['delete_customer'];

        // Delete the customer data from the customer table
        $sql = "DELETE FROM `customer` WHERE `id`='$id'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            // Customer deleted successfully
            echo '<div class="alert alert-success">Customer deleted successfully!</div>';
        } else {
            // Error deleting customer
            echo '<div class="alert alert-danger">Error deleting customer!</div>';
        }
    }

    // Search customer records
    if (isset($_POST['search_customer'])) {
        $search_query = validateInput($_POST['search_query']);

        // Fetch customer records that match the search query
        $sql = "SELECT * FROM `customer` WHERE `first_name` LIKE '%$search_query%' OR `last_name` LIKE '%$search_query%'";
        $result = mysqli_query($conn, $sql);
        $customers = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        // Fetch all customer records for viewing the list
        $sql = "SELECT * FROM `customer`";
        $result = mysqli_query($conn, $sql);
        $customers = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    // Close the database connection
    mysqli_close($conn);
    ?>

    <!-- Customer Form -->
    <div class="mt-4">
        <h3>Add / Update Customer</h3>
        <form action="customer.php" method="POST">
            <input type="hidden" name="id" value="<?php echo isset($customer['id']) ? $customer['id'] : ''; ?>">
            <div class="form-group">
                <label>Title:</label>
                <input type="text" name="title" class="form-control" value="<?php echo isset($customer['title']) ? $customer['title'] : ''; ?>">
            </div>
            <div class="form-group">
                <label>First Name:</label>
                <input type="text" name="first_name" class="form-control" value="<?php echo isset($customer['first_name']) ? $customer['first_name'] : ''; ?>">
            </div>
            <div class="form-group">
                <label>Last Name:</label>
                <input type="text" name="last_name" class="form-control" value="<?php echo isset($customer['last_name']) ? $customer['last_name'] : ''; ?>">
            </div>
            <div class="form-group">
                <label>Contact Number:</label>
                <input type="text" name="contact_no" class="form-control" value="<?php echo isset($customer['contact_no']) ? $customer['contact_no'] : ''; ?>">
            </div>
            <div class="form-group">
                <label>District:</label>
                <input type="text" name="district" class="form-control" value="<?php echo isset($customer['district']) ? $customer['district'] : ''; ?>">
            </div>

            <div class="container mt-3">

                <div class="row mt-3">
                    <div class="col-md-6">
                        <!-- Add Customer and Update Customer buttons in the left column -->
                        <button type="submit" name="add_customer" class="btn btn-primary">Add Customer</button>
                        <button type="submit" name="update_customer" class="btn btn-success">Update Customer</button>
                    </div>

            </div>


        </form>
    </div>

    <!-- Search Form -->
    <div class="mt-4">
        <h3>Search Customer</h3>
        <form action="customer.php" method="POST">
            <div class="input-group">
                <input type="text" name="search_query" class="form-control" placeholder="Search by First Name or Last Name">
                <div class="input-group-append">
                    <button type="submit" name="search_customer" class="btn btn-primary">Search</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Customer List -->
    <div class="mt-4">
        <h2>Customer List</h2>
        <table class="table table-bordered">
            <tr>
                <th>Title</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Contact Number</th>
                <th>District</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($customers as $customer) : ?>
                <tr>
                    <td><?php echo $customer['title']; ?></td>
                    <td><?php echo $customer['first_name']; ?></td>
                    <td><?php echo $customer['last_name']; ?></td>
                    <td><?php echo $customer['contact_no']; ?></td>
                    <td><?php echo $customer['district']; ?></td>
                    <td>
                        <a href="customer.php?id=<?php echo $customer['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="customer.php?delete_customer=<?php echo $customer['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>

<!-- Include Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
