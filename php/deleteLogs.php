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
            $sql = "DELETE FROM SYSTEMLOGS";          
            $ClinicRecordsQuery = $ClinicRecordsDB->GetRows($sql);
            $Message = "Successfully Deleted Logs";       
        }else{
                $Message = 'Failed to delete Logs';
        }
    }else{
        $Message = 'The database is offline';
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