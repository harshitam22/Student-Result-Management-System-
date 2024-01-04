<?php
session_start();
$valid = true;
if (isset($_POST['submit2'])) {
    $server = "localhost";
    $username = "root";
    $password = "";

    $conn = mysqli_connect($server, $username, $password);
    if (!$conn)
        echo "Connection to Database Failed due to " . mysqli_connect_error;

    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $sql = "SELECT `password` FROM `student_result_management_system`.`faculty` WHERE `email` LIKE '$email'";

    $_SESSION['email'] = $email;
    $res = $conn->query($sql);


    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $p = $row['password'];
        if ($p == $pass) {
            header("Location: faculty.php");
            exit();
        } else {
            $valid = false;
        }
    } else
        $valid = false;

    $conn->close();
} else if (isset($_POST['submit'])) {
    $server = "localhost";
    $username = "root";
    $password = "";

    $conn = mysqli_connect($server, $username, $password);
    if (!$conn)
        echo "Connection to Database Failed due to " . mysqli_connect_error;

    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $sql = "SELECT `password` FROM `student_result_management_system`.`student` WHERE `email` LIKE '$email'";

    $_SESSION['email'] = $email;
    $res = $conn->query($sql);


    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $p = $row['password'];
        if ($p == $pass) {
            header("Location: student.php");
            exit();
        } else {
            $valid = false;
        }
    } else
        $valid = false;

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">

    <style>
        .container
        {
            padding-top: 2%;
            text-align: center;
        }
        .container #login, #stud, #fac
        {
            position: absolute;
            top: 45%;
            left: 52%;
            transform: translate(-50%, -50%);
            display: inline-block;
            text-align: center;
        }
        img
        {
            width: 65%;
            height: 500px;
        }
        button
        {
            width: 225px;
            height: 55px;
            font-size: 30px;
            margin-bottom: 10px;
            background: cyan;
            border: 1px solid blue;
            cursor: pointer;
        }
        h3
        {
            margin-bottom: 20px;
            margin-top: 5px;
            font-size: 30px;
            font-family: cursive;
        }
        .container #stud, #fac
        {
            display: none;
            width: 18%;
        }
        #email, #pass
        {
            height: 27px;
            width: 100%;
            font-size: 15px;
        }
        #submit
        {
            height: 25px;
            width: 50%;
            font-size: 15px;
        }
    </style>

    <script>
        function func()
        {
            document.getElementById('login').style.display = 'none';
            document.getElementById('stud').style.display = 'block';
        }
        function func1()
        {
            document.getElementById('login').style.display = 'none';
            document.getElementById('fac').style.display = 'block';
        }
    </script>
</head>
<body>
    <div id="head">
        <h1>Student Result Management System</h1>
    </div>
    <div class="container">
        <img src="notice-board.png" alt="notice board">
        <span id="login">
            <h3>Login</h3>
            <p style="color:red"><?php
            if ($valid == false)
                echo "*Incorrect Credentials ";
            ?></p>
            <button onclick="func()">Student</button><br>
            <button onclick="func1()">Faculty</button><br><br>
            <b>To Register 
            <a href="signup.html">Click Here!</a></b>
        </span>
        <span id="stud">
            <h3>Student Login</h3>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <input type="text" placeholder="Enter Email" id="email" name="email" pattern="[a-zA-z0-9]+@+[a-zA-Z]+.com">
                <br>
                <br>
                <input type="password" name="pass" id="pass" placeholder="Enter Password">
                <br>
                <br>
                <input type="submit" name="submit" id="submit">
                <br>
                <br>
            </form>
            <b>To Register 
            <a href="signup.html">Click Here!</a></b>
        </span>
        <span id="fac">
            <h3>Faculty Login</h3>
            <form action="valid.php" method="post">
                <input type="text" placeholder="Enter Email" id="email" name="email" pattern="[a-zA-z0-9]+@+[a-zA-Z]+.com">
                <br>
                <br>
                <input type="password" name="pass" id="pass" placeholder="Enter Password">
                <br>
                <br>
                <input type="submit" name="submit2" id="submit2">
                <br>
                <br>
            </form>
            <b>To Register 
            <a href="signup.html">Click Here!</a></b>
        </span>
    </div>
</body>
</html>

