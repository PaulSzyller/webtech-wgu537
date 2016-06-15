<?php
	include('database.php');
	session_start();

	//GET data from the form
	$content = $_POST['content'];
	$UID = $_POST['UID'];

	//connect to DB
	$conn = connect_db();
	$result = mysqli_query($conn, "SELECT * FROM users WHERE id = '$UID'");
	$row = mysqli_fetch_assoc($result);

	//fetch user info
	$name = $row["Name"];
	$profile_pic = $row["profile_pic"];

	//insert into posts database
	$result_insert = mysqli_query($conn, "INSERT INTO posts (id, content, UID, name, profile_pic, likes) VALUES (NULL, '$content', '$UID', '$name', '$profile_pic', '0')");

	if($result_insert) {
		//redirect to feed page
		header("Location: feed.php");
	}
	else {
		//error
		echo "Something went wrong, please try again";
	}
?>
