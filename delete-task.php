<?php 

  require_once "config/constants.php";

  if(isset($_GET['task_id'])) {

    // Delete the task from database
    $task_id = $_GET['task_id'];

    $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error($conn));

    $select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error($conn));

    $query = "DELETE FROM tbl_tasks WHERE task_id='$task_id'";

    $result = mysqli_query($conn, $query);

    if($result) {

      $_SESSION['delete_task'] = '<p class="success">Task deleted successfully.</p>';
      header("location: ".APPURL."");
    } else {

      $_SESSION['delete_task_fail'] = '<p class="error">Failed to delete task.</p>';
      header("location: ".APPURL."");
    }
  } else {

    // Redirect to home page
    header("location: ".APPURL."");
  }

?>