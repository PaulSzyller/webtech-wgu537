<?php
    include('database.php');
    //start session
    session_start();

    //get username and password from $_POST
    $username = $_POST["username"];
    $password = $_POST["password"];

    //connect to db
    $conn = connect_db();

    //query user with username given from users data table
    $result = mysqli_query($conn, "SELECT * FROM users WHERE Username='$username'");
	$row = mysqli_fetch_assoc($result);

    //if password matches
    if(password_verify($password, $row["Password"])){
        //save username to session and redirect to feed
        $_SESSION["username"] = $username;
        header("Location: feed.php");
    }

    //error
    else {
        echo "Invalid password! Try again!";
    }
?>
