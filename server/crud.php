<?php
    //include mysql connection
    require("../config/connect_mysql.php");

    if(!isset($_POST) or empty($_POST))
    {
        die("Server Error");
    }

    if(!isset($_POST['action'])){
        die("Server Error");
    }



    // login email verification
    
    if($_POST['action'] == 'emailVerification'){
        $email_address = $_POST['data'];

        $userQuery = "SELECT user_id,first_name,last_name,phone_number,email_address,password,role FROM user_details WHERE email_address = ?";
        $stmt = $conn->prepare($userQuery);
        $stmt->bindParam(1,$email_address);
        $stmt->execute();
        $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($user_data);
        return;


    }

    // login email verification

    if($_POST['action'] == 'createUser'){
        $data = json_decode($_POST['data'],true);
        $firstName = $data["firstName"];
        $lastName = $data["lastName"];
        $phoneNumber = $data["phoneNumber"];
        $emailAddress = $data["emailAddress"];
        $password = $data["password"];
        $role = $data["role"];

        $insertQuery = "INSERT INTO user_details (first_name,last_name,phone_number,email_address,password,role) VALUES(
        ?,?,?,?,?,?);";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bindParam(1,$firstName);
        $stmt->bindParam(2,$lastName);
        $stmt->bindParam(3,$phoneNumber);
        $stmt->bindParam(4,$emailAddress);
        $stmt->bindParam(5,$password);
        $stmt->bindParam(6,$role);
        if(!$stmt ->execute()){
            die("insertion error");
        }

        // get user id from database
        $userQuery = "SELECT user_id,first_name,last_name,phone_number,email_address,role FROM user_details WHERE email_address = ?";
        $stmt = $conn->prepare($userQuery);
        $stmt->bindParam(1,$emailAddress);
        $stmt->execute();
        $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($user_data);
        return;
    
    }





    
    // Add new product in db
    if($_POST['action'] == 'add_product'){
        $data = json_decode($_POST['data'],true);

        $product_name = $data['product_name'];
        $description = $data['description'];
        $price = $data['price'];
        $category = $data['category'];
        $stock_count = $data['stock_count'];

        $productQuery ="INSERT INTO  product_details(product_name,description,price,last_updates,r_product_category_id, stock_count ) VALUES(?,?,?,NOW(),
        (select product_category_id from product_category where category = ?),?);";

        $stmt = $conn->prepare($productQuery);
        $stmt->bindParam(1,$product_name);
        $stmt->bindParam(2,$description);
        $stmt->bindParam(3,$price);
        $stmt->bindParam(4,$category);
        $stmt->bindParam(5,$stock_count);
        $stmt->execute();
        echo "Product Inserted successfully";
        return;
    }
    
    // Update product in db
    if($_POST['action'] == 'update_product'){
        $data = json_decode($_POST['data'],true);

        $product_id = $data['choose_product'];
        $product_name = $data['product_name'];
        $description = $data['description'];
        $price = $data['price'];
        $category = $data['category']; 

        $updateProductQuery = "UPDATE product_details SET product_name = ? , description = ?, price = ?, last_updates = NOW(),r_product_category_id = ? WHERE product_id = ?";

        $stmt = $conn->prepare($updateProductQuery);
        $stmt->bindParam(1,$product_name);
        $stmt->bindParam(2,$description);
        $stmt->bindParam(3,$price);
        $stmt->bindParam(4,$category);
        $stmt->bindParam(5,$product_id);
        $stmt->execute();
        echo "Product updated successfully";
        return;
    }


    // add product stock in db
    if($_POST['action'] == 'add_stock'){
        $data = json_decode($_POST['data'],true);

        $product_id = $data['choose_product'];
        $stock_count = $data['stock_count'];

        $addStockQuery = "UPDATE product_details SET stock_count = (stock_count+?), last_updates = NOW() WHERE product_id = ?";

        $stmt = $conn->prepare($addStockQuery);
        $stmt->bindParam(1,$stock_count);
        $stmt->bindParam(2,$product_id);
        $stmt->execute();
        echo "stock added successfully";
        return;
    }

    // add product stock in db
    if($_POST['action'] == 'delete_product'){
        $data = json_decode($_POST['data'],true);

        $delete_id = $data['delete_id'];

        $deleteQuery = "DELETE FROM product_details where product_id = ?;";
        $stmt = $conn->prepare($deleteQuery);
        $stmt ->bindParam(1,$delete_id);
        $stmt->execute();
        echo "Product deleted successfully";
        return;
    }


    // add new customer 
    if($_POST['action'] == 'add_customer'){
        $data = json_decode($_POST['data'],true);
        $first_name = $data['first_name'];
        $last_name = $data['last_name'];
        $phone_number = $data['phone_number'];
        $email_address = $data['email_address'];
        $date_of_birth = $data['date_of_birth'];
        $gender = $data['gender'];
        $address = $data['address'];
        $city = $data['city'];
        $state = $data['state'];
        $postel_number = $data['postel_number'];
        $country = $data['country'];
        
        
        $customerQuery = "INSERT INTO customer_details(first_name,last_name, phone_number, email_address,date_of_birth,gender,address,city,state,postel_number, country)VALUES(?,?,?,?,?,?,?,?,?,?,?);";

        $stmt = $conn->prepare($customerQuery);
        $stmt->bindParam(1,$first_name);
        $stmt->bindParam(2,$last_name);
        $stmt->bindParam(3,$phone_number);
        $stmt->bindParam(4,$email_address);
        $stmt->bindParam(5,$date_of_birth);
        $stmt->bindParam(6,$gender);
        $stmt->bindParam(7,$address);
        $stmt->bindParam(8,$city);
        $stmt->bindParam(9,$state);
        $stmt->bindParam(10,$postel_number);
        $stmt->bindParam(11,$country);

        $stmt->execute();
        echo "New customer added successfully";
        return;


    }

    // delete customer 
    if($_POST['action'] == 'delete_customer'){
        $data = json_decode($_POST['data'],true);

        $phone_number = $data['phone_number'];
        $deleteQuery = "DELETE FROM customer_details where phone_number = ?;";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bindParam(1,$phone_number);

        $stmt -> execute();
        echo "customer deleted successfully";
        return;
    }


    // Add new order 
    if($_POST['action'] == 'add_order'){
        $data = json_decode($_POST['data'],true);

        $customer_number = $data['customer_number'];
        $product_name = $data['product_name'];
        $count = $data['count'];
        $discount = $data['discount'];
        $userId = $data["user_id"];


        $insertQuery = "INSERT INTO order_details(r_customer_id,r_product_id,count,total_price,order_date,status,updated_date, r_user_id ) VALUES
        ((SELECT customer_id FROM customer_details WHERE phone_number = ?),
        (SELECT product_id FROM product_details WHERE product_name = ?),
        ?,
        (SELECT (?*(price-((price)*?/100))) FROM product_details WHERE product_name = ?),
        NOW(),
        'pending',
        NOW(),
        ?);";

        $stmt = $conn->prepare($insertQuery);

        $stmt->bindParam(1,$customer_number);
        $stmt->bindParam(2,$product_name);
        $stmt->bindParam(3,$count);
        $stmt->bindParam(4,$count);
        $stmt->bindParam(5,$discount);
        $stmt->bindParam(6,$product_name);
        $stmt->bindParam(7,$userId);

        $stmt->execute();
        echo "New order added";


        
        // reduce the stock count
        $reduceStockQuery = "UPDATE product_details SET stock_count = (stock_count - ?) where  product_name = ?;";

        $stmt = $conn->prepare($reduceStockQuery);

        $stmt -> bindParam(1,$count);
        $stmt -> bindParam(2,$product_name);
        $stmt -> execute();
        return;


    }
    // Search order by phone number
    if($_POST['action'] == 'search_orders'){
        $phone_number = $_POST['data'];
        $userProductQuery = "SELECT order_id,product_name FROM order_details AS od LEFT JOIN customer_details AS cd ON od.r_customer_id = cd.customer_id LEFT JOIN product_details AS pd ON od.r_product_id = pd.product_id WHERE cd.phone_number = ? AND od.status ='pending';";
        $stmt = $conn->prepare($userProductQuery);
        $stmt->bindParam(1,$phone_number);
        $stmt->execute();
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        return;

    }
    
    // Update order
    if($_POST['action'] == 'update_status'){
        $data = json_decode($_POST['data'],true);

        $order_id = $data['customer_order_id'];
        $status = $data['status'];


        $updateOrderQuery = "UPDATE order_details SET status = ?, updated_date = NOW() where order_id = ?;";
        $stmt = $conn->prepare($updateOrderQuery);
        $stmt->bindParam(1,$status);
        $stmt->bindParam(2,$order_id);
        $stmt -> execute();
        echo "order updated successfully";
        return;
    }






    // Array data for prepared query
    if($_POST['action'] == 'preparedQuery'){
        $resultSet = $conn->query($_POST['query']);
        $array = $resultSet->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($array);
        return;
    }

    
    if($_POST['action'] == 'retrieveArray' & $_POST['userid']!=null){
        $userId = $_POST['userid'];
        $profitPercentage = $_POST['profitPercentage'];

        $arrQuery = "";

        // total sales
        $totalSalesQuery = "SELECT SUM(count) AS total_sales FROM order_details WHERE r_user_id = ?;";

        $stmt = $conn->prepare($totalSalesQuery);
        $stmt->bindParam(1,$userId);
        $stmt->execute();
        $array["total_sales"] = $stmt->fetch(PDO::FETCH_COLUMN);

        // Total orders
        $totaOrderQuery = "SELECT COUNT(order_id) AS total_orders FROM order_details WHERE r_user_id = ?;";
        $stmt = $conn->prepare($totaOrderQuery);
        $stmt->bindParam(1,$userId);
        $stmt->execute();
        $array["total_orders"] = $stmt->fetch(PDO::FETCH_COLUMN);

        // Total customers
        
        
        $customersQuery = "SELECT COUNT(DISTINCT(r_customer_id)) AS customers FROM order_details WHERE r_user_id = ?;";
        $stmt = $conn->prepare($customersQuery);
        $stmt->bindParam(1,$userId);
        $stmt->execute();
        $array["customers"] = $stmt->fetch(PDO::FETCH_COLUMN);

        // Total revenue

        $revenueQuery = "SELECT SUM(total_price) AS revenue FROM order_details WHERE r_user_id = ?;";
        $stmt = $conn->prepare($revenueQuery);
        $stmt->bindParam(1,$userId);
        $stmt->execute();
        $array["revenue"] = $stmt->fetch(PDO::FETCH_COLUMN);


        // Total loss data

        $lossQuery = "SELECT SUM(total_price) AS loss FROM order_details WHERE status = 'cancelled' AND r_user_id = ?;";
        $stmt = $conn->prepare($lossQuery);
        $stmt->bindParam(1,$userId);
        $stmt->execute();
        $array['loss'] = $stmt->fetch(PDO::FETCH_COLUMN);


        // list all array
        
        $listQuery = "SELECT r_product_id,product_name, pc.category AS product_category,SUM(count) AS sales_count,COUNT(DISTINCT(r_customer_id)) AS customers_count, SUM(total_price) AS revenue, (SUM(total_price)*(?/100)) AS profit FROM order_details AS od LEFT JOIN product_details AS pd ON od.r_product_id = pd.product_id LEFT JOIN product_category AS pc ON pd.r_product_category_id = pc.product_category_id WHERE r_user_id = ? GROUP BY product_name ORDER BY sales_count DESC;";
        
        $stmt = $conn->prepare($listQuery);
        $stmt->bindParam(1,$profitPercentage);
        $stmt->bindParam(2,$userId);
        $stmt->execute();
        $array['listAllArray'] = $stmt->fetchALl(PDO::FETCH_ASSOC);

        // Completed array 

        $completedStatusQuery = "SELECT r_product_id,product_name, pc.category AS product_category,SUM(count) AS sales_count,COUNT(DISTINCT(r_customer_id)) AS customers_count, SUM(total_price) AS revenue, (SUM(total_price)*(?/100)) AS profit FROM order_details AS od LEFT JOIN product_details AS pd ON od.r_product_id = pd.product_id LEFT JOIN product_category AS pc ON pd.r_product_category_id = pc.product_category_id WHERE status  = 'completed' AND r_user_id = ? GROUP BY product_name ORDER BY sales_count DESC ;";
        
        $stmt = $conn->prepare($completedStatusQuery);
        $stmt->bindParam(1,$profitPercentage);
        $stmt->bindParam(2,$userId);
        $stmt->execute();
        $array['completedArray'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // pending array

        $pendingStatusQuery = "SELECT r_product_id,product_name, pc.category AS product_category,SUM(count) AS sales_count,COUNT(DISTINCT(r_customer_id)) AS customers_count, SUM(total_price) AS revenue, (SUM(total_price)*(?/100)) AS profit FROM order_details AS od LEFT JOIN product_details AS pd ON od.r_product_id = pd.product_id LEFT JOIN product_category AS pc ON pd.r_product_category_id = pc.product_category_id WHERE status  = 'pending'AND r_user_id = ? GROUP BY product_name ORDER BY sales_count DESC ;";
        
        $stmt = $conn->prepare($pendingStatusQuery);
        $stmt->bindParam(1,$profitPercentage);
        $stmt->bindParam(2,$userId);
        $stmt->execute();
        $array['pendingArray'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // cancelled array
        
        $cancelledStatusQuery = "SELECT r_product_id,product_name, pc.category AS product_category,SUM(count) AS sales_count,COUNT(DISTINCT(r_customer_id)) AS customers_count, SUM(total_price) AS revenue, SUM(total_price) AS loss FROM order_details AS od LEFT JOIN product_details AS pd ON od.r_product_id = pd.product_id LEFT JOIN product_category AS pc ON pd.r_product_category_id = pc.product_category_id WHERE status  = 'cancelled' AND r_user_id = ? GROUP BY product_name ORDER BY sales_count DESC ;";
        
        $stmt = $conn->prepare($cancelledStatusQuery);
        $stmt->bindParam(1,$userId);
        $stmt->execute();
        $array['cancelledArray'] = $stmt->fetchAll(PDO::FETCH_ASSOC);


        // loss data;
        
        $lossResultQuery = "SELECT r_product_id,SUM(total_price) AS loss FROM order_details WHERE status = 'cancelled' AND r_user_id = ? GROUP BY r_product_id;";
        $stmt = $conn->prepare($lossResultQuery);
        $stmt->bindParam(1,$userId);
        $stmt->execute();
        $array['lossData'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($array);
        return;

    }elseif($_POST['userid'] == null){

        
        $profitPercentage = $_POST['profitPercentage'];
        
        // total sales
        $totalSalesQuery = "SELECT SUM(count) AS total_sales FROM order_details;";
        $resultSet = $conn->query($totalSalesQuery);
        $array['total_sales'] = $resultSet->fetch(PDO::FETCH_COLUMN);
        
        // Total orders
        
        
        $totaOrderQuery = "SELECT COUNT(order_id) AS total_orders FROM order_details;";
        $resultSet = $conn->query($totaOrderQuery);
        $array['total_orders'] = $resultSet->fetch(PDO::FETCH_COLUMN);
        
        
        // Total customers
        
        $customersQuery = "SELECT COUNT(DISTINCT(r_customer_id)) AS customers FROM order_details;";
        $resultSet = $conn->query($customersQuery);
        $array['customers'] = $resultSet->fetch(PDO::FETCH_COLUMN);

        // Total revenue
        
        $revenueQuery = "SELECT SUM(total_price) AS revenue FROM order_details;";
        $resultSet = $conn->query($revenueQuery);
        $array['revenue'] = $resultSet->fetch(PDO::FETCH_COLUMN);
        
        // Total loss data
        
        $lossQuery = "SELECT SUM(total_price) AS loss FROM order_details WHERE status = 'cancelled';";
        $resultSet = $conn->query($lossQuery);
        $array['loss'] = $resultSet->fetch(PDO::FETCH_COLUMN);
        
        // list all array
        
        $listQuery = "SELECT r_product_id,product_name, pc.category AS product_category,SUM(count) AS sales_count,COUNT(DISTINCT(r_customer_id)) AS customers_count, SUM(total_price) AS revenue, (SUM(total_price)*(23/100)) AS profit FROM order_details AS od LEFT JOIN product_details AS pd ON od.r_product_id = pd.product_id LEFT JOIN product_category AS pc ON pd.r_product_category_id = pc.product_category_id GROUP BY product_name ORDER BY sales_count DESC;";
        
        $resultSet = $conn->query($listQuery);
        $array['listAllArray'] = $resultSet->fetchAll(PDO::FETCH_ASSOC);
        
        // Completed array 
        
        $completedStatusQuery = "SELECT r_product_id,product_name, pc.category AS product_category,SUM(count) AS sales_count,COUNT(DISTINCT(r_customer_id)) AS customers_count, SUM(total_price) AS revenue, (SUM(total_price)*(23/100)) AS profit FROM order_details AS od LEFT JOIN product_details AS pd ON od.r_product_id = pd.product_id LEFT JOIN product_category AS pc ON pd.r_product_category_id = pc.product_category_id WHERE status  = 'completed' GROUP BY product_name ORDER BY sales_count DESC ;";
        
        $resultSet = $conn->query($completedStatusQuery);
        $array['completedArray'] = $resultSet->fetchAll(PDO::FETCH_ASSOC);
        
        // pending array
        
        
        $pendingStatusQuery = "SELECT r_product_id,product_name, pc.category AS product_category,SUM(count) AS sales_count,COUNT(DISTINCT(r_customer_id)) AS customers_count, SUM(total_price) AS revenue, (SUM(total_price)*(?/100)) AS profit FROM order_details AS od LEFT JOIN product_details AS pd ON od.r_product_id = pd.product_id LEFT JOIN product_category AS pc ON pd.r_product_category_id = pc.product_category_id WHERE status  = 'pending' GROUP BY product_name ORDER BY sales_count DESC ;";
        $stmt = $conn->prepare($pendingStatusQuery);
        $stmt->bindParam(1,$profitPercentage);
        $stmt->execute();
        
        $array['pendingArray'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // cancelled array
        
        
        $cancelledStatusQuery = "SELECT r_product_id,product_name, pc.category AS product_category,SUM(count) AS sales_count,COUNT(DISTINCT(r_customer_id)) AS customers_count, SUM(total_price) AS revenue, SUM(total_price) AS loss FROM order_details AS od LEFT JOIN product_details AS pd ON od.r_product_id = pd.product_id LEFT JOIN product_category AS pc ON pd.r_product_category_id = pc.product_category_id WHERE status  = 'cancelled' GROUP BY product_name ORDER BY sales_count DESC ;";
        
        $resultSet = $conn->query($cancelledStatusQuery);
        $array['cancelledArray'] = $resultSet->fetchAll(PDO::FETCH_ASSOC);

        // loss data;
        
        
        $lossResultQuery = "SELECT r_product_id,SUM(total_price) AS loss FROM order_details WHERE status = 'cancelled' GROUP BY r_product_id;";
        $resultSet = $conn->query($lossResultQuery);
        
        $array['lossData'] = $resultSet->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($array);
        return;
    }






?>