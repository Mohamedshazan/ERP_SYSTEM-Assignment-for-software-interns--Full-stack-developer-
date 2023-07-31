function validateForm() {
    var itemCode = document.getElementById("item_code").value;
    var itemName = document.getElementById("item_name").value;
    var itemCategory = document.getElementById("item_category").value;
    var itemSubcategory = document.getElementById("item_subcategory").value;
    var quantity = document.getElementById("quantity").value;
    var unitPrice = document.getElementById("unit_price").value;

    if (itemCode.trim() === "") {
        alert("Please enter the item code.");
        return false;
    }

    if (itemName.trim() === "") {
        alert("Please enter the item name.");
        return false;
    }

    if (itemCategory.trim() === "") {
        alert("Please select the item category.");
        return false;
    }

    if (itemSubcategory.trim() === "") {
        alert("Please select the item subcategory.");
        return false;
    }

    if (quantity.trim() === "") {
        alert("Please enter the quantity.");
        return false;
    }

    if (isNaN(quantity)) {
        alert("Quantity must be a number.");
        return false;
    }

    if (unitPrice.trim() === "") {
        alert("Please enter the unit price.");
        return false;
    }

    if (isNaN(unitPrice)) {
        alert("Unit price must be a number.");
        return false;
    }

    return true;
}
