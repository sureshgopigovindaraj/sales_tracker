<?php
    session_start();
    require_once("curl.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales tracker Login</title>
    <link rel="stylesheet" href="assets/styles/login.css">
</head>
<body>
    <div class="loginpage">
        <form action="login.php" method="post" target="_self">
            <h1>login</h1>
            <div>
                <label for="email_address">Email address</label>
                <input type="email" name="emailAddress" id="email_address" value="<?= isset($_COOKIE['emailAddress'])? $_COOKIE['emailAddress'] : ''?>" required>
                <h4><?= (isset($_GET['mailError']) ? $_GET['mailError']:"" )?></h4>
            </div>
            <div>
                <label for="password">password</label>
                <input type="password" id="password" name="password" value="<?= isset($_COOKIE['password'])? $_COOKIE['password'] : ''?>" required>
                <h4><?= (isset($_GET['passwordError']) ? $_GET['passwordError']:"" )?></h4>
            </div>
            <button type="submit" name="action" value="login">login</button>
            <div class="signup">
                <b>create an account</b><a href="registerpage.php">Sign Up</a>
            </div>
        </form>
        
    </div>
    <!-- <pre> -->
</body>
<?php
    // validate user
    if(!empty($_POST))
    {
        // get user data from database
        $data = $_POST['emailAddress'];
        $action = "emailVerification";
        $user_data = $curlObj -> retrive($data,$action);

        if(!empty($user_data)){
            if($user_data['password'] != $_POST['password']){
                if(isset($_COOKIE['password']))  setcookie("password","",0) ;
                setcookie("emailAddress",$_POST['emailAddress'],(time()+120));
                header("location:login.php?passwordError=*incorrect password");
                return;
            }
            $_SESSION['user_id'] = $user_data['user_id'];
            $_SESSION['first_name'] = $user_data['first_name'];
            $_SESSION['last_name'] = $user_data['last_name'];
            $_SESSION['phone_number'] = $user_data['phone_number'];
            $_SESSION['email_address'] = $user_data['email_address'];
            $_SESSION['role'] = $user_data['role'];
            if($user_data['role'] == 'admin'){
                header("location:track.php");
                return;
            }
            header("location:salesperson.php");
        }else{
            if(isset($_COOKIE['emailAddress']))  setcookie("emailAddress","",0) ;
            setcookie("password",$_POST['password'],(time()+120));
            header("location:login.php?mailError=*Incorrect mail");
            return;
        }
    }   

?>
</html>