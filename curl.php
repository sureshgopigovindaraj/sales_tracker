<?php

    // require_once("config/connect_mysql.php");


    class Fetch{
        // private $conn;

        // public function __construct()
        // {
        //     $obj = new ConnectMysql();
        //     $this->conn = $obj->getConnection();
        // }
        
        public function retrive($data, $action){
            $dataArr = [
            "data" =>$data,
            "action" =>$action,
            ];

            $curl = curl_init();
            $curlData = [
            CURLOPT_URL =>"http://localhost/php/Infi/Sales%20Tracker/dev/server/crud.php",
            CURLOPT_ENCODING =>'',
            CURLOPT_RETURNTRANSFER =>true,
            CURLOPT_POST =>true,
            CURLOPT_POSTFIELDS =>$dataArr,
            ];
            curl_setopt_array($curl,$curlData);
            $resultSet = curl_exec($curl);
            return json_decode($resultSet,true);
        }
        public function store($data, $action){
            $dataArr = [
            "data" =>$data,
            "action" =>$action,
            ];

            $curl = curl_init();
            $curlData = [
            CURLOPT_URL =>"http://localhost/php/Infi/Sales%20Tracker/dev/server/crud.php",
            CURLOPT_ENCODING =>'',
            CURLOPT_RETURNTRANSFER =>true,
            CURLOPT_POST =>true,
            CURLOPT_POSTFIELDS =>$dataArr,
            ];
            curl_setopt_array($curl,$curlData);
            return curl_exec($curl);
        }
    }

    $curlObj = new Fetch();






?>