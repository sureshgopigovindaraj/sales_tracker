<?php
    session_start();
    // category product array 
    $category_query = "SELECT * FROM product_category ORDER BY category;";
    $data = [
        "query" =>$category_query,
        "action" =>"preparedQuery",
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
    $category_data = json_decode($resultSet,true);




    if(isset($_SESSION['role'])){
        if($_SESSION['role'] == 'admin'){
            unset($_SESSION['user_id']);
        }
    }

    $userId = isset($_SESSION['user_id'])? $_SESSION['user_id']:null;
    $profitPercentage=23;
    // $userId = null;
    // Array data
    $data = [
        "userid" =>$userId,
        "profitPercentage" => $profitPercentage,
        "action" => "retrieveArray",
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

    $fetchedArray = json_decode($resultSet,true);
    // print_r($fetchedArray);

    // total sales
    $summary_data['total_sales'] = $fetchedArray['total_sales'];
    
    // Total orders
    $summary_data['total_orders'] = $fetchedArray['total_orders'];
    
    
    // Total customers
    $summary_data['customers'] = $fetchedArray['customers'];

    // Total revenue
    $summary_data['revenue'] = $fetchedArray['revenue'];
    
    // Total loss data
    $summary_data['loss'] = $fetchedArray['loss'];
    
    // list all array
    $list_data = $fetchedArray['listAllArray'];
    
    // Completed array 
    $completed_status_array = $fetchedArray['completedArray'];
    
    // pending array
    $pending_status_array = $fetchedArray['pendingArray'];
    
    // cancelled array
    $cancelled_status_array = $fetchedArray['cancelledArray'];

    // loss data;
    $loss_data = $fetchedArray['lossData'];

    // Profits both admin and salesperson
    $summary_data['profit'] = $summary_data['revenue']*($profitPercentage/100);



    // print_r($loss_data);
    foreach($loss_data as $loss){
        foreach($list_data as $key => $list){
            if($loss['r_product_id'] == $list['r_product_id']){
                $list_data[$key]["loss"] = $loss["loss"];
                continue;
            }
            !isset($list_data[$key]["loss"])?$list_data[$key]["loss"] ="-":'';
        }
    }

    //customer array for update data for select option

    $customerQuery = "SELECT customer_id,phone_number FROM customer_details;";
    $data = [
        "query" =>$customerQuery,
        "action" =>"preparedQuery",
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
    $customer_data = json_decode($resultSet,true);
    // print_r($customer_data);


    // product array for update data for select option
    $productQuery = "SELECT product_id,product_name FROM product_details;";
    $data = [
        "query" =>$productQuery,
        "action" =>"preparedQuery",
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
    $product_data = json_decode($resultSet,true);
    // print_r($product_data);

?>