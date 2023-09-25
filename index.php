<?php require_once "config/constants.php" ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Task Manager</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<div class="header-container">
  <a href="<?php echo APPURL; ?>"><img class="logo" src="img/task-manager-logo.png" alt="logo-image"></a>
  <a  style="text-decoration: none;" href="<?php echo APPURL; ?>"><h1>TASK MANAGER</h1></a>
  </div>
  
  

  <!-- Menu Starts Here -->
  <div class="menu">
  <div class="main-menu">
    <a href="<?php echo APPURL; ?>" class="btn" style="color: #fff;"><i class="fa fa-home"></i> Home</a>
    <a href="<?php echo APPURL; ?>manage-list.php" class="btn" style="color: #fff;"><i class="fa fa-bars"></i> Manage Lists</a>
</div>
      <h2 class="your-lists">Your Lists: </h2>

      <?php 
      
        // Displaying lists from the database in our nav bar
        $conn2 = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error($conn2));

        $select2 = mysqli_select_db($conn2, DB_NAME) or die(mysqli_error($conn2));

        $query2 = "SELECT * FROM tbl_lists";

        $result2 = mysqli_query($conn2, $query2);

        if($result2) {

          while($row2 = mysqli_fetch_assoc($result2))
          {
            $list_id = $row2['list_id'];
            $list_name = $row2['list_name'];
            ?>
              <a href="<?php echo APPURL; ?>list-task.php?list_id=<?php echo $list_id; ?>"><?php echo $list_name; ?></a>
            <?php
          }
        }
      ?>

      

  </div> <!-- Menu Ends Here -->

  <!-- Tasks Starts Here -->

  <!-- Tasks Starts Here -->

  <p>
    <?php 
    if(isset($_SESSION['add_task'])) {
      echo $_SESSION['add_task'];
      unset($_SESSION['add_task']);
    }
    
    if(isset($_SESSION['delete_task'])) {
      echo $_SESSION['delete_task'];
      unset($_SESSION['delete_task']);
    }
    if(isset($_SESSION['delete_task_fail'])) {
      echo $_SESSION['delete_task_fail'];
      unset($_SESSION['delete_task_fail']);
    }
    if(isset($_SESSION['update_task'])) {
      echo $_SESSION['update_task'];
      unset($_SESSION['update_task']);
    }
    ?>
  </p>

  <div class="all-tasks">
    <a href="<?php echo APPURL; ?>add-task.php">Add Task</a>
    <table>
      <tr>
        <th>S.N</th>
        <th>Task Name</th>
        <th>Priority</th>
        <th>Deadline</th>
        <th>Actions</th>
      </tr>

      <?php 
      $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error($conn));
      $select = mysqli_select_db($conn, DB_NAME);
      $query = "SELECT * FROM tbl_tasks ORDER BY FIELD(priority, 'High', 'Medium', 'Low')";
      $result = mysqli_query($conn, $query);

      if($result) {

        if(mysqli_num_rows($result) > 0) {
          
        $sn = 1;
        while($row = mysqli_fetch_assoc($result)) {
          $task_id = $row['task_id'];
          $task_name = $row['task_name'];
          $priority = $row['priority'];
          $deadline = $row['deadline'];
          ?>

          <tr>
            <td><?php echo $sn++; ?></td>
            <td><?php echo $task_name; ?></td>
            <td><?php echo $priority; ?></td>
            <td class="task-deadline"><?php echo $deadline; ?></td> <!-- Add the class here -->
            <td>
              <a href="<?php echo APPURL; ?>update-task.php?task_id=<?php echo $task_id; ?>" class="update-btn" style="background-color: #00cccc; color:white; padding:3px; border-radius:3px; text-decoration:none;">Update</a>
              <a href="<?php echo APPURL; ?>delete-task.php?task_id=<?php echo $task_id; ?>" class="delete-btn" style="background-color: red; color:white; padding:3px; border-radius:3px; text-decoration:none;">Delete</a>
            </td>
          </tr>

          <?php
        }
      } else {
        // No data in the database
        ?>
        <tr>
          <td colspan="5">No Task Added Yet</td>
        </tr>
        <?php
      }
      }
      ?>
    </table>
  </div>
  <!-- Tasks Ends Here -->

  <!-- Adding JavaScript -->
  <script>
    function checkTaskDeadlines() {

      var currentDate = new Date();
      var deadlineCells = document.querySelectorAll('.task-deadline');

      deadlineCells.forEach(function (cell) {

        var deadlineDate = new Date(cell.textContent);
        if (deadlineDate < currentDate) {
          cell.classList.add('deadline-passed');
          cell.textContent = 'Deadline Passed';
        }

      });
    }
    
    window.onload = function () {
      checkTaskDeadlines();
      hideMessages();
    };
  </script>
</body>
</html>
