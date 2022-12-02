<?php
    require_once '../php/centralConnection.php';
    session_start();
    if(empty($_SESSION['logged_in'])){
        header('Location: ../../index.html');
    } 
?>
<!DOCTYPE html>
<html>
 <head>
  <title>Backup</title>
  <script src="dist/jquery.min.js"></script>
  <link rel="stylesheet" type="text/css" href="../css/backup.css">
  <script src="../dist/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="../dist/jquery-confirm.min.css">
  <script src="../dist/jquery-confirm.min.js"></script>
  <script src="../dist/jspdf.debug.js"></script>
  <script src="../dist/jspdf.min.js"></script>
  <script src="../dist/html2pdf.bundle.min.js"></script>
 </head>
 <body>
    <nav>
      <span id="userFullname"><b><?php echo ucwords($_SESSION['homePosDisp']) . " ";
      $tempNAME = strtolower($_SESSION['fullname']);
      echo ucwords($tempNAME); 
      ?></b></span>
      <a href="Homepage/index.php" id="nav2" class="nav-pages active">Home</a>
      <a href="userList.php?type=checkRecords" id="nav3" class="nav-pages admin-nav">User List</a>
      <a href="Student/index.php?type=checkRecords" id="nav4" class="nav-pages">Student</a>
      <a href="Consultation/index.php?type=checkRecords" id="nav5" class="nav-pages">Consultation</a>
      
      <a href="#" id="nav7" onclick="logout()" class="nav-pages">Logout</a>
    </nav>

  <br />
  <div class="container" style="width:700px;">
   <div class="row">
    <br />
    <form method="post" id="export_form">
     <h3>Download a Backup</h3>
     <div class="form-group">
      <label for="TxtFileName">Enter filename</label>
      <input type="text" name="TxtFileName" id="TxtFileName" required />
      <input type="submit" name="submit" id="submit" class="btn btn-info" value="Download" />
     </div>
    </form>
   </div>
  </div>
 </body>
</html>

<script type="text/javascript">

    // ---------------------------start functions for System Logs---------------------------------------
            var act = "";

            //function called when logout tab pressed
            function logout(){
                act = "Logged out";
                logAction(act);
                /*alert("logs success");*/
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
    
            $(document).ready(function() {

                var acclvl = sessionStorage.getItem('isStandard');

                if(acclvl == "true"){
                    $(".admin-nav").hide();

                    document.getElementById("nav2").style.width = "12.5%";
                    document.getElementById("nav4").style.width = "12.5%";
                    document.getElementById("nav5").style.width = "12.5%";
                    document.getElementById("nav8").style.width = "12.5%";
                }
            }); 
</script> 

<?php

$get_all_table_query = "SHOW TABLES";
$statement = $connectPDO->prepare($get_all_table_query);
$statement->execute();
$result = $statement->fetchAll();


 $output = '';

 if(isset($_POST['TxtFileName']))
{
  $TxtFileName = $_POST['TxtFileName'];
  $output.= "\n\nDROP DATABASE if exists clinicRecord;\n";
  $output.= "CREATE DATABASE clinicRecord;\n";
  $output.= "USE clinicRecord;\n";

   $tableArray = array("archivedconsultation","archivedlog","archivedstaff","archivedstudent","consultationinfo","personalmedicalrecord","systemlogs","useraccounts");

 foreach($tableArray as $table)
 {
  $show_table_query = "SHOW CREATE TABLE " . $table . "";
  $statement = $connectPDO->prepare($show_table_query);
  $statement->execute();
  $show_table_result = $statement->fetchAll();

  foreach($show_table_result as $show_table_row)
  {
   $output .= "\n\n" . $show_table_row["Create Table"] . ";\n\n";
  }
  $select_query = "SELECT * FROM " . $table . "";
  $statement = $connectPDO->prepare($select_query);
  $statement->execute();
  $total_row = $statement->rowCount();

  for($count=0; $count<$total_row; $count++)
  {
   $single_result = $statement->fetch(PDO::FETCH_ASSOC);
   

   $table_column_array = array_keys($single_result);
   $table_value_array = array_values($single_result);
   if($table == "personalmedicalrecord" || $table == "archivedstudent"){
    $table_value_array[6] = null;
   }


   $output .= "\nINSERT INTO $table (";
   $output .= "" . implode(", ", $table_column_array) . ") VALUES (";
   $output .= "'" . implode("','", $table_value_array) . "');\n";
  }
 }
 $file_name = $TxtFileName ."--" . date('Y-m-d') . '.sql';
 $file_handle = fopen($file_name, 'w+');
 fwrite($file_handle, $output);
 fclose($file_handle);
 header('Content-Description: File Transfer');
 header('Content-Type: application/octet-stream');
 header('Content-Disposition: attachment; filename=' . basename($file_name));
 header('Content-Transfer-Encoding: binary');
 header('Expires: 0');
 header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file_name));
    ob_clean();
    flush();
    readfile($file_name);
    unlink($file_name);
}


?>
