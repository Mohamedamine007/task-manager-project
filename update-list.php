<?php require_once "config/constants.php" ?>
<?php

  $list_name = '';
  $list_description = '';
  // Check if we get the list_id when we clicked the update button
  if(isset($_GET['list_id'])) {

    $list_id = $_GET['list_id'];
    // Connect to the database
    $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error($conn));
    // Select the database
    $select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error($conn));
    // Query for retreving the data from the database so we can display it to the user, so he can modified it
    $query = "SELECT * FROM tbl_lists WHERE list_id='$list_id'";
    // Execute the query
    $result = mysqli_query($conn, $query);
    // Check whether the query is executed or not
    if($result) {

      $row = mysqli_fetch_assoc($result);
      $list_id = $row['list_id'];
      $list_name = $row['list_name'];
      $list_description = $row['list_description'];
    } else {

      header("location: ".APPURL."manage-list.php");
    }
  } else {

    // Redirect the user to the manage list page
    header("location: ".APPURL."manage-list.php");
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update Page</title>
  <link rel="stylesheet" href="css/update-list.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<div class="header-container">
  <a href="<?php echo APPURL; ?>"><img class="logo" src="img/task-manager-logo.png" alt="logo-image"></a>
  <a  style="text-decoration: none;" href="<?php echo APPURL; ?>"><h1>TASK MANAGER</h1></a>
  </div>

  <div class="menu">

  <div class="main-menu">
    <a href="<?php echo APPURL; ?>" class="btn" style="color: #fff; text-decoration: none;"><i class="fa fa-home"></i> Home</a>
    <a href="<?php echo APPURL; ?>manage-list.php" class="btn" style="color: #fff; text-decoration: none;"><i class="fa fa-bars"></i> Manage Lists</a>
</div>

  </div>

  <h3>Update List Page</h3>
  <p>

    <?php 
    
      if(isset($_SESSION['update_fail'])) {

        echo $_SESSION['update_fail'];
        unset($_SESSION['update_fail']);
      }
    
    ?>

  </p>
  <form action="update-list.php" method="post">
  <input type="hidden" name="list_id" value="<?php echo $list_id; ?>">

      <label for="list_name">List Name: </label>
      <input type="text" name="list_name" id="" value="<?php echo $list_name; ?>" ><br><br>

      <label for="list_description">List Description: </label>
      <textarea name="list_description"><?php echo $list_description; ?></textarea>

      <div class="button-container">
            <input type="submit" name="submit" value="Update" onclick="return confirmUpdate('<?php echo $list_name; ?>');">
      </div>

    

  </form>

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

<?php  

  if(isset($_POST['submit'])) {
    $conn2 = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error($conn2));

    $list_id = $_POST['list_id'];
    $list_name = mysqli_real_escape_string($conn2,$_POST['list_name']) ;
    $list_description = mysqli_real_escape_string($conn2,$_POST['list_description']);

    $select2 = mysqli_select_db($conn2, DB_NAME) or die(mysqli_error($conn2));

    echo $query2 = "UPDATE tbl_lists SET list_name='$list_name', list_description='$list_description' WHERE list_id=$list_id";

    $result2 = mysqli_query($conn2, $query2);

    if($result2) {

      $_SESSION['update'] = '<p class="success">List updated successfully.</p>';
      header("location: ".APPURL."manage-list.php");
    } else {

      $_SESSION['update_fail'] = '<p class="error">FAILED to update list</p>';
      header("location: ".APPURL."update-list.php?list_id=$list_id");
    }
  }

?>