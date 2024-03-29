<!DOCTYPE html>
<?php
session_start()
?>

<html lang="en" style="position: relative; min-height: 100%;">
<head>
<title>Online Course Registration</title>
        <meta charset="utf-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="/AlgCommon/Contents/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="/AlgCommon/Contents/AlgCss/Site.css" rel="stylesheet" type="text/css"/>
</head>
<body style="padding-top: 50px; margin-bottom: 60px;">
    <nav class="navbar navbar-default navbar-fixed-top navbar-inverse">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" 
                       data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" style="padding: 10px" href="http://www.algonquincollege.com">
              <img src="/AlgCommon/Contents/img/AC.png" 
                   alt="Algonquin College" style="max-width:100%; max-height:100%;"/>
          </a>    
        </div>
        <?php
        if(!isset($_SESSION["loginVerified"])){ 
        ?>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
               <li class="active"><a href="Index.php">Home </a></li>
               <li><a href="CourseSelection.php">Course Selection</a></li>
               <li><a href="CurrentRegistration.php">Current Registration</a></li>
               <li><a href="Login.php">Login</a></li>          
            </ul>
        </div>
        <?php
        }
        else{      
?>
             <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
               <li class="active"><a href="CourseSelection.php">Home </a></li>
               <li><a href="CourseSelection.php">Course Selection</a></li>
               <li><a href="CurrentRegistration.php">Current Registration</a></li>
               <li><a href="Logout.php">Log Out</a></li>          
            </ul>
        </div>
        <?php } ?>
      </div>  
    </nav>
