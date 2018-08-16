<?php
require('connect.php');
if (isset($_POST['reg_user'])) {
    $errors=0;
    $name = mysqli_real_escape_string($conn,$_POST['name']);

    $email = mysqli_real_escape_string($conn,$_POST['email']);

    $password1= mysqli_real_escape_string($conn,$_POST['password1']);
    $password2= mysqli_real_escape_string($conn,$_POST['password2']);
   
    if (empty($name)) {
        $errors+=1;
        echo "<script type='text/javascript'>alert('Username  is required!');</script>";
    }
    if (empty($email)) {
        $errors+=1;
        echo "<script type='text/javascript'>alert('Email is required!');</script>";

    }
    if (empty($password1&&$password2)) {
        $errors+=1;
        echo "<script type='text/javascript'>alert('Password is required!');</script>";

    }
    if ($password1 != $password2) {
        $errors+=1;
        echo "<script type='text/javascript'>alert('The two passwords do not match!');</script>";
    }

    $check_query = "SELECT * FROM myTable WHERE name='$name' OR email='$email'";

    $result = mysqli_query($conn, $check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        if ($user['name'] === $name) {
            $errors+=1;
            echo "<script type='text/javascript'>alert('Username taken!!');</script>";

        }

        if ($user['email'] === $email) {
            $errors+=1;
            echo "<script type='text/javascript'>alert('Email taken!!');</script>";
        }
    }

    if($errors==0){
        $sql = "INSERT INTO myTable(name,email, password) VALUES ('$name', '$email','$password1')";
        mysqli_query($conn,$sql);
        session_start();
        $_SESSION['name']= $name;
        $_SESSION['success']  = "You are now logged in";
        header('Location: ./home.php');


    }
}

if (isset($_POST['login_user'])) {


    $name = $_POST['name'];
    $password1= $_POST['password1'];
    $query = "SELECT * FROM myTable WHERE name='$name' AND password='$password1'";


    $results = mysqli_query($conn, $query);


    if (mysqli_num_rows($results) == 1) {
        session_start();
        $_SESSION['name']= $name;
        $_SESSION['success']  = "You are now logged in";
        header('Location: ./home.php');

    }
   else echo "<script type='text/javascript'>alert('Wrong username/password combination');</script>";

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="style1.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>


    <title>Demo</title>
</head>
<body id="index">


<div id="accordion">
    <div class="card">
        <div class="row">
            <div class="col-md-4">
                <div class="nav-side-menu">
                    <div class="navbar-brand">
                        <img src="images/logo-footer.png">
                    </div>

                    <div class="card-header">
                        <a class="card-link" data-toggle="collapse" href="#Register" id="main_nav">Register</a>
                    </div>
                      <div class="card-header">
                        <a class="card-link" data-toggle="collapse" href="#Login" id="main_nav">Login</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4" id=welcome>

                    <h1> Welcome to Dashboard!</h1>
                    <hr>
                    <br>
                <div id="Register" class="collapse" data-parent="#accordion">
                    <h3> Register</h3>

                    <form  method="post" class="form-horizontal" action="index.php" >
                    <div class="form-group">
                        <label  for="Name">Username:</label>
                        <input type="text" class="form-control" name="name" placeholder="Enter username">
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" name="email" placeholder="Enter email" >

                    </div>
                    <div class="form-group">
                        <label for="email">Password:</label>

                        <input type="password" class="form-control" name="password1" placeholder="Enter password">

                    </div>
                        <div class="form-group">
                            <label for="email">Re-enter Password:</label>

                            <input type="password" class="form-control" name="password2" placeholder="Enter password">

                        </div>
                        <div class="form-group">
                            <button type="Submit" class="btn btn-default" name="reg_user">Submit</button>
                            <br>
                            <p>
                                <br>
                                Already a member? <a href=#Login data-toggle="collapse">Login</a>
                            </p>
                    </div>

                    </form>
                </div>

                <div id="Login" class="collapse" data-parent="#accordion" >
                    <h3>Login</h3>
                    <form method="post" class="form-horizontal" action="index.php">
                        <div class="form-group">
                            <label for="email">Username:</label>
                            <input type="text" class="form-control" id="name" placeholder="Username" name ="name"/>
                        </div>
                        <div class="form-group">
                            <label for="pwd">Password:</label>
                            <input type="password" class="form-control" id="password" placeholder="Password" name ="password1"/>
                        </div>
                        <div class="form-group">
                            <button type="Submit" class="btn btn-default" name="login_user">Submit</button>
                            <br>
                            <p>
                                <br>
                                Not yet a member? <a href=#Register data-toggle="collapse">Sign up</a>
                            </p>
                        </div>

                    </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
</html>

