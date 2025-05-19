<?php


    // mysqli procedure method

    // $host ="localhost";
    // $user_name = "root";
    // $pass = "";
    // $db_name = "sales_tracker";
    // $port = 4306;
    // $conn = mysqli_connect($host, $user_name, $pass, $db_name,$port);

    // if($conn == false){
    //     die("Database connection error!");
    // }


    // PDO method


    $dsn = "mysql:host=localhost;dbname=sales_tracker;port=4306";
    $userName = "root";
    $password = "";

    $conn = new PDO($dsn,$userName,$password);
    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);




?>