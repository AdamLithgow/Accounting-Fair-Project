<?php
	require_once("phpsrc/safer.php");
    require_once("phpsrc/pdo.php");
	//$proceed = safer(10);
	//if(safer(10) == false){
	//	echo "<br>You are not authorized to this page....<br>";
		//exit;
	//}
	echo "<h2>My Requested Interviews</h2>";
    echo "idtimeSlot == 6 means not assigned to a time slot<br>";

    $id = $_SESSION['pk'];
	$query = "Select * from interviews where idcompRep = '$id'";
	//echo "query = $query";
	$result = runQuery($query);
	
    displayRecordSetE($result,"Student_Edit","Student_Del","Student_View","Student_Create","idinterviews");













	/*  samples for using pdo are below
    displayRecordSet(getTableStructure("users"));
    println(" ");
    displayRecordSet(runQuery("Select * from users"));
    $email="koontzrd@grace.edu";
    $username="Rick Koontz";
    $authority=99;
    $password="test";
    $arr = array($email, $username, $authority, $password);

    insertRecord("users", $arr, false);
    displayRecordSet(runQuery("Select * from users"));

    $array['password']="test123";
    $array['authority']=42;

    updateRecord("users", $array, "email", "koontzrd@grace.edu");
    displayRecordSet(runQuery("Select * from users"));
	displayRecordSet(getTableStructure("loans"));
	*/




?>
