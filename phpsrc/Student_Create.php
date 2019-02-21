<?php
    //echo "signin.php";
    require_once("pdo.php");

    //get the values from the form

    $state = 0;
    if(isset($_POST['state'])){
        $state=$_POST['state'];
    }
    $post = 1;
    $msg = "";
    //validate inputs
    if($state == 1)
    {
        $id = $_SESSION['pk'];

        //verify student name input
        if(isset($_POST['student'])){
            $student =$_POST['student'];
            if(strlen($student)==""){
                $post=0;
                $msg = "You must enter a student name";
            }
        }
        else{
            $post=0;
            $msg = "You must enter a student name";
        }

        //verify school input
        if(isset($_POST['school'])){
            $school =$_POST['school'];
            if(strlen($school)=="None Selected"){
                $post=0;
                $msg = "You must select a school";
            }
        }
        else{
            $post=0;
            $msg = "You must select a school";
        }

        //post student 1 to DB
        if($post==1){
            $arr= array("null",$school,$student);          //how to find out id from school
            //print_r($arr);
            $result=insertRecord("students", $arr);
            echo "<br>result=$result";
            if($result>0){
                $msg = "Student Added.";
            }
        }
    }

    //******* Display the Form *******

    if($result==1){
        echo "<h2>Students Requested</h2>";
        exit;
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Create Student</title>
    </head>
    <body>
        <form action='index.php?p=Student_Create' method=post>
            <input type='hidden' name='auth' value=10>
            <input type='hidden' name='state' value=1>
            <table>
                <tr>
                    <td colspan=2><?php $msg ?></td>
                </tr>

                <tr>
                    <td>Student Name: </td>
                    <td><input type="text" name='student'></td>
                </tr>

                <tr>
                    <td>Student School: </td>
                    <td>
                        <select name = school>
                        <?php
                            $temp = buildQuickList("Select idschool, schoolname From school", 'schoolname','idschool');
                            echo $temp;
                        ?>
                    </td>
                </tr>

                <tr>
                    <td colspan=2><input type='submit' value='create'></td>
                </tr>
            </table>
        </form>
    </body>
</html>
