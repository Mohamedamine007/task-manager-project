<?php require_once "config/constants.php" ?>
<?php 

  $list_id_url = $_GET['list_id'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Task Manager</title>
  <link rel="stylesheet" href="css/list-task.css">
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
            <a href="<?php echo APPURL; ?>" class="btn" style="color: #fff; text-decoration: none;"><i class="fa fa-home"></i> Home</a>
            <a href="<?php echo APPURL; ?>manage-list.php" class="btn" style="color: #fff; text-decoration: none;"><i class="fa fa-bars"></i> Manage Lists</a>
        </div>

      <h2>Your Lists: </h2>

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
        
      <div class="all-task">

        <a href="<?php echo APPURL; ?>add-task.php">Add Task</a>

        <table>
        
          <tr>
            <th>S.N</th>
            <th>Task Name</th>
            <th>Priority</th>
            <th>Deadline</th>
            <th>Action</th>
          </tr>

        <?php 
        
          $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error($conn));

          $select = mysqli_select_db($conn, DB_NAME);

          $query = "SELECT * FROM tbl_tasks WHERE list_id=$list_id_url";

          $result = mysqli_query($conn, $query);

          if($result) {

            $count_rows = mysqli_num_rows($result);

            if($count_rows > 0) {
                $i = 1;
                while($row = mysqli_fetch_assoc($result))
                {
                  $task_id = $row['task_id'];
                  $task_name = $row['task_name'];
                  $priority = $row['priority'];
                  $deadline = $row['deadline'];
                  ?>

                    <tr>
                      <td><?php echo $i++; ?> </td>
                      <td><?php echo $task_name; ?></td>
                      <td><?php echo $priority; ?></td>
                      <td><?php echo $deadline; ?></td>
                      <td>
                      <a href="<?php echo APPURL; ?>update-task.php?task_id=<?php echo $task_id; ?>">Update</a>
                    <a href="<?php echo APPURL; ?>delete-task.php?task_id=<?php echo $task_id; ?>" id="delete-btn">Delete</a>
                      </td>
                    </tr>

                  <?php
                }
            } else {
              ?>

                <tr>
                  <td colspan="5" >No Tasks Added On This List</td>
                </tr>

              <?php
            }
          }

        ?>
        </table>

      </div>
      <script>
    function confirmUpdate(listName) {
        var confirmUpdate = confirm("Are you sure you want to update the list '" + listName + "'?");
        if (confirmUpdate) {
            return true;
        } else {
            return false;
        }
    }
</script>

</body>
</html>