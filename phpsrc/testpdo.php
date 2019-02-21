<?php
			//test pdo
			require_once("pdo.php");
			echoln("testing pdo");
			//getRecord(table, pkfield, pkvalue)
			echoln(" ");
			echoln("retrieve a record...");
			$row = getRecord("users","username","test");
			print_r($row);
			echoln(" ");
			//getRecordSet(query, parameters)
			echoln(" ");
			echoln("retrieve a recordset with parameters...");
			$query = "select * from users where username=? and password=?";
			$parms[0]="koontzrd";
			$parms[1]="test";
			$row = getRecordSet($query,$parms);
			print_r($row);
			displayRecordSet($row);
			echoln(" ");	
			//runQuery(query)
			echoln(" ");
			echoln("run a query with no parameters");
			$query = "select * from users";
			$rs = runQuery($query);
			foreach($rs as $row)
				print_r($row);
			echoln(" ");				
			//displayRecordSet(result)
			echoln(" ");
			echoln("display a record set (result from runQuery or getRecordSet)");
			$query = "select * from users";
			$rs = runQuery($query);
			displayRecordSet($rs);
			echoln(" ");						
			//getTableStructure(tablename)
			echoln(" ");
			echoln("displaya table structure");
			displayRecordSet(getTableStructure("users"));
			echoln(" ");	
			//insertRecord(tablename, recordArray, autoincrement value)
			//    for autoincrement pk:  $result = insertRecord("customers",$array);
			//    for non incrementing pk:  $result = insertRecord("books",$array, false);
			//         pkfield must be listed first
			//add a user 
			$username="verdetj";
			$password="password";
			$name="tim verde";
			$authlevel=10;
			$arr = array($username, $password, $name, $authlevel);
			print_r($arr);
			echoln(" ");
			echoln("Insert a record with no autoincrementing key");
			$success = insertRecord("users",$arr,false);
			echoln("result of insert = ".$success);
			displayRecordSet(runQuery("Select * from users"));
			echoln(" ");
			//add a user 
			$testid="does not matter";
			$testname="testing";
			$testnumber=42;
			$arr = array($testid,$testname,$testnumber);
			print_r($arr);
			echoln(" ");
			echoln("Insert a record with autoincrementing key");
			$success = insertRecord("testAuto",$arr);
			echoln("result of insert = ".$success);
			displayRecordSet(runQuery("Select * from testAuto"));
			echoln(" ");			
			//
			//now update the added records
			echoln(" ");	
			echoln("update password on verdetj ");	
			$password = "pass2";
			$record["password"]=$password;
			updateRecord("users",$record,"username","verdetj");
			displayRecordSet(runQuery("Select * from users"));
			echoln(" ");			
			//
			//now delete the extra records 
			echoln(" ");	
			echoln("delete verdetj ");	
			delRecord("users","username","verdetj");
			displayRecordSet(runQuery("Select * from users"));
			echoln(" ");			
			//lets delete the records from testAuto as well
			echoln(" ");
			echoln("delete all records from testAuto where testName='testing'");
			delRecords("testAuto","testName","testing");
			displayRecordSet(runQuery("Select * from testAuto"));
			echoln(" ");					
			
			
			
			
			
?>