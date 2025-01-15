<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $uname = $_GET['username'];
    $upass = $_GET['password'];

    // Check for missing input
    if (!$uname || !$upass) {
        echo "<script>alert('All fields are required. Please fill out the form correctly.');</script>";
        echo "<script>location.href='signup.html';</script>";
        exit;
    }

    include_once 'connection.php';

    // Check database connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    $sql = "SELECT * FROM user WHERE username='$uname'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows == 1) {
        $row = $result->fetch_assoc();
        
        if (password_verify($upass, $row['password'])) {
  
            $utype = $row['role'];
            
            if ($utype == 'user') {
                header('location:./User/home.php');
            } else if ($utype == 'admin') {
                header('location:./Admin/home.php');
            }
        } else {
            // Password is incorrect
            echo "<script> alert('Incorrect password') </script>";
            echo "<script> location.href='login.html' </script>";
        }
    } else {
        // User not found
        echo "<script> alert('User Not Found') </script>";
        echo "<script> location.href='login.html' </script>";
    }

    $conn->close();
} else {
    // If the request method is not GET, redirect to login page
    header("Location: login.html");
    exit;
}
?>
