<?php

    include 'config.php';

    if(isset($_SESSION['user'])){
        $user= $_SESSION['user'];
    }else{
        header('Location:login.php');
    }
    // selecting data from table
    $sql = 'SELECT empId,lesson,time,duration FROM logsheet';
    $stmt = $connect->prepare($sql);
    $stmt->execute();
    //stats
    $numlesson = $stmt->rowCount();
    $stmt2 = $connect->query('SELECT * FROM logsheet');
    $thours = 0;
    while($rows = $stmt2->fetch(PDO::FETCH_ASSOC)){
         $thours = $thours + $rows['duration'];
    }

     // selecting data from table
     $sql = 'SELECT * FROM attendence';
     $stmt = $connect->prepare($sql);
     $stmt->execute();
     //stats
     $numattend = $stmt->rowCount();
    
 

?> 

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ehc home</title>
    <link rel="stylesheet" type="text/css" href="style.css">
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
            <div class="lesson">
                <div class="text">
                    <p id="numLesson"><?php
                    if(isset($numlesson)){
                        echo $numlesson;
                    }
                    ?></p>
                    <p>LESSON</p>
                </div>
            </div>
            <div class="hours">
                <div class="text">
                    <p id="hr"><?php
                    if(isset($thours)){
                        echo round(($thours/60),2);
                    }
                    ?></p>
                    <p>HOURS</p>
                </div>
            </div>
            <div class="attendence">
                <div class="text">
                    <p id="register"><?php
                    if(isset($numattend)){
                        echo $numattend;
                    }
                    ?></p>
                    <p>ATTENDENCE</p>
                </div>
            </div>
        </div>

        <div class="main">
            <form action="">
                <div class="tableDisplay">
                    <table>
                        <tr>
                            <th>ID</th>
                            <th>LESSSON</th>
                            <th>DATE</th>
                            <th>TIME</th>
                            <th>DURATION</th>
                        </tr>
                        <?php
                            $stmt2 = $connect->query('SELECT * FROM logsheet');
                             while($rows = $stmt2->fetch(PDO::FETCH_ASSOC)){
                                echo'
                                <tr>
                                <td>' .$rows['empId'].'</td>
                                <td> ' .$rows['lesson'].'</td>
                                <td> ' .$rows['date'].'</td>
                                <td> ' .$rows['time'].'</td>
                                <td> ' .$rows['duration'].'</td>
                                </tr>
                                ';
                                 }
                                ?>
                    </table>
                </div>
            </form>

        </div>

        <div class="footer">
            <p id="copyright">Copyright @EHC </p>
            <p id="signiture">Powered by FCtechnologies</p>
        </div>
    </div>
</body>

</html>