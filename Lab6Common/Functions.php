    <!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
       
                
       
function ValidatePrincipalAmount($principalAmount)
  {
    if(strlen($principalAmount)==0){
      $principalAmountError.="Principal amount field cannot be empty";
  }
  
    else if(!is_numeric($principalAmount)){
      $principalAmountError.= "Principal Amount must be a number";
    }
    else if ($principalAmount <= 0)
    		{
   
    			$principalAmountError .= "Principal Amount must be greater than 0";
    		}
      
        
        return $principalAmountError;
      }

  function ValidateInterestAmount($interestAmount){
    if(strlen($interestAmount)==0){
        $interestAmountError .="Interest Amount field cannot be empty";
    }

    else if($interestAmount<=0){
        $interestAmountError.="Interest amount must be greater than 0";
    }
    else if(!is_numeric($interestAmount)){
        $interestAmountError.="Interest amount must be a number";
    }
    
    return $interestAmountError;
  }


  function ValidateYears($years){
    if ($years == 0)
    {

        $yearsToDepositError.= "Must select number of years to deposit";
    }
    else if ($years < 0)
    {
        $yearsToDepositError.= "Number of years to deposit must be greater then 0";
    }
    else if ($years > 20)
    {
        $yearsToDepositError .= "Number of years to deposit can not be greater then 20";
    }
  
    return $yearsToDepositError;
}

function ValidateName($name){
    if(strlen($name)==0){
      $nameError .= "Name cannot be empty";
    }
   
    return $nameError;
}

function ValidateStudentID($studentID){
    if(strlen($studentID)==0){
      $studentIdError .= "Student ID cannot be empty";
    }
   
    return $studentIdError;
}

function ValidatePostalCode($postalCode){

    $postalCodeRegex = "/[a-z][0-9][a-z]\s*[0-9][a-z][0-9]/i";
                if (empty($postalCode))
                {
                    $postalCodeError="Postal Code is Required ";

                }
                else if(!(preg_match($postalCodeRegex,$postalCode)))
                {
                    $postalCodeError= "Incorrect Postal Code ";
                }
          
                return $postalCodeError;
  }

function ValidateEmailAddress($email)
              {
                $emailRegex="/[a-zA-Z0-9._%+-]+@(([a-zA-Z0-9-]+)\.)+[a-zA-Z]{2,4}/";

                if(empty($email))
                {
                   $emailAddressError="  Email is Required ";

                }
                else if(!(preg_match($emailRegex, $email)))
                {
                    $emailAddressError="Incorrect Email";
                

                }
              
              return $emailAddressError;
  }

  function ValidatePhoneNumber($number){
    $phoneRegex ="/^[2-9][0-9][0-9]-[2-9][0-9][0-9]-\d{4}$/";
             if (empty($number))
             {
                 $phoneNumberError="  Phone number is Required ";
             }
             else if(!(preg_match($phoneRegex, $number)))
             {
                 $phoneNumberError="Incorrect Phone number";
             }
       
             return $phoneNumberError;
           }
           

   function StudentRegistration($userId, $name, $phone, $passwordA){
               $dbConnection = parse_ini_file('./db_connection.ini');
               extract($dbConnection );
                
                 $myPDO = new PDO($dsn, $user, $password);
                 if (!$myPDO){ 

                    $myPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
                  }
                  
               $sqlFindStudent =  $myPDO->prepare("SELECT StudentId FROM Student WHERE StudentId=:userId");              
               $sqlFindStudent->bindParam(':userId', $userId);
               $studentsFound=$sqlFindStudent->execute();
         
               if ($studentsFound){
                   $studentIdError="Student with this ID has already signed up";
                   return $studentIdError;
                   }
                   else {
                       $sqlInsert = "INSERT INTO Student VALUES(:studentId, :studentName, :studentPhone, :studentPassword)";
                       $pStmt = $myPDO->prepare($sqlInsert);
                       $pStmt->execute([ 'studentId' => $userId, 'studentName' => $name, 'studentPhone' => $phone, 'studentPassword'=>$passwordA]);
                      // $commentId = $myPDO ->lastInsertId( );
                    //  $comment->setCommentId($commentId);
                       return ""; 
                   }
           }
           
       function StudentLogin($userId, $passwordA){
           $dbConnection = parse_ini_file('./db_connection.ini');
               extract($dbConnection );
                
                 $myPDO = new PDO($dsn, $user, $password);
                 if (!$myPDO){ 

                    $myPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
                  }
                  
               $sqlFindStudent =  $myPDO->prepare("SELECT StudentId,Password FROM Student WHERE (StudentId=:userId AND Password=:password)");              
               $sqlFindStudent->bindParam(':userId', $userId);
               $sqlFindStudent->bindParam(':password', $passwordA);
               $sqlFindStudent->execute();
               //$user = $sqlFindStudent->fetch(PDO::FETCH_ASSOC);
               if($sqlFindStudent->rowCount()<=0){
                   $loginError="Incorrect username/password combination!";
                   return $loginError;
               }
               else{
                   return "";
               }
               
       }
           
       function getUserById($userId){
             $dbConnection = parse_ini_file('./db_connection.ini');
               extract($dbConnection );
                
                 $myPDO = new PDO($dsn, $user, $password);
                 if (!$myPDO){ 

                    $myPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
                  }
           
           $sql = "SELECT StudentId, Name, Phone FROM Student WHERE StudentId = :userId"; 
           $pStmt = $myPDO -> prepare( $sql );
           $pStmt -> execute(['userId' => $userId]);
           $row = $pStmt->fetch(PDO::FETCH_ASSOC);
           if ($row){
               return array($row['StudentId'], $row['Name'], $row['Phone']);
           }
           else {
               return null;
               
           }
           
           }
 
        ?>
     
    </body>
</html>
