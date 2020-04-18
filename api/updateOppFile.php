<?php
  session_name("Project");
  session_start();
  require_once('../dbconn.php');

   $log_file = "/Users/prashantm/development/GitHub/crux/my-errors.log";
   ini_set("log_errors", TRUE);
   ini_set('error_log', $log_file);

  $insert_arr = array();


  foreach ($_POST as $key => $value) {
          // If the field exists in the $fields array, include it in the email
          $insert_arr[$key] = $value;
          error_log($key);

          error_log($value);

      }

  $oppid = $insert_arr['opportunity-id'];
  $empno = $_SESSION["userempno"];

  $con=getConnection();


  $sql="select estimation_sheet , proposal_doc from  opp_details where id = {$oppid}";
  $result = mysqli_query($con,$sql) or debug($sql."   failed  <br/><br/>");
  list($estimation, $proposal) = mysqli_fetch_array($result);

  if(!empty($estimation) && !empty($proposal)){
    $sql="update file_data set is_deleted = 1 where id in( {$estimation}, {$proposal})";
    $result = mysqli_query($con,$sql) or debug($sql."   failed  <br/><br/>");
  }





  if (count($_FILES) > 0) {
      if (is_uploaded_file($_FILES['proposal']['tmp_name'])) {
          $fileData = addslashes(file_get_contents($_FILES['proposal']['tmp_name']));
          $filesize = $_FILES['proposal']['size'];
          $filename = $_FILES['proposal']['name'];
          $filetype = $_FILES['proposal']['type'];

          $sql = "insert into file_data (
                    file_name,file_size,mime_type,
                    file_content,entity_name,entity_id,uploaded_by
                    )
                    values (
                      '{$filename}',$filesize,'{$filetype}',
                      '{$fileData}','OPP',$oppid,$empno
                    )";
          mysqli_query($con, $sql) or die("<b>Error:</b> Problem on proposal  Insert<br/>" . mysqli_error($con));
          $insPK = mysqli_insert_id($con);


          $sql = "update opp_details set proposal_doc = {$insPK} where id = {$insert_arr['opportunity-id']}";
          mysqli_query($con, $sql) or die("<b>Error:</b> Problem on  proposal update<br/>" . mysqli_error($con));

      }


        if (is_uploaded_file($_FILES['estimate']['tmp_name'])) {
            $fileData = addslashes(file_get_contents($_FILES['estimate']['tmp_name']));
            $filesize = $_FILES['estimate']['size'];
            $filename = $_FILES['estimate']['name'];
            $filetype = $_FILES['estimate']['type'];

            $sql = "insert into file_data (
                      file_name,file_size,mime_type,
                      file_content,entity_name,entity_id,uploaded_by
                      )
                      values (
                        '{$filename}',$filesize,'{$filetype}',
                        '{$fileData}','OPP',$oppid,$empno
                      )";
            mysqli_query($con, $sql) or die("<b>Error:</b> Problem on estimate Insert<br/>" . mysqli_error($con));
            $insPK = mysqli_insert_id($con);



            $sql = "update opp_details set estimation_sheet = {$insPK} where id = {$insert_arr['opportunity-id']}";
            mysqli_query($con, $sql) or die("<b>Error:</b> Problem on  estimate update<br/>" . mysqli_error($con));

        }


}

?>
