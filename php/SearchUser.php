<?php
  require_once 'Database.php';
  require 'centralConnection.php';
	date_default_timezone_set('Asia/Manila');

  $Message = '';

  $Num = "";
  $Firstname = "";
  $Middlename = "";
  $Lastname = "";
  $Position = "";
  $AccessLevel = "";
  $Username = "";
  $Password = "";
  $Error;

    // Receive Data from Client
    $TxtFirstName = $_POST['SearchTxtFirstName'];
    $TxtLastName = $_POST['SearchTxtLastName'];
    
    $ClinicRecordsDB = new Database($Server,$User,$DBPassword);

    if ($ClinicRecordsDB->Connect()==true)
    {
      $Result = $ClinicRecordsDB->SelectDatabase($Database);
                          
      if($Result == true)
      {   
        CheckUser($TxtFirstName, $TxtLastName);
      }
      else
      {
        $Message = 'Failed to search information!';
        $Error = "1";
      }
    }  
    else
    {
      $Message = 'The database is offline!';
      $Error = "1";    
    } 

    $XMLData = '';	
    $XMLData .= ' <user ';
    $XMLData .= ' Num = ' . '"'.$Num.'"';
    $XMLData .= ' Firstname = ' . '"'.$Firstname.'"';
    $XMLData .= ' Middlename = ' . '"'.$Middlename.'"';
    $XMLData .= ' Lastname = ' . '"'.$Lastname.'"';
    $XMLData .= ' Position = ' . '"'.$Position.'"';
    $XMLData .= ' AccessLevel = ' . '"'.$AccessLevel.'"';
    $XMLData .= ' Username = ' . '"'.$Username.'"';
    $XMLData .= ' Password = ' . '"'.$Password.'"';
    $XMLData .= ' Message = ' . '"'.$Message.'"';
    $XMLData .= ' Error = ' . '"'.$Error.'"';
    $XMLData .= ' />';
    
    //Generate XML output
    header('Content-Type: text/xml');
    //Generate XML header
    echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
    echo '<Document>';    	
    echo $XMLData;
    echo '</Document>';

  function CheckUser($TxtFirstName, $TxtLastName){
    $sql;

    //Access Global Variables
    global $Error, $ClinicRecordsDB, $Message, $Num, $Firstname, $Middlename, $Lastname, $Position, $AccessLevel, $Username, $Password;  
    
    $TxtFirstName = strtolower($TxtFirstName);
    $TxtLastName = strtolower($TxtLastName);

      $sql = "SELECT * FROM USERACCOUNTS WHERE FirstName = '$TxtFirstName' AND LastName = '$TxtLastName'";

      $Result = $ClinicRecordsDB->Execute($sql);
      
      $ClinicRecordQuery = $ClinicRecordsDB->GetRows($sql);                
    
      if($ClinicRecordQuery)
      {            
        $Row = $ClinicRecordQuery->fetch_array();
        if($Row)
          {        
            $Num = stripslashes($Row['Num']);
            $Firstname = stripslashes($Row['FirstName']);
            $Middlename = stripslashes($Row['MiddleName']);
            $Lastname = stripslashes($Row['LastName']);
            $Position = stripslashes($Row['Position']);
            $AccessLevel = stripslashes($Row['AccessLevel']);
            $Username = stripslashes($Row['UserName']);
            $Password = stripslashes($Row['Password']);
            $Message = 'Search completed!';
            $Error = "0";
          }else{
            $Message = "No user found. Please try again.";
            $Error = "1";
          }           
      }
    }
?>
