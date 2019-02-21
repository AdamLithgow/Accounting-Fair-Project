<?php
    //echo "signin.php";
    require_once("pdo.php");
    echo "Please be careful and do not hit submit or enter until you select the 5 students (or less), in priority order, for your requested interviews. Once you hit submit, there is no way to edit. Sorry for any inconvenience that this may cause.";
    $qu = "Select count(*) as howmany From interviews where idcomprep = ".$_SESSION['pk']." and priorityLevel = 1";//query
    $rs2 = runQuery($qu);
    //echo "<br>array=";
    //displayRecordSet($rs2);
    foreach($rs2 as $rs3)
        $howmany = $rs3['howmany'];
    $trouble = 0;
    //send users to edit if they have already done this page.
    if($howmany > 0){ 
        echo "<h3>You may no longer add interviews</h3>";  
        //hide table "trouble" with JS
        $trouble = 1;
    }
    
    //TODO IN CODING CLUB - Make it so that if they select less than 5 students it does not mess up. At this point, it looks like gold plating to me and I have a paper to write.

    //get the values from the form

    $state = 0;
    if(isset($_POST['state'])){
        $state=$_POST['state'];
    }
    $post = 1;
    $msg = "";

    //validate no repeat entries
    if(!($student1 != $student2 && $student3 != $student1 && $student3 != $student2 && $student4 != $student1 && $student4 != $student2 && $student4 != $student3 && $student5 != $student1 && $student5 != $student2 && $student5 != $student3 && $student5 != $student4)){
        $post = 0;
        echo "<h2>Error: Cannot Select Same Student Twice</h2>";
    }

    //validate inputs
    if($state == 1)
    {
        $id = $_SESSION['pk'];
        
        //Student 1 is *Actually* required so we will go through and do this one first
        if(isset($_POST['student1'])){
            $student1 =$_POST['student1'];
            if(strlen($student1)==1){
                $post=0;
                $msg = "You must select at least one student";
            }
        }
        else{
            $post=0;
            $msg = "You must select at least one student";
        } 
        
        
                
        //post student 1 to DB
        if($post==1){
            $arr= array("null",6,$id,$student1,1);
            //print_r($arr);
            $result=insertRecord("interviews", $arr);
            //echo "<br>result=$result";
            if($result>0){
                $msg = "Student Added.";
            }            
        }
        
        //~~~~ student2-5 are not required fields~~~
        if(isset($_POST['student2'])){
            $student2 =$_POST['student2'];
            if(!(strlen($student2)==1) && $post == 1){
                $arr= array("null",6,$id,$student2,2);
                $result=insertRecord("interviews", $arr);
                $msg = "Students Added.";
            }               
        }
        
        if(isset($_POST['student3'])){
            $student3 =$_POST['student3'];
            if(!(strlen($student3)==1) && $post == 1)
            {                
                $arr= array("null",6,$id,$student3,3);
                $result=insertRecord("interviews", $arr);
            }               
        }
        
        if(isset($_POST['student4'])){
            $student4 =$_POST['student4'];
            if(!(strlen($student4)==1) && $post == 1){
                $arr= array("null",6,$id,$student4,4);
                $result=insertRecord("interviews", $arr);
            }               
        }
        
        if(isset($_POST['student5'])){
            $student5 =$_POST['student5'];
            if(!(strlen($student5)==1) && $post == 1){
                $arr= array("null",6,$id,$student5,5);
                $result=insertRecord("interviews", $arr);
            }               
        }
    }
    
    //******* Display the Form *******

    if($result==1){
        echo "<h2>Interviews Requested</h2>";
        exit;
    }else{
        echo "<br><h2>Error: Please Try Again</h2>";
    }
?>


<html>
    <head>
        <title>Create Interview</title>
    </head>
    <body>
        <form action='index.php?p=Interview_Create' method=post>
            <input type='hidden' name='auth' value=10>
            <input type='hidden' name='state' value=1>
            <table id = "trouble">
                <tr>
                    <td colspan=2><?php $msg ?></td>
                </tr>
<?php 
    if($trouble == 0)
    {       
        for($k=1; $k<6; $k++){
            echo"<tr>"; 
            echo"<td>Student ".$k.": </td>";
            echo"<td>";
            echo"<select name = student".$k.">";
            $temp = buildQuickList("Select idstudents, studentName From students", 'studentName','idstudents');
            echo $temp;  
            echo"</td>";
            echo"</tr>";
        }
        echo"<tr>";
        echo"<td colspan=2><input type='submit' value='create'></td>";
        echo"</tr>";
    }?>
                
            </table>
        </form>
    </body>
</html>