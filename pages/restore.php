<?php
    require_once '../php/centralConnection.php';
    session_start();
    if(empty($_SESSION['logged_in'])){
        header('Location: ../../index.html');
    } 

    $message = '';
?>
<!DOCTYPE html>  
<html>  
 <head>  
  <title>Restore</title>  
  <script src="dist/jquery.min.js"></script>
  <link rel="stylesheet" type="text/css" href="../css/restore.css">
  <script src="../dist/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="../dist/jquery-confirm.min.css">
  <script src="../dist/jquery-confirm.min.js"></script>
  <script src="../dist/jspdf.debug.js"></script>
  <script src="../dist/jspdf.min.js"></script>
  <script src="../dist/html2pdf.bundle.min.js"></script> 
  <script>
    var globalAL = "";
    
    function openManual(){
                if(globalAL == "admin"){
                    window.open("../files/ManualAdmin.pdf");
                }else if(globalAL == "superadmin"){
                    window.open("../files/ManualSuperadmin.pdf");
                }else{
                    window.open("../files/ManualStandard.pdf");                }
            }
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
          <button class="dropbtn active">Maintenance</button>
                <div class="dropdown-content">
                    <a class="dropA" href="logs.php?type=checkRecords" onclick="userCheckLogs()">Logs</a>
                    <a class="dropA" href="Student/index.php?type=checkArchivedStudent">Archived Student Records</a>
                    <a class="dropA" href="Consultation/index.php?type=checkArchivedConsultation">Archived Consultation Records</a>
                    <a class="dropA" href="userList.php?type=checkArchivedStaff">Archived Staff Accounts</a>
                    <a class="dropA" href="logs.php?type=checkArchivedLogs">Archived System Logs</a>
                    
                    <a class="dropA" href="backup.php">Backup</a>
                    <a class="dropA" href="#">Restore</a>
                </div>
      </div>
      <a href="#" onclick="openManual()" id="nav8" class="nav-pages">Help</a>
      <a href="#" id="nav7" onclick="logout()" class="nav-pages">Logout</a>
    </nav> 
  <br /><br />  
  <div class="container" style="width:700px;">  
    
   <h3 align="center">Please select a backup file to restore database</h3>  
   <br />
   <div><?php echo $message; ?></div>
   <form method="post" enctype="multipart/form-data">
    <p><label>Select Sql File</label>
    <input type="file" name="database" /></p>
    <br />
    <input type="submit" name="import" class="btn btn-info" value="Upload" /><br><br>
   </form>
  </div>  
 </body>  
</html>

<?php 

$tempo = $_SESSION['accesslevel'];

    echo "<script type='text/javascript'>
        globalAL = '$tempo';
    </script>";


if(isset($_POST["import"]))
{
 if($_FILES["database"]["name"] != '')
 {
  $array = explode(".", $_FILES["database"]["name"]);
  $extension = end($array);
  if($extension == 'sql')
  {
   $output = '';
   $count = 0;
   $file_data = file($_FILES["database"]["tmp_name"]);
   foreach($file_data as $row)
   {
    $start_character = substr(trim($row), 0, 2);
    if($start_character != '--' || $start_character != '/*' || $start_character != '//' || $row != '')
    {

     $output = $output . $row;
     
     $end_character = substr(trim($row), -1, 1);
     if($end_character == ';')
     {
      if(!mysqli_query($connect, $output))
      {
       $count++;
      }
      $output = '';
     }
    }
   }
   if($count > 0)
   {
    $message = '<label class="text-danger">There is an error in Database Import</label>';
   }
   else
   {
    $message = '<label class="text-success">Database Successfully Imported</label>';
   }
  }
  else
  {
   $message = '<label class="text-danger">Invalid File</label>';
  }
 }
 else
 {
  $message = '<label class="text-danger">Please Select Sql File</label>';
 }
}
?>


