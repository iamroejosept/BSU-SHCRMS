<?php
require_once 'Database.php';
require '../../../php/centralConnection.php';
date_default_timezone_set('Asia/Manila');

  $Message = '';
  $Error = "0";
  $type = '';

  $temp = $_POST['temp'];
  $idnumber = $_POST['idnumber'];
  $type = $_POST['type'];

    $TxtLastname = "";
    $TxtFirstname = "";
    $TxtMiddlename = "";
    $TxtExtension = "";
    $RadPosition = "";
    $TxtRank = "";
    $TxtContactNumber = "";
    $TxtEmail = "";
    $TxtUsername = "";
    $TxtPassword = "";
    


  if($temp == "1"){
    $ClinicRecordsDB = new Database($Server,$User,$DBPassword);

    if ($ClinicRecordsDB->Connect()==true)
    {
      $Result = $ClinicRecordsDB->SelectDatabase($Database);
                          
      if($Result == true)
      {   
        FetchUser($idnumber);
      }
      else
      {
        $Message = 'Failed to fetch information!';
        $Error = "1";
      }
    }  
    else
    {
      $Message = 'The database is offline!';
      $Error = "1";    
    } 
  }

   $XMLData = '';	
	 $XMLData .= ' <output ';
	 $XMLData .= ' Message = ' . '"'.$Message.'"';
   $XMLData .= ' Error = ' . '"'.$Error.'"';
  $XMLData .= ' Lastname = ' . '"'.$TxtLastname.'"';
  $XMLData .= ' Firstname = ' . '"'.$TxtFirstname.'"';
  $XMLData .= ' Middlename = ' . '"'.$TxtMiddlename.'"';
  $XMLData .= ' Extension = ' . '"'.$TxtExtension.'"';
  $XMLData .= ' Position = ' . '"'.$RadPosition.'"';
  $XMLData .= ' Rank = ' . '"'.$TxtRank.'"';
  $XMLData .= ' ContactNumber = ' . '"'.$TxtContactNumber.'"';
  $XMLData .= ' Email = ' . '"'.$TxtEmail.'"';
  $XMLData .= ' Username = ' . '"'.$TxtUsername.'"';
  $XMLData .= ' Password = '.'"'.$TxtPassword.'"';  
	 $XMLData .= ' />';
	
	//Generate XML output
	 header('Content-Type: text/xml');
	//Generate XML header
	echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
	echo '<Document>';    	
	echo $XMLData;
	echo '</Document>';

  function FetchUser($ID){

    $sql;

    //Access Global Variables
    global $Error, $ClinicRecordsDB, $Message, $TxtLastname, $TxtFirstname, $TxtMiddlename, $TxtExtension, $RadPosition, $TxtRank, $TxtContactNumber, $TxtEmail, $TxtUsername, $TxtPassword, $type;

      if ($type =='viewArchivedRecord'){
        $sql = "SELECT * FROM ARCHIVEDSTAFF  WHERE IdNum = '$ID'";
      }else if ($type == 'viewRecord' || $type == 'newRecord'){
        $sql = "SELECT * FROM USERACCOUNTS  WHERE IdNum = '$ID'";
      }
      

      $Result = $ClinicRecordsDB->Execute($sql);
      
      $ClinicRecordQuery = $ClinicRecordsDB->GetRows($sql);                
    
      if($ClinicRecordQuery)
      {
        $Row = $ClinicRecordQuery->fetch_array();
        if($Row)
          {     
            $TxtEmail =stripcslashes($Row['Email']);; 
            $TxtUsername = stripcslashes($Row['Username']);;
            $TxtPassword = stripcslashes($Row['Password']);; 
            $TxtLastname = stripslashes($Row['LastName']);;
            $TxtFirstname = stripslashes($Row['FirstName']);;
            $TxtMiddlename = stripslashes($Row['MiddleName']);;
            $TxtExtension = stripslashes($Row['Extension']);;
            $RadPosition = stripslashes($Row['Position']);;
            $TxtRank = stripslashes($Row['Rank']);;
            $TxtContactNumber = stripslashes($Row['ContactNum']);;
            
            $Message = "Search completed!";
            $Error = "0"; 
          }else{
            $Message = "No user found. Please try again.";
            $Error = "1";
          }            
      }
  }

?>