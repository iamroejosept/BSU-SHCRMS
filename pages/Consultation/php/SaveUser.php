<?php
  require_once 'Database.php';
  require '../../../php/centralConnection.php';
	date_default_timezone_set('Asia/Manila');

  $Message = '';
  $Error;

  $numb = $_POST['numb'];

  // Receive Data from Client
  $TxtStudentIDNumber2 = $_POST['TxtStudentIDNumber2'];
  $TxtFirstName = $_POST['TxtFirstName'];
  $TxtMiddleName = $_POST['TxtMiddleName'];
  $TxtLastName = $_POST['TxtLastName'];
  $TxtExtension = $_POST['TxtExtension'];
  $TxtAge = $_POST['TxtAge'];
  $TxtSex = $_POST['TxtSex'];
  $TxtCourseStrand = $_POST['TxtCourseStrand'];
  $TxtYear = $_POST['TxtYear'];
  $TxtPhysician = $_POST['userFullN'];
  $TxtPhysicianIDNumber = $_POST['userID'];
  $TxtDate = $_POST['TxtDate'];
  $TxtComplaints = $_POST['TxtComplaints'];
  $TxtDiagnosis = $_POST['TxtDiagnosis'];
  $TxtDiagnosticTest = $_POST['TxtDiagnosticTest'];
  $TxtMedicineGiven = $_POST['TxtMedicineGiven'];
  $TxtTemperature = $_POST['TxtTemperature'];
  $TxtBP = $_POST['TxtBP'];
  $TxtPR = $_POST['TxtPR'];
  $RadSmoker = $_POST['RadSmoker'];
  $RadSanger = $_POST['RadSanger'];
  $RadMoma = $_POST['RadMoma'];
  $RadVS = $_POST['RadVS'];
  $TxtBooster = $_POST['TxtBooster'];
  $TxtVaccineBrand = $_POST['TxtVaccineBrand'];
  $TxtNumberOfStick = $_POST['TxtNumberOfStick'];
  $TxtNumberOfYears = $_POST['TxtNumberOfYears'];
  $TxtAgeStarted = $_POST['TxtAgeStarted'];
  $Others = $_POST['TxtOthers'];
  $TxtMomaSpan = $_POST['TxtMomaSpan'];
  $TxtRemarks = $_POST['TxtRemarks'];
  $TxtPhysicalFindings = $_POST['TxtPhysicalFindings'];
    
    $ClinicRecordsDB = new Database($Server,$User,$DBPassword);

    if ($ClinicRecordsDB->Connect()==true)
    {
      $Result = $ClinicRecordsDB->SelectDatabase($Database);
                          
      if($Result == true)
      {   
        UpdateUser();
      }
      else
      {
        $Message = 'Failed to save information!';
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

    function UpdateUser(){
      global $ClinicRecordsDB,$Message,$Error,$TxtStudentIDNumber2,$TxtDate,$TxtLastName,$TxtFirstName,$TxtMiddleName,$TxtPhysician,$TxtPhysicianIDNumber,$RadSmoker,$RadSanger,$RadMoma,$RadVS,$TxtBooster,$TxtComplaints,$TxtDiagnosis,$TxtDiagnosticTest,$TxtMedicineGiven,$TxtTemperature,$TxtBP,$TxtPR, $TxtNumberOfStick,$TxtNumberOfYears,$TxtAgeStarted,$Others,$TxtMomaSpan, $numb, $TxtExtension,$TxtVaccineBrand,$TxtAge,$TxtSex,$TxtCourseStrand,$TxtYear,$TxtRemarks,$TxtPhysicalFindings;

      $sql;

      $TxtStudentIDNumber2 = strtolower($TxtStudentIDNumber2);
      $TxtDate = strtolower($TxtDate);
      $TxtLastName = strtolower($TxtLastName);
      $TxtFirstName = strtolower($TxtFirstName);
      $TxtMiddleName = strtolower($TxtMiddleName);
      $TxtExtension = strtolower($TxtExtension);
      $TxtSex = strtolower($TxtSex);
      $TxtCourseStrand = strtolower($TxtCourseStrand);
      $TxtPhysician = strtolower($TxtPhysician);
      $TxtPhysicianIDNumber = strtolower($TxtPhysicianIDNumber);
      $TxtTemperature = strtolower($TxtTemperature);
      $TxtBP = strtolower($TxtBP);
      $TxtPR = strtolower($TxtPR);
      $RadSmoker = strtolower($RadSmoker);
      $RadSanger = strtolower($RadSanger);
      $RadMoma = strtolower($RadMoma);
      $RadVS = strtolower($RadVS);
      $TxtBooster = strtolower($TxtBooster);
      $TxtNumberOfStick = strtolower($TxtNumberOfStick);
      $TxtNumberOfYears = strtolower($TxtNumberOfYears);
      $TxtAgeStarted = strtolower ($TxtAgeStarted);
      $Others = strtolower ($Others);
      $TxtVaccineBrand = strtolower ($TxtVaccineBrand);
      $TxtMomaSpan = strtolower ($TxtMomaSpan);

      $sql = "UPDATE ConsultationInfo SET IdNumb='$TxtStudentIDNumber2', LastN='$TxtLastName', FirstN='$TxtFirstName', MiddleN='$TxtMiddleName', Physician='$TxtPhysician', PhysicianID='$TxtPhysicianIDNumber', Complaints='$TxtComplaints', Diagnosis='$TxtDiagnosis', DiagnosticTestNeeded='$TxtDiagnosticTest', MedicineGiven='$TxtMedicineGiven', Temperature='$TxtTemperature', BloodPressure='$TxtBP', PulseRate='$TxtPR', Smoker='$RadSmoker', NumOfStick='$TxtNumberOfStick', NumOfYearAsSmoker='$TxtNumberOfYears', AlcoholDrinker='$RadSanger', AgeStartedAsDrinker='$TxtAgeStarted', Others='$Others', Moma='$RadMoma', HowLongAsChewer='$TxtMomaSpan', Vaccination='$RadVS', Booster='$TxtBooster', Extens='$TxtExtension', Vaccine='$TxtVaccineBrand', Ages='$TxtAge', Sexs='$TxtSex', CourseStrand='$TxtCourseStrand', Years='$TxtYear', PhysicalFindings='$TxtPhysicalFindings', Remarks='$TxtRemarks', updated_at = CURRENT_TIMESTAMP WHERE Num='$numb'";

      $Result = $ClinicRecordsDB->Execute($sql);


      $Message = 'Successfully stored!';   
      $Error = "1";
    }
?>
