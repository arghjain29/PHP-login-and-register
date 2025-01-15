<?php 

$uname=$_POST['username'];
$uemail=$_POST['email'];
$upass1=$_POST['password1'];
$upass2=$_POST['password2'];
$utype=$_POST['role'];


if (!$uname || !$uemail || !$upass1 || !$upass2 || !$utype) {
    echo "<script>alert('All fields are required. Please fill out the form correctly.');</script>";
    echo "<script>location.href='signup.html';</script>";
    exit;
}

if ($upass1!=$upass2) {
    echo 'Password Mismatch';
    die;
}



$cipher_pass = password_hash($upass1, PASSWORD_BCRYPT);

include_once 'connection.php';

$status= mysqli_query($conn, "insert into user(username,password,email,role) values('$uname','$cipher_pass','$uemail','$utype')");



if ($status){
    echo "<script>alert('User Registered Successfully')</script>";
    echo "<script>location.href='login.html'</script>";
}
else {
    echo mysqli_error($conn);
}
?>