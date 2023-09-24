<?php 

  require_once "config/constants.php";


  if(isset($_GET['task_id'])) {

    $task_id = $_GET['task_id'];

    $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error($conn));

    $select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error($conn));

    $query = "SELECT * FROM tbl_tasks WHERE task_id='$task_id'";

    $result = mysqli_query($conn, $query);

    if($result) {

      $row = mysqli_fetch_assoc($result);

      $task_name = $row['task_name'];
      $task_description = $row['task_description'];
      $list_id = $row['list_id'];
      $priority = $row['priority'];
      $deadline = $row['deadline'];
    } else {

      header("location: ".APPURL."");
    }
  } else {
    header("location: ".APPURL."");
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update Task</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
        /* Style for labels */
      label {
        display: block;
        color: white;
        margin-bottom: 10px;
      }

      /* Style for form elements */
      input[type="text"],
      input[type="date"],
      textarea,
      select {
        width: 100%;
        max-width: 400px; /* Set a maximum width for form elements */
        padding: 10px;
        background-color: #333;
        color: white;
        border: none;
        border-radius: 5px;
        margin-bottom: 20px;
      }

      /* Style for the submit button */
      input[type="submit"] {
        background-color: cyan;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
      }

      /* Add some hover effects to the button */
      input[type="submit"]:hover {
        background-color: #00a0a0;
      }

      /* Update body background color and text color */
      body {
        background-color: #000;
        color: #fff;
        font-family: Arial, sans-serif;
      }

      .header-container {
        display: flex;
        align-items: center; /* Vertically align content */
      }

      .logo {
        max-width: 100px; /* Set a maximum width for the logo */
        margin-right: 10px; /* Add some spacing between the logo and text */
      }

      h1 {
        font-size: 24px; /* Adjust the font size as needed */
        margin: 0; /* Remove margin to prevent extra space */
        color: #fff;
        font-weight: bold;
      }

      /* Update links color and hover color */
      a {
        color: #00cccc;
        text-decoration: none;
      }

      a:hover {
        color: #fff;
      }
      .btn {
        background-color: #000;
        border: none;
        color: #fff;
        padding: 12px 16px;
        font-size: 16px;
        cursor: pointer;
        text-decoration: none;
      }

      /* Darker background on mouse-over */
      .btn:hover {
        background-color: #262626;
      }
    </style>
</head>
<body>
<div class="header-container">
  <a href="<?php echo APPURL; ?>"><img class="logo" src="img/task-manager-logo.png" alt="logo-image"></a>
  <a  style="text-decoration: none;" href="<?php echo APPURL; ?>"><h1>TASK MANAGER</h1></a>
  </div>
  <p>

  <div class="main-menu">
    <a href="<?php echo APPURL; ?>" class="btn" style="color: #fff;"><i class="fa fa-home"></i> Home</a>
</div>

  </p>

  <h3>Update Task Page</h3>

  <p>

    <?php 
    
      if(isset($_SESSION['update_task_fail'])) {

        echo $_SESSION['update_task_fail'];
        unset($_SESSION['update_task_fail']);
      }
    
    ?>

  </p>

  <form action="update-task.php" method="post">
  <input type="hidden" name="task_id" value="<?php echo $task_id; ?>">
    <table>

      <tr>
        <td>Task Name: </td>
        <td><input type="text" name="task_name" value="<?php echo $task_name; ?>" required></td>
      </tr>

      <tr>
        <td>Task Description: </td>
        <td><textarea name="task_description" id=""><?php echo $task_description; ?></textarea></td>
      </tr>

      <tr>
        <td>Select List: </td>
        <td><select name="list_id" id="">

        <?php
            $conn2 = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error($conn2));

            $select2 = mysqli_select_db($conn2, DB_NAME) or die(mysqli_error($conn2));

            $query2 = "SELECT * FROM tbl_lists";

            $result2 = mysqli_query($conn2, $query2);

            if($result2) {

              $count_rows2 = mysqli_num_rows($result2);

              if($count_rows2 > 0) {

                while($row2 = mysqli_fetch_assoc($result2))
                {
                  // Get individual value
                  $list_id_db = $row2['list_id'];
                  $list_name = $row2['list_name'];
                  ?>

                    <option <?php if($list_id_db==$list_id) {echo "selected='selected'";} ?> value="<?php echo $list_id_db; ?>"><?php echo $list_name; ?></option>

                  <?php
                }
              } else {

                ?>
                  <option <?php if($list_id=0) {echo "selected='selected'";} ?> value="0">None</option>
                <?php
              }
            }
        ?>
        </select></td>
      </tr>

      <tr>
        <td>Priority: </td>
        <td><select name="priority" id="">
          <option <?php if($priority=="High") {echo "selected='selected'";} ?> value="High">High</option>
          <option <?php if($priority=="Medium") {echo "selected='selected'";} ?> value="Medium">Medium</option>
          <option <?php if($priority=="Low") {echo "selected='selected'";} ?> value="Low">Low</option>
        </select></td>
      </tr>

      <tr>
        <td>Deadline: </td>
        <td><input type="date" name="deadline" value="<?php echo $deadline; ?>" id=""></td>
      </tr>

      <tr>
        <td><input type="submit" name="submit" value="Update"></td>
      </tr>

    </table>

  </form>

  
</body>
</html>

<?php 

$conn3 = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error($conn3));

  if(isset($_POST['submit'])) {

    $task_id = $_POST['task_id'];
    $task_name = mysqli_real_escape_string($conn3, $_POST['task_name']);
    $task_description = mysqli_real_escape_string($conn3, $_POST['task_description']);
    $list_id = $_POST['list_id'];
    $priority = $_POST['priority'];
    $deadline = $_POST['deadline'];

    $select3 = mysqli_select_db($conn3, DB_NAME) or die(mysqli_error($conn3));

    $query3 = "UPDATE tbl_tasks SET task_name='$task_name', task_description='$task_description', list_id='$list_id', priority='$priority', deadline='$deadline' WHERE task_id=$task_id";

    $result3 = mysqli_query($conn3, $query3);

    if($result3) {

      $_SESSION['update_task'] = '<p class="success">Task updated successfully.</p>';
      header("location: ".APPURL);
      exit();
    } else {

      $_SESSION['update_task_fail'] = '<p class="error">Failed to update task.</p>';
      header("location: ".APPURL."update-task.php?task_id=".$task_id);
      exit();
    }
    
  }

?>