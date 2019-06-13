<?php
        include "Lab6Common/Header.php";
        include "Lab6Common/Footer.php";
        include "Lab6Common/Functions.php";
        session_start(); 
       
   ?>
<?php 
        
        // if(!($_SESSION["termsCheck"]))
          //    {
          //    header("Location: Disclaimer.php ");
            // }?>

        <h1 class="container-fluid">Sign Up</h1>
        <p class="container-fluid">All field are required</p>
        
       <?php
       

  $number=trim($_POST["number"]);
  $name=trim($_POST["name"]);
  $studentID=trim($_POST["studentID"]);
  $passwordA=$_POST["passwordA"];
  $passwordB=$_POST["passwordB"];

  $errors=false;
  $viewForm=true;
  $nameError="";
  $phoneNumberError="";
  $studentIdError="";
  $passwordAError="";
  $PasswordBError="";
  $studentIdExists="";
  
   
  $xNumber="";
  $xStudentID="";
  $xPasswordA="";
  $xPasswordB="";
  
      
     if (isset($_POST["submitBtn"]))
         {
             $nameError = ValidateName($name);
             $phoneNumberError = ValidatePhoneNumber($number);
             $studentIdError= ValidateStudentID($studentID);
             
              if(strlen($nameError)>0){
                 $errors=true;
             }
              if(strlen($phoneNumberError)>0){
                 $errors=true;
             }
            
               if (strlen($passwordA)<=0)
             {
                 $errors=true;
                 $passwordAError="Password cannot be left blank!";
             }
                if (strlen($passwordB)<=0)
             {
                 $errors=true;
                 $passwordBError="Password cannot be left blank!";
             }
             if ($passwordA != $passwordB)
             {
                 $errors=true;
                 $passwordAError="Passwords do NOT match";
             }
             if(strlen($studentIdError)>0){
                 $errors=true;
             }
              if($errors===false){   
             $studentIdExists = StudentRegistration($studentID, $name, $number, $passwordA);
             if($studentIdExists != ""){
                 $errors=true;
                 $studentIdError=$studentIdExists;   
            }
              }
            
        
   }           

         
  if(isset($name)){
      $xName=$name;
  }
  
   if(isset($studentID)){
      $xStudentID=$studentID;
  }

   if(isset($passwordA)){
      $xPasswordA=$passwordA;
  }

   if(isset($passwordB)){
      $xPasswordB=$passwordB;
  }
  
  if(isset($number)){
      $xNumber=$number;
  }
  
 if(isset($_POST["clear"])){
          $xName="";     
          $xStudentID="";
          $xPasswordA="";
          $xPasswordB="";
          $xNumber="";
               }
               
               
         if(!($errors) && isset($_POST["submitBtn"]) )
             {
               $viewForm=false;
               $_SESSION["studentValid"]=true;
               $_SESSION["studentID"]=$studentID;
               $_SESSION["studentName"]=$name;
               $_SESSION["studentPhone"]=$number;
               $_SESSION["studentPassword"]=$passwordA;
               $_SESSION["loginVerified"]=true;
                     
               header("Location: CourseSelection.php ");
                   }
    if($viewForm)
{
    ?>
        <form method="post"  action="NewUser.php" id="form1">
        <div class= "form-group container-fluid table">
        <hr>
  <table>
      
     <tr>
      <td><label for="studentId">Student ID:</label></td>
     
      <td><input  type="text" name="studentID" id="name" class="form-control" value="<?php echo $xStudentID;?>"></td>
       <td> <span class="errors" style="color: red"><?php echo $studentIdError;?> </span></td>
    </tr>
    
    <tr>
      <td><label for="name">Name:</label></td>
    <p></p>
      <td><input  type="text" name="name" id="name" class="form-control" value="<?php echo $xName;?>"></td>
       <td> <span class="errors" style="color: red"><?php echo $nameError;?> </span></td>
    </tr> 
    
    <tr>
      <td><label for="phoneNumber">Phone Number: </label>
          <br>
          <p>(nnn-nnn-nnnn)</p>
      <td><input type="text" name="number" class="form-control" value="<?php echo $xNumber;?>"></td>
      <td> <span class="errors" style="color: red">  <?php echo $phoneNumberError;?></span></td>
    </tr>
    
    <tr>
      <td><label for="passwordA">Password: </label>
      <td><input type="password" name="passwordA" class="form-control" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" value="<?php echo $xPasswordA;?>" required></td>
      <td> <span class="errors" style="color: red"> <?php echo $passwordAError;?></span></td>
    </tr>
    
    <tr>
      <td><label for="passwordB">Password Again: </label>
      <td><input type="password" name="passwordB" class="form-control" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" value="<?php echo $xPasswordB;?>" required></td>
      <td> <span class="errors" style="color: red"> <?php echo $passwordBError;?></span></td>
    </tr>
    
    <tr>
   
        <td></td>
        
      <td><button type="submit" name="submitBtn" class="btn btn-primary">Submit</button> <button type="submit" name="clear" class="btn btn-primary ">Clear</button></td>
    </tr>
    
  </table>

</div>
</form>
        <?php
}
?>
        
    </body>
</html>
