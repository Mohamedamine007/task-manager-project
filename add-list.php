<?php require_once "config/constants.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Task Manager</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

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

<body>

<div class="header-container">
  <a href="<?php echo APPURL; ?>"><img class="logo" src="img/task-manager-logo.png" alt="logo-image"></a>
  <a  style="text-decoration: none;" href="<?php echo APPURL; ?>"><h1>TASK MANAGER</h1></a>
  </div>
<div class="main-menu">
    <a href="<?php echo APPURL; ?>" class="btn" style="color: #fff;"><i class="fa fa-home"></i> Home</a>
    <a href="<?php echo APPURL; ?>manage-list.php" class="btn" style="color: #fff;"><i class="fa fa-bars"></i> Manage Lists</a>
</div>

<h3>Add List</h3>
<p>
<?php 

  // Check whter the session is created or not
  if(isset($_SESSION['add_fail'])) {

    // Display the session message
    echo $_SESSION['add_fail'];

    // Remove the message after displaying once, becaue if we didn't remove it, the fail messagd will be displayed forever
    unset($_SESSION['add_fail']);
  }

?>
</p>

<!-- Form To Add List Starts Here -->

<form action="add-list.php" method="post">

  <table>

    <tr>
      <td>List Name: </td>
      <td><input type="text" name="list_name" id="" placeholder="Enter The List Name..." required></td>
    </tr>

    <tr>
      <td>List Description: </td>
      <td><textarea name="list_description" id="" placeholder="Enter The List Description..." required></textarea></td>
    </tr>

    <tr>
      <td><input type="submit" value="Save" name="submit">
      </td>
    </tr>
  </table>

</form>
</body>
</html>

<?php 

 // Connect Database
 $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error($conn));

  if (isset($_POST['submit'])) {

    $list_name = mysqli_real_escape_string($conn, $_POST['list_name']);
    $list_description = mysqli_real_escape_string($conn, $_POST['list_description']);


    // Select Database
    $db_select = mysqli_select_db($conn, 'task_manager');

    // Insert into the database
    $sql = "INSERT INTO tbl_lists(list_name, list_description) VALUES('$list_name', '$list_description')";
    $result = mysqli_query($conn, $sql);
    if ($result) {

      // Create a session variable to display a message
      $_SESSION['add'] = '<p class="success">List added successfully.</p>';

      // Redirect to Manage List Page
      header("location: ".APPURL."manage-list.php");
      
    } else {

      // Create a session variable to display the error message
      $_SESSION['add_fail'] = '<p class="error">FAILED to add list</p>';

      // Redirect to the same page
      header("location: ".APPURL."add-list.php");
    }

  }

?>