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

        //verify company name input
        if(isset($_POST['companyname'])){
            $companyname =$_POST['companyname'];
            if(strlen($companyname)==""){
                $post=0;
                $msg = "You must enter a company name";
            }
        }
        else{
            $post=0;
            $msg = "You must enter a company name";
        }
        
        //verify company info input
        if(isset($_POST['companyinfo'])){
            $companyinfo =$_POST['companyinfo'];
            if(strlen($companyinfo)==""){
                $post=0;
                $msg = "You must enter intern majors looking for";
            }
        }
        else{
            $post=0;
            $msg = "You must enter intern majors looking for";
        }
        
        //verify priorityLevel input (will always have a value due to drop down menu)
        if(isset($_POST['priorityLevel'])){
            $priorityLevel =$_POST['priorityLevel'];
        }
        
        //post company 1 to DB
        if($post==1){
            $arr= array("null",$companyname,$companyinfo,$priorityLevel);          
            //print_r($arr);
            $result=insertRecord("company", $arr);
            //echo "<br>result=$result";
            if($result>0){
                $msg = "Company Added.";
            }
        }
    }

    //******* Display the Form *******

    if($result==1){
        echo "<h2>Company Added</h2>";
        exit;
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Create Company</title>
    </head>
    <body>
        <form action='index.php?p=Company_Create' method=post>
            <input type='hidden' name='auth' value=10>
            <input type='hidden' name='state' value=1>
            <table>
                <tr>
                    <td colspan=2><?php $msg ?></td>
                </tr>

                <tr>
                    <td>Company Name: </td>
                    <td><input type="text" name='companyname'></td>
                </tr>
                
                <tr>
                    <td>Interns Majors Looking For: </td>
                    <td><input type="text" name='companyinfo'></td>
                </tr>
                
                <tr>
                    <td>Is This A Sponsor Company?: </td>
                    <td>
                        <select name='priorityLevel'>
                            <option value = "0">No</option>
                            <option value = "1">Yes</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td colspan=2><input type='submit' value='create'></td>
                </tr>
            </table>
        </form>
    </body>
</html>
