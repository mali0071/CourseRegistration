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
        $maxHours=16;
        $registeredHours=0;
        $remainingHours=$maxHours-$registeredHours;
        $viewForm=true;
        $errors=true;

          $studentInfo=array(
              "studentID"=> getUserById($studentID)[0],
              "name"=>getUserById($studentID)[1],
              "phone"=>getUserById($studentID)[2],);
          
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
                  
               $sql =  $myPDO->prepare("SELECT Term,Year,SemesterCode FROM Semester"); 
               $sql->execute();
               $semesters = $sql->fetchAll();
               
               if(isset($_POST["submitBtn"]) && isset($_POST['selectedCourses'])){   
                   $selectedCourses=$_POST["selectedCourses"];
                    foreach($selectedCourses as $selected){
                       $insertStmnt = $myPDO->prepare("INSERT INTO Registration(StudentId, CourseCode, SemesterCode) VALUES(:studentID, :courseCode, :semesterCode)");
                       $insertStmnt->execute([':studentID' => $studentInfo['studentID'],
                                            ':courseCode'=>$selected,
                                            ':semesterCode'=>$_POST["semesterDropDown"]]);                     
                   } 
                
               }
                 else if(isset($_POST["submitBtn"])){
                  $checkBoxError="You did not select a checkbox item!";
               }
               
               if(isset($_POST["clear"])){
                   
               }
  
 if($viewForm){
                   
?>
<form method="post"  action="CourseSelection.php" id="form1">
    <h1 align="center">Course Selection</h1>
  
        <div class= "container-fluid table form-group ">
        <p>Welcome <strong><?php echo$studentName ?></strong> (not you? change user <a href="http://localhost/CST8257Lab6/Logout.php">here</a>)</p>
        <p>You have registered <strong><?php echo$registeredHours ?></strong> hours for the selected semester</p>
        <p>You can register <strong><?php echo $remainingHours ?></strong> more hours of courses(s) for the semester</p>
        <p>Please note that the courses you have registered will not be displayed in the list</p>
        
        <span class="errors" style="color: red"><?php echo $checkBoxError;?> </span>
        <table align="left" width="100%" class="table">
            <tr>
                 <div class="form-group container-fluid pull-right form-group" >
                    <select name="semesterDropDown" id="semesterDropDown" class="form-control" onchange="javascript:valueselect(this)">
                        <?php foreach($semesters as $semester):?>
                        <option value="<?=$semester["SemesterCode"];?>"<?php if($semester["SemesterCode"]==$_GET["selected"])echo "selected";?>><?=$semester["Year"];?> <?=$semester["Term"];?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            </tr>
            <tr>
            <th>Course Code</th>
            <th>Course Title</th>
            <th>Hours</th>
            <th>Select</th>
            </tr>

         <?php 
         
         
         
               $sql =$myPDO->prepare("SELECT CourseCode,SemesterCode FROM Registration WHERE StudentId=:studentId;"); 
               $sql->execute([':studentId'=>$studentInfo['studentID']]);
               $registeredCourses = $sql->fetchAll();
               
               
               
            //$stmnt = $myPDO->prepare("SELECT CourseCode FROM CourseOffer WHERE SemesterCode = :name");
            $stmnt = $myPDO->prepare("SELECT CourseCode FROM CourseOffer WHERE SemesterCode = :name AND CourseCode NOT IN (SELECT CourseCode FROM Registration WHERE StudentId = '$studentID');");
            $value = $_GET["selected"];
            if($value==null){
                $stmnt->execute([':name' => "17F"]);
            }
            else{
                $stmnt->execute([':name' => $value]);
            } 
            
            $coursesCode=$stmnt->fetchAll();
            
            
            
            if($stmnt->rowCount()) {
             
            $i=0;
            foreach($coursesCode as $courseCode){               
            $stmnt = $myPDO->prepare("SELECT CourseCode,Title, WeeklyHours FROM Course WHERE CourseCode = :code;");
            $stmnt->execute([':code' => $courseCode['CourseCode'] ]);
            $courseList=$stmnt->fetch();
            
            
           if(!in_array($registeredCourses[$i]['CourseCode'],$courseCode)){
                   echo "<tr>";
                  echo  "<td>". $courseList['CourseCode'] ."</td>";
                  echo  "<td>" . $courseList['Title'] ."</td>";
                  echo  "<td>" . $courseList['WeeklyHours'] ."</td>";
                  echo "<td> <input type='checkbox' name='selectedCourses[]' value='".$courseList["CourseCode"]."'/></td>" ; 
                echo  "</tr>";
                }
              }
                $i++;
            }   
?>
        
        </table>
        <div class="container-fluid pull-right">
            <button type="submit" name="submitBtn" class="btn btn-primary">Submit</button> <button type="reset" name="clear" class="btn btn-primary ">Clear</button>
        </div>
        
        </div>
</div>
</form>
 <?php }?>
<script type="text/javascript">
   function valueselect(sel) {
      var value = sel.options[sel.selectedIndex].value;
      window.location.href = "CourseSelection.php?selected="+value;
   }
</script>