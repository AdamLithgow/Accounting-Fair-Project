<?php
		//echo "signin.php";
		require_once("pdo.php");
		//echo "signin.php v3";

        //******* Edit if Ready *******
        if(isset($_POST['state'])){
            $state = $_POST['state'];
        }
        if($state == 1)
        {
            $id = $_SESSION['pk'];
        
            //Student 1 is *Actually* required so we will go through and do this one first
            if(isset($_POST['student1'])){
                $student1 =$_POST['student1'];
                if(strlen($student1)=="None Selected"){
                    $post=0;
                    $msg = "You must select at least one student";
                }
            }
            else{
                $post=0;
                $msg = "You must select at least one student";
            } 

            //post student 1 to DB
            if($post==1){
                $arr= array("null",6,$id,$student1,1);
                //print_r($arr);
                $result=insertRecord("interviews", $arr);
                echo "<br>result=$result";
                if($result>0){
                    $msg = "Student Added.";
                }            
            }
            
            if($post==1){
                //update the account to the db
                $arr= array("null",$student1,$student2,$student3,$student4,$student5);
                //print_r($arr);
                $array['student1'] = $student1;
                $array['student2'] = $student2;
                $array['student3'] = $student3;
                $array['student4'] = $student4;
                $array['student5'] = $student5;
                $result = updateRecord("interviews",$array,"idinterview",$id);
                echo "<br>result=$result";
                if($result>0){
                    $msg = "Interview Updated";
                }else{
                    $msg = "Error Updating Interview";
                }
            }
        }

		//******* Display the Form *******
        //get record to display
            echo "<h2>Edit Interview</h2>";
            if(isset($_GET['i'])){
                $id = $_GET['i'];
            }
            else{
                echo "error, interview not found";
                exit;
            }

        //create query
            $rs = getRecord("interviews","idinterviews",$id);
            //print_r($rs);
            if(count($rs)==0){
                echo "<br>interview not found";
                exit;
            }
        //display record
            $studentid = $rs['idstudents'];
            $slot = $rs['idtimeSlot'];
            $rs = getRecord("students","idstudents",$studentid);
            $student = $rs['studentName'];
            $schoolid = $rs['idschool'];
            $rs = getRecord("school","idschool",$school);
            $school = $rs['schoolname'];
            $rs = getRecord("timeslot","idtimeSlot",$slot);
            $slot = $rs['slotTime'];
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>Edit Interview</title>
    </head>
    <body>
        <form action='index.php?p=Interview_View' method="post">
            <input type="hidden" name="auth" value=10>
            <input type="hidden" name="state" value=1>
            <table>
                <tr>
                    <td colspan=2><?php $msg ?></td>
                </tr>

                <tr>
                    <td>Student Name: </td>
                    <td>
                        <select name = student>
                        <?php
                            $temp = buildQuickList("Select idstudents, studentName From students", 'studentName','idstudents', $studentid);
                            echo $temp;
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>Time Slot: </td>
                    <td><input type="text" name="slot" size="40" maxlen="40" value='<?php echo $slot; ?>' disabled></td>
                </tr>
                
                <tr>
                    <td colspan=2><input type='submit' value='create'></td>
                </tr>
                
            </table>
        </form>
    </body>
</html>