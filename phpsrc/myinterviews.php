<?php
	require_once("phpsrc/safer.php");
    require_once("phpsrc/pdo.php");
	//$proceed = safer(10);
	//if(safer(10) == false){
	//	echo "<br>You are not authorized to this page....<br>";
		//exit;
	//}
	echo "<h2>My Requested Interviews</h2>";

    $id = $_SESSION['pk'];
	$query = "Select interviews.idtimeSlot, interviews.priorityLevel, students.studentName from interviews inner join students on interviews.idstudents = students.idstudents where idcompRep = '$id'";

	//echo "query = $query";
	$result = runQuery($query);
	
    displayRecordSetE($result,"Interview_View","Interview_Create","idinterviews");













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
