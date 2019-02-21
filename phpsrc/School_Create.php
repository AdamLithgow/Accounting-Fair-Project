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

        //verify school name input
        if(isset($_POST['schoolname'])){
            $schoolname =$_POST['schoolname'];
            if(strlen($schoolname)==""){
                $post=0;
                $msg = "You must enter a school name";
            }
        }
        else{
            $post=0;
            $msg = "You must enter a school name";
        }


        //post school 1 to DB
        if($post==1){
            $arr= array("null",$schoolname);          
            //print_r($arr);
            $result=insertRecord("school", $arr);
            echo "<br>result=$result";
            if($result>0){
                $msg = "School Added.";
            }
        }
    }

    //******* Display the Form *******

    if($result==1){
        echo "<h2>School Added</h2>";
        exit;
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Create School</title>
    </head>
    <body>
        <form action='index.php?p=School_Create' method=post>
            <input type='hidden' name='auth' value=10>
            <input type='hidden' name='state' value=1>
            <table>
                <tr>
                    <td colspan=2><?php $msg ?></td>
                </tr>

                <tr>
                    <td>School Name: </td>
                    <td><input type="text" name='schoolname'></td>
                </tr>

                <tr>
                    <td colspan=2><input type='submit' value='create'></td>
                </tr>
            </table>
        </form>
    </body>
</html>
