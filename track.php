<?php
require_once("array_data.php");
// error_reporting(0);

if(empty($_SESSION)){
    header("location:login.php");
    return;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Tracker</title>
    <link rel="stylesheet" href="assets/styles/bootstrap.min.css">
    <link rel="stylesheet" href="assets/styles/trackstyle.css">
    <link rel="stylesheet" href="assets/styles/all.min.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="header">
                    <?php if(isset($_SESSION["role"]))
                            echo (($_SESSION['role']=="salesperson") ? "<a href='salesperson.php'><em class='fa-regular fa-circle-left'></em></a>": '');

                    ?>
                    <h1>Sales tracker</h1>
                    <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> logout</a>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-sm-12">
                <div class="body_content">
                    <div class="row">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-10">
                            <div class="filter">
                                <form action="">
                                <!-- form for filter bases on month -->
                                    <label for=""><b>sort by</b>
                                        <select name="" id="">
                                            <option value="">All</option>
                                            <option value="<?php echo date("Y/m/d") ?>">Today</option>
                                            <option value="<?php echo date("Y/m/d",strtotime("last week")) ?>">Last one week</option>
                                            <option value="<?php echo date("Y/m/d",strtotime("last month")) ?>">Last one month</option>
                                        </select>
                                    </label>
                                <!-- filter based on category -->
                                    <label for=""><b>category</b>
                                        <select name="" id="">
                                            <option value="">All</option>
                                            <?php 
                                            foreach($category_data as $data){
                                                echo "<option value='$data[category]'>$data[category]</option>";
                                            }
                                            
                                            ?>
                                        </select>
                                    </label>
                                <!-- form for filter bases on status -->
                                    <label for=""><b>Status</b>
                                        <select name="" id="">
                                            <option value="">All</option>
                                            <option value="">Completed</option>
                                            <option value="">Pending</option>
                                            <option value="">Cancelled</option>
                                        </select>
                                    </label>
                                    <button type="submit" class="btn btn-success filter_button">filter</button>
                                </form>
                                <form action="">
                                    <label for="">filter by range</label>

                                    <!-- <select name="" id="">
                                        <option value="">Day</option>
                                        <option value="">Week</option>
                                        <option value="">Month</option>
                                        <option value="">Range</option>
                                    </select> -->
                                </form>
                            </div>
                        </div>
                        <div class="col-sm-1"></div>
                    </div>
                    
                    
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-12 sales_head">
                                    <h1>Sales and Revenue</h1>
                                </div>
                            </div>
                            <div class="summary">
                                <div>
                                    <h1>Total sales</h1><b><?= empty($fetchedArray['total_sales']) ? "0" : $fetchedArray['total_sales'] ?></b>
                                </div>
                                <div>
                                    <h1>orders</h1><b><?= empty($fetchedArray['total_orders']) ? "0" : $fetchedArray['total_orders'] ?></b>
                                </div>
                                <div>
                                    <h1>customers</h1><b><?= empty($fetchedArray['customers']) ? "0" : $fetchedArray['customers'] ?></b>
                                </div>
                                <div>
                                    <h1>Revenue</h1><b><?= empty($fetchedArray['revenue']) ? "0" : $fetchedArray['revenue'] ?></b>
                                </div>
                                <div>
                                    <h1>Profit</h1><b><?= empty($fetchedArray['profit']) ? "0" : $fetchedArray['profit'] ?></b>
                                </div>
                                <div>
                                    <h1>loss</h1><b><?= empty($fetchedArray['loss']) ? "0" : $fetchedArray['loss'] ?></b>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="body-table">
                            <!-- Sales table -->
                            <div class="all">
                                <h2>All</h2>
                                <table cellspacing ='0' cellpadding ='0' border="0" width="" class="table-header">
                                    <tr>
                                        <th>Product name</th>
                                        <th>category</th>
                                        <th>sales count</th>
                                        <th>customer count</th>
                                        <th>Revenue</th>
                                        <th>Profit</th>
                                        <th>loss</th>
                                    </tr>
                                    <?php
                                    if(!empty($fetchedArray['listAllArray'])){
                                        foreach($fetchedArray['listAllArray'] as $list){
                                            echo "<tr>";
                                            echo"<td>$list[product_name]</td>";
                                            echo"<td>$list[product_category]</td>";
                                            echo"<td>$list[sales_count]</td>";
                                            echo"<td>$list[customers_count]</td>";
                                            echo"<td>$list[revenue]</td>";
                                            echo"<td>$list[profit]</td>";
                                            echo"<td>".(isset($list["loss"]) ? $list["loss"] : "0")."</td>";
                                            echo "</tr>";

                                        }
                                    }
                                    else{
                                        echo"<tr>
                                            <td colspan='7' align='center'>No products</td>
                                        </tr>";
                                    }

                                    ?>
                                </table>
                            </div>
                            <div class="completed">
                                <h2 class="text-success">completed</h2>
                                <table cellspacing ='0' cellpadding ='0' border="0" width="" class="table-header">
                                    <tr>
                                        <th>Product name</th>
                                        <th>category</th>
                                        <th>sales count</th>
                                        <th>customer count</th>
                                        <th>Revenue</th>
                                        <th>Profit</th>
                                    </tr>
                                    <?php
                                    if(!empty($fetchedArray['completedArray'])){
                                        foreach($fetchedArray['completedArray'] as $list){
                                            echo "<tr>";
                                            echo"<td>$list[product_name]</td>";
                                            echo"<td>$list[product_category]</td>";
                                            echo"<td>$list[sales_count]</td>";
                                            echo"<td>$list[customers_count]</td>";
                                            echo"<td>$list[revenue]</td>";
                                            echo"<td>$list[profit]</td>";
                                            echo "</tr>";

                                        }
                                    }
                                    else{
                                        echo"<tr>
                                            <td colspan='6' align='center'>No completed status products</td>
                                        </tr>";
                                    }
                                    ?>
                                </table>
                            </div>
                            
                            <div class="pending">
                                <h2 class="text-warning">Pending</h2>
                                <table cellspacing ='0' cellpadding ='0' border="0" width="">
                                    <tr>
                                        <th>Product name</th>
                                        <th>category</th>
                                        <th>sales count</th>
                                        <th>customer count</th>
                                        <th>Revenue</th>
                                        <th>pending amount</th>
                                    </tr>
                                    <?php
                                    if(!empty($fetchedArray['pendingArray'])){
                                        foreach($fetchedArray['pendingArray'] as $list){
                                            echo "<tr>";
                                            echo"<td>$list[product_name]</td>";
                                            echo"<td>$list[product_category]</td>";
                                            echo"<td>$list[sales_count]</td>";
                                            echo"<td>$list[customers_count]</td>";
                                            echo"<td>$list[revenue]</td>";
                                            echo"<td>$list[profit]</td>";
                                            echo "</tr>";

                                        }
                                    }
                                    else{
                                        echo"<tr>
                                            <td colspan='6' align='center'>No pending status products</td>
                                        </tr>";
                                    }
                                    ?>
                                </table>
                            </div>
                            
                            <div class="cancelled">
                                    <h2 class="text-danger">Cancelled</h2>
                                    <table cellspacing ='0' cellpadding ='0' border="0" width="">
                                    <tr>
                                        <th>Product name</th>
                                        <th>category</th>
                                        <th>sales count</th>
                                        <th>customer count</th>
                                        <th>Revenue</th>
                                        <th>Loss</th>
                                    </tr>
                                    <?php
                                    if(!empty($fetchedArray['cancelledArray'])){
                                        foreach($fetchedArray['cancelledArray'] as $list){
                                            echo "<tr>";
                                            echo"<td>$list[product_name]</td>";
                                            echo"<td>$list[product_category]</td>";
                                            echo"<td>$list[sales_count]</td>";
                                            echo"<td>$list[customers_count]</td>";
                                            echo"<td>$list[revenue]</td>";
                                            echo"<td>$list[loss]</td>";
                                            echo "</tr>";

                                        }
                                    }
                                    else{
                                        echo"<tr>
                                            <td colspan='6' align='center'>No cancel status products</td>
                                        </tr>";
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        
        
    </div>

</body>
</html>