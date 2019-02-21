<?php
    //echo "signin.php";
    require_once("pdo.php");
    //echo "signin.php v3";


    //******* Display the Form *******
    //get record to display
        echo "<h2>View Student</h2>";
        if(isset($_GET['i'])){
            $id = $_GET['i'];
        }
        else{
            echo "error, student not found";
            exit;
        }

    //create query
        $query = "SELECT * FROM students WHERE idstudent=? AND idschool=?";
        $parms[0] = $_SESSION['idstudent'];
        $parms[1] = $id;
        $rs = getRecordSet($query,$parms);
        //print_r($rs);
        if(count($rs)==0){
            echo "<br>student not found";
            exit;
        }
        //displayRecordSet($rs);
        foreach($rs as $row){
            //now we have it
        }
       $student = $row['student'];
       $school = $row['school'];
?>

<!DOCTYPE html>
<html>
    <head>
        <title>View Student</title>
    </head>
    <body>
        <form action='index.php?p=Student_View' method=post>
            <input type='hidden' name='auth' value=10>
            <input type='hidden' name='state' value=1>
            <table>
                <tr>
                    <td colspan=2><?php $msg ?></td>
                </tr>

                <tr>
                    <td>Student Name: </td>
                    <td><input type="text" name='student' disabled></td>
                </tr>

                <tr>
                    <td>Student School: </td>
                    <td>
                        <select name = school disabled>
                        <?php
                            $temp = buildQuickList("Select idschool, schoolname From school", 'schoolname','idschool');
                            echo $temp;
                        ?>
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>