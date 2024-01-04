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
</script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <script>
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
            <li id="viewres"><button onclick="func()">View Result</button></li>
            <li id="recheck"><button onclick="func1()">Apply Recheck</button></li>
        </ul></b>
    </div>

    <div class="content">
        <div id="res">
            <h2 align="left" style="margin-left: 3%;">Result : </h2>
            <center>
                <fieldset style="width: 80%; text-align:center; font-size: 20px;">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        Enter Semeter: 
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
                        
                        Exam Type: 
                        <select name="type" id="type" style="margin-right: 6%;">
                            <option value="R">Regular</option>
                            <option value="B">Back</option>
                        </select>

                        <input type="submit" name="submit1" id="submit1" value="View Result">
                    </form>
                </fieldset>
                <br>
                <?php
                session_start();
                if (isset($_POST['submit1'])) {
                    $server = "localhost";
                    $username = "root";
                    $password = "";

                    $conn = mysqli_connect($server, $username, $password);
                    if (!$conn)
                        echo "Connection to Database Failed due to " . mysqli_connect_error;

                    $email = $_SESSION['email'];
                    $sem = $_POST['sem'];
                    $type = $_POST['type'];
                    $sql = "SELECT `eid`,`student_result_management_system`.`course`.`name`,`marks` from `student_result_management_system`.`exam`,`student_result_management_system`.`course`,`student_result_management_system`.`student` WHERE `student_result_management_system`.`course`.`cid` = `student_result_management_system`.`exam`.`cid` AND `student_result_management_system`.`student`.`sid` = `student_result_management_system`.`exam`.`sid` AND `email` = '$email' AND `student_result_management_system`.`exam`.`sem` = '$sem' AND `student_result_management_system`.`exam`.`TYPE` = '$type'";
                    $res = $conn->query($sql);


                    echo "<table border='1px solid black' cellspacing='0' style='text-align: center; width: 67%; font-size: 17px;'>";
                    echo "<tr>";
                    echo "<th>Exam ID</th>";
                    echo "<th>Course</th>";
                    echo "<th>Marks Obtained</th>";
                    echo "</tr>";
                    if ($res->num_rows > 0) {
                        while ($row = $res->fetch_assoc()) {
                            $eid = $row['eid'];
                            $course = $row['name'];
                            $marks = $row['marks'];
                            echo "<tr>";
                            echo "<td>$eid</td>";
                            echo "<td>$course</td>";
                            echo "<td>$marks</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No Results Found</td></tr>";
                    }
                    echo "</table>";

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
                        Enter Exam ID : 
                        <input type="text" name="eid" id="eid" style="margin-right: 6%;">
                        <input type="submit" name="submit2" id="submit2" value="View Result">
                    </form>
                </fieldset>
                <br>
                <?php

                ?>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <?php
                //session_start();
                if (isset($_POST['submit2'])) {
                    //session_start();
                    echo "<script>func1()</script>";
                    $server = "localhost";
                    $username = "root";
                    $password = "";

                    $conn = mysqli_connect($server, $username, $password);
                    if (!$conn)
                        echo "Connection to Database Failed due to " . mysqli_connect_error;

                    $email = $_SESSION['email'];
                    $eid = $_POST['eid'];
                    $_SESSION['eid'] = $eid;
                    $sql = "SELECT `eid`, `exam`.`sid`, `cid`, `marks`, `type` FROM `student_result_management_system`.`exam`, `student_result_management_system`.`student` WHERE `exam`.`sid` = `student`.`sid` AND `eid` = '$eid' AND `student`.`email` = '$email'";
                    $res = $conn->query($sql);

                    if ($res->num_rows > 0) {
                        $row = $res->fetch_assoc();
                        $eid = $row['eid'];
                        $sid = $row['sid'];
                        $cid = $row['cid'];
                        $marks = $row['marks'];
                        $type = $row['type'];

                        echo "<table border='1px solid black' cellspacing='0' style='text-align: center; width: 67%; font-size: 17px;'>";
                        echo "<tr>";
                        echo "<th>Exam ID</th>";
                        echo "<th>Student ID</th>";
                        echo "<th>Course ID</th>";
                        echo "<th>Marks</th>";
                        echo "<th>Exam Type</th>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<td>$eid</td>";
                        echo "<td>$sid</td>";
                        echo "<td>$cid</td>";
                        echo "<td>$marks</td>";
                        echo "<td>$type</td>";
                        echo "</tr>";
                        echo "</table><br>";

                        echo "<input type='submit' name='apply' id='apply' value='Apply for Recheck' style='width: 15%; height: 30px; background-color: #5ce75c; border: 0;'>";
                        $conn->close();
                    } else
                        echo "<h3>No Such Exam ID</h3>";
                }
                ?>
                </form>
                <?php

                if (isset($_POST['apply'])) {
                    //session_start();
                    echo "<script>func1()</script>";
                    $server = "localhost";
                    $username = "root";
                    $password = "";

                    $conn = mysqli_connect($server, $username, $password);
                    if (!$conn)
                        echo "Connection to Database Failed due to " . mysqli_connect_error;


                    $eid = $_SESSION['eid'];
                    $sql = "UPDATE `student_result_management_system`.`exam` SET `recheck` = 'Y' WHERE `eid` = '$eid'";
                    if ($conn->query($sql) === TRUE) {
                        echo "<h3>Successfully Applied for Recheck</h3>";
                    } else {
                        echo "Error Applying for Recheck: " . $conn->error;
                    }
                    $conn->close();
                }
                ?>
            </center>
        </div>
    </div>
</body>
</html>
