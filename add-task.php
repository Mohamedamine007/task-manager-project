<?php require_once "config/constants.php"; ?>
<?php 
$conn2 = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error($conn2));
  if(isset($_POST['submit'])) {
    $task_name = mysqli_real_escape_string($conn2, $_POST['task_name']);
    $task_description = mysqli_real_escape_string($conn2, $_POST['task_description']);
    $list_id = mysqli_real_escape_string($conn2, $_POST['list_id']);
    $priority = $_POST['priority'];
    $deadline = $_POST['deadline'];

    $db_select2 = mysqli_select_db($conn2, DB_NAME);

    $query2 = "INSERT INTO tbl_tasks(task_name, task_description, list_id, priority, deadline) VALUES('$task_name', '$task_description', '$list_id', '$priority', '$deadline')";

    $result2 = mysqli_query($conn2, $query2);

    if($result2) {
      $_SESSION['add_task'] = '<p class="success">Task added successfully.</p>';
      header("location: ".APPURL."");
    } else {
      $_SESSION['add_fail'] = '<p class="error">FAILED to add task</p>';
      header("location: ".APPURL."add-task.php");
    }

  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Task</title>
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
    .success {
      color: #270;
      background-color: #dff2bf;
    }
    .error {
      color: #d8000c;
      background-color: #ffbaba;
    }
    </style>
</head>
<body>
<div class="header-container">
  <a href="<?php echo APPURL; ?>"><img class="logo" src="img/task-manager-logo.png" alt="logo-image"></a>
  <a  style="text-decoration: none;" href="<?php echo APPURL; ?>"><h1>TASK MANAGER</h1></a>
  </div>

  <a href="<?php echo APPURL; ?>" class="btn" style="color: #fff;"><i class="fa fa-home"></i> Home</a>

  <h3>Add Task Page</h3>

  <p>

    <?php 
      if(isset($_SESSION['add_fail'])) {

        echo $_SESSION['add_fail'];
        unset($_SESSION['add_fail']);
      } 
    ?>

  </p>

  <form action="add-task.php" method="post">

    <table>

      <tr>
          <td>Task Name: </td>
          <td><input type="text" name="task_name" id="" placeholder="Type your task name..." required></td>
      </tr>

      <tr>
        <td>Task Description: </td>
        <td><textarea name="task_description" id="" placeholder="Type task description"></textarea></td>
      </tr>

      <tr>
        <td>Select List: </td>
        <td><select name="list_id" id="">
          <?php 
          
            $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error($conn));
            
            $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error($conn));

            $query = "SELECT * FROM tbl_lists";

            $result = mysqli_query($conn, $query);

            if($result) {

              $count_rows = mysqli_num_rows($result);

              if($count_rows > 0) {

                // Display all lists on dropdown from database
                while($row = mysqli_fetch_assoc($result))
                {
                  $list_id = $row['list_id'];
                  $list_name = $row['list_name'];
                  ?>
                    <option value="<?php echo $list_id; ?>"><?php echo $list_name; ?></option>
                  <?php
                }
              } else {
                // Display none as option
                ?>
                <option value="0">None</option>
                <?php
              }
            }
          ?>
        </select></td>
      </tr>

      <tr>
        <td>Priority: </td>
        <td><select name="priority" id="">
          <option value="High">High</option>
          <option value="Medium">Medium</option>
          <option value="Low">Low</option>
        </select></td>
      </tr>

      <tr>
        <td>Dead Line: </td>
        <td><input type="date" name="deadline" id=""></td>
      </tr>

      <tr>
        <td><input type="submit" value="Save" name="submit"></td>
      </tr>
    </table>

  </form>
</body>
</html>