<?php
  require_once 'Database.php';
  require '../../../php/centralConnection.php';
	date_default_timezone_set('Asia/Manila');

 
  $Message = '';
  $Error = "0";
  
    
    $TxtStaffIDNumber = $_POST['TxtStaffIDNumber'];
    $RadStatus = $_POST['RadStatus'];
    $TxtLastname = $_POST['TxtLastname'];
    $TxtFirstname = $_POST['TxtFirstname'];
    $TxtMiddlename = $_POST['TxtMiddlename'];
    $TxtExtension = $_POST['TxtExtension'];
    $RadPosition = $_POST['RadPosition'];
    $TxtRank = $_POST['TxtRank'];
    $TxtContactNumber = $_POST['TxtContactNumber'];
    $TxtEmail = $_POST['TxtEmail'];
    $TxtUsername = $_POST['TxtUsername'];
    $TxtPassword = $_POST['TxtPassword'];
    $ClinicRecordsDB = new Database($Server,$User,$DBPassword);

    if ($ClinicRecordsDB->Connect()==true)
    {
      $Result = $ClinicRecordsDB->SelectDatabase($Database);
                          
      if($Result == true)
      {   
        CheckRecord($TxtStaffIDNumber);

      }
      else
      {
        $Message = 'Failed to add information!';
        $Error = "1";
      }
    }  
    else
    {
      $Message = 'The database is offline!';    
      $Error = "1";
    } 
  
    

  $XMLData = '';	
	$XMLData .= ' <output ';
	$XMLData .= ' Result = ' . '"'.$Message.'"';
  $XMLData .= ' Error = ' . '"'.$Error.'"';
	$XMLData .= ' />';
	
	//Generate XML output
	header('Content-Type: text/xml');
	//Generate XML header
	echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
	echo '<Document>';    	
	echo $XMLData;
	echo '</Document>';

  function CheckRecord($IDNum){
    $IDNumber = $IDNum;
    $sql;

    //Access Global Variables
    global $ClinicRecordsDB, $Message, $Error;  
    
      $sql = "SELECT IdNum FROM USERACCOUNTS WHERE IdNum = '$IDNumber' ";

      $Result = $ClinicRecordsDB->Execute($sql);
      
      $ClinicRecordQuery = $ClinicRecordsDB->GetRows($sql);                
    
      if($ClinicRecordQuery)
      {            
        $Row = $ClinicRecordQuery->fetch_array();            
        if($Row)
        {         
         
            $Message = 'The account already exist. Please try again.';
            $Error = "1";
             
        }else{
          
              global $ClinicRecordsDB,$Message,$Error, $TxtStaffIDNumber, $TxtLastname, $TxtFirstname, $TxtMiddlename, $TxtExtension, $RadPosition, $TxtRank, $TxtContactNumber, $TxtEmail, $TxtUsername, $TxtPassword,$RadStatus;

          $RadStatus = strtolower($RadStatus);
          $TxtLastname = strtolower($TxtLastname);
          $TxtFirstname = strtolower($TxtFirstname);
          $TxtMiddlename = strtolower($TxtMiddlename);
          $TxtExtension = strtolower($TxtExtension);
          $RadPosition = strtolower($RadPosition);
          $TxtRank = strtolower($TxtRank);
          $TxtEmail = strtolower($TxtEmail);

          $TxtPassword = password_hash($TxtPassword, PASSWORD_DEFAULT);
      

          $sql = "INSERT INTO USERACCOUNTS (IdNum,Status,Email, Username, Password,Lastname,Firstname,Middlename,Extension,Position,Rank,ContactNum, created_at) VALUES ('$TxtStaffIDNumber','$RadStatus', '$TxtEmail', '$TxtUsername', '$TxtPassword', '$TxtLastname','$TxtFirstname','$TxtMiddlename','$TxtExtension','$RadPosition','$TxtRank','$TxtContactNumber', CURRENT_TIMESTAMP)";  
  
          $Result = $ClinicRecordsDB->GetRows($sql);

          if($Result){
              $Message = 'Successfully added the information!'; 
              $Error = "0";
          }else{
              $Message = 'Database error!'; 
              $Error = "1";
          }
          
          
        }       
      }
  }

    
   
?>
