<?php
	include('database.php');
	include('functions.php');
	session_start();

	//connect to DB
	$conn = connect_db();


	//GET data from the form
	$content = sanitizeString($_POST['content'], $conn);
	$UID = sanitizeString($_POST['UID'], $conn);
	$PID = sanitizeString($_POST['PID'], $conn);

	//get info on comment owner
	$result = mysqli_query($conn, "SELECT * FROM users WHERE id = '$UID'");
	$row = mysqli_fetch_assoc($result);

	//fetch user info
	$name = sanitizeString($row["Name"], $conn);

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
