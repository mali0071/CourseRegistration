<?php
        include "Lab6Common/Header.php";
        include "Lab6Common/Footer.php";
        include "Lab6Common/Functions.php";
        
        session_start();
        
        if (isset($_SESSION["studentID"])){
            header("Location: CourseSelection.php");
            exit( );
        }

   ?>

     <h1 class="container-fluid">Log in </h1>
     <p class="container-fluid">You need to <a href="http://localhost/CST8257Lab6/NewUser.php">sign up</a> if you're a new user.</p>

     <?php
     
     $viewForm=true;
     $errors=true;
     $loginError="";
     $studentIdError="";
     $PasswordAError="";
     
     
     $studentID=$_POST["studentID"];
     $studentPassword=$_POST["passwordA"];
     
      if (isset($_POST["submitBtn"]))
         {

             if(strlen($studentID)<=0){
                 $errors=true;
                 $studentIdError="Student ID cannot be blank";
                 $xPasswordA=$studentPassword;
             }
           
             if (strlen($studentPassword)<=0)
             {
                 $errors=true;
                 $passwordAError="Password cannot be blank";
                 $xStudentID=$studentID;
             }  
             else{
                 $xStudentID=$studentID;
                 $xPasswordA=$studentPassword;
                 $errors=false;
             }
             
           
             $loginCheck = StudentLogin($studentID, $studentPassword);
             if($loginCheck === "" and $errors===false){
                 $_SESSION["studentID"]=$studentID;
                 $_SESSION["studentPassword"]=$studentPassword;
                 $_SESSION["loginVerified"]=true;
                 $viewForm=false;
                 if(isset($_SESSION["RequestedURL"])){
                     header("Location:".$_SESSION["RequestedURL"]);
                 }else{
                     header("Location: CourseSelection.php ");
                 }                 
             }
             else{
                 $loginError=$loginCheck;
             }
             
         }
         
         if(isset($_POST["clear"])){  
          $xStudentID="";
          $xPasswordA="";
        
               }
             
      
if($viewForm)
{
    ?>
     
        <form method="post"  action="Login.php" id="form1">
            <div class= "form-group container-fluid table">
        <hr>
  <table>
      <span class="errors" style="color: red"><?php echo $loginError;?> </span>
     <tr>
      <td><label for="studentId">Student ID: </label></td>
      <td><input  type="text" name="studentID" id="name" class="form-control" value="<?php echo $xStudentID;?>"></td>
       <td> <span class="errors" style="color: red"><?php echo $studentIdError;?> </span></td>
    </tr>
    <tr>
      <td><label for="password">Password: </label>
      <td><input type="password" name="passwordA" class="form-control" value="<?php echo $xPasswordA;?>" ></td>
      <td> <span class="errors" style="color: red">  <?php echo $passwordAError;?></span></td>
    </tr>
    
    <tr>
        <td></td>
      <td><button type="submit" name="submitBtn" class="btn btn-primary">Submit</button> <button type="submit" name="clear" class="btn btn-primary">Clear</button></td>
    </tr>
    
  </table>

</div>
</form>
        <?php
}
?>
     
     
