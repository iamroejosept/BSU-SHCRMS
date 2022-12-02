<?php
    require_once 'Database.php';
    require 'centralConnection.php';
    date_default_timezone_set('Asia/Manila');


    $Message = "";

    $ClinicRecordsDB = new Database($Server,$User,$DBPassword);

    if ($ClinicRecordsDB->Connect()==true)
    {
        $Result = $ClinicRecordsDB->SelectDatabase($Database);
                      
        if($Result == true){         
            archiveRecord();       
        }else{
                $Message = 'Failed to delete Logs';
        }
    }else{
        $Message = 'The database is offline';
    }

    function archiveRecord (){
        global $ClinicRecordsDB, $Message;

        if($_SERVER['REQUEST_METHOD'] == 'GET'){
            if($_GET["type"] == "archiveLogs"){
                $sql = "INSERT INTO ARCHIVEDLOG SELECT * FROM SYSTEMLOGS";
                $Result1 = $ClinicRecordsDB->GetRows($sql);
                $sql = "DELETE FROM SYSTEMLOGS";
                $Result2 = $ClinicRecordsDB->GetRows($sql);

                if ($Result1 && $Result2){
                    $Message = "Successfully archived logs";
                }else{
                    $Message = "Failed to Archive logs";
                }
                
            }else if($_GET["type"] == "archiveStaff"){
                
                $id = $_GET["id"];

                $sql = "INSERT INTO ARCHIVEDSTAFF SELECT * FROM USERACCOUNTS WHERE user_id ='$id'";
                $Result1 = $ClinicRecordsDB->GetRows($sql);
                $sql = "DELETE FROM USERACCOUNTS WHERE user_id='$id'";
                $Result2 = $ClinicRecordsDB->GetRows($sql);

                if ($Result1 && $Result2){
                    $sql = "UPDATE ARCHIVEDSTAFF SET archived_at = CURRENT_TIMESTAMP WHERE user_id ='$id'";
                    $query = $ClinicRecordsDB->GetRows($sql);
                    $Message = "Successfully archived staff account";
                }else{
                    $Message = "Failed to archive staff account";
                }
            }else if($_GET["type"] == "archiveStudent"){
                $id = $_GET["id"];

                $sql = "INSERT INTO archivedstudent SELECT * FROM personalmedicalrecord WHERE id_num = '$id'";
                $Result1 = $ClinicRecordsDB->GetRows($sql);
                $sql = "DELETE FROM personalmedicalrecord WHERE id_num = '$id'";
                $Result2 = $ClinicRecordsDB->GetRows($sql);

                if ($Result1 && $Result2){
                    $sql = "UPDATE archivedstudent SET archived_at = CURRENT_TIMESTAMP WHERE id_num ='$id'";
                    $query = $ClinicRecordsDB->GetRows($sql);
                    $Message = "Successfully Archived student info";
                }else{
                    $Message = "Failed to archived student info";
                }
            }else if($_GET["type"] == "archiveConsultation"){
                $id = $_GET["id"];

                $sql = "INSERT INTO ARCHIVEDCONSULTATION SELECT * FROM CONSULTATIONINFO WHERE Num = '$id'";
                $Result1 = $ClinicRecordsDB->GetRows($sql);
                $sql = "DELETE FROM CONSULTATIONINFO WHERE Num = '$id'";
                $Result2 = $ClinicRecordsDB->GetRows($sql);

                if ($Result1 && $Result2){
                    $sql = "UPDATE ARCHIVEDCONSULTATION SET archived_at = CURRENT_TIMESTAMP WHERE Num = '$id'";
                    $query = $ClinicRecordsDB->GetRows($sql);
                    $Message = "Successfully archived consultation record";
                }else{
                    $Message = "Failed to consultation record";
                }
            }else if($_GET["type"] == "autoArchive"){
                $interval = 2555; //7 years
                $deleteInterval = 365; // 1year
                /*$interval = 0;*/ //for testing

                $sql = "INSERT INTO ARCHIVEDSTAFF SELECT * FROM USERACCOUNTS WHERE DATEDIFF( CURRENT_TIMESTAMP, created_at) > $interval";
                $Result11 = $ClinicRecordsDB->GetRows($sql);
                $sql = "DELETE FROM USERACCOUNTS WHERE DATEDIFF(CURRENT_TIMESTAMP, created_at) > $interval";
                $Result12 = $ClinicRecordsDB->GetRows($sql);

                $sql = "INSERT INTO archivedstudent SELECT * FROM personalmedicalrecord WHERE DATEDIFF( CURRENT_TIMESTAMP, created_at) > $interval";
                $Result21 = $ClinicRecordsDB->GetRows($sql);
                $sql = "DELETE FROM personalmedicalrecord WHERE DATEDIFF( CURRENT_TIMESTAMP, created_at) > $interval";
                $Result22 = $ClinicRecordsDB->GetRows($sql);

                $sql = "INSERT INTO ARCHIVEDCONSULTATION SELECT * FROM CONSULTATIONINFO WHERE DATEDIFF( CURRENT_TIMESTAMP, created_at) > $interval";
                $Result31 = $ClinicRecordsDB->GetRows($sql);
                $sql = "DELETE FROM CONSULTATIONINFO WHERE DATEDIFF( CURRENT_TIMESTAMP, created_at) > $interval";
                $Result32 = $ClinicRecordsDB->GetRows($sql);

                $sql = "DELETE FROM ARCHIVEDSTAFF WHERE DATEDIFF( CURRENT_TIMESTAMP, archived_at) > $deleteInterval";
                $Result4 = $ClinicRecordsDB->GetRows($sql);

                $sql = "DELETE FROM archivedstudent WHERE DATEDIFF( CURRENT_TIMESTAMP, archived_at) > $deleteInterval";
                $Result5 = $ClinicRecordsDB->GetRows($sql);

                $sql = "DELETE FROM ARCHIVEDCONSULTATION WHERE DATEDIFF( CURRENT_TIMESTAMP, archived_at) > $deleteInterval";
                $Result6 = $ClinicRecordsDB->GetRows($sql);

                if ($Result11 && $Result12  && $Result21 && $Result22 && $Result31 && $Result32 && $Result4 && $Result5 && $Result6) {
                    $Message = "Successfully Auto Archived Records";
                }else{
                    $Message = "$Result11 \n $Result12  \n $Result21 \n $Result22 \n $Result31 \n $Result32 \n $Result4 \n $Result5 \n $Result6";
                }
            }
        }

    }


    $XMLData = '';  
    $XMLData .= ' <output ';
    $XMLData .= ' Message = ' . '"'.$Message.'"';
    $XMLData .= ' />';
    
    //Generate XML output
    header('Content-Type: text/xml');
    //Generate XML header
    echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
    echo '<Document>';      
    echo $XMLData;
    echo '</Document>';

?>