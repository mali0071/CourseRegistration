
<?php
        include "Lab6Common/Header.php";
        include "Lab6Common/Footer.php";
        include "Lab6Common/Functions.php";
        
        session_start();
       $_SESSION["RequestedURL"]=$_SERVER["REQUEST_URI"];
        if (!isset($_SESSION["studentID"])){
            header("Location: Login.php");
            exit( );
        }
        
       $studentID = $_SESSION["studentID"];
       $studentName="";
       $studentPhone="";
       
       $studentInfo=array(
              "studentID"=> getUserById($studentID)[0],
              "name"=>getUserById($studentID)[1],
              "phone"=>getUserById($studentID)[2]);
          
          foreach($studentInfo as $key=>$value){
              if($key=="studentID"){
                  $studentID=$value;
              }
              else if($key=="name"){
                  $studentName=$value;
              }
              else{
                  $studentPhone=$value;
              }
          }
          
               $dbConnection = parse_ini_file('./db_connection.ini');
               extract($dbConnection );
                
                 $myPDO = new PDO($dsn, $user, $password);
                 if (!$myPDO){ 

                    $myPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
                  }
                  
               $sql =$myPDO->prepare("SELECT CourseCode,SemesterCode FROM Registration WHERE StudentId=:studentId"); 
               $sql->execute([':studentId'=>$studentInfo['studentID']]);
               $registeredCourses = $sql->fetchAll();
               
               if(isset($_POST["deleteBtn"]) && isset($_POST['selectedCourses'])){ 
                   
                   $selectedCourses=$_POST["selectedCourses"];
                   foreach($registeredCourses as $selected){
                    
                    if(in_array($selected['CourseCode'], $selectedCourses)){   
                        
                    foreach($selectedCourses as $selectedToDelete){
                       $deleteStmnt = $myPDO->prepare("DELETE FROM Registration WHERE CourseCode=:code AND SemesterCode=:scode;");
                       $deleteStmnt->execute([//':studentID' => $studentInfo['studentID'],
                                            ':code'=>$selected['CourseCode'],
                                            ':scode'=>$selected['SemesterCode']]);                     
                        } 
                    }
                   }
                   header("Location:CurrentRegistration.php");
               }
               else if(isset($_POST["deleteBtn"])){
                  $checkBoxError="You did not select a checkbox item!";
               }
               
        
?>
<form method="post"  action="CurrentRegistration.php" id="form1">
    <h1 align="center">Current Registrations</h1>
        
        <div class= "container-fluid table form-group">
        <p>Welcome <strong><?php echo$studentName ?></strong> (not you? change user <a href="http://localhost/CST8257Lab6/Logout.php">here</a>), the followings are your current registrations</p>

        
        <span class="errors" style="color: red"><?php echo $checkBoxError;?> </span>
        <table align="left" width="100%" class="table">
            <tr>
            <th>Year</th>
            <th>Term</th>
            <th>Course Code</th>
            <th>Course Title</th>
            <th>Hours</th>
            <th>Select</th>
            </tr>

         <?php 
         
            if($sql->rowCount()) {
            $F17total=0;
            foreach($registeredCourses as $courses){               
            $stmnt = $myPDO->prepare("SELECT CourseCode,Title, WeeklyHours FROM Course WHERE CourseCode = :code");
            $stmnt->execute([':code' => $courses['CourseCode']]);
            $courseList=$stmnt->fetch();
            
          
            $sqlSemester = $myPDO->prepare("SELECT Year,Term FROM Semester WHERE SemesterCode = :code");
            $sqlSemester ->execute([':code' => $courses['SemesterCode']]);
            $semesterTerm=$sqlSemester->fetch();
            
               if($semesterTerm['Term']=='Fall' && $semesterTerm['Year']==2017){
                echo "<tr>";
                  echo "<td>".$semesterTerm['Year']."</td>";
                  echo "<td>".$semesterTerm['Term']."</td>";
                  echo  "<td>". $courseList['CourseCode'] ."</td>";
                  echo  "<td>" . $courseList['Title'] ."</td>";
                  echo  "<td>" . $courseList['WeeklyHours'] ."</td>";   
                  echo "<td> <input type='checkbox' name='selectedCourses[]' value='".$courseList["CourseCode"]."'/></td>" ;
                echo  "</tr>";
                $F17total+=$courseList['WeeklyHours'];
                $_SESSION["F17total"]=$F17total;
                }
                
                }
                 if($F17total>0){
                     echo "<tr>
                      <td></td>
                      <td></td>
                      <td></td>
                        <td class='distinct' align='right'>Total Weekly Hours:</td>
                        <td>". $F17total ."</td>
                     </tr>";
                }
                
            $S17total=0;
            foreach($registeredCourses as $courses){               
            $stmnt = $myPDO->prepare("SELECT CourseCode,Title, WeeklyHours FROM Course WHERE CourseCode = :code");
            $stmnt->execute([':code' => $courses['CourseCode']]);
            $courseList=$stmnt->fetch();
            
          
            $sqlSemester = $myPDO->prepare("SELECT Year,Term FROM Semester WHERE SemesterCode = :code");
            $sqlSemester ->execute([':code' => $courses['SemesterCode']]);
            $semesterTerm=$sqlSemester->fetch();
            
               if($semesterTerm['Term']=='Summer' && $semesterTerm['Year']==2017){
                echo "<tr>";
                  echo "<td>".$semesterTerm['Year']."</td>";
                  echo "<td>".$semesterTerm['Term']."</td>";
                  echo  "<td>". $courseList['CourseCode'] ."</td>";
                  echo  "<td>" . $courseList['Title'] ."</td>";
                  echo  "<td>" . $courseList['WeeklyHours'] ."</td>";   
                  echo "<td> <input type='checkbox' name='selectedCourses[]' value='".$courseList["CourseCode"]."'/></td>" ;
                echo  "</tr>";
                $S17total+=$courseList['WeeklyHours'];
                }
                
                }
                 if($S17total>0){
                     echo "<tr>
                      <td></td>
                      <td></td>
                      <td></td>
                        <td class='distinct' align='right'>Total Weekly Hours:</td>
                        <td>". $S17total ."</td>
                     </tr>";
                }
                
                   $W17total=0;
            foreach($registeredCourses as $courses){               
            $stmnt = $myPDO->prepare("SELECT CourseCode,Title, WeeklyHours FROM Course WHERE CourseCode = :code");
            $stmnt->execute([':code' => $courses['CourseCode']]);
            $courseList=$stmnt->fetch();
            
          
            $sqlSemester = $myPDO->prepare("SELECT Year,Term FROM Semester WHERE SemesterCode = :code");
            $sqlSemester ->execute([':code' => $courses['SemesterCode']]);
            $semesterTerm=$sqlSemester->fetch();
            
               if($semesterTerm['Term']=='Winter' && $semesterTerm['Year']==2017){
                echo "<tr>";
                  echo "<td>".$semesterTerm['Year']."</td>";
                  echo "<td>".$semesterTerm['Term']."</td>";
                  echo  "<td>". $courseList['CourseCode'] ."</td>";
                  echo  "<td>" . $courseList['Title'] ."</td>";
                  echo  "<td>" . $courseList['WeeklyHours'] ."</td>";   
                  echo "<td> <input type='checkbox' name='selectedCourses[]' value='".$courseList["CourseCode"]."'/></td>" ;
                echo  "</tr>";
                $W17total+=$courseList['WeeklyHours'];
                }
                
                }
                 if($W17total>0){
                     echo "<tr>
                      <td></td>
                      <td></td>
                      <td></td>
                        <td class='distinct' align='right'>Total Weekly Hours:</td>
                        <td>". $W17total ."</td>
                     </tr>";
                }
                
                $F18total=0;
            foreach($registeredCourses as $courses){               
            $stmnt = $myPDO->prepare("SELECT CourseCode,Title, WeeklyHours FROM Course WHERE CourseCode = :code");
            $stmnt->execute([':code' => $courses['CourseCode']]);
            $courseList=$stmnt->fetch();
            
          
            $sqlSemester = $myPDO->prepare("SELECT Year,Term FROM Semester WHERE SemesterCode = :code");
            $sqlSemester ->execute([':code' => $courses['SemesterCode']]);
            $semesterTerm=$sqlSemester->fetch();
            
               if($semesterTerm['Term']=='Fall' && $semesterTerm['Year']==2018){
                echo "<tr>";
                  echo "<td>".$semesterTerm['Year']."</td>";
                  echo "<td>".$semesterTerm['Term']."</td>";
                  echo  "<td>". $courseList['CourseCode'] ."</td>";
                  echo  "<td>" . $courseList['Title'] ."</td>";
                  echo  "<td>" . $courseList['WeeklyHours'] ."</td>";   
                  echo "<td> <input type='checkbox' name='selectedCourses[]' value='".$courseList["CourseCode"]."'/></td>" ;
                echo  "</tr>";
                $F18total+=$courseList['WeeklyHours'];
                }
                
                }
                 if($F18total>0){
                     echo "<tr>
                      <td></td>
                      <td></td>
                      <td></td>
                        <td class='distinct' align='right'>Total Weekly Hours:</td>
                        <td>". $F18total ."</td>
                     </tr>";
                }
                
                  $W18total=0;
            foreach($registeredCourses as $courses){               
            $stmnt = $myPDO->prepare("SELECT CourseCode,Title, WeeklyHours FROM Course WHERE CourseCode = :code");
            $stmnt->execute([':code' => $courses['CourseCode']]);
            $courseList=$stmnt->fetch();
            
          
            $sqlSemester = $myPDO->prepare("SELECT Year,Term FROM Semester WHERE SemesterCode = :code");
            $sqlSemester ->execute([':code' => $courses['SemesterCode']]);
            $semesterTerm=$sqlSemester->fetch();
            
               if($semesterTerm['Term']=='Winter' && $semesterTerm['Year']==2018){
                echo "<tr>";
                  echo "<td>".$semesterTerm['Year']."</td>";
                  echo "<td>".$semesterTerm['Term']."</td>";
                  echo  "<td>". $courseList['CourseCode'] ."</td>";
                  echo  "<td>" . $courseList['Title'] ."</td>";
                  echo  "<td>" . $courseList['WeeklyHours'] ."</td>";   
                  echo "<td> <input type='checkbox' name='selectedCourses[]' value='".$courseList["CourseCode"]."'/></td>" ;
                echo  "</tr>";
                $W18total+=$courseList['WeeklyHours'];
                }
                
                }
                 if($W18total>0){
                     echo "<tr>
                      <td></td>
                      <td></td>
                      <td></td>
                        <td class='distinct' align='right'>Total Weekly Hours:</td>
                        <td>". $W18total ."</td>
                     </tr>";
                } 
                
                
                   $S18total=0;
            foreach($registeredCourses as $courses){               
            $stmnt = $myPDO->prepare("SELECT CourseCode,Title, WeeklyHours FROM Course WHERE CourseCode = :code");
            $stmnt->execute([':code' => $courses['CourseCode']]);
            $courseList=$stmnt->fetch();
            
          
            $sqlSemester = $myPDO->prepare("SELECT Year,Term FROM Semester WHERE SemesterCode = :code");
            $sqlSemester ->execute([':code' => $courses['SemesterCode']]);
            $semesterTerm=$sqlSemester->fetch();
            
               if($semesterTerm['Term']=='Summer' && $semesterTerm['Year']==2018){
                echo "<tr>";
                  echo "<td>".$semesterTerm['Year']."</td>";
                  echo "<td>".$semesterTerm['Term']."</td>";
                  echo  "<td>". $courseList['CourseCode'] ."</td>";
                  echo  "<td>" . $courseList['Title'] ."</td>";
                  echo  "<td>" . $courseList['WeeklyHours'] ."</td>";   
                  echo "<td> <input type='checkbox' name='selectedCourses[]' value='".$courseList["CourseCode"]."'/></td>" ;
                echo  "</tr>";
                $S18total+=$courseList['WeeklyHours'];
                }
                
                }
                 if($S18total>0){
                     echo "<tr>
                      <td></td>
                      <td></td>
                      <td></td>
                        <td class='distinct' align='right'>Total Weekly Hours:</td>
                        <td>". $S18total ."</td>
                     </tr>";
                }
             
                
                $F19total=0;
            foreach($registeredCourses as $courses){               
            $stmnt = $myPDO->prepare("SELECT CourseCode,Title, WeeklyHours FROM Course WHERE CourseCode = :code");
            $stmnt->execute([':code' => $courses['CourseCode']]);
            $courseList=$stmnt->fetch();
            
          
            $sqlSemester = $myPDO->prepare("SELECT Year,Term FROM Semester WHERE SemesterCode = :code");
            $sqlSemester ->execute([':code' => $courses['SemesterCode']]);
            $semesterTerm=$sqlSemester->fetch();
            
               if($semesterTerm['Term']=='Fall' && $semesterTerm['Year']==2019){
                echo "<tr>";
                  echo "<td>".$semesterTerm['Year']."</td>";
                  echo "<td>".$semesterTerm['Term']."</td>";
                  echo  "<td>". $courseList['CourseCode'] ."</td>";
                  echo  "<td>" . $courseList['Title'] ."</td>";
                  echo  "<td>" . $courseList['WeeklyHours'] ."</td>";   
                  echo "<td> <input type='checkbox' name='selectedCourses[]' value='".$courseList["CourseCode"]."'/></td>" ;
                echo  "</tr>";
                $F19total+=$courseList['WeeklyHours'];
                }
                
                }
                 if($F19total>0){
                     echo "<tr>
                      <td></td>
                      <td></td>
                      <td></td>
                        <td class='distinct' align='right'>Total Weekly Hours:</td>
                        <td>". $F19total ."</td>
                     </tr>";
                }
                
                $W19total=0;
            foreach($registeredCourses as $courses){               
            $stmnt = $myPDO->prepare("SELECT CourseCode,Title, WeeklyHours FROM Course WHERE CourseCode = :code");
            $stmnt->execute([':code' => $courses['CourseCode']]);
            $courseList=$stmnt->fetch();
            
          
            $sqlSemester = $myPDO->prepare("SELECT Year,Term FROM Semester WHERE SemesterCode = :code");
            $sqlSemester ->execute([':code' => $courses['SemesterCode']]);
            $semesterTerm=$sqlSemester->fetch();
            
               if($semesterTerm['Term']=='Winter' && $semesterTerm['Year']==2019){
                echo "<tr>";
                  echo "<td>".$semesterTerm['Year']."</td>";
                  echo "<td>".$semesterTerm['Term']."</td>";
                  echo  "<td>". $courseList['CourseCode'] ."</td>";
                  echo  "<td>" . $courseList['Title'] ."</td>";
                  echo  "<td>" . $courseList['WeeklyHours'] ."</td>";   
                  echo "<td> <input type='checkbox' name='selectedCourses[]' value='".$courseList["CourseCode"]."'/></td>" ;
                echo  "</tr>";
                $W19total+=$courseList['WeeklyHours'];
                }
                
                }
                 if($W19total>0){
                     echo "<tr>
                      <td></td>
                      <td></td>
                      <td></td>
                        <td class='distinct' align='right'>Total Weekly Hours:</td>
                        <td>". $W19total ."</td>
                     </tr>";
                }
                
                $S19total=0;
            foreach($registeredCourses as $courses){               
            $stmnt = $myPDO->prepare("SELECT CourseCode,Title, WeeklyHours FROM Course WHERE CourseCode = :code");
            $stmnt->execute([':code' => $courses['CourseCode']]);
            $courseList=$stmnt->fetch();
            
          
            $sqlSemester = $myPDO->prepare("SELECT Year,Term FROM Semester WHERE SemesterCode = :code");
            $sqlSemester ->execute([':code' => $courses['SemesterCode']]);
            $semesterTerm=$sqlSemester->fetch();
            
               if($semesterTerm['Term']=='Winter' && $semesterTerm['Year']==2019){
                echo "<tr>";
                  echo "<td>".$semesterTerm['Year']."</td>";
                  echo "<td>".$semesterTerm['Term']."</td>";
                  echo  "<td>". $courseList['CourseCode'] ."</td>";
                  echo  "<td>" . $courseList['Title'] ."</td>";
                  echo  "<td>" . $courseList['WeeklyHours'] ."</td>";   
                  echo "<td> <input type='checkbox' name='selectedCourses[]' value='".$courseList["CourseCode"]."'/></td>" ;
                echo  "</tr>";
                $S19total+=$courseList['WeeklyHours'];
                }
                
                }
                 if($S19total>0){
                     echo "<tr>
                      <td></td>
                      <td></td>
                      <td></td>
                        <td class='distinct' align='right'>Total Weekly Hours:</td>
                        <td>". $S19total ."</td>
                     </tr>";
                }
                
                
           }
 
            ?>
        
        </table>
        <div class="container-fluid pull-right">
            <button name="deleteBtn" vale="Delete" class="btn btn-primary" onClick="return confirm('Are you sure you want to delete?')">Delete</button> <button type="reset" name="clear" class="btn btn-primary ">Clear</button>
        </div>
        
        </div>
</div>
</form>
