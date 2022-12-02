<?php
require_once 'Database.php';
require '../../../php/centralConnection.php';
date_default_timezone_set('Asia/Manila');

  $Message = '';
  $Error = "0";

  $temp = $_POST['temp'];
  $numb = $_POST['numb'];
  $type = $_POST['type'];

    $TxtStudentIDNumber = "";
    $TxtFirstName = "";
    $TxtMiddleName = "";
    $TxtLastName = "";
    $TxtExtension = "";
    $TxtAge = "";
    $TxtSex = "";
    $TxtCourseStrand = "";
    $TxtYear = "";
    $TxtPhysician = "";
    $TxtPhysicianIDNumber = "";
    $TxtDate = "";
    $TxtComplaints = "";
    $TxtDiagnosis = "";
    $TxtDiagnosticTest = "";
    $TxtMedicineGiven = "";
    $TxtTemperature = "";
    $TxtBP = "";
    $TxtPR = "";
    $RadSmoker = "";
    $RadSanger = "";
    $RadMoma = "";
    $RadVS = "";
    $TxtNumOfStick = "";
    $TxtNumOfYearAsSmoker = "";
    $TxtAgeStartedAsDrinker = "";
    $TxtOthers = "";
    $TxtHowLongAsChewer = "";
    $TxtBooster = "";
    $TxtVaccineBrand = "";
    $TxtRemarks = "";
    $TxtPhysicalFindings = "";
    
  if($temp == "1"){
    $ClinicRecordsDB = new Database($Server,$User,$DBPassword);

    if ($ClinicRecordsDB->Connect()==true)
    {
      $Result = $ClinicRecordsDB->SelectDatabase($Database);
                          
      if($Result == true)
      {   
        FetchUser($numb);
        
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
  $XMLData .= ' StudentIDNumber = ' . '"'.$TxtStudentIDNumber.'"';
  $XMLData .= ' FirstName = ' . '"'.$TxtFirstName.'"';
  $XMLData .= ' MiddleName = ' . '"'.$TxtMiddleName.'"';
  $XMLData .= ' LastName = ' . '"'.$TxtLastName.'"';
  $XMLData .= ' Extension = ' . '"'.$TxtExtension.'"';
  $XMLData .= ' Age = ' . '"'.$TxtAge.'"';
  $XMLData .= ' Sex = ' . '"'.$TxtSex.'"';
  $XMLData .= ' CourseStrand = ' . '"'.$TxtCourseStrand.'"';
  $XMLData .= ' Year = ' . '"'.$TxtYear.'"';
  $XMLData .= ' Physician = ' . '"'.$TxtPhysician.'"';
  $XMLData .= ' PhysicianIDNumber = ' . '"'.$TxtPhysicianIDNumber.'"';
  $XMLData .= ' Date = ' . '"'.$TxtDate.'"';
  $XMLData .= ' Complaints = ' . '"'.$TxtComplaints.'"';
  $XMLData .= ' Diagnosis = ' . '"'.$TxtDiagnosis.'"';
  $XMLData .= ' DiagnosticTest = ' . '"'.$TxtDiagnosticTest.'"';
  $XMLData .= ' MedicineGiven = ' . '"'.$TxtMedicineGiven.'"';
  $XMLData .= ' Temperature = ' . '"'.$TxtTemperature.'"';
  $XMLData .= ' BP = ' . '"'.$TxtBP.'"';
  $XMLData .= ' PR = ' . '"'.$TxtPR.'"';
  $XMLData .= ' Smoker = ' . '"'.$RadSmoker.'"';
  $XMLData .= ' Sanger = ' . '"'.$RadSanger.'"';
  $XMLData .= ' Moma = ' . '"'.$RadMoma.'"';
  $XMLData .= ' VS = ' . '"'.$RadVS.'"';
  $XMLData .= ' NumOfStick = ' . '"'.$TxtNumOfStick.'"';
  $XMLData .= ' NumOfYearAsSmoker = ' . '"'.$TxtNumOfYearAsSmoker.'"';
  $XMLData .= ' AgeStartedAsDrinker = ' . '"'.$TxtAgeStartedAsDrinker.'"';
  $XMLData .= ' Others = ' . '"'.$TxtOthers.'"';
  $XMLData .= ' HowLongAsChewer = ' . '"'.$TxtHowLongAsChewer.'"';
  $XMLData .= ' Booster = ' . '"'.$TxtBooster.'"';
  $XMLData .= ' VaccineBrand = ' . '"'.$TxtVaccineBrand.'"';
  $XMLData .= ' Remarks = ' . '"'.$TxtRemarks.'"';
  $XMLData .= ' PhysicalFindings = ' . '"'.$TxtPhysicalFindings.'"';
	$XMLData .= ' />';
	
	//Generate XML output
	header('Content-Type: text/xml');
	//Generate XML header
	echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
	echo '<Document>';    	
	echo $XMLData;
	echo '</Document>';

  function FetchUser($numb){
    $sql;

    //Access Global Variables
    global $Error, $ClinicRecordsDB, $Message, $TxtStudentIDNumber,$TxtFirstName,$TxtMiddleName,$TxtLastName,$TxtPhysician,$TxtPhysicianIDNumber,$TxtDate,$TxtComplaints,$TxtDiagnosis,$TxtDiagnosticTest,$TxtMedicineGiven,$TxtTemperature,$TxtBP,$TxtPR,$RadSmoker,$RadSanger,$RadMoma,$RadVS,$TxtNumOfStick,$TxtNumOfYearAsSmoker,$TxtAgeStartedAsDrinker,$TxtOthers,$TxtHowLongAsChewer,$TxtBooster,$TxtExtension,$TxtVaccineBrand, $type,$TxtAge,$TxtSex,$TxtCourseStrand,$TxtYear,$TxtRemarks,$TxtPhysicalFindings;

      if ($type =='viewArchivedCons'){
        $sql = "SELECT * FROM archivedconsultation  WHERE Num = '$numb'";
      }else if ($type == 'viewCons'){
        $sql = "SELECT * FROM ConsultationInfo  WHERE Num = '$numb'";
      }

      $Result = $ClinicRecordsDB->Execute($sql);
      
      $ClinicRecordQuery = $ClinicRecordsDB->GetRows($sql);                
    
      if($ClinicRecordQuery)
      {
        $Row = $ClinicRecordQuery->fetch_array();
        if($Row)
          {        
            $TxtStudentIDNumber = stripslashes($Row['IdNumb']);;
            $TxtFirstName = stripslashes($Row['FirstN']);;
            $TxtMiddleName = stripslashes($Row['MiddleN']);;
            $TxtLastName = stripslashes($Row['LastN']);;
            $TxtExtension = stripslashes($Row['Extens']);;
            $TxtAge = stripslashes($Row['Ages']);;
            $TxtSex = stripslashes($Row['Sexs']);;
            $TxtCourseStrand = stripslashes($Row['CourseStrand']);;
            $TxtYear = stripslashes($Row['Years']);;
            $TxtPhysician = stripslashes($Row['Physician']);;
            $TxtPhysicianIDNumber = stripslashes($Row['PhysicianID']);;
            $TxtDate = stripslashes($Row['Dates']);;
            $TxtComplaints = htmlentities($Row['Complaints']);
            $TxtComplaints = str_replace("<br />", "&#13;&#10;", nl2br($TxtComplaints));
            $TxtDiagnosis = htmlentities($Row['Diagnosis']);
            $TxtDiagnosis = str_replace("<br />", "&#13;&#10;", nl2br($TxtDiagnosis));
            $TxtDiagnosticTest = htmlentities($Row['DiagnosticTestNeeded']);
            $TxtDiagnosticTest = str_replace("<br />", "&#13;&#10;", nl2br($TxtDiagnosticTest));
            $TxtMedicineGiven = htmlentities($Row['MedicineGiven']);
            $TxtMedicineGiven = str_replace("<br />", "&#13;&#10;", nl2br($TxtMedicineGiven));
            $TxtTemperature = stripslashes($Row['Temperature']);;
            $TxtBP = stripslashes($Row['BloodPressure']);;
            $TxtPR = stripslashes($Row['PulseRate']);;
            $RadSmoker = stripslashes($Row['Smoker']);;
            $RadSanger = stripslashes($Row['AlcoholDrinker']);;
            $RadMoma = stripslashes($Row['Moma']);;
            $RadVS = stripslashes($Row['Vaccination']);;
            $TxtNumOfStick = stripslashes($Row['NumOfStick']);;
            $TxtNumOfYearAsSmoker = stripslashes($Row['NumOfYearAsSmoker']);;
            $TxtAgeStartedAsDrinker = stripslashes($Row['AgeStartedAsDrinker']);;
            $TxtOthers = stripslashes($Row['Others']);;
            $TxtHowLongAsChewer = stripslashes($Row['HowLongAsChewer']);;
            $TxtBooster = stripslashes($Row['Booster']);;
            $TxtVaccineBrand = stripslashes($Row['Vaccine']);;
            $TxtRemarks = htmlentities($Row['Remarks']);
            $TxtRemarks = str_replace("<br />", "&#13;&#10;", nl2br($TxtRemarks));
            $TxtPhysicalFindings = htmlentities($Row['PhysicalFindings']);
            $TxtPhysicalFindings = str_replace("<br />", "&#13;&#10;", nl2br($TxtPhysicalFindings));
            $Message = "Search completed!";
            $Error = "0"; 
          }else{
            $Message = "No user found. Please try again.";
            $Error = "1";
          }            
      }
  }

  function br2nl( $input ) {
    return preg_replace('/<br\s?\/?>/ius', "\n", str_replace("\n","",str_replace("\r","", htmlspecialchars_decode($input))));
}

?>