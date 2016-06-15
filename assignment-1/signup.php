<?php
    include('database.php');
    include('functions.php');
    //start session
    session_start();

    //get inputs from $_POST
    $username = sanitizeString($_POST["username"]);
    $password = $_POST["password"];
    $password_conf = $_POST["password_conf"];
    $name = sanitizeString($_POST["name"]);
    $email = sanitizeString($_POST["email"]);
    $dob = sanitizeString($_POST["dob"]);
    $gender = sanitizeString($_POST["gender"]);
    $question = sanitizeString($_POST["question"]);
    $answer = sanitizeString($_POST["answer"]);
    $location = sanitizeString($_POST["location"]);
    $profile_pic = sanitizeString($_POST["profile_pic"]);

    //check for password and confirmation matching
    if($password != $password_conf) {
        echo "Password confirmation doesn't match Password!<br>";
        echo "Please try again.";
    }
    elseif (($hash_pw = password_hash($password, PASSWORD_DEFAULT)) == FALSE){
        echo "Something went wrong, please try again!";
    }
    $hash_pw = sanitizeString($hash_pw);

    //connect to db
    $conn = connect_db();

    //insert new user into users data table
    $result_insert = mysqli_query($conn, "INSERT INTO `myDB`.`users` (`id`, `Username`, `Password`, `Name`, `email`, `dob`, `gender`, `verification_question`, `verification_answer`, `location`, `profile_pic`) VALUES (NULL, '$username', '$hash_pw', '$name', '$email', '$dob', '$gender', '$question', '$answer', '$location', '$profile_pic')");

    //redirect to login
    if($result_insert) {
        header("Location: login.html");
    }
    //error
    else {
        echo "Something went wrong, please try again!";
    }
?>
