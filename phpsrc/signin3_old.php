<?php
		require_once("pdo.php");
		//echo "signin.php v3";
		//lets get the values from the form
		$firstTrip = 0;
		$post = 1;
		$msg = "";
		//validate username
		
		if(isset($_POST['user'])){
			$username = $_POST['user'];
			$firstTrip = 1;
		}
		else{
			$username = "";
			$post = 0;
		}

		if(strlen($username)<1 && $firstTrip == 1){
			$msg =  "*User name not entered.  ";
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
			//exit;
		}
		//echo "<br>username = $username";
		//echo "<br>password = $password";

		//set up the query string
		if($post == 1){
			$query = "select * from users where username=? and password = ?";
			$parm[0] = $username;
			$parm[1] = $password;
			//echo "test";
			$rs = runQuery($query,$parm);
			//echo "<br>return value =".sizeof($rs);
			//print_r($rs);
			if(sizeof($rs) == 0){
				unset($rs);
			}
		}

		$c=0;
		//echo "<br> - returned record:";
		//print_r($rs);
		//display the records on the screen
		if(isset($rs)){
			//echo "<br>print records";
			$c=1;
			foreach($rs as $row){
				foreach($row as $key=>$val){
					//echo "<br>$key = $val";
				}
			}
		}
		//message if not found
		if($firstTrip == 1){
			if($c==0){
				//failed attempt
				echo "<br>invalid login, please try again";
				include("signin2.html");				
			}
			else{
				//successful login 
				include("home.html");
			}
		}
		else{
			//first attempt
			include ("signin2.html");
		}
		
		

		
?>