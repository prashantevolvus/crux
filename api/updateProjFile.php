<?php
  session_name("Project");
  session_start();
  require_once('../dbconn.php');

   // $log_file = "~/my-errors.log";
   // ini_set("log_errors", TRUE);
   // ini_set('error_log', $log_file);

  $insert_arr = array();


  foreach ($_POST as $key => $value) {
          // If the field exists in the $fields array, include it in the email
          $insert_arr[$key] = $value;


      }

  $projid = $insert_arr['projFileID'];
  $empno = $_SESSION["userempno"];
  $fileentity = $insert_arr['fileentity'];
  $filetype = $insert_arr['fileType'];
  $filedesc = $insert_arr['fileDesc'];


  $con=getConnection();





  if (count($_FILES) > 0) {
    $version = 1;

      if (is_uploaded_file($_FILES['filecontent']['tmp_name'])) {
          $sql="
              select   id,version  from  file_data
              where entity_id = {$projid} and entity_name = '{$fileentity}'
              and file_type_id = {$filetype}

          ";
          error_log($sql);
          $version = 0;
          $result = mysqli_query($con,$sql) or debug($sql."   failed  <br/><br/>");
          list($fileid,$version) = mysqli_fetch_array($result);
          $version++;
          if(!empty($fileid)){
            $sql="update file_data set latest = 0 where id = {$fileid} and latest = 1";
            $result = mysqli_query($con,$sql) or debug($sql."   failed  <br/><br/>");

          }
          else{
            $version = 1;
          }

          $fileData = addslashes(file_get_contents($_FILES['filecontent']['tmp_name']));
          $filesize = $_FILES['filecontent']['size'];
          $filename = $_FILES['filecontent']['name'];
          $mimetype = $_FILES['filecontent']['type'];

          $sql = "insert into file_data (
                    file_name,file_size,mime_type,file_desc,
                    file_content,entity_name,entity_id,uploaded_by,file_type_id,version
                    )
                    values (
                      '{$filename}',$filesize,'{$mimetype}','{$filedesc}',
                      '{$fileData}','{$fileentity}',{$projid},{$empno},{$filetype},{$version}
                    )";

          mysqli_query($con, $sql) or die("<b>Error:</b> {$sql} Problem on proposal  Insert<br/>" . mysqli_error($con));

      }



        }




?>
