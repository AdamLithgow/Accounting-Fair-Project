<?php
		//echo "signin.php";
		require_once("pdo.php");
        echo"admin account credentials: user = 'JAKD@grace.edu' pass = 'JAKD123' <br> please use create account to test other things :)";
		//echo "signin.php v3";
		//lets get the values from the form
		$firstTrip = 0;
		$post = 1;
		$msg = "";
		//validate username

		if(isset($_POST['email'])){
			$username = $_POST['email'];
			$firstTrip = 1;
		}
		else{
			$username = "";
			$post = 0;
		}

		if(strlen($username)<1 && $firstTrip == 1){
			$msg =  "User name not entered.  ";
			$post = 0;
			//exit;
		}

		if(isset($_POST['pass'])){
			$password = $_POST['pass'];
			$firstTrip = 1;
		}
		else{
			$password = "";
			$post = 0;
		}

		if(strlen($password)<1 && $firstTrip == 1){
			$msg =  "*Password not entered.";
			$post = 0;
			//exit;
		}
		//echo "<br>email = $username";
		//echo "<br>password = $password";
		//echo "<br>post = $post";
		//echo "<br>";
		//set up the query string
		if($post == 1){
			$query = "select * from comprep where email=? and pass = ?";
			$parm[0] = $username;
			$parm[1] = $password;
			$parm[2] = $primarykey;
			//echo "test";
			$rs = getRecordSet($query,$parm);
			//displayRecordSet($rs);
			$c = sizeof($rs);
			//echo "<br>return value =".sizeof($rs);
			//print_r($rs);
			if($c == 0){
				unset($rs);
			}
		}

		//message if not found
		if($firstTrip == 1){
			if($c==0){
				//failed attempt
				echo "<br>invalid login, please try again";
				include("htmlsrc\signin.html");
			}
			else{
				//successful login
				//set up the session variables
				$row = $rs[0];
				$_SESSION['user'] = $row['email'];
				$_SESSION['auth'] = $row['auth'];
				$_SESSION['pk'] = $row['idcompRep'];

                //load the main page
				echo "<h2>Welcome, ".$_SESSION['user']." to the Accounting Organzier System</h2>";
				
                //this if statement sends the normal user to myInterviews and the admin to the assignInterviews pages.
                if($_SESSION['auth'] < 20)
                    echo "<h3><a href=index.php?p=myinterviews>Click here to continue</a>";
                else
                    echo "<h3><a href=index.php?p=logic>Click here to continue</a>";
			}
		}
		else{
			//first attempt
			include ("htmlsrc\signin.html");
		}




?>
