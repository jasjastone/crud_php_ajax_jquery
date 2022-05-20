<?php
require "./connection.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <title>PHP AJAX CRUD APPLICATION</title>
</head>

<body>
    <!-- Button trigger add product modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdropAdd">
        Add Product
    </button>

    <!-- Modal of adding products -->
    <div class="modal fade" id="staticBackdropAdd" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Add New Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addform">
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="product-name" id="product-name" placeholder="Product Name">
                            <label for="product-name">Product Name</label>
                        </div>
                        <div class="form-floating">
                            <input type="number" class="form-control" name="product-price" id="product-price" placeholder="Product Price">
                            <label for="product-price">Product Price</label>
                        </div>
                        <!-- this input is must because we will use it to check if the add button is cliced in php -->
                        <input type="hidden" name="add-product" value="click">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" name="add-product" id="add-button" value="Add" class="btn btn-primary" />
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal of edit products -->
    <div class="modal fade" id="staticBackdropEdit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="updateform">
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="product-name-edit" id="product-name-edit" placeholder="Product Name">
                            <label for="product-name">Product Name</label>
                        </div>
                        <div class="form-floating">
                            <input type="number" class="form-control" name="product-price-edit" id="product-price-edit" placeholder="Product Price">
                            <label for="product-price">Product Price</label>
                        </div>
                        <!-- this input is must because we will use it to check if the update button is clicked in php -->
                        <input type="hidden" name="update-product" value="click">
                        <input type="hidden" name="product_id_edit" id="product_id_edit" value="click">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" name="update-product" id="update-product-button" value="Update" class="btn btn-warning" />
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal of delete message products -->
    <div class="modal fade" id="staticBackdropDelete" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Do you realy want to delete This Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="deleteform">
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <input class="form-control" disabled id="product-name-delete">
                            <label for="product-name-delete">Product Name</label>
                        </div>
                        <div class="form-floating">
                            <input class="form-control" disabled id="product-price-delete"/>
                            <label for="product-price-delete">Product Price</label>
                        </div>
                        <!-- this input is must because we will use it to check if the delete button is clicked in php -->
                        <input type="hidden" name="delete-product" value="click">
                        <input type="hidden" name="product_id_delete" id="product_id_delete" value="click">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" name="update-product" id="update-product-button" value="Delete" class="btn btn-danger" />
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- fetch the products using normal php -->
    <div class="container">
        <table class="table table-hover table-striped table-striped-columns">

            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Price Tshs</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $selectAll = "SELECT  * FROM products";
                $exeSelectAll = mysqli_query($connection, $selectAll);
                $i = 1;
                if ($exeSelectAll) {
                    while ($row = mysqli_fetch_array($exeSelectAll)) { ?>
                        <tr>
                            <th scope="row"><?php echo $i++; ?></th>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['price']; ?></td>
                            <!-- data id is a custom prop what will store the id of the product -->
                            <!-- if you don't know what props are go and pitia html data binds topic to learn more -->
                            <td><button type="button" class="btn edit-button btn-warning" data-bs-toggle="modal" data-bs-target="#staticBackdropEdit" data-id="<?php echo $row['id']; ?>">Edit</button> <button type="button" class="btn delete-button btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdropDelete" data-id="<?php echo $row['id']; ?>">Delete</button></td>
                        </tr>
                <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>

<!-- This include is must because we will use jquery and ajax to make request to the database -->
<script type="text/javascript" src="https://code.jquery.com/jquery-1.7.1.min.js"></script>

</html>


<script>





    //! start make the add request postdata!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    //here i declare the global request variable for storing all the request
    //  so that we can handle them easly but its not neccessarly to do this
    // but i want the control of every request so i should know them and cancel them if there is a new request make
    var request;
    //if the form is submited for adding the product
    $('#addform').submit(function(event) {
        //stop the form from submit to the action url;
        event.preventDefault();

        //here we check if the user has a running request and try to make a new one we stop the running request
        if (request) {
            request.abort();
        }
        // get the form you can also not create the variable and just $(this) and it will still work fine
        //but here let make things simple and store it on a variable addform
        var addform = $(this);
        // Let's select and cache all the fields of the form you can include all of them here
        // I will just put the select and textarea as an example you also add another input tag here
        //basically we will disable them after start making the request
        var inputs = addform.find("input, select, button, textarea");
        // Serialize the data in the addform
        var serializedData = addform.serialize();
        // Let's disable the inputs for the duration of the Ajax request that will take.
        //! Note: we disable all elements AFTER the form data has been serialized.
        //! Disabled form elements will not be serialized means will not be included to the form when submit.
        inputs.prop("disabled", true);

        //? Now let send the data to the DBHelper.php file using ajax and store the response
        //? to the request variable that we create on top of the script
        const urlToPostData = "DBHelper.php";
        const method = "post"
        request = $.ajax({
            url: urlToPostData,
            type: method,
            data: serializedData
        });


        // we check here if the is success
        request.done(function(response, textStatus, jqXHR) {
            //here we hide the model for add since the data has successed
            $("#staticBackdropAdd").modal("hide");
            //here you can implement the auto refresh of the page
            location.reload();
        });

        // here we handle the request if it fails
        request.fail(function(jqXHR, textStatus, errorThrown) {
            // Log the error to the console
            console.error(
                "The following error occurred: " +
                textStatus, errorThrown
            );
        });

        // this function will always be call where the response is success or fail
        request.always(function() {
            // here we enable all the input fields where the response is success or fail
            inputs.prop("disabled", false);
        });

    });
    //! end of add product ajax request postdata!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!






    //! start of edit product ajax request getdata!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    // check if the view button is click by use the class name edit-button
    // here we can't use id because id is unique and can't be assaign to a multiple element so it won't work
    $(".edit-button").click(function(event) {
        //stop the link from following the url
        event.preventDefault();
        //initialize the needed variables modify them as you want
        // get the data-id databind from the view button that was clicked
        const id = $(this).data('id');
        const url = "DBHelper.php";
        const method = "post";
        //? make the get request using ajax
        const response = $.ajax({
            url: url,
            type: method,
            data: {
                // the get-product we use in php on isset to see if there is request for get product
                // we may use as hidden input on the form but i just want to make things simple to i put it manually
                // on the post i use hidden input because there was a form and i think here we don't neccessarily need
                // the form so i just hard coded it and give it any value like i gave it
                "get-product": "get the product",
                id: id
            }
        });

        response.done(function(response) {
            // here we convert the response to json object of javascript
            response = JSON.parse(response);
            // the id,name and price are the names of the column in my product array from php DBHelper
            // then we set the value of the inputs of the edit model to be the datafrom the database
            document.getElementById("product-name-edit").value = response.name;
            document.getElementById("product-price-edit").value = response.price;
            document.getElementById("product_id_edit").value = response.id;
        });
    });
    //! end of edit product ajax request getdata!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!






    //! start of update product ajax request postdata!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    $('#updateform').submit(function(event) {
        //stop the form from submit to the action url;
        event.preventDefault();

        //here we check if the user has a running request and try to make a new one we stop the running request
        if (request) {
            request.abort();
        }
        // get the form you can also not create the variable and just $(this) and it will still work fine
        //but here let make things simple and store it on a variable addform
        var updateform = $(this);
        // Let's select and cache all the fields of the form you can include all of them here
        // I will just put the select and textarea as an example you also add another input tag here
        //basically we will disable them after start making the request
        var inputs = updateform.find("input, select, button, textarea");
        // Serialize the data in the addform serialize means get all the inputs from the form and its data
        var serializedData = updateform.serialize();
        // Let's disable the inputs for the duration of the Ajax request that will take.
        //! Note: we disable all elements AFTER the form data has been serialized.
        //! Disabled form elements will not be serialized means will not be included to the form when submit.
        inputs.prop("disabled", true);

        //? Now let send the data to the DBHelper.php file using ajax and store the response
        //? to the request variable that we create on top of the script
        const urlToPostData = "DBHelper.php";
        const method = "post"
        request = $.ajax({
            url: urlToPostData,
            type: method,
            data: serializedData
        });


        // we check here if the is success
        request.done(function(response, textStatus, jqXHR) {
            //here we hide the model because the request has successed
            $("#staticBackdropEdit").modal("hide");
            // now let reload the page to get the current changes
            location.reload();
        });

        // here we handle the request if it fails
        request.fail(function(jqXHR, textStatus, errorThrown) {
            //you can use this section to display the errors to the user

            // Log the error to the console
            console.error(
                "The following error occurred: " +
                textStatus, errorThrown
            );
        });

        // this function will always be call where the response is success or fail
        request.always(function() {
            // here we enable all the input fields where the response is success or fail
            inputs.prop("disabled", false);
        });
    });
    //! end of update product ajax request postdata!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!



    //! start of delete product ajax request getdata!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    //if the user click any of the delete button with the class of .delete-button we start get the data the user justclick
    $('.delete-button').click(function (event){
        event.preventDefault();
        if(request){
            request.abort();
        }
        //here i will still make the request to the edit because we want to get the information of the product
        //so that we can display to user before delete it user should confirm the deletion
        //so i will copy and paste the code from the edit get data below and change only the id
        // of the inputs inorder to match with the id of the delete modal

        //stop the link from following the url
        event.preventDefault();
        //initialize the needed variables modify them as you want
        // get the data-id databind from the view button that was clicked
        const id = $(this).data('id');
        const url = "DBHelper.php";
        const method = "post";
        //? make the get request using ajax
        const response = $.ajax({
            url: url,
            type: method,
            data: {
                // the get-product we use in php on isset to see if there is request for get product
                // we may use as hidden input on the form but i just want to make things simple to i put it manually
                // on the post i use hidden input because there was a form and i think here we don't neccessarily need
                // the form so i just hard coded it and give it any value like i gave it
                "get-product": "get the product",
                id: id
            }
        });

        response.done(function(response) {
            // here we convert the response to json object of javascript
            response = JSON.parse(response);
            // the id,name and price are the names of the column in my product array from php DBHelper
            // then we set the value of the inputs of the edit model to be the datafrom the database
            document.getElementById("product-name-delete").value = response.name;
            document.getElementById("product-price-delete").value = response.price;
            document.getElementById("product_id_delete").value = response.id;
        });
    });

    //! start of delete product ajax request getdata!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!


    //! start of delete product ajax request postdata!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    $('#deleteform').submit(function(event) {
        //stop the form from submit to the action url;
        event.preventDefault();

        //here we check if the user has a running request and try to make a new one we stop the running request
        if (request) {
            request.abort();
        }
        // get the form you can also not create the variable and just $(this) and it will still work fine
        //but here let make things simple and store it on a variable addform
        var deleteForm = $(this);
        // Let's select and cache all the fields of the form you can include all of them here
        // I will just put the select and textarea as an example you also add another input tag here
        //basically we will disable them after start making the request
        var inputs = deleteForm.find("input, select, button, textarea");
        // Serialize the data in the addform serialize means get all the inputs from the form and its data
        //?? here we serialize because remember on the modal we put a form with the id of the product
        // ?? so when make a request we will use the id to delete the product on DB
        var serializedData = deleteForm.serialize();
        // Let's disable the inputs for the duration of the Ajax request that will take.
        //! Note: we disable all elements AFTER the form data has been serialized.
        //! Disabled form elements will not be serialized means will not be included to the form when submit.
        inputs.prop("disabled", true);

        //? Now let send the data to the DBHelper.php file using ajax and store the response
        //? to the request variable that we create on top of the script
        const urlToPostData = "DBHelper.php";
        const method = "post"
        request = $.ajax({
            url: urlToPostData,
            type: method,
            data: serializedData
        });


        // we check here if the is success
        request.done(function(response, textStatus, jqXHR) {
            //here we hide the model because the request has successed
            $("#staticBackdropDelete").modal("hide");
            // now let reload the page to get the current changes
            location.reload();
        });

        // here we handle the request if it fails
        request.fail(function(jqXHR, textStatus, errorThrown) {
            //you can use this section to display the errors to the user

            // Log the error to the console
            console.error(
                "The following error occurred: " +
                textStatus, errorThrown
            );
        });

        // this function will always be call where the response is success or fail
        request.always(function() {
            // here we enable all the input fields where the response is success or fail
            inputs.prop("disabled", false);
        });
    });
    //! end of update product ajax request postdata!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

</script>