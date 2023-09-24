<?php require_once "config/constants.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Task Manager</title>
  <link rel="stylesheet" href="css/manage-list.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<div class="header-container">
  <a href="<?php echo APPURL; ?>"><img class="logo" src="img/task-manager-logo.png" alt="logo-image"></a>
  <a  style="text-decoration: none;" href="<?php echo APPURL; ?>"><h1>TASK MANAGER</h1></a>
  </div>

  <div class="main-menu">
    <a href="<?php echo APPURL; ?>" class="btn" style="color: #fff;"><i class="fa fa-home"></i> Home</a>
</div>

  <h3>Manage Lists Page</h3>

  <p>
    <?php
    
      // Checking for the add session
      if(isset($_SESSION['add'])) {

        // Display the message
        echo $_SESSION['add'];

        // Remove the message 
        unset($_SESSION['add']);
      }
      // Check for the delete session
      if(isset($_SESSION['delete'])) {

        echo $_SESSION['delete'];
        unset($_SESSION['delete']);
      }
      // Check for the delete fail session
      if(isset($_SESSION['delete_fail'])) {

        echo $_SESSION['delete_fail'];
        unset($_SESSION['delete_fail']);
      }

      if(isset($_SESSION['update'])) {

        echo $_SESSION['update'];
        unset($_SESSION['update']);
      }
    ?>
  </p>

  <!-- Table to display lists starts here -->
  <div class="all-lists">
    <a href="<?php echo APPURL; ?>add-list.php" id="add-list-btn">Add List</a>

    <table>

      <tr>
        <th>S.N</th>
        <th>List Name</th>
        <th>Actions</th>
      </tr>
<?php 

      // Connect to the database
      $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error($conn));

      // Select the database
      $select = mysqli_select_db($conn, 'task_manager') or die(mysqli_error($conn));

      // Query to display the lists from the database to the management page
      $query = "SELECT * FROM tbl_lists";
      $result = mysqli_query($conn, $query);

      // Check whether the query executed or not
      if($result) {

        if (mysqli_num_rows($result) > 0) {
          
          $i = 1;
          while($row = mysqli_fetch_assoc($result))
          {
            $list_id = $row['list_id'];
            $list_name = $row['list_name'];
            $list_description = $row['list_description'];
            ?>

            <tr>
              <td><?php echo $i++; ?>.</td>
              <td><?php echo $list_name; ?></td>
              <td>
                <a href="<?php echo APPURL; ?>/update-list.php?list_id=<?php echo $list_id; ?>" style="background-color: #00cccc; color:white; padding:3px; border-radius:3px; text-decoration:none;">Update</a>
                <a href="<?php echo APPURL; ?>/delete-list.php?list_id=<?php echo $list_id; ?>" style="background-color: red; color:white; padding:3px; border-radius:3px; text-decoration:none;" onclick="return confirmDelete('<?php echo $list_name; ?>');">Delete</a>

              </td>
            </tr>
            <?php
          }
        } else {
          ?>
           <tr>
            <td colspan="3">No List Added Yet.</td>
           </tr>
          <?php
        }
      } else {  

        echo "Error executing query: " . mysqli_error($conn);
      }
?>
      

    </table>
  </div>

  <script>
    function confirmDelete(listName) {
        var confirmDelete = confirm("Are you sure you want to delete the list '" + listName + "'?");
        if (confirmDelete) {
            return true;
        } else {
            return false;
        }
    }
</script>


</body>
</html>