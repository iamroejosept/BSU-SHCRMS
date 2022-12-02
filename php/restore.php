<?php
    require_once 'Database.php';
    require_once 'centralConnection.php';
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
            if($_GET["type"] == "restoreLogs"){
                $sql = "INSERT INTO SYSTEMLOGS SELECT * FROM ARCHIVEDLOG";
                $Result1 = $ClinicRecordsDB->GetRows($sql);
                $sql = "DELETE FROM ARCHIVEDLOG";
                $Result2 = $ClinicRecordsDB->GetRows($sql);

                if ($Result1 && $Result2){
                    $Message = "Successfully restored logs";
                }else{
                    $Message = "Failed to restore logs";
                }
                
            }else if($_GET["type"] == "restoreStaff"){
                
                $id = $_GET["id"];

                $sql = "INSERT INTO USERACCOUNTS SELECT * FROM ARCHIVEDSTAFF WHERE user_id ='$id'";
                $Result1 = $ClinicRecordsDB->GetRows($sql);
                $sql = "DELETE FROM ARCHIVEDSTAFF WHERE user_id ='$id'";
                $Result2 = $ClinicRecordsDB->GetRows($sql);

                if ($Result1 && $Result2){
                    $sql = "UPDATE USERACCOUNTS SET archived_at = '', created_at = CURRENT_TIMESTAMP WHERE user_id ='$id'";
                    $query = $ClinicRecordsDB->GetRows($sql);
                    $Message = "Successfully restored staff account";
                }else{
                    $Message = "Failed to restore staff account";
                }
            }else if($_GET["type"] == "restoreStudent"){
                $id = $_GET["id"];

                $sql = "INSERT INTO personalmedicalrecord SELECT * FROM archivedstudent WHERE id_num = '$id'";
                $Result1 = $ClinicRecordsDB->GetRows($sql);
                $sql = "DELETE FROM archivedstudent WHERE id_num = '$id'";
                $Result2 = $ClinicRecordsDB->GetRows($sql);

                if ($Result1 && $Result2){
                    $sql = "UPDATE personalmedicalrecord SET archived_at = '', created_at = CURRENT_TIMESTAMP WHERE id_num ='$id'";
                    $query = $ClinicRecordsDB->GetRows($sql);
                    $Message = "Successfully restored student info";
                }else{
                    $Message = "Failed to restored student info";
                }

                /*$sql = "SELECT * FROM personalmedicalrecord WHERE StudentIDNumber = '$id'";
                $Query1 = $ClinicRecordsDB->GetRows($sql);
                $sql = "SELECT * FROM ARCHIVEDSTUDENT WHERE StudentIDNumber = '$id'";
                $Query2 = $ClinicRecordsDB->GetRows($sql);

                $sql = "SELECT id_num FROM ARCHIVEDSTUDENT WHERE StudentIDNumber = '$id'";
                $Query3 = $ClinicRecordsDB->GetRows($sql);
                $Row = $Query3->fetch_array();
                $temp = stripslashes($Row['id_num']);;

                if($Query1 && $Query2){
                    $Message = "$Query2";
                }else{
                    
                }*/

                
            }else if($_GET["type"] == "restoreConsultation"){
                $id = $_GET["id"];

                $sql = "INSERT INTO CONSULTATIONINFO SELECT * FROM ARCHIVEDCONSULTATION WHERE Num = '$id'";
                $Result1 = $ClinicRecordsDB->GetRows($sql);
                $sql = "DELETE FROM ARCHIVEDCONSULTATION WHERE Num = '$id'";
                $Result2 = $ClinicRecordsDB->GetRows($sql);

                if ($Result1 && $Result2){
                    $sql = "UPDATE CONSULTATIONINFO SET archived_at = '', created_at = CURRENT_TIMESTAMP WHERE Num ='$id'";
                    $query = $ClinicRecordsDB->GetRows($sql);
                    $Message = "Successfully restored consultation record";
                }else{
                    $Message = "Failed to restore consultation record";
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