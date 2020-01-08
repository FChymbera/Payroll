<?php
    include'config.php';

    if(isset($_SESSION['user'])){
        $user= $_SESSION['user'];
    }else{
        header('Location:login.php');
    }
    if(isset($_POST['report'])){

        $stmt=$connect->query('SELECT SUM(tax) AS totaltax FROM income');
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        $totaltax= $data['totaltax'];

        $stmt=$connect->query('SELECT SUM(nssa) AS totalnssa FROM income');
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        $totalnssa= $data['totalnssa'];

        $stmt=$connect->query('SELECT SUM(medicals) AS totalmedical FROM income');
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        $totalmedical= $data['totalmedical'];

        $stmt=$connect->query('SELECT SUM(gross_income) AS totalgross FROM income');
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        $count = $stmt->rowcount();
        $totalgross= $data['totalgross'];

        $totaldeductions= round(($totaltax + $totalnssa + $totalmedical),2);
        $avgincome = round(($totalgross/$count),2);
    }
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="report.css">
    <title>NSSA & TAX</title>
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
                <button>Logout</button>
            </div>
        </div>

        <div class="statsbar">
            <h1>Report</h1>
        </div>

        <div class="main">
            <div id="payslip">

                <form action="" method="post">
                    <div class="payslip_header">
                        <input type="submit" value="View Report" name="report">
                        <h1>EASTERN HEIGHTS COLLEGE</h1>
                        <h4>Eastern Heights College Report :
                            <?php echo date('Y,m,d'); ?>
                        </h4>
                        <div class="detail">
                            <P><b>Employer Name:</b> <label>Eastern Heights College</label></P>
                            <p><b>Physical Address:</b> <label>26 Hebert Chitepo Street</label></p>
                        </div>

                    </div>
                    <div class="incomedisplay">
                        <fieldset id="income">
                            <legend>Deductions Data</legend>
                            <div class="form_row">
                                <label for="">Total Tax Paid</label>
                                <input type="text" name="tax" value="<?php if(isset($totaltax)){ echo '$'.$totaltax;} ?>"><br>
                            </div>
                            <div class="form_row">
                                <label for="">Total NSSA Paid</label>
                                <input type="text" name="nssa" value="<?php if(isset($totalnssa)){ echo '$'.round($totalnssa,2);} ?>"><br>
                            </div>
                            <div class="form_row">
                                <label for="">Total Medical Aid Fees</label>
                                <input type="text" name="total" value="<?php if(isset($totalmedical)){ echo '$'.$totalmedical;} ?>"><br>
                            </div>
                        </fieldset>
                        <fieldset id="ded">
                        <Legend>Income Data</Legend>
                            <div class="form_row">
                                <label for="">Total Income</label>
                                <input type="text" name="income" value="<?php if(isset($totalgross)){ echo '$'.$totalgross;} ?>"><br>
                            </div>
                            <div class="form_row">
                                <label for="">Total Deduction</label>
                                <input type="text" name="deductions" value="<?php if(isset($totaldeductions)){ echo '$'.$totaldeductions;} ?>"><br>
                            </div>
                            <div class="form_row">
                                <label for="">Avarage Income</label>
                                <input type="text" name="avgincome" value="<?php if(isset($avgincome)){ echo '$'.$avgincome;} ?>"><br>
                            </div>
                        </fieldset>
                    </div>
                    <div class="forecast">
                        <table>
                            <tr>
                                <th>Date</th>
                                <th>Income</th>
                                <th>Tax</th>
                                <th>NSSA</th>
                            </tr>
                        </table>
                    </div>
                    </fieldset>

                </form>
            </div>
        </div>

        <div class="footer">
            <p id="copyright">Copyright @EHC </p>
            <p id="signiture">Powered by FCtechnologies</p>
        </div>
    </div>

</body>

</html>