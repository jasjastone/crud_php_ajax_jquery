<?php
require "./connection.php";

// This will check if we want to add product
if (isset($_POST['add-product'])) {
    $productName = $_POST['product-name'];
    $productPrice = $_POST['product-price'];
    $insert = "INSERT INTO products(`name`,`price`) VALUES('$productName',$productPrice)";
    $exeInsert = mysqli_query($connection, $insert);
    if ($exeInsert) {
        // here we echo as the response to the ajax request you na echo any thing you want here
        //example you can echo array or json object eg echo json
        // echo json_encode(['hellow'=>"world"]);
        echo "Product Inserted";
    } else {
        // here we echo as the response to the ajax request you na echo any thing you want here
        echo "Product Not Inserted";
    }
}

// This will get the information of the product
if (isset($_POST['get-product'])) {
    $id = $_POST['id'];
    $selectProduct = "SELECT * FROM products WHERE id=$id";
    $exeSelectProduct = mysqli_query($connection, $selectProduct);
    if ($exeSelectProduct) {
        $row = mysqli_fetch_array($exeSelectProduct);
        $productArray = ['name' => $row['name'], 'price' => $row['price'], 'id' => $row['id']];
        // here we convert the array to json object so that wecan use it as json object in javascript response
        echo json_encode($productArray);
    } else {
        echo "Product Not Found";
    }
}
// This will check if we want to update product
if (isset($_POST['update-product'])) {
    //look at the edit model you will find all the input fields that i use here and most important
    // i use the name attribute of the input to get the data from it
    $productName = $_POST['product-name-edit'];
    $productPrice = $_POST['product-price-edit'];
    $id = $_POST['product_id_edit'];

    //first we select the database and look if the product exist so that we can update only the fields that the user has entered
    //and not the empty fields;
    $selectProduct = "SELECT * FROM products WHERE id=$id";
    $exeSelectProduct = mysqli_query($connection, $selectProduct);
    if ($exeSelectProduct) {
        $row = mysqli_fetch_array($exeSelectProduct);

        // here we set the variable to be updated and set the null values to the database values
        // we use ?? to check if the variable is null if yes we use the second value if not we use the value of the variable
        $productName = $productName ?? $row['name'];
        $productPrice = $productPrice ?? $row['price'];
        //here we start update the user information
        $update = "UPDATE products SET `name`='$productName',`price`=$productPrice WHERE `id`=$id";
        $exeUpdate = mysqli_query($connection,$update);
        if($exeUpdate){
            echo "Update Success";
        }
        else{
            "Could not update the product";
        }

    } else {
        echo "Product Not Found";
    }
}


if(isset($_POST['delete-product'])){
    $id = $_POST['product_id_delete'];
    $delete = "DELETE FROM products WHERE id=$id";
    $execDelete = mysqli_query($connection,$delete);
    if($execDelete){
        echo "Item Delete";
    }
    else{
        echo "Could not delete the specified Item";
    }
}
