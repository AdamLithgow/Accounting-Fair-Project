<?php
    //echo "signin.php";
    require_once("pdo.php");
    //echo "signin.php v3";


    //******* Display the Form *******
    //get record to display
        echo "<h2>View Interview</h2>";
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
        <title>View Interview</title>
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
                
            </table>
        </form>
    </body>
</html>