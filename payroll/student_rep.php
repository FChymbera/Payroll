<?php
        include 'config.php';

    	if(isset($_POST['submit'])){

            $stdId = $_POST['stdId'];
            $fname = $_POST['fname'];
            $sname = $_POST['sname'];
            $sex = $_POST['gender'];
            $class = $_POST['class'];

            $errMsg = '';
            if($stdId == '')
                $errMsg = 'Enter your student ID';
            if($fname == '')
                $errMsg = 'Enter student name';
            if($sname == '')
                $errMsg = 'Enter student surname';
    
            if($errMsg == ''){
                try {
                    $sql =  'INSERT INTO student(stdId,fname,sname,sex,class) VALUES(?,?,?,?,?)';
                    $stmt = $connect->prepare($sql);
                    $stmt->execute([$stdId,$fname,$sname,$sex,$class]);
                }
                catch(PDOException $e) {
                    echo $e->getMessage();
                }
            }
        }
    
        if(isset($_GET['action']) && $_GET['action'] == 'joined') {
            $errMsg = 'Registration successfull';
        }
        $stmt2 = $connect->query('SELECT * FROM student');
        while($rows = $stmt2->fetch(PDO::FETCH_ASSOC)){
            $check=$rows['stdId'];
            global $stdId;
            if($stdId==$check){
                 //insert user credentials
            $sql3 = 'INSERT INTO user(userID,password,access) VALUE(?,?,?)';
            $stmt3 = $connect->prepare($sql3);
            $stmt3->execute([$stdId,'student','student']);
            }
        }
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ehc reps</title>
    <link rel="stylesheet" type="text/css" href="student.css">
</head>

<body>
    <div class="wrapper">
        <div class="header">
            <div class="logo">
                <div class="logo_img">

                </div>
                <h1>EHC</h1>
                <p>Payroll System</p>

            </div>
            <div class="welcomeNote">
            
            </div>
        </div>
        <div class="navbar">
            <div class="navlist">
                <ul class="nav-list">
                    <li class="nav-items">
                        <a href="home.php">Home</a>
                    </li>
                    <li class="nav-items">
                        <a href="staff.php">Stuff</a>
                    </li>
                    <li class="nav-items">
                        <a href="student_rep.php">Student Reps</a>
                    </li>
                    <li class="nav-items">
                        <a href="payroll.php">Income</a>
                    </li>
                    <li class="nav-items">
                        <a href="report.php">Report</a>
                    </li>
                    <li class="nav-items">
                        <a href="setting.php">Passwords</a>
                    </li>
                </ul>
            </div>
            <div class="logoutButton">
            <button><a href="logout.php">Logout</a></button>
            </div>
        </div>

        <div class="statsbar">
            <h1 style ="color:beige; text-decoration-line: underline;">Student</h1>
            <?php
				if(isset($errMsg)){
					echo '<div style="color:#FF0000;text-align:center;font-size:17px;">'.$errMsg.'</div>';
				} 
            ?>
        </div>
        main tab 
        <div class="main">
            <fieldset id="photo">
                <legend>Students</legend>
                <table>
                    <tr>
                        <th>Student ID</th>
                        <th>Class</th>
                    </tr>
                    <?php
                            $stmt3 = $connect->query('SELECT * FROM student');
                             while($rows = $stmt3->fetch(PDO::FETCH_ASSOC)){
                                echo'
                                <tr>
                                <td>' .$rows['stdId'].'</td>
                                <td> ' .$rows['class'].'</td>
                                </tr>
                                ';
                                 }
                                ?>
                </table>
            </fieldset>
            <form action="" method="post">
                <fieldset id="student_details">
                    <legend>student Details</legend>
                    <label for="manage">Sudent ID</label><br>
                    <input type="text" name="stdId"><br>
                    <label for="manage">First Name</label><br>
                    <input type="text" name="fname"><br>
                    <label for="manage">Surname</label><br>
                    <input type="text" name="sname"><br>
                    <label for="manage">Gender</label><br>
                    <input type="text" name="gender"><br>
                    <label for="manage">Class</label><br>
                    <input type="text" name="class"><br>
                    <input type="submit" value="Submit" name="submit" id="submit">
                    <input type="button" value="Reset" id="reset">
                </fieldset>
            </form>

        </div>

        <div class="footer">
            <p id="copyright">Copyright @EHC </p>
            <p id="signiture">Powered by FCtechnologies</p>
        </div>
    </div>
</body>

</html>