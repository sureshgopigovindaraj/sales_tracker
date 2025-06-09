<?php
    session_start();
    require "curl.php";

    // category product array 
    $category_query = "SELECT * FROM product_category ORDER BY category;";
    $category_data = $curlObj->retrive($category_query,"preparedQuery");

    if(isset($_SESSION['role'])){
        if($_SESSION['role'] == 'admin'){
            unset($_SESSION['user_id']);
        }
    }

    $userId = isset($_SESSION['user_id'])? $_SESSION['user_id']:null;
    $profitPercentage=23;
   
    // Array data
    $fetchedArray = $curlObj -> retrive($userId,"retrieveArray");

    // Profits both admin and salesperson
    $fetchedArray['profit'] = $fetchedArray['revenue'] *($profitPercentage/100);

    // print_r($fetchedArray['lossData']);
    foreach($fetchedArray['lossData'] as $loss){
        foreach($fetchedArray['listAllArray'] as $key => $list){
            if($loss['r_product_id'] == $list['r_product_id']){
                $fetchedArray['listAllArray'][$key]["loss"] = $loss["loss"];
                continue;
            }
            !isset($fetchedArray['listAllArray'][$key]["loss"])?$fetchedArray['listAllArray'][$key]["loss"] ="-":'';
        }
    }

    //customer array for update data for select option
    $customerQuery = "SELECT customer_id,phone_number FROM customer_details;";
    $customer_data = $curlObj ->retrive($customerQuery,"preparedQuery");

    // product array for update data for select option
    $productQuery = "SELECT product_id,product_name FROM product_details;";
    $product_data = $curlObj ->retrive($productQuery,"preparedQuery");
?>