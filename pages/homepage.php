<?php
    session_start();

    if(empty($_SESSION['logged_in'])){
        header('Location: ../index.html');
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Homepage</title>
        <link rel="stylesheet" href="../css/homepage-style.css">
        <link rel = "icon" href = "../images/BSU-Logo.png" type = "image/x-icon">
        <script src="../dist/jquery-3.6.0.min.js"></script>
        <link rel="stylesheet" href="../dist/jquery-confirm.min.css">
        <script src="../dist/jquery-confirm.min.js"></script>
        <script type="text/javascript">

// ---------------------------start functions for System Logs---------------------------------------
            var act = "";

            //function called when logout tab pressed
            function logout(){
                act = "Logged out";
                logAction(act);
                alert("logs success");
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

            //called to log user clicking "logs" tab
            function userCheckLogs(){
                act = "Checked User Activities." 
                logAction(act);
            }
// ---------------------------end functions for System Logs---------------------------------------



           /* function logout(){
            sessionStorage.clear();
            }*/

            $(document).ready(function() {

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
    <div>
     <nav>
            <a href="../pages/homepage.php" id="nav1" class="nav-logo">
                <section>
                    <div id="contani" class="rt-container">
                        <div id="hrani" class="heart-rate">
                        <svg id="navani" version="1.0" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="35vw" height="4.5vw" viewBox="0 0 750 85" enable-background="new 0 0 850 60" xml:space="preserve">
                          <polyline id="polani" fill="none" stroke="#062102" stroke-width="6" stroke-miterlimit="0" points="0,45.486 38.514,45.486 44.595,33.324 50.676, 45.486 57.771,45.486 62.838,55.622 71.959,9 80.067,63.729 84.122,45.486 97.297, 45.486 103.379, 20.324 110.07, 60.45 117.07, 35 121, 45 160, 45 167, 55 173, 25 180, 68 189, 8 196, 48 205, 48  210, 56 216, 35 223, 66 229, 48 270, 48 276, 35 284, 72 289, 50 297, 50 304, 20 312, 60 320, 40 325, 48 370, 48 379, 8 387, 58 393, 38 399, 69 408, 22 414, 48 421, 48 428, 62 432, 48 485, 48 492, 78 500, 27 507, 48 515, 48 521, 65 528, 48, 570, 48 579, 9 587, 75 595, 38 604, 38 610, 17 618, 48 627, 48 632, 64 639, 22 645, 48 690, 48" />
                        </svg>
                            
                            <div id="fiani" class="fade-in"></div>
                            <div id="foani" class="fade-out"></div>
                        </div>
    		         </div>
                </section></a>
            <a href="../pages/homepage.php" id="nav2" class="nav-pages">Home</a>
            <a href="../pages/addUser.php" id="nav3" class="nav-pages admin-nav">Add Staff</a>
            <a href="../pages/searchUser.php" id="nav4" class="nav-pages admin-nav">Search Staff</a>
            <a href="../pages/addRecord.php" id="nav5" class="nav-pages">Add Record</a>
            <a href="#" id="nav6" class="nav-pages">Search Record</a>
            <a href="../pages/logs.php" id="nav7" onclick="userCheckLogs()" class="nav-pages admin-nav">Logs</a>
            <a href="../php/logout.php" id="nav8" onclick="logout()" class="nav-pages">Logout</a>
            <div id="line" class="animation start-home"></div>
    </nav>
    </div>
    <div>
        <img src="../images/BSU-Logo.png" alt="Logo" width="28%" height="28%">
        <h4>STUDENT HEALTH CONSULTATION<br/>RECORD MANAGEMENT SYSTEM</h4>
    </div>
</body>

</html>