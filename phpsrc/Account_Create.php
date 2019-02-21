<?php
		//echo "signin.php";
		require_once("pdo.php");
		//echo "signin.php v3";
		//lets get the values from the form

		$state = 0;
        if(isset($_POST['state'])){
            $state=$_POST['state'];
        }
		$post = 1;
		$msg = "";
		//validate email
        if($state == 1)
        {
            //validate the inputs
            //~~~~~~ email ~~~~~~~
            if(isset($_POST['email'])){
                $email=$_POST['email'];
                if(strlen($email)==0){
                    $post=0;
                    $msg = "invalid email";
                }
            }
            else{
                $post=0;
                $msg = "invalid email";
            }
             //~~~~~~ repName ~~~~~~~
            if(isset($_POST['repName'])){
                $repName=$_POST['repName'];
                if(strlen($repName)==0){
                    $post=0;
                    $msg = "invalid repName";
                }
            }
            else{
                $post=0;
                $msg = "invalid repName";
            }        
             //~~~~~~ password ~~~~~~~
            if(isset($_POST['pass'])){
                $pass=$_POST['pass'];
                if(strlen($pass)==0){
                    $post=0;
                    $msg = "invalid password";
                }
            }
            else{
                $post=0;
                $msg = "invalid password";
            }  
            
            //~~~~~~ comp ~~~~~~~
            if(isset($_POST['comp'])){
                $comp=$_POST['comp'];
                if(strlen($comp)==0){
                    $post=0;
                    $msg = "invalid company";
                }
            }
            else{
                $post=0;
                $msg = "invalid company";
            }  
            
            if($post==1){
                //post the account to the db
                //pk, compID, repName, email auth pass
                $arr= array("null",$comp, $repName,$email,10,$pass);
                $result=insertRecord("comprep", $arr);
                //echo "result=$result";
                if($result == 1){
                    echo "Account created successfully.";
                }
            }
        }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Create Account</title>
    </head>
    <body>
        <form action='index.php?p=Account_Create' method=post>
            <input type='hidden' name='auth' value=10>
            <input type='hidden' name='state' value=1>
            <table>
                <tr>
                    <td colspan=2><?php $msg ?></td>
                </tr>
        
                <tr>
                    <td>Full Name: </td>
                    <td><input type='text' name='repName' size=40 maxlen=40 ></td>
                </tr>
 
                <tr>
                    <td>Company: </td>
                    <td>
                        <select name = comp>
                            <?php
                                $temp = buildQuickList("Select idcompany, companyName From company", 'companyName','idcompany');
                                echo $temp;
                            ?>
                    </td>
                </tr>

                <tr>
                    <td>Email: </td>
                    <td><input type='text' name='email' size=40 maxlen=40></td>
                </tr>

                <tr>
                    <td>Password: </td>
                    <td><input type='password' name='pass' size=40 maxlen=40></td>
                </tr>

                <tr>
                    <td colspan=2><input type='submit' value='create'></td>
                </tr>
            </table>
        </form>
    </body>
</html>