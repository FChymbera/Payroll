<?php
    include'config.php';
    if(isset($_SESSION['user'])){
        $user= $_SESSION['user'];
    }else{
        header('Location:login.php');
    }
    global $user;
    if(isset($_POST['payslip'])){
        $sql='SELECT * FROM income WHERE empId=:id';
        $stmt = $connect->prepare($sql);
        $stmt->execute([':id'=>$user]);
        $data=$stmt->fetch(PDO::FETCH_ASSOC);
        $income =$data['gross_income'];
        $nssa =$data['nssa'];
        $tax =$data['tax'];
        $med =$data['medicals'];
        $income2 =$data['net_income'];

        $sql='SELECT * FROM employee WHERE empId=:id';
        $stmt = $connect->prepare($sql);
        $stmt->execute([':id'=>$user]);
        $data2=$stmt->fetch(PDO::FETCH_ASSOC);
        $name = $data2['fname'];
        $sname = $data2['sname'];
        $contract= $data2['contract'];
        $id=$data2['nationalId'];
    }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="payslip.css">
    <link rel="stylesheet" type="text/css" href="modal.css">
    <link rel="stylesheet" type="text/css" href="attendence.css">
    <script src="modal.js"></script>
    <title>Document</title>
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
                        <a href="user-home.php">Home</a>
                    </li>
                    <li class="nav-items">
                        <a href="#" onclick="pop_attendence()">Attendence</a>
                    </li>
                    <li class="nav-items">
                        <a href="#" onclick="pop_modal()">Log Lessons</a>
                    </li>
                    <li class="nav-items">
                        <a href="payslip.php">View Payslip</a>
                    </li>
                    <li class="nav-items">
                        <a href="user-password.php">Settings</a>
                    </li>
                </ul>
            </div>
            <div class="logoutButton">
            <button><a href="logout.php">Logout</a></button>
            </div>
        </div>

        <div class="statsbar">
            <h1>Payslip</h1>
        </div>

        <div class="main">
            <div id="payslip">

                <form action="" method="post" class="boxx">
                    <div class="payslip_header">
                        <h1>EASTERN HEIGHTS COLLEGE</h1>
                        <h4>Payslip as at
                            <?php echo date('Y,m,d'); ?>
                        </h4>
                        <div class="detail">
                            <P>Employee Name<?php if(isset($name)){ echo('  '.$name.' '.$sname);} ?></P>
                            <p>Nationa ID <?php if(isset($id)){ echo($id);} ?></p>
                            <p>Contract Type <?php if(isset($contract)){ echo($contract);} ?></p>
                        </div>

                    </div>
                    <div class="incomedisplay">
                        <fieldset id="income">
                            <Legend>Gross Income</Legend>
                            <div class="form_row">
                                <label for="">Gross Income</label>
                                <input type="text" name="gincome" value=" <?php if(isset($income)){ echo('$'.round($income,2));} ?>"><br>
                            </div>
                            
                        </fieldset>
                        <fieldset id="ded">
                            <legend>Deductions</legend>
                            <div class="form_row">
                                <label for="">Tax deduction</label>
                                <input type="text" name="tax" value=" <?php if(isset($tax)){ echo('$'.round($tax,2));} ?>"><br>
                            </div>
                            <div class="form_row">
                                <label for="">NSSA deduction</label>
                                <input type="text" name="nssa" value=" <?php if(isset($nssa)){ echo('$'.round($nssa,2));} ?>"><br>
                            </div>
                          
                            <div class="form_row">
                                <label for="">Medical Aid deduction</label>
                                <input type="text" name="medical" value=" <?php if(isset($med)){ echo('$'.round($med,2));} ?>"><br>
                            </div>

                        </fieldset>
                    </div>
                    <fieldset id="netsal">
                        <legend>Net Income</legend>
                        <div class="form_row">
                            <label for="">Net Income</label>
                            <input type="text" name="nicome" value=" <?php if(isset($income2)){ echo('$'.round($income2,2));} ?>"></p>
                        </div>

                    </fieldset>
                    <input type="submit" value="View Payslip" name="payslip">
                </form>
            </div>
        </div>

        <div class="footer">
            <p id="copyright">Copyright @EHC </p>
            <p id="signiture">Powered by FCtechnologies</p>
        </div>
    </div>
    <div class="overlay" id="closed">
        <div class="modal" id="closed">
            <div class="modal-header">
            <?php
				if(isset($errMsg)){
					echo '<div style="color:#FF0000;text-align:center;font-size:17px;">'.$errMsg.'</div>';
				}
			?> 
                <h1>Log Lesson</h1>
                <button class="modal-close" onclick="push_modal()">&times;</button>
            </div>
            <div class="modal_content">
                <form action="logmodal.php" method="post">
                <input type="text" name="empId" placeholder="Employee ID">
                    <label for="lesson">LESSON</label><br>
                    <input list="lesson" name="lesson">
                    <datalist id="lesson">
                        <option value="Mathematics">
                        <option value="English">
                        <option value="Shona">
                        <option value="Biology">
                        <option value="Chemestry">
                        <option value="Accounts">
                        <option value="Computers">
                        <option value="History">
                        <option value="Divinity">
                        <option value="Economics">
                        <option value="Business Studies"></datalist><br>
                    <label for="Level">CLASS</label><br>
                    <input list="Class" name="class">
                    <datalist id="Class">
                                <option value="Form 1">
                                <option value="Form 2">
                                <option value="Form 3">
                                <option value="Form 4">
                                <option value="Lower 6 Science">
                                <option value="Lower 6 Commercials">
                                <option value="Lower 6 Arts">
                                <option value="Upper 6 Science">
                                <option value="Upper 6 Commercials">
                                <option value="Upper 6 Arts">
                    </datalist><br>
                    <label for="Duration">DURATION</label><br>
                    <select name="lessonTime" id="LT">
                        <option value="35">35 Minutes</option>
                        <option value="70">70 Minutes</option>
                        <option value="105">105 Minutes</option>
                </select><br>
                    <label for="lesson">TOPIC COVERED</label><br>
                    <input type="text" name="topic"><br>
                    <input type="date" name="Date" id="Cdate"><br>
                    <label for="lesson">Class Rep ID</label><br>
                    <input type="text" name="stdId"><br>
                    <input type="submit" value="Submit" name="loglesson">
                    <input type="reset" value="Reset">
                </form>
            </div>
        </div>
    </div>
    <div class="overlay" id="A_closed">
        <div class="modalA" id="A_closed">
            <div class="modal-header">
                <h1>ATTENDENCE REGISTER</h1>
                <button class="modal-close" onclick="push_attendence()">&times;</button>
                <?php
				if(isset($errMsg)){
					echo '<div style="color:#FF0000;text-align:center;font-size:17px;">'.$errMsg.'</div>';
				}
			?> 
            </div>
            <div class="modal_content2">
                <form action="attendencemodal.php" method="post">
                    <input type="text" name="empID" id="epmId1" placeholder="Employee ID">
                    <input type="date" name="dat" id="Cdate"><br>
                    <input type="text" name="tim" id="Ctime" value="<?php echo date('H:i:s'); ?>"><br>
                    <input type="submit" value="Log-in"  name ="log-in">
                </form>
            </div>
        </div>
    </div>

</body>

</html>