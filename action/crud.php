<?php

    // this is the file to insert update and delete data from databases and this relocate to previous page using header
    include_once("../config/connect_mysql.php");
    require "../curl.php";
    session_start();

    if(!isset($_POST['action'])){
        setcookie("result","Server Error",time()+15,"/php/Infi/Sales%20Tracker/dev/salesperson.php");
        die;
    }

    $data =json_encode($_POST);
    $action = $_POST['action'];
    $result = $curlObj -> store($data, $action);
    setcookie("result",$result,time()+15,"/php/Infi/Sales%20Tracker/dev/salesperson.php");

    
    //add new product
    if($_POST['action'] =='add_product'){
        header("location:../salesperson.php?option1=product&option2=create_product");
        return;
    }

    // update product details
    if($_POST['action'] =='update_product'){
        header("location:../salesperson.php?option1=product&option2=update_product");
        return;
    }

    // update stock count
    if($_POST['action'] =='add_stock' ){
        header("location:../salesperson.php?option1=product&option2=add_stocks");
        return;
    }
        
        // delete product
    if($_POST['action'] =='delete_product'){
        header("location:../salesperson.php?option1=product&option2=delete_product");
        return;
    }
        
        
    // Add new customer
    if($_POST['action'] =='add_customer'){
        header("location:../salesperson.php?option1=customer&option2=create_customer");
        return;
    }

    // delete customer
    if($_POST['action'] =='delete_customer'){
        header("Location:../salesperson.php?option1=customer&option2=delete_customer");
        return;
    }
        


    // Add new Order
    if($_POST['action'] =='add_order'){
        header("location:../salesperson.php?option1=order&option2=add_order");
        return;

    }

    // Update orders status
    if($_POST['action'] =='update_status'){
        header("location:../salesperson.php?option1=order&option2=update_order");
        return;
    }



?>