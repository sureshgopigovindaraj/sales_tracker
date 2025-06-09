<?php

    session_start();
    session_unset();
    session_destroy();
    setcookie(session_name(),"",0);
    setcookie("emaiAddress","",0);
    setcookie("password","",0);
    header("location:login.php");

?>