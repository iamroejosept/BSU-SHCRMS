<?php
    session_start();
    if(empty($_SESSION['logged_in'])){
        header('Location: ../../index.html');
    } 

    
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>BSU - SHCRMS</title>
  <link rel = "icon" href = "images/BSU-UHSLogo.png" type = "image/x-icon">
	<link rel="stylesheet" type="text/css" href="css/homepage-style.css">
  <script src="dist/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="dist/jquery-confirm.min.css">
  <script src="dist/jquery-confirm.min.js"></script>
  <script type="text/javascript">

// ---------------------------start functions for System Logs---------------------------------------
            var act = "";
            var globalAL = "";

            //function called when logout tab pressed
            function logout(){
                act = "Logged out";
                logAction(act);
                /*alert("logs success");*/
                  $.ajax({
                    url:"../../php/logout.php",
                    method:"POST",
                    data:"",
                    success:function(xml){
                        sessionStorage.clear();
                        setTimeout(function(){
                            window.location.href = '../../index.html';
                        }, 100);
                    }
                  })
            }

            function openManual(){
                if(globalAL == "admin"){
                    window.open("../../files/ManualAdmin.pdf");
                }else if(globalAL == "superadmin"){
                    window.open("../../files/ManualSuperadmin.pdf");
                }else{
                    window.open("../../files/ManualStandard.pdf");                }
            }

            //main function for user activity logging
            function logAction(userAction){
                act = userAction;
                $.ajax({
                    url:"../../php/logAction.php",
                    method:"POST",
                    data:jQuery.param({ action: act, isSuccess:"1" }),
                    dataType: "xml",
                    success:function(xml){

                    }
                  })
            }

            //called to log user clicking "logs" tab
            function userCheckLogs(){
                act = "Checked User Activities." 
                logAction(act);
            }
        // ---------------------------end functions for System Logs---------------------------------------
    
            $(document).ready(function() {

                var acclvl = sessionStorage.getItem('isStandard');

                if(acclvl == "true"){
                    $(".admin-nav").hide();

                    document.getElementById("userFullname").style.width = "52%";
                    document.getElementById("nav2").style.width = "9.33%";
                    document.getElementById("nav3").style.width = "9.33%";
                    document.getElementById("nav4").style.width = "9.33%";
                    document.getElementById("nav5").style.width = "9.33%";
                    document.getElementById("nav7").style.width = "9.33%";
                    document.getElementById("nav8").style.width = "9.33%";
                }
            }); 
  </script>
</head>
<body>
    <nav>
      <span id="userFullname"><b><?php echo ucwords($_SESSION['homePosDisp']) . " ";
      $tempNAME = strtolower($_SESSION['fullname']);
      echo ucwords($tempNAME); 
      ?></b></span>
      <a href="#" id="nav2" class="nav-pages active">Home</a>
      <a href="../userList.php?type=checkRecords" id="nav3" class="nav-pages admin-nav">User List</a>
      <a href="../Student/index.php?type=checkRecords" id="nav4" class="nav-pages">Student</a>
      <a href="../Consultation/index.php?type=checkRecords" id="nav5" class="nav-pages">Consultation</a>
      
      <div class="dropdown nav-pages admin-nav" id="nav6">
          <button class="dropbtn">Maintenance</button>
                <div class="dropdown-content">
                    <a class="dropA" href="../logs.php?type=checkRecords" onclick="userCheckLogs()">Logs</a>
                    <a class="dropA" href="../Student/index.php?type=checkArchivedStudent">Archived Student Records</a>
                    <a class="dropA" href="../Consultation/index.php?type=checkArchivedConsultation">Archived Consultation Records</a>
                    <a class="dropA" href="../userList.php?type=checkArchivedStaff">Archived Staff Accounts</a>
                    <a class="dropA" href="../logs.php?type=checkArchivedLogs">Archived System Logs</a>
                    
                    <a class="dropA" href="../backup.php">Backup</a>
                    <a class="dropA" href="../restore.php">Restore</a>
                </div>
      </div>
      <a href="#" onclick="openManual()" id="nav8" class="nav-pages">Help</a>
      <a href="#" id="nav7" onclick="logout()" class="nav-pages">Logout</a>
    </nav> 
	  <div id="form_wrapper">
      <div id="form_left">
        <div id="vission">
          <h1>Vision</h1>
          <p>The university health services envisions itself as a provider of excellent health services for the Benguet State University community.</p>
        </div>
        <div id="mission">
          <h1>Mission</h1>
          <p>Develop a better quality of life through health promotions, disease prevention, and medical interention.</p>
        </div>
      </div>
      <div id="form_right">
        <img id="bsuUHS-logo" src="images/BSU-UHSLogo.png" alt="BSU-UHS Logo">
        <img id="bsu-logo" src="images/BSU-Logo.png" alt="BSU Logo">
      </div>
    </div>
</body>
</html>
<?php
$tempo = $_SESSION['accesslevel'];

    echo "<script type='text/javascript'>
        globalAL = '$tempo';
    </script>";
?>