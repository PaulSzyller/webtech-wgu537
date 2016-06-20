<?php
	include('database.php');
	include('functions.php');
	session_start();

    //connect to DB
    $conn = connect_db();

	//GET data from the form
	$content = sanitizeString($_POST['content'], $conn);
	$UID = sanitizeString($_POST['UID'], $conn);

	//get info on post owner
	$result = mysqli_query($conn, "SELECT * FROM users WHERE id = '$UID'");
	$row = mysqli_fetch_assoc($result);

	//fetch user info
	$name = sanitizeString($row["Name"], $conn);
	$profile_pic = sanitizeString($row["profile_pic"], $conn);
	$likes = sanitizeString("0", $conn);

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
