<?php
	include('database.php');
	include('functions.php');
	session_start();

	//GET data from the form
	$content = sanitizeString($_POST['content']);
	$UID = sanitizeString($_POST['UID']);

	//connect to DB
	$conn = connect_db();
	$result = mysqli_query($conn, "SELECT * FROM users WHERE id = '$UID'");
	$row = mysqli_fetch_assoc($result);

	//fetch user info
	$name = sanitizeString($row["Name"]);
	$profile_pic = sanitizeString($row["profile_pic"]);
	$likes = sanitizeString("0");

	//insert into posts database
	$result_insert = mysqli_query($conn, "INSERT INTO posts (id, content, UID, name, profile_pic, likes) VALUES (NULL, '$content', '$UID', '$name', '$profile_pic', '$likes')");

	if($result_insert) {
		//redirect to feed page
		header("Location: feed.php");
	}
	else {
		//error
		echo "Something went wrong, please try again";
	}
?>
