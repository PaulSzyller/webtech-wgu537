<?php
    session_start();
    //preventing the feed page to be accessible while to logged in.
    if(!isset($_SESSION['username'])){
        header("Location: login.html");
    }
?>
<!DOCTYPE html>
<html>
<head>
	<title>MyFacebook Feed</title>
</head>
<body>
	<?php
		include('database.php');

        //connect to DB
    	$conn = connect_db();

        //get info on user from users data table
    	$username = $_SESSION["username"];
    	$result = mysqli_query($conn, "SELECT * FROM users WHERE Username='$username'");

        //fetch results from row about user
    	$row = mysqli_fetch_assoc($result);
        //display welcome message + pic
    	echo "<center><h1>Welcome back " . $row["Name"] . "!</h1>";
    	echo "<img src='" . $row["profile_pic"] . "'>";
        //logout
        echo "<form method='GET' action='logout.php'>";
        echo "<input type='submit' value='logout'>";
        echo "</form></center>";
        echo "<hr>";
	
        //new post form
        echo "<form method='POST' action='posts.php'>";
        echo "<p><label>Write a new post:</label><br>";
        echo "<textarea name='content'>Say something...</textarea><br>";
        echo "<input type='hidden' name='UID' value='$row[id]'>";
        echo "<input type='submit'>";
        echo "</form>";
        echo "</p>";

        //display all posts from posts data table
        $result_posts = mysqli_query($conn, "SELECT * FROM posts ORDER BY id DESC");
        $num_of_posts = mysqli_num_rows($result_posts);
        for ($i = 0; $i < $num_of_posts; $i++){
            $post_row = mysqli_fetch_assoc($result_posts);
            echo "<hr><p>$post_row[name] (" . date("m/d/Y h:i:sa", strtotime($post_row['created_at'])) . "):<br>$post_row[content]";
            echo "<form action='likes.php' method='POST'>";
            echo "<input type='hidden' name='PID' value='$post_row[id]'><input type='submit' value='Like'>($post_row[likes])";
            echo "</form>";

            //new comment form
            echo "<form method='POST' action='comments.php'>";
            echo "<label>Comment on this post:</label><br>";
            echo "<textarea name='content'>Say something...</textarea><br>";
            echo "<input type='hidden' name='UID' value='$row[id]'>";
            echo "<input type='hidden' name='PID' value='$post_row[id]'>";
            echo "<input type='submit'>";
            echo "</form>";
            echo "</p>";

            //display all comments for this post
            $result_comments = mysqli_query($conn, "SELECT * FROM comments WHERE PID='$post_row[id]' ORDER BY id DESC");
            $num_of_comments = mysqli_num_rows($result_comments);
            for ($j = 0; $j < $num_of_comments; $j++){
                $comment_row = mysqli_fetch_assoc($result_comments);
                echo "<span style='padding-left:68px;''>";
                echo "$comment_row[name] (" . date("m/d/Y h:i:sa", strtotime($comment_row['created_at'])) .  "): $comment_row[comment]";
                echo "<br></span>";
            }
        }
    ?>
</body>
</html>
