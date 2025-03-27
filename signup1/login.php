<?php
$login=0;
$invalid=0;
    if($_SERVER['REQUEST_METHOD']=='POST'){
        include 'connect.php';
        $username=$_POST['username'];
        $password=$_POST['password'];

        

        $sql="Select * from `registration` where
        username='$username' and password='$password'";

        $result=mysqli_query($con,$sql);
        if($result){
            $num=mysqli_num_rows($result);
            if($num>0){
                $login=1;
                session_start();
                $_SESSION['username']=$username;
                header('location:home.php');
            }else{
                $invalid=1;
            }
    }
}
?>



<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <title>Login Page</title>
    <style>
      body {
        background: #f4f4f4;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
      }
      .login-container {
        background: white;
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        width: 100%;
        max-width: 380px;
        text-align: center;
      }
      .login-container h2 {
        margin-bottom: 25px;
        color: #333;
      }
      .form-control {
        border-radius: 20px;
      }
      .form-control:focus {
        border-color: #ff7b00;
        box-shadow: 0 0 8px rgba(255, 123, 0, 0.5);
      }
      .btn-primary {
        background-color: #ff7b00;
        border-radius: 20px;
        border: none;
      }
      .btn-primary:hover {
        background-color: #e66a00;
      }
    </style>
  </head>
  <body>
    <div class="login-container">
      <h2><i class="fas fa-user-circle"></i> Welcome </h2>
      <form action="login.php" method="post">
        <div class="mb-3">
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-user"></i></span>
            <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
          </div>
        </div>
        <div class="mb-3">
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-lock"></i></span>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
          </div>
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
      </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
