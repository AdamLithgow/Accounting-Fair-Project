<?php
    require_once("pdo.php");

    $studentid;

    //Bring in the interview table data so we can work with it
    $query = "SELECT idstudents, count(idstudents) FROM interviews WHERE priorityLevel != 0 group by idstudents order by idstudents";
    $rs=getRecordSet($query,$param);

    //TODO - Comment out in final prod
    displayRecordSet($rs); //this is printing the table currently.

    foreach($rs as $row)
    {
        $studentid = $row['idstudents'];

        if($studentid != 1)
        {
            //logic for discarding time slots
            if($row['count(idstudents)'] > 5)
            {
                //get number of non-sponsor interviews to take
                $interviewsToSelect = 5 - runQuery("SELECT i.idstudents, count(idstudents)
                                                    FROM interviews AS i
                                                    INNER JOIN comprep AS cr
                                                        ON i.idcompRep = cr.idcompRep
                                                    INNER JOIN company AS c
                                                        ON cr.idcompany = c.idcompany
                                                    WHERE c.isSponsor = 1 
                                                    AND i.idstudents = $studentid
                                                    ORDER BY idinterviews");
                
                
                                
                //echo "<br>interviewstoselect = ".$interviewsToSelect;
                //echo "student = ".$studentid;
                
                //select top rows from $rs equal to a count of $interviewsToSelect
                $dataSet = runQuery("SELECT i.* 
                                    FROM interviews AS i
                                    INNER JOIN comprep AS cr
                                        on i.idcomprep = cr.idcomprep
                                    INNER JOIN company AS c
                                        ON cr.idcompany = c.idcompany
                                    WHERE c.isSponsor = 0 and i.idstudents = $studentid
                                    ORDER BY idinterviews DESC
                                    LIMIT $interviewsToSelect;
                                    ");
                //echo "this is dataset";
               // displayRecordSet($dataSet);

                //update excess records as time slot 7 (rejected)
                foreach($dataSet as $entry)
                {
                    //echo "entry = ";
                    //print_r($entry);
                    $arr['idinterviews'] = $entry['idinterviews'];
                    $arr['idtimeSlot'] = 7;
                    $arr['idcompRep'] = $entry['idcompRep'];
                    $arr['idstudents'] = $entry['idstudents'];
                    $arr['priorityLevel'] = $entry['priorityLevel'];
                    //echo "I am updating".$entry['idinterviews'];
                    //print_r($arr);
                    updateRecord("interviews", $arr, "idinterviews", $entry['idinterviews']);
                }
                
            }
        
        }
    }
    //assign time slots for sponsors
    assignStudents();

    function assignStudents()
    {
        $query = "
            SELECT i.*, c.isSponsor
            FROM interviews AS i
            INNER JOIN comprep AS cr
                ON i.idcompRep = cr.idcompRep
            INNER JOIN company AS c
                ON cr.idcompany = c.idcompany 
            WHERE priorityLevel != 0
            AND idstudents != 1 AND idtimeSlot = 6
            ORDER BY c.isSponsor DESC, i.priorityLevel
        ";
        /*
        if($isSponsor == true)
        {
            //query the interviews table for all interviews where the comprep's company is a sponsor
            $parms[0] = 1;
        }
        else
        {
            //query the interviews table for all interviews where the comprep's company is NOT a sponsor
            $parms[0] = 0;
        }
        */
        
        //retrieve the data
        $records = getRecordSet($query, $parms);
        //echo "displaying thing for assignStudents";
        displayRecordSet($records);

        foreach($records as $data)
        {
            if($data['idstudents'] != 1){
                $availableRepSlot;
                $idtimeSlot = $data['idtimeSlot'];
                $id = $data['idinterviews'];
                $idcompRep = $data['idcompRep'];
                $idstudents = $data['idstudents'];
                $priorityLevel = $data['priorityLevel'];
                //check for rep's first available time slot
                /*
                for($j = 1; $j < 6; $j++)
                {
                    echo "<br>code inside first foreach reached";
                    //check if time slot with id equal to $j has a current interview. if it returns empty, there isn't one
                    if(mysqli_num_rows(runQuery("SELECT * FROM interviews WHERE idcompRep = $idcompRep AND idtimeSlot = $j")) == 0)
                    {
                        echo "<br>code inside if reached";
                        $availableRepSlot = $j;
                        break;
                    }
                    else
                    {
                        echo "<br>code inside else reached";
                        continue;
                    }
                    echo "<br>code reached";
                }

                //check if rep's open slot is availble for student too
                for($k = 1; $k < 6; $k++)
                {
                    echo "<br>inside second for loop reached";
                    if(mysqli_num_rows(runQuery("SELECT * FROM interviews WHERE idstudents = $idstudents AND idtimeSlot = $availableRepSlot")) == 0)
                    {
                        //time slot is available for both rep and student so update the record with updated time slot id
                        $idtimeSlot = $k;
                        $array['idinterviews'] = $id;
                        $array['idtimeSlot'] = $idtimeSlot;
                        $array['idcompRep'] = $idcompRep;
                        $array['idstudents'] = $idstudents;
                        $array['priorityLevel'] = $priorityLevel;
                        echo "right before record update reached";
                        updateRecord("interviews", $array, "idinterviews", $id);
                        echo "fetch updated record";
                        $sample = getRecord("interviews", "idinterviews", $id);
                        print_r($sample);
                        break;
                    }
                    else
                    {
//**                    check for student's next available slot and verify against rep's available slots
                        continue;
                    }
                }
                */
                for($j = 1; $j < 6; $j++)
                {
                    //check if time slot with id equal to $j has a current interview. if it returns empty, there isn't one
                    if(mysqli_num_rows(runQuery("SELECT * FROM interviews WHERE idcompRep = $idcompRep AND idtimeSlot = $j")) == 0 && mysqli_num_rows(runQuery("SELECT * FROM interviews WHERE idstudents = $idstudents AND idtimeSlot = $j")) == 0)
                    {
                        echo mysqli_num_rows(runQuery("SELECT * FROM interviews WHERE idcompRep = $idcompRep AND idtimeSlot = $j"));
                        //time slot is available for both rep and student so update the record with updated time slot id
                        $idtimeSlot = $j;
                        $array['idinterviews'] = $id;
                        $array['idtimeSlot'] = $idtimeSlot;
                        $array['idcompRep'] = $idcompRep;
                        $array['idstudents'] = $idstudents;
                        $array['priorityLevel'] = $priorityLevel;
                        //updateRecord("interviews", $array, "idinterviews", $id);
                        break;
                    }
                }
            }
        }
    }

    //sort students by who has most interviews
?>