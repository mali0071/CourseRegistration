<?php
        include "Lab6Common/Header.php";
        include "Lab6Common/Footer.php";
        session_start();
        if(isset($_SESSION["loginVerified"])){
             header("Location: CourseSelection.php");
            exit( );
        }
          $_SESSION["RequestedURL"]=$_SERVER["REQUEST_URI"];
                  
?>
<div class="container-fluid">
  <h1>Welcome to Algonquin College Online Course Registration</h1>
        <p>If you have never used this before, you have to <a href="http://localhost/CST8257Lab6/NewUser.php">sign up</a> first.</p>
        <p>If you have already signed up, you can  <a href="http://localhost/CST8257Lab6/Login.php">log in</a> now.</p>
</div>
        
        