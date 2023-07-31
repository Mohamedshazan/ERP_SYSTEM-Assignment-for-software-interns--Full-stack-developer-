<!DOCTYPE html>
<html>

<head>
    <title>ERP- Reports</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
<?php
// Include the database connection configuration
include('config.php');

// Function to validate input data (you can implement more validations if needed)
function validateInput($data)
{
    return htmlspecialchars(trim($data));
}

// Invoice Report
if (isset($_POST['invoice_report'])) {
    $start_date = validateInput($_POST['start_date']);
    $end_date = validateInput($_POST['end_date']);

    $sql = "SELECT i.invoice_no, i.date, c.first_name, c.last_name, c.district, COUNT(im.item_id) as item_count, SUM(im.amount) as invoice_amount
                FROM invoice i
                INNER JOIN customer c ON i.customer = c.id
                INNER JOIN invoice_master im ON i.invoice_no = im.invoice_no
                WHERE i.date BETWEEN '$start_date' AND '$end_date'
                GROUP BY i.invoice_no";
    $result = mysqli_query($conn, $sql);
    $invoice_report = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Invoice Item Report
if (isset($_POST['invoice_item_report'])) {
    $start_date = validateInput($_POST['start_date_item']);
    $end_date = validateInput($_POST['end_date_item']);

    $sql = "SELECT i.invoice_no, i.date, c.first_name, c.last_name, im.item_id, item.item_name, item.item_category, im.unit_price
                FROM invoice i
                INNER JOIN customer c ON i.customer = c.id
                INNER JOIN invoice_master im ON i.invoice_no = im.invoice_no
                INNER JOIN item ON im.item_id = item.id
                WHERE i.date BETWEEN '$start_date' AND '$end_date'";
    $result = mysqli_query($conn, $sql);
    $invoice_item_report = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Item Report
if (isset($_POST['item_report'])) {
    $sql = "SELECT item_name, item_category, item_subcategory, quantity as item_quantity FROM item";
    $result = mysqli_query($conn, $sql);
    $items = mysqli_fetch_all($result, MYSQLI_ASSOC);
}
?>

<div class="container mt-4">
    <h2>Task 3 - Reports</h2>
    <ul class="nav nav-tabs mt-3">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#invoice-report">Invoice Report</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#invoice-item-report">Invoice Item Report</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#item-report">Item Report</a>
        </li>
    </ul>

    <div class="tab-content mt-3">
        <!-- Invoice Report Tab -->
        <div class="tab-pane fade show active" id="invoice-report">
            <h4>Invoice Report</h4>
            <form action="" method="POST">
                <label for="start_date">Start Date:</label>
                <input type="date" id="start_date" name="start_date" required>
                <label for="end_date">End Date:</label>
                <input type="date" id="end_date" name="end_date" required>
                <button type="submit" class="btn btn-primary" name="invoice_report">Generate Report</button>
            </form>

            <?php if (isset($invoice_report)) : ?>
                <table class="table table-bordered mt-3">
                    <tr>
                        <th>Invoice Number</th>
                        <th>Date</th>
                        <th>Customer</th>
                        <th>Customer District</th>
                        <th>Item Count</th>
                        <th>Invoice Amount</th>
                    </tr>
                    <?php foreach ($invoice_report as $invoice) : ?>
                        <tr>
                            <td><?php echo $invoice['invoice_no']; ?></td>
                            <td><?php echo $invoice['date']; ?></td>
                            <td><?php echo $invoice['first_name'] . ' ' . $invoice['last_name']; ?></td>
                            <td><?php echo $invoice['district']; ?></td>
                            <td><?php echo $invoice['item_count']; ?></td>
                            <td><?php echo $invoice['invoice_amount']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>
        </div>

        <!-- Invoice Item Report Tab -->
        <div class="tab-pane fade" id="invoice-item-report">
            <h4>Invoice Item Report</h4>
            <form action="" method="POST">
                <label for="start_date_item">Start Date:</label>
                <input type="date" id="start_date_item" name="start_date_item" required>
                <label for="end_date_item">End Date:</label>
                <input type="date" id="end_date_item" name="end_date_item" required>
                <button type="submit" class="btn btn-primary" name="invoice_item_report">Generate Report</button>
            </form>

            <?php if (isset($invoice_item_report)) : ?>
                <table class="table table-bordered mt-3">
                    <tr>
                        <th>Invoice Number</th>
                        <th>Invoiced Date</th>
                        <th>Customer Name</th>
                        <th>Item Name with Item Code</th>
                        <th>Item Category</th>
                        <th>Item Unit Price</th>
                    </tr>
                    <?php foreach ($invoice_item_report as $invoiceItem) : ?>
                        <tr>
                            <td><?php echo $invoiceItem['invoice_no']; ?></td>
                            <td><?php echo $invoiceItem['date']; ?></td>
                            <td><?php echo $invoiceItem['first_name'] . ' ' . $invoiceItem['last_name']; ?></td>
                            <td><?php echo $invoiceItem['item_name'] . ' (' . $invoiceItem['item_id'] . ')'; ?></td>
                            <td><?php echo $invoiceItem['item_category']; ?></td>
                            <td><?php echo $invoiceItem['unit_price']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>
        </div>

        <!-- Item Report Tab -->
        <div class="tab-pane fade" id="item-report">
            <h4>Item Report</h4>
            <form action="" method="POST">
                <button type="submit" class="btn btn-primary" name="item_report">Generate Report</button>
            </form>

            <?php if (isset($items)) : ?>
                <table class="table table-bordered mt-3">
                    <tr>
                        <th>Item Name</th>
                        <th>Item Category</th>
                        <th>Item Subcategory</th>
                        <th>Item Quantity</th>
                    </tr>
                    <?php foreach ($items as $item) : ?>
                        <tr>

                            <td><?php echo $item['item_name']; ?></td>
                            <td><?php echo $item['item_category']; ?></td>
                            <td><?php echo $item['item_subcategory']; ?></td>
                            <td><?php echo $item['item_quantity']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Include Bootstrap JS and jQuery -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>
