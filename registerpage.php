<?php
    session_start();
    ob_start();
    require_once("curl.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>create account</title>
    <link rel="stylesheet" href="assets/styles/login.css">
    <link rel="stylesheet" href="assets/styles/register.css">
</head>
<body>
    <div class="registerpage">
        <form action="registerpage.php" method="post" target="_self" enctype="application/x-www-form-urlencoded">
            <h1>Create an account</h1>
            <div>
                <div>
                    <label for="">First name</label>
                    <input type="text" name="firstName" id="" required>
                </div>
                <div>
                    <label for="">Last name</label>
                    <input type="text" name="lastName" id="">
                </div>
                <div>
                    <label for="">phone number</label>
                    <input type="number" name="phoneNumber" id="" required>
                </div>
                <div>
                    <label for="">email address</label>
                    <input type="email" name="emailAddress" id="" required>
                </div>
                <div>
                    <label for="">Password</label>
                    <input type="password" name="password" id="" required>
                </div>
                <div class="role">
                    <label for="salesperson"><input type="radio" name="role" id="salesperson" value="salesperson" required >Sales Person</label>
                    <label for="admin"><input type="radio" name="role" id="admin" value="admin" required>Admin</label>
                    <!-- <a href="registerpage.php?role=0">salesperson</a>
                    <a href="registerpage.php?role=1">admin</a> -->
                </div>
                <!-- <input type="text" name="role" value="<?php if(isset($_GET['role']))echo ((($_GET['role'])==0) ?'salesperson': "admin"); else echo "salesperson"?>" hidden> -->
                <button type="submit">create</button>
                <div class="login">
                    <b>Already have an account?</b><a href="login.php">login</a>
                </div>
            </div>
        </form>
    </div>
<?php
    // echo"<pre>";

    if(empty($_POST)){
        return;
    }
    // to get value for verification
    $data = $_POST['emailAddress'];
    $action = "emailVerification";
    $userData = $curlObj ->retrive($data, $action);

    if(!empty($userData)){
        echo "This email is already exists";
        return;
    }

    // insert new user and take value
    print_r($_POST);
    $data = json_encode($_POST);
    $action = "createUser";
    $user_data = $curlObj ->retrive($data,$action);
    if(!empty($user_data)){
        $_SESSION['user_id'] = $user_data['user_id'];
        $_SESSION['first_name'] = $user_data['first_name'];
        $_SESSION['last_name'] = $user_data['last_name'];
        $_SESSION['phone_number'] = $user_data['phone_number'];
        $_SESSION['email_address'] = $user_data['email_address'];
        $_SESSION['role'] = $user_data['role'];
        print_r($_SESSION);
        print_r($user_data);
        die;
        if($user_data['role']=='admin'){
            header("location:track.php");
            return;
        }
        header("location:salesperson.php");
        return;
    }

ob_flush();
?>


</body>
</html>
