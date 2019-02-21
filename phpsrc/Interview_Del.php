<?php
		//echo "signin.php";
		require_once("pdo.php");
		//echo "signin.php v3";

        //******* Delete if Ready *******
        if(isset($_POST['state'])){
            $state = $_POST['state'];
        }
        if($state ==1){
            //user said to delete record
            if(isset($_POST['id'])){
                $id = $_POST['id'];
            }else{
                echo "<br>error, missing id";
            }
            //do deletion
            $result = delRecord("interviews", "idinterviews", $id);
            if($result >0){
                echo "<h2> Record Deleted</h2>";
                echo "<br> <a href='index.php?p=myinterviews'>Click Here</a> to continue";
                exit;
            }
            echo "<br> Error Deleting Record";
        }

		//******* Display the Form *******
        //get record to display
            echo "<h2>Delete Interview</h2>";
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
        //displayRecordSet($rs);
            $student = $rs['idstudents'];
            $slot = $rs['idtimeSlot'];
            $rs = getRecord("students","idstudents",$student);
            $student = $rs['studentName'];
            $school = $rs['idschool'];
            $rs = getRecord("school","idschool",$school);
            $school = $rs['schoolname'];
            $rs = getRecord("timeslot","idtimeSlot",$slot);
            $slot = $rs['slotTime'];
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>Delete Interview</title>
    </head>
    <body>
        <form action='index.php?p=Interview_Del' method="post">
            <input type="hidden" name="auth" value=10>
            <input type="hidden" name="state" value=1>
            <table>
                <tr>
                    <td colspan=2><?php $msg ?></td>
                </tr>

                <tr>
                    <td>Student Name: </td>
                    <td><input type="text" name="student" size="40" maxlen="40" value='<?php echo $student; ?>' disabled></td>
                </tr>

                <tr>
                    <td>School: </td>
                    <td><input type="text" name="school" size="40" maxlen="40" value='<?php echo $school; ?>' disabled></td>
                </tr>

                <tr>
                    <td>Time Slot: </td>
                    <td><input type="text" name="slot" size="40" maxlen="40" value='<?php echo $slot; ?>' disabled></td>
                </tr>
                <tr>
                    <td colspan=2><input type='submit' value='delete'></td>
                </tr>
            </table>
        </form>
    </body>
</html>