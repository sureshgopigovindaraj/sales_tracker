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

    class ConnectMysql{
        private $dsn ;
        private $userName;
        private $password;


        public function __construct(){
            $this->dsn = "mysql:host=localhost;dbname=sales_tracker;port=4306";
            $this->userName = "root";
            $this->password = "";
        }
        public function getConnection(){
            $conn = new PDO($this->dsn,$this->userName,$this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            return $conn;
        }
    }

    // PDO method


    // $dsn = "mysql:host=localhost;dbname=sales_tracker;port=4306";
    // $userName = "root";
    // $password = "";
    $obj = new ConnectMysql();
    $conn = $obj->getConnection();
    




?>