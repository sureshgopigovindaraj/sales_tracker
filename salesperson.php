<?php
include_once("array_data.php");


// if(empty($_SESSION)){
//     header("location:login.php");
//     return;
// }
//want ot implement the code for error message


$get = $_GET;
$post = $_POST;
$sampleCustomerNumber = [
    2155683058,2920308562,6120616861,2442669770,2984536996
];

if(isset($get['logout']))
    if($get['logout']==1)
    {
        // print_r($_GET);
        session_unset();
        session_destroy();
        setcookie("emaiAddress","",0);
        setcookie("password","",0);
        header("location:login.php");
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin page</title>
    <link rel="stylesheet" href="assets/styles/salespersonstyle.css">
    <link rel="stylesheet" href="assets/styles/all.min.css">
</head>
<body>
<?php
    //update order details using phone number and them products
    if(isset($post['phone_number'])){
        
        $data = [
            "data" => $post['phone_number'],    
            "action" =>$post['action'],
        ];

        $curl = curl_init();
        $curlData = [
            CURLOPT_URL =>"http://localhost/php/Infi/Sales%20Tracker/dev/server/crud.php",
            CURLOPT_ENCODING =>'',
            CURLOPT_RETURNTRANSFER =>true,
            CURLOPT_POST =>true,
            CURLOPT_POSTFIELDS =>$data,
        ];
        curl_setopt_array($curl,$curlData);
        $resultSet = curl_exec($curl);
        $user_product_data = json_decode($resultSet,true);
    }
?>

<?php
    // condition to display particular div like order, product using display none and flex
    if(isset($get['option1']) and isset($get['option2'])){
        echo "<style>
        #order,#add_order{
            display:none;
        }
        #orderhead{
            border-bottom: 1px dashed gray;
        }
        #$get[option1]{
            display:flex;
        }
        #$get[option1]head{
            
            border-bottom: 3px solid #3e004a;

        }
        #$get[option2]{
            display:block;
        }
        </style>";
    }
    if(isset($_COOKIE['result'])){
        echo "<style>
            .messages{
                display: block;
            }
        </style>";
        if($_COOKIE['result'] == 'Server Error')
        echo "<style>
            .messages{
                color: brown;
                border-left: 5px solid red;
                border-right: 5px solid red;
                background-color: rgb(252, 139, 139);
            }
        </style>";
    }
?>

    <div class="header">
        <div>
            <h1><em class="fa-solid fa-user"></em> Welcome,</h1>
            <h1> <?= isset($_SESSION['first_name'])?$_SESSION['first_name']:"guest" ?>!</h1>
        </div>
        <div>
            <a href="track.php"><em class="fa-solid fa-chart-line"></em> track sales</a>
            <a href="salesperson.php?logout=1"><em class="fa-solid fa-right-from-bracket"></em>  logout</a>
        </div>
    </div>      
    <div class="messages">
        <h3><?= isset($_COOKIE['result'])? $_COOKIE['result'] : '' ?></h3>
    </div>
    <!-- CREATE, UPDATE AND DELETE operation for product -->
    <div class="poster">
        <div class="options">
            <a href="salesperson.php?option1=order&option2=add_order" id="orderhead">new order</a>
            <a href="salesperson.php?option1=product&option2=create_product" id="producthead">product</a>
            <a href="salesperson.php?option1=customer&option2=create_customer" id="customerhead">customer</a>
        </div>
    </div>
    <div class="body-content" id="product">
        <div class="operations">
            <a href="salesperson.php?option1=product&option2=create_product">Create</a>
            <a href="salesperson.php?option1=product&option2=update_product">Update</a>
            <a href="salesperson.php?option1=product&option2=add_stocks">add stock</a>
            <a href="salesperson.php?option1=product&option2=delete_product">delete</a>

        </div>
        <div class="actions">
            <div class="create_product" id="create_product">
                <h1>Create product</h1>
                <form action="action/crud.php" method="post" target="_self" enctype="application/x-www-form-urlencoded">
                        <div>
                            <label for="">product name</label>
                            <input type="text" name="product_name" id="">
                        </div>
                        <div>
                            <label for="">product description</label>
                            <textarea name="description" id=""></textarea>
                        </div>
                        <div>
                            <label for="">product category</label>
                            <select name="category" id="">
                                <?php
                                foreach($category_data as $data){
                                    echo "<option value='$data[category]'>$data[category]</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div>
                            <label for="">price</label>
                            <input type="text" name="price" id="">
                        </div>
                        <div>
                            <label for="">stock count</label>
                            <input type="text" name="stock_count" id="" required>
                        </div>
                            <br>
                            <button type="submit" name="action" value="add_product">Add</button>
                            <a href=""> cancel</a>
                </form>
            </div>
            <div class="update_product" id="update_product">
                    <h1>Update product</h1>
                    <form action="action/crud.php" method="post" target="_self" enctype="application/x-www-form-urlencoded">
                        <div>
                            <label for="">product name</label>
                            <select name="choose_product" id="">
                                <?php
                                foreach($product_data as $data){
                                    echo "<option value='$data[product_id]'>$data[product_name]</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div>
                            <label for="">update product name</label>
                            <input type="text" name="product_name" id="" required>
                        </div>
                        <div>
                            <label for="">change description</label>
                            <textarea name="description" id=""  required></textarea>
                        </div>
                        <div>
                            <label for="">change category</label>
                            <select name="category" id="">
                                <?php
                                foreach($category_data as $data){
                                    echo "<option value='$data[product_category_id]'>$data[category]</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div>
                            <label for="">change price</label>
                            <input type="text" name="price" id="" required>
                        </div>
                        <br>
                        <button type="submit" name="action" value="update_product">update</button>
                        <a href=""> cancel</a>
                    </form>
            </div>
            <div class="add_stocks" id="add_stocks">
                <h1>Add stock</h1>
                    <form action="action/crud.php" method="post" target="_self" enctype="application/x-www-form-urlencoded">
                        <div>
                            <label for="choose_product">product name</label>
                            <select name="choose_product" id="choose_product">
                                <?php
                                foreach($product_data as $data){
                                    echo "<option value='$data[product_id]'>$data[product_name]</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div>
                            <label for="stock_count">Add Stock count</label>
                            <input type="number" name="stock_count" id="stock_count" required>
                        </div>
                        <button type="submit" name="action" value="add_stock">Add stock</button>
                        <a href=""> cancel</a>
                    </form>
            </div>
            <div class="delete_product" id="delete_product">
                    <h1>Delete Product</h1>
                    <form action="action/crud.php" method="post" target="_self" enctype="application/x-www-form-urlencoded">
                        <div>
                            <label for="">product name</label>
                            <select name="delete_id" id="">
                                <?php
                                foreach($product_data as $data){
                                    echo "<option value='$data[product_id]'>$data[product_name]</option>";
                                }
                                ?>
                            </select>
                        </div>
                            <button type="submit" name="action" value="delete_product">Delete</button>
                            <a href="">cancel</a>
                    </form>
                </div>
            </div>
            </div>
    </div>
    <div class="body-content" id="customer">
        <div class="operations">
            <a href="salesperson.php?option1=customer&option2=create_customer">Create</a>
            <a href="salesperson.php?option1=customer&option2=update_customer">Update</a>
            <a href="salesperson.php?option1=customer&option2=delete_customer">delete</a>

        </div>
        <div class="actions">
            <div class="create_customer" id="create_customer">
                <h1>Create customer</h1>
                <form action="action/crud.php" method="post" target="_self" enctype="application/x-www-form-urlencoded">
                    <div>
                        <label for="">First name</label>
                        <input type="text" name="first_name" id="" required>
                    </div>
                    <div>
                        <label for="">Last name</label>
                        <input type="text" name="last_name" id="">
                    </div>
                    <div>
                        <label for="">phone number</label>
                        <input type="number" name="phone_number" id="" required>
                    </div>
                    <div>
                        <label for="">email address</label>
                        <input type="text" name="email_address" id="" required>
                    </div>
                    <div>
                        <label for="">DOB</label>
                        <input type="date" name="date_of_birth" id="" required>
                    </div>
                    <div>
                        <label for="">gender</label>
                        <select name="gender" id="">
                            <option value="m">male</option>
                            <option value="f">female</option>
                            <option value="o">other</option>
                        </select>
                    </div>
                    <div>
                        <label for="">address</label>
                        <textarea name="address" id=""></textarea>
                    </div>
                    <div>
                        <label for="">city</label>
                        <input type="text" name="city" id="">
                    </div>
                    <div>
                        <label for="">state</label>
                        <input type="text" name="state" id="">
                    </div>
                    <div>
                        <label for="">postel number</label>
                        <input type="number" name="postel_number" id="">
                    </div>
                    <div>
                        <label for="">country</label>
                        <input type="text" name="country">
                    </div>
                    <br>
                    <button type="submit" name="action" value="add_customer">Add</button>
                    <a href=""> cancel</a>
                </form>
            </div>
            <!-- want to implement -->
            <div class="update_customer" id="update_customer">
                    <h1>Update customer</h1>
                    <form action="action/crud.php" method="post" target="_self" enctype="application/x-www-form-urlencoded">
                        <div>
                            <label for="">customer name</label>
                            <select name="choose_product" id="">
                                
                            </select>
                        </div>
                        
                        <br>
                        <button type="submit" name="action" value="update_customer">update</button>
                        <a href=""> cancel</a>
                    </form>
            </div>
            <div class="delete_customer" id="delete_customer">
                    <h1>Delete customer</h1>
                        <form action="action/crud.php" method="post" target="_self" enctype="application/x-www-form-urlencoded">
                            <div>
                                <label for="">phone number</label>
                                <input type="number" name="phone_number" id="" required>
                            </div>
                            <button type="submit" name="action" value="delete_customer">delete</button>
                            <a href=""> cancel</a>
                        </form>
                </div>
            </div>
        </div>
    </div>
    <div class="body-content" id="order">
        <div class="operations">
            <a href="salesperson.php?option1=order&option2=add_order">Create</a>
            <a href="salesperson.php?option1=order&option2=update_order">Update</a>
        </div>
        <div class="actions">
            <div class="add_order" id="add_order">
                <h1>Add new order</h1>
                <form action="action/crud.php" method="post" target="_self" enctype="application/x-www-form-urlencoded">
                    <fieldset>
                        <legend>customer details</legend>
                        <div>
                            <!-- <label for="">customer number</label>
                            <input type="number" name="customer_number" placeholder="customer number" required>    -->
                            <label for="customer_number">customer number</label>
                            <select name="customer_number" id="customer_number" required>
                                <?php
                                foreach($sampleCustomerNumber as $data){
                                    echo"<option value='$data'>$data</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </fieldset>
                    <fieldset>
                            <legend>product details</legend>
                            <!-- <label for="">product name</label>
                            <input type="text" placeholder="product" name="search_product"value="<?= isset($_GET['search_product'])?$_GET['search_product']:''?>">
                            <a href="">search</a> -->
                            <div>
                            <label for="product_name">products</label>
                            <select name="product_name" id="product_name" required>
                                <?php
                                foreach($product_data as $data){
                                    echo"<option value='$data[product_name]'>$data[product_name]</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div>
                            <label for="count">quantity</label>
                            <input type="text" placeholder="quantity" name="count" id="count" value="1" required>
                        </div>
                        <div>
                            <label for="discount">discounts</label>
                            <input type="number" name="discount" id="discount" placeholder="percentage" value="0" required>
                        </div>    
                    </fieldset>
                <input type="text" name="user_id" value="<?=isset($_SESSION["user_id"])?$_SESSION["user_id"] : -1?>" hidden>
                <button type="submit" name="action" value="add_order">submit order</button>
                <a href="">cancel</a>
            </form>
            </div>
            <div class="update_order" id="update_order">
                    <h1>Update order</h1>
                    <form action="salesperson.php?option1=order&option2=update_order" method="post" target="_self">
                        <div>
                            <label for="">Customer number</label>
                            <input type="text" placeholder="search customer products" name="phone_number" value="<?php 
                                if(isset($post['phone_number']))
                                echo $post['phone_number'];
                            ?>">
                        </div>
                        <br>
                        <button type="submit" name="action" value="search_orders">Search</button>
                    </form>
                    
                    <form action="action/crud.php" method="post" target="_self" enctype="application/x-www-form-urlencoded">
                        <div>
                            <label for="">Customer ordered products</label>
                            <select name="customer_order_id" id="" required >
                                <option value="" disabled selected>No data</option>
                                <?php
                                    foreach($user_product_data as $data){
                                        echo "<option value='$data[order_id]' selected>$data[product_name]</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div>
                            <label for="">update status</label>
                            <select name="status" id="">
                                <option value="completed">Completed</option> 
                                <option value="cancelled">cancelled</option>
                            </select>
                        </div>
                        <input type="text" name="phone_number" value="<?php 
                            if(isset($post['phone_number']))
                            echo $post['phone_number'];
                        ?>" hidden>
                        <br>
                        <button type="submit" name="action" value="update_status">submit</button>
                    </form>
                    <!-- <div>
                        <table cellspacing ='0' cellpadding ='0' border="0" width="100%">
                            <tr>
                                <th>Customer Name</th>
                                <th>Phone Number</th>
                                <th>Ordered Product</th>
                                <th>Count</th>
                                <th>total Price</th>
                                <th>Status</th>
                            </tr>
                            
                        </table>
                    </div> -->
            </div>
        </div>
    </div>
</body>
</html>
<!-- <?php
// ob_flush();
?> -->