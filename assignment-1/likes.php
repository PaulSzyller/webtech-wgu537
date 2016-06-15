<?php
	include('database.php');
	//connect to db
	$conn = connect_db();

	//get pid from the form
	$PID = $_POST['PID'];
	
	//fetch post with id PID
	$result = mysqli_query($conn, "SELECT * FROM posts WHERE id='$PID'");
	$row = mysqli_fetch_assoc($result);

	//get likes value stored in variable
	$likes = $row['likes'];
	//increment value
	$likes = $likes + 1;
	//update likes for the post in the DB
	$result = mysqli_query($conn, "UPDATE posts SET likes='$likes' WHERE id='$PID'");
	
	//redirect to feed
	if ($result) {
		header("Location: feed.php");
	}
	//error
	else {
		echo("Error updating likes");
	}
?>