<?php 

// Require constants.php
require_once "config/constants.php";

//  Check wheter the list_id is assigned or not

if(isset($_GET['list_id'])) {

// Delete the list from the database

// Get the list_id id value
$list_id = $_GET['list_id'];
// Connect to the database
$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error($conn));
// Select the database
$select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error($conn));
// Write the query to delete lists from the database
echo $query = "DELETE FROM tbl_lists WHERE list_id='$list_id'";
// Execute the deletion query
$result = mysqli_query($conn, $query);
// Check whether the query executed successfully or not
if($result) {

  // Query executed
  $_SESSION['delete'] = '<p class="success">List deleted successfully.</p>';
  // Redirection to the manage list pge
  header("location: ".APPURL."manage-list.php");
} else {

  // FAILED to delete
  $_SESSION['delete_fail'] = '<p class="error">FAILED to delete list</p>';
  // Redirection to the manage list page
  header("location: ".APPURL."manage-list.php");
}
} else {

  // Rediret to Manage List Page
  header("localhost: ".APPURL."/manage-list.php");
}

?>