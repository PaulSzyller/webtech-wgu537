<?php
	include('database.php');
	session_start();

	//GET data from the form
	$content = $_POST['content'];
	$UID = $_POST['UID'];
	$PID = $_POST['PID'];

	//connect to DB
	$conn = connect_db();
	$result = mysqli_query($conn, "SELECT * FROM users WHERE id = '$UID'");
	$row = mysqli_fetch_assoc($result);

	//fetch user info
	$name = $row["Name"];

	//insert into posts database
	$result_insert = mysqli_query($conn, "INSERT INTO comments (id, PID, comment, UID, name) VALUES (NULL, '$PID', '$content', '$UID', '$name')");

	if($result_insert) {
		//redirect to feed page
		header("Location: feed.php");
	}
	else {
		//error
		echo "Something went wrong, please try again";
	}
?>
