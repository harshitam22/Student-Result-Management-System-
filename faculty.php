<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">

    <script>
        function func1()
        {
            var x1 = document.getElementById('viewres');
            var x2 = document.getElementById('recheck');
            x1.style.color = 'black';
            x2.style.color = 'white';
            var x = x1.getElementsByTagName('button');
            var y = x2.getElementsByTagName('button');
            x[0].style.color = 'black';
            x[0].style.textDecoration = 'none';
            y[0].style.textDecoration = 'underline';
            y[0].style.color = 'white';
            document.getElementById('res').style.display = 'none';
            document.getElementById('applyrecheck').style.display = 'block';
        }

        function func()
        {
            var x2 = document.getElementById('viewres');
            var x1 = document.getElementById('recheck');
            x1.style.color = 'black';
            x2.style.color = 'white';
            var x = x1.getElementsByTagName('button');
            var y = x2.getElementsByTagName('button');
            x[0].style.color = 'black';
            x[0].style.textDecoration = 'none';
            y[0].style.textDecoration = 'underline';
            y[0].style.color = 'white';
            document.getElementById('res').style.display = 'block';
            document.getElementById('applyrecheck').style.display = 'none';
        }

        function logout()
        {
            <?php
            $_SESSION['email'] = "";
            ?>
            location.replace("valid.php");
        }
    </script>
</head>
<body>
    <div id="head">
        <h1>Student Result Management System</h1>
        <button class="logout" onclick="logout()">Logout</button>
    </div>

    <div class="leftnav">
        <br>
        <b>
        <ul>
            <li id="viewres"><button onclick="func()">Update Marks</button></li>
            <li id="recheck"><button onclick="func1()">View Recheck<br>Requests</button></li>
        </ul></b>
    </div>

    <div class="content">
        <div id="res">
            <h2 align="left" style="margin-left: 3%;">Update Marks : </h2>
            <center>
                <fieldset style="width: 80%; text-align:center; font-size: 20px;">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        Course:
                        <select name="course" id="course" style="margin-right: 6%;">
                        <?php
                        session_start();
                        $server = "localhost";
                        $username = "root";
                        $password = "";

                        $conn = mysqli_connect($server, $username, $password);
                        if (!$conn)
                            echo "Connection to Database Failed due to " . mysqli_connect_error;

                        $email = $_SESSION['email'];
                        $sql = "SELECT `cid`, `name` FROM `student_result_management_system`.`course` WHERE `cid` IN (SELECT `cid` FROM `student_result_management_system`.`teaches` WHERE `fid` = (SELECT `fid` FROM `student_result_management_system`.`faculty` WHERE `email` = '$email'))";
                        $res = $conn->query($sql);

                        if ($res->num_rows > 0) {
                            while ($row = $res->fetch_assoc()) {
                                $name = $row['name'];
                                $cid = $row['cid'];
                                echo "<option value='$cid'>$name</option>";
                            }

                        }

                        $conn->close();
                        ?>
                        </select>
                        
                        Semeter: 
                        <select name="sem" id="sem" style="margin-right: 6%;">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                        </select>
                        
                        Section: 
                        <select name="sec" id="sec" style="margin-right: 6%;">
                        <?php
                        session_start();
                        $server = "localhost";
                        $username = "root";
                        $password = "";

                        $conn = mysqli_connect($server, $username, $password);
                        if (!$conn)
                            echo "Connection to Database Failed due to " . mysqli_connect_error;

                        $email = $_SESSION['email'];
                        $sql = "SELECT DISTINCT `sec` FROM `student_result_management_system`.`student`";
                        $res = $conn->query($sql);

                        if ($res->num_rows > 0) {
                            while ($row = $res->fetch_assoc()) {
                                $sec = $row['sec'];
                                echo "<option value='$sec'>$sec</option>";
                            }
                        }

                        $conn->close();
                        ?>
                        </select>

                        <input type="submit" name="submit1" id="submit1" value="View Students">
                    </form>
                </fieldset>
                <br>
                <?php
                if (isset($_POST['submit1'])) {
                    $sem = $_POST['sem'];
                    $course = $_POST['course'];
                    $sec = $_POST['sec'];
                    setcookie("sem", $sem, time() + 86400, "/");
                    setcookie("course", $course, time() + 86400, "/");
                    setcookie("sec", $sec, time() + 86400, "/");
                    f();
                }

                function f()
                {
                    $server = "localhost";
                    $username = "root";
                    $password = "";

                    $conn = mysqli_connect($server, $username, $password);
                    if (!$conn)
                        echo "Connection to Database Failed due to " . mysqli_connect_error;

                    $email = $_SESSION['email'];
                    $sem = $_COOKIE['sem'];
                    $sec = $_COOKIE['sec'];
                    $course = $_COOKIE['course'];
                    $sql = "SELECT `eid`, `exam`.`sid`, `sname` FROM `student_result_management_system`.`exam`, `student_result_management_system`.`student` WHERE `exam`.`sid` = `student`.`sid` AND `exam`.`sem` = '$sem' AND `sec` = '$sec' AND `cid` = '$course'";
                    $res = $conn->query($sql);

                    echo "<table border='1px solid black' cellspacing='0' style='text-align: center; width: 67%; font-size: 17px;'>";
                    echo "<tr>";
                    echo "<th>Exam ID</th>";
                    echo "<th>Course ID</th>";
                    echo "<th>Student ID</th>";
                    echo "<th>Student Name</th>";
                    echo "<th>Marks Obtained</th>";
                    echo "<th>Update</th>";
                    echo "</tr>";
                    if ($res->num_rows > 0) {
                        while ($row = $res->fetch_assoc()) {
                            $sid = $row['sid'];
                            $eid = $row['eid'];
                            $name = $row['sname'];
                            ?> 
                                
                                            <tr>
                                            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method='post'>
                                            <td><input type='text' name='eid' id='eid' value="<?= $eid ?>" style='border:0; text-align:center;' readonly></td>
                                            <td><?= $course ?></td>
                                            <td><?= $sid ?></td>
                                            <td><?= $name ?></td>
                                            <td><input type='text' name='marks' id='marks'></td>
                                            <td><input type='submit' value='Update' id='update' name='update'></td>
                                            </form>    
                                        </tr>
                                
                            <?php
                        }
                    }
                    echo "</table>";

                    $conn->close();
                }
                ?>
                <?php
                if (isset($_POST['update'])) {
                    $server = "localhost";
                    $username = "root";
                    $password = "";

                    $conn = mysqli_connect($server, $username, $password);
                    if (!$conn)
                        echo "Connection to Database Failed due to " . mysqli_connect_error;

                    $eid = $_POST['eid'];
                    $marks = $_POST['marks'];
                    $sql = "UPDATE `student_result_management_system`.`exam` SET `marks` = '$marks' WHERE `exam`.`eid` = '$eid'";
                    if (!$conn->query($sql)) {
                        echo "Marks Not Updated<br>";
                    } else
                        f();

                    $conn->close();
                }
                ?>
            </center>
        </div>

        <div id="applyrecheck">
            <h2 align="left" style="margin-left: 3%;">Re-Check : </h2>
            <center>
                <fieldset style="width: 80%; text-align:center; font-size: 20px;">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        Course:
                        <select name="course" id="course" style="margin-right: 6%;">
                        <?php
                        session_start();
                        $server = "localhost";
                        $username = "root";
                        $password = "";

                        $conn = mysqli_connect($server, $username, $password);
                        if (!$conn)
                            echo "Connection to Database Failed due to " . mysqli_connect_error;

                        $email = $_SESSION['email'];
                        $sql = "SELECT `name` FROM `student_result_management_system`.`course` WHERE `cid` IN (SELECT `cid` FROM `student_result_management_system`.`teaches` WHERE `fid` = (SELECT `fid` FROM `student_result_management_system`.`faculty` WHERE `email` = '$email'))";
                        $res = $conn->query($sql);

                        if ($res->num_rows > 0) {
                            while ($row = $res->fetch_assoc()) {
                                $name = $row['name'];
                                echo "<option value='$name'>$name</option>";
                            }

                        }

                        $conn->close();
                        ?>
                        </select>
                        <input type="submit" name="submit2" id="submit2" value="View Requests">
                    </form>
                </fieldset>
                <?php
                //session_start();
                if (isset($_POST['submit2'])) {
                    // setcookie ('sem', "", time()-3600);
                    // setcookie ('sed', "", time()-3600);
                    // setcookie ('course', "", time()-3600);
                    unset($_COOKIE['sem']);
                    unset($_COOKIE['sec']);
                    unset($_COOKIE['course']);

                    echo "<script>func1()</script>";

                    $server = "localhost";
                    $username = "root";
                    $password = "";

                    $conn = mysqli_connect($server, $username, $password);
                    if (!$conn)
                        echo "Connection to Database Failed due to " . mysqli_connect_error;

                    $course = $_POST['course'];
                    $sql = "SELECT `eid`, `sid`, `cid`, `marks`, `type` FROM `student_result_management_system`.`exam` WHERE `recheck` = 'Y'";
                    $res = $conn->query($sql);

                    if ($res->num_rows > 0) {
                        echo "<br><table border='1px solid black' cellspacing='0' style='text-align: center; width: 67%; font-size: 17px;'>";
                        echo "<tr>";
                        echo "<th>Exam ID</th>";
                        echo "<th>Student ID</th>";
                        echo "<th>Course ID</th>";
                        echo "<th>Marks</th>";
                        echo "<th>Exam Type</th>";
                        echo "</tr>";
                        while ($row = $res->fetch_assoc()) {
                            $eid = $row['eid'];
                            $sid = $row['sid'];
                            $cid = $row['cid'];
                            $marks = $row['marks'];
                            $type = $row['type'];

                            echo "<tr>";
                            echo "<td>$eid</td>";
                            echo "<td>$sid</td>";
                            echo "<td>$cid</td>";
                            echo "<td>$marks</td>";
                            echo "<td>$type</td>";
                            echo "</tr>";
                        }
                    } else
                        echo "<h3>No Current Requests</h3>";

                    $conn->close();
                }
                ?>
            </center>
        </div>
    </div>
</body>
</html>
