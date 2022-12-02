<?php
    require_once '../php/Database.php';
    require '../php/centralConnection.php';
    date_default_timezone_set('Asia/Manila');
    session_start();
    if(empty($_SESSION['logged_in'])){
    header('Location: ../index.html');
    }

    $ClinicRecordsDB = new Database($Server,$User,$DBPassword);

    if ($ClinicRecordsDB->Connect()==true)
    {
        $Result = $ClinicRecordsDB->SelectDatabase($Database);
                      
        if($Result == true)
        {         
            if($_SERVER['REQUEST_METHOD'] == 'GET'){
                if($_GET["type"] == "checkRecords"){
                    $sql = "SELECT * FROM SYSTEMLOGS";          
                    $ClinicRecordsQuery = $ClinicRecordsDB->GetRows($sql);
                }else if($_GET["type"] == "checkArchivedLogs"){
                    $sql = "SELECT * FROM archivedlog";          
                    $ClinicRecordsQuery = $ClinicRecordsDB->GetRows($sql);
                }
                $type = $_GET["type"];
            }
                   
        }
    }

    if(empty($_SESSION['logged_in'])){
        header('Location: ../index.html');
    }

?>  

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>System Logs</title>  
        <link rel = "icon" href = "../images/BSU-Logo.png" type = "image/x-icon">
        <script src="Staff/dist/jquery.min.js"></script> 
        <link rel="stylesheet" href="Staff/dist/bootstrap.min.css" />
        <script src="Staff/dist/jquery.dataTables.min.js"></script>  
        <script src="Staff/dist/dataTables.bootstrap.min.js"></script>   
        <link rel="stylesheet" href="Staff/dist/dataTables.bootstrap.min.css" /> 
        <link rel="stylesheet" href="../css/logs.css">

        <script>  

        // ---------------------------start functions for System Logs---------------------------------------
            var act = "";
            var globalAL = "";

            //function called when logout tab pressed
            function logout(){
                act = "Logged out";
                logAction(act);
                  $.ajax({
                    url:"../php/logout.php",
                    method:"POST",
                    data:"",
                    success:function(xml){
                        sessionStorage.clear();
                        setTimeout(function(){
                            window.location.href = '../index.html';
                        }, 100);
                    }
                  })
            }

            //main function for user activity logging
            function logAction(userAction){
                act = userAction;
                $.ajax({
                    url:"../php/logAction.php",
                    method:"POST",
                    data:jQuery.param({ action: act, isSuccess:"1" }),
                    dataType: "xml",
                    success:function(xml){

                    }
                })
            }

            function openManual(){
                if(globalAL == "admin"){
                    window.open("../files/ManualAdmin.pdf");
                }else if(globalAL == "superadmin"){
                    window.open("../files/ManualSuperadmin.pdf");
                }else{
                    window.open("../files/ManualStandard.pdf");                }
            }

            //called to log user clicking "logs" tab
            function userCheckLogs(){
                act = "Checked User Activities." 
                logAction(act);
            }
// ---------------------------end functions for System Logs---------------------------------------
            
            function deleteLogs(){
                var acttype = "archiveLogs";

                if(confirm("Are you sure you want to archive all system logs?")){
                    $.ajax({
                    url:"../php/archive.php",
                    method:"GET",
                    data:jQuery.param({ type: acttype}),
                    success:function(xml){
                        $(xml).find('output').each(function()
                        {
                            $(xml).find('output').each(function()
                            {
                                var message = $(this).attr('Message');
                                logAction(message);
                                alert(message);

                            });
                            window.location.href = 'logs.php?type=checkRecords';

                        });
                    }
                })
                }

            }

             function editTableNav(y){
                if(y == "checkArchived"){
                    document.getElementById('tab1').innerHTML = '&bull;&nbsp;ARCHIVED SYSTEM LOGS&nbsp;&bull;';
                }else{
                    document.getElementById('tab1').innerHTML = '&bull;&nbsp;SYSTEM LOGS&nbsp;&bull;';
                }
            }

            function userRestoreRecord(){
                acttype = "restoreLogs";

                if(confirm("Are you sure you want to restore all system logs?")){
                    $.ajax({
                    url:"../php/restore.php",
                    method:"GET",
                    data:jQuery.param({ type: acttype}),
                    success:function(xml){
                        $(xml).find('output').each(function()
                        {
                            $(xml).find('output').each(function()
                            {
                                var message = $(this).attr('Message');
                                logAction(message);
                                alert(message);

                            });
                            window.location.href = 'logs.php?type=checkArchivedLogs';

                        });
                    }
                })
                }


            }

        $(document).ready(function(){  
            var table = $('#user_data').DataTable({
                dom: 'fltp',
                'paging': true
            });
            var length = table.page.info().recordsTotal;

            var span = document.getElementById("NumRecord");
            span.textContent = "Total Number of Record/s: " + length.toString();
        
                var acclvl = sessionStorage.getItem('isStandard');

                if(acclvl == "true"){
                    $(".admin-nav").hide();
                    document.getElementById("nav1").style.width = "64%";
                    document.getElementById("nav2").style.width = "8%";
                    document.getElementById("nav5").style.width = "8%";
                    document.getElementById("nav6").style.width = "14%";
                    document.getElementById("nav7").style.width = "5%";
                    document.getElementById("line").style.width = "4.5%";
                    document.getElementById("line").style.left = "66%";

                    document.getElementById("nav5").addEventListener("mouseover", function(){
                        document.getElementById("line").style.width = "7.8%";
                        document.getElementById("line").style.left = "72.3%";
                    });
                    document.getElementById("nav5").addEventListener("mouseout", function(){
                        document.getElementById("line").style.width = "4.5%";
                        document.getElementById("line").style.left = "66%";
                    });

                    document.getElementById("nav6").addEventListener("mouseover", function(){
                        document.getElementById("line").style.width = "9.5%";
                        document.getElementById("line").style.left = "82.3%";
                    });
                    document.getElementById("nav6").addEventListener("mouseout", function(){
                        document.getElementById("line").style.width = "4.5%";
                        document.getElementById("line").style.left = "66%";
                    });

                    document.getElementById("nav7").addEventListener("mouseover", function(){
                        document.getElementById("line").style.width = "4.3%";
                        document.getElementById("line").style.left = "94.5%";
                    });

                    document.getElementById("nav7").addEventListener("mouseout", function(){
                        document.getElementById("line").style.width = "4.5%";
                        document.getElementById("line").style.left = "66%";
                    });

                    document.getElementById("navani").setAttribute("width", "55vw");
                    document.getElementById("navani").setAttribute("viewBox", "0 0 1060 85");
                    document.getElementById("navani").setAttribute("enable-background", "new 0 0 1000 60");
                    document.getElementById("polani").setAttribute("points", "0,45.486 38.514,45.486 44.595,33.324 50.676, 45.486 57.771,45.486 62.838,55.622 71.959,9 80.067,63.729 84.122,45.486 97.297, 45.486 103.379, 20.324 110.07, 60.45 117.07, 35 121, 45 160, 45 167, 55 173, 25 180, 68 189, 8 196, 48 205, 48  210, 56 216, 35 223, 66 229, 48 270, 48 276, 35 284, 72 289, 50 297, 50 304, 20 312, 60 320, 40 325, 48 370, 48 379, 8 387, 58 393, 38 399, 69 408, 22 414, 48 421, 48 428, 62 432, 48 485, 48 492, 78 500, 27 507, 48 515, 48 521, 65 528, 48, 570, 48 579, 9 587, 75 595, 38 604, 38 610, 17 618, 48 627, 48 632, 64 639, 22 645, 48 700, 48 708, 63 716, 48 723, 48 729, 35 738, 75 746, 17 754, 48 767, 48 773, 63 780, 27 787, 48 832, 48 839, 57 846, 15 853, 58 860, 40 868, 80 875, 52 883, 52 891, 25 898, 48 945, 48 952, 36 959, 59 966, 16 972, 48 979, 48 985, 77 993, 23 1000, 58 1008, 48 1060, 48");

                    document.getElementById("contani").setAttribute("class", "rt-containerSTAFF");
                    document.getElementById("hrani").setAttribute("class", "heart-rateSTAFF");
                    document.getElementById("fiani").setAttribute("class", "fade-inSTAFF");
                    document.getElementById("foani").setAttribute("class", "fade-outSTAFF");
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
      <a href="Homepage/index.php" id="nav2" class="nav-pages">Home</a>
      <a href="userList.php?type=checkRecords" id="nav3" class="nav-pages admin-nav">User List</a>
      <a href="Student/index.php?type=checkRecords" id="nav4" class="nav-pages">Student</a>
      <a href="Consultation/index.php?type=checkRecords" id="nav5" class="nav-pages">Consultation</a>
      
      <div class="dropdown nav-pages admin-nav" id="nav6">
          <button class="dropbtn active" id="dropbtnLbl">Maintenance</button>
                <div class="dropdown-content">
                    <a class="dropA" id="systemLog" href="logs.php?type=checkRecords" onclick="userCheckLogs()">Logs</a>
                    <a class="dropA" href="Student/index.php?type=checkArchivedStudent">Archived Student Records</a>
                    <a class="dropA" href="Consultation/index.php?type=checkArchivedConsultation">Archived Consultation Records</a>
                    <a class="dropA" href="userList.php?type=checkArchivedStaff">Archived Staff Accounts</a>
                    <a class="dropA" id="archivedSystemLog" href="logs.php?type=checkArchivedLogs">Archived System Logs</a>
                    
                    <a class="dropA" href="backup.php">Backup</a>
                    <a class="dropA" href="restore.php">Restore</a>
                </div>
      </div>
      <a href="#" onclick="openManual()" id="nav8" class="nav-pages">Help</a>
      <a href="#" id="nav7" onclick="logout()" class="nav-pages">Logout</a>
    </nav> 
        <div class="cont container">
            <div class="tabs">
                <div class="tabs-head">
                    <span id="tab1" class="tabs-toggle is-active">&bull;&nbsp;SYSTEM LOGS&nbsp;&bull;</span>
                </div>
                <div id="notif">
                    <?php 
                    if ($type == 'checkArchivedLogs'){
                        echo "<input type=\"button\" id=\"deleteLogs\" class=\"btn btn-primary\" onclick=\"userRestoreRecord()\" value=\"Restore Logs\"></input>";
                    }else if ($type == 'checkRecords'){
                        echo "<input type=\"button\" id=\"deleteLogs\" class=\"btn btn-primary\" onclick=\"deleteLogs()\" value=\"Archive Logs\"></input>";
                    }
                    ?>
                    
                    <!-- <a href="../php/archive.php?type=archiveLogs" class="btn btn-primary">Archive Logs</a> -->
                    <span id="NumRecord">Total Number of Record/s: </span>
                </div>
                <div class="tabs-body">
                    <div class="tabs-content is-active table-responsive">  
                    <table id="user_data" class="table table-striped table-bordered">  
                          <thead>  
                               <tr>  
                                        <th>UserID</th>
                                        <th>Username</th>
                                        <th>System Feedback</th>
                                        <th>Date and Time</th>
                                        <th>Access Level</th>
                               </tr>  
                          </thead>  
                          <?php        
                          while($Row = $ClinicRecordsQuery->fetch_array())  
                          {  
                                $Row = array_map('strtoupper', $Row);
                                echo "  
                                <tr>
                                    <td>$Row[userID]</td>
                                    <td>$Row[username]</td>
                                    <td>$Row[action]</td>
                                    <td>$Row[date]</td>
                                    <td>$Row[position]</td>
                                </tr>
                               ";  
                          }  
                          ?>  
                     </table> 
                    </div>
                </div>
            </div>
        </div>
        <script src="../js/script-tab.js"></script>
    </body>
</html>
<?php
    $tempo = $_SESSION['accesslevel'];
    $tempor =  "";
    $_SESSION["typed"] = $_GET["type"];

    if($_GET["type"] == 'checkArchivedLogs'){
        $tempor = "checkArchived";
    }else{
        $tempor = "checkRecord";
    }

    echo "<script type='text/javascript'>
        globalAL = '$tempo';
        editTableNav('$tempor');
    </script>";
?>
 
 