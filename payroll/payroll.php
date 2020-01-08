<?php
    include 'config.php';

    if(isset($_SESSION['user'])){
        $user= $_SESSION['user'];
    }else{
        header('Location:login.php');
    }
    
    if(isset($_POST['process'])){
        $empId=$_POST['empID'];
      
        $sql = 'SELECT contract,fname,sname FROM employee WHERE empId=:id';
        $stmt = $connect->prepare($sql);
        $stmt->execute([':id'=>$empId]);
        $rslt=$stmt->fetch(PDO::FETCH_ASSOC);
        $fname= $rslt['fname'];
        $sname=$rslt['sname'];
        if($rslt['contract'] =='permant'){
            $sql = 'SELECT level FROM employee WHERE empId=:id';
            $stmt = $connect->prepare($sql);
            $stmt->execute([':id'=>$empId]);
            $rslt2=$stmt->fetch(PDO::FETCH_ASSOC);
            $level = $rslt2['level'];

            // fetch gross salary & update income file
            $sql2 = 'SELECT salary FROM salary WHERE level=:lvl';
            $stmt2 = $connect->prepare($sql2);
            $stmt2->execute([':lvl'=>$level]);
            $gross = $stmt2->fetch(PDO::FETCH_ASSOC );
            $grosssalary = $gross['salary'];

            //get medical
            $sql4 = 'SELECT amount FROM deductible WHERE name="medical"';
            $stmt4 = $connect->prepare($sql4);
            $stmt4->execute();
            $med=$stmt4->fetch(PDO::FETCH_ASSOC);
            $medical = $med['amount'];

            //calculate income
            $hrs=0;
            $nssa = $grosssalary*0.035;
            $tax = $grosssalary*0.2;
            $netsal = $grosssalary-$nssa-$tax-$medical;

            //update gross income
            global $empId;
            $sql3='UPDATE income SET gross_income=:gincome, tax=:tx, nssa=:ns, medicals=:med, net_income=:wage WHERE empId=:id';
            $statement = $connect->prepare($sql3);
            $statement->execute([':gincome'=>$grosssalary,':tx'=>$tax,':ns'=>$nssa, ':med'=>$medical, ':wage'=>$netsal, ':id'=>$empId]);
       
        }elseif ($rslt['contract']=='temporal') {
            
            $sql = 'SELECT accumhours FROM work_hours WHERE empId=:id';
            $stmt = $connect->prepare($sql);
            $stmt->execute([':id'=>$empId]);
            $wrkhrs=$stmt->fetch(PDO::FETCH_ASSOC);

            $hrs = $wrkhrs['accumhours'];
            //select wage rate
            $sql2 = 'SELECT amount FROM deductible WHERE name="rate"';
            $stmt2 = $connect->prepare($sql2);
            $stmt2->execute();
            $hrlyrate=$stmt2->fetch(PDO::FETCH_ASSOC);
            $rate = $hrlyrate['amount'];

            //get medical
            $sql2 = 'SELECT amount FROM deductible WHERE name="medical"';
            $stmt2 = $connect->prepare($sql2);
            $stmt2->execute();
            $med=$stmt2->fetch(PDO::FETCH_ASSOC);
            $medical = $med['amount'];

            //calculate income
            $grosssalary = ($hrs/60)*$rate;
            $nssa = $grosssalary*0.035;
            $tax=0;
            global $tax;
            if($grosssalary>300){
                $tax = $grosssalary*0.2;
            }
            $netsal = $grosssalary-$nssa-$tax-$medical;

            //update income file
            $sql3='UPDATE income SET gross_income=:gincome, tax=:tx, nssa=:ns, medicals=:med, net_income=:wage WHERE empId=:id';
            $statement = $connect->prepare($sql3);
            $statement->execute([':gincome'=>$grosssalary,':tx'=>$tax,':ns'=>$nssa, ':med'=>$medical, ':wage'=>$netsal, ':id'=>$empId]);
        }
    }

    //calculate salary
    function calculatePay($empId,$contract){
        global $connect;
        if(isset($empId) && $contract =='permant'){
            $sql = 'SELECT level FROM employee WHERE empId=:id';
            $stmt = $connect->prepare($sql);
            $stmt->execute([':id'=>$empId]);
            $rslt2=$stmt->fetch(PDO::FETCH_ASSOC);
            $level = $rslt2['level'];

            // fetch gross salary & update income file
            $sql2 = 'SELECT salary FROM salary WHERE level=:lvl';
            $stmt2 = $connect->prepare($sql2);
            $stmt2->execute([':lvl'=>$level]);
            $gross = $stmt2->fetch(PDO::FETCH_ASSOC );
            $grosssalary = $gross['salary'];

            //get medical
            $sql4 = 'SELECT amount FROM deductible WHERE name="medical"';
            $stmt4 = $connect->prepare($sql4);
            $stmt4->execute();
            $med=$stmt4->fetch(PDO::FETCH_ASSOC);
            $medical = $med['amount'];

            //calculate income
            $hrs="N/A";
            $nssa = $grosssalary*0.035;
            $tax = $grosssalary*0.2;
            $netsal = $grosssalary-$nssa-$tax-$medical;

            //update gross income
            global $empId;
            $sql3='UPDATE income SET gross_income=:gincome, tax=:tx, nssa=:ns, medicals=:med, net_income=:wage WHERE empId=:id';
            $statement = $connect->prepare($sql3);
            $statement->execute([':gincome'=>$grosssalary,':tx'=>$tax,':ns'=>$nssa, ':med'=>$medical, ':wage'=>$netsal, ':id'=>$empId]);
        }
        if(isset($empId) && $contract =='temporal'){
            
            $sql = 'SELECT accumhours FROM work_hours WHERE empId=:id';
            $stmt = $connect->prepare($sql);
            $stmt->execute([':id'=>$empId]);
            $wrkhrs=$stmt->fetch(PDO::FETCH_ASSOC);

            $hrs = $wrkhrs['accumhours'];
            //select wage rate
            $sql2 = 'SELECT amount FROM deductible WHERE name="rate"';
            $stmt2 = $connect->prepare($sql2);
            $stmt2->execute();
            $hrlyrate=$stmt2->fetch(PDO::FETCH_ASSOC);
            $rate = $hrlyrate['amount'];

            //get medical
            $sql2 = 'SELECT amount FROM deductible WHERE name="medical"';
            $stmt2 = $connect->prepare($sql2);
            $stmt2->execute();
            $med=$stmt2->fetch(PDO::FETCH_ASSOC);
            $medical = $med['amount'];

            //calculate income
            $grosssalary = ($hrs/60)*$rate;
            $nssa = $grosssalary*0.035;
            $tax=0;
            global $tax;
            if($grosssalary>300){
                $tax = $grosssalary*0.2; 
            }
            $netsal = $grosssalary-$nssa-$tax-$medical;

            //update income file
            $sql3='UPDATE income SET gross_income=:gincome, tax=:tx, nssa=:ns, medicals=:med, net_income=:wage WHERE empId=:id';
            $statement = $connect->prepare($sql3);
            $statement->execute([':gincome'=>$grosssalary,':tx'=>$tax,':ns'=>$nssa, ':med'=>$medical, ':wage'=>$netsal, ':id'=>$empId]);
        }
    }
    //calculate income for all employees
    if(isset($_POST['processAll'])){

        $stmt = $connect->query('SELECT * FROM employee');
        while ($rslt = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $empId = $rslt['empId'];
            $contract = $rslt['contract'];
            global $empId;
            calculatePay($empId,$contract);
            
        } 
        $msg ='Payroll Processing Complete';
    }
?>
 
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ehc payroll</title>
    <link rel="stylesheet" type="text/css" href="payroll.css">
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
            <h1 style ="color:beige; text-decoration-line: underline;">Payroll</h1>
        </div>


        <div class="main">
            <div class="pay1">
                <form action="" method="post">
                    <fieldset id="payroll1">
                        <div class="form_row">
                            <label for="epmID">Employee ID</label>
                            <input type="search" name="empID" id="empID" required><br>
                        </div>
                        <div class="form_row">
                            <label for="empName">Employee Name</label>
                            <input type="text" name="empName" id="empName" value="<?php if(isset($_POST['process']) && isset($fname)){echo ($fname."  ".$sname);} ?>" ><br>
                        </div>
                        <div class="form_row">
                            <label for="thours"> Total Hours</label>
                            <input type="text" name="thours" id="thours" value="<?php if(isset($_POST['process']) && isset($hrs)){ echo round(($hrs/60),2);} ?>"><br>
                        </div>
                        <div class="form_row">
                            <label for="grossIncome">Gross Income</label>
                            <input type="text" name="grossIncome" id="grossIncome" value="<?php if(isset($_POST['process']) && isset($grosssalary)){ echo '$'.round($grosssalary,2);} ?>"><br>
                        </div>
                        <div class="form_row">
                            <label for="tdeductions">Total Deductions</label>
                            <input type="text" name="tdeductions" id="tdeductions" value="<?php if(isset($_POST['process']) && isset($tax)){echo '$'.round(($tax+$nssa),2);} ?>"><br>
                        </div>
                        <div class="form_row">

                            <label for="netIncome">Net Income</label>
                            <input type="text" name="netincome" id="netincome" value="<?php if(isset($_POST['process']) && isset($netsal)){echo '$'.round($netsal,2);} ?>"><br>
                        </div>
                        <div class="pay1_buttons">
                            <input type="submit" value="Proccess" id="process" name="process">
                            <input type="reset" value="Reset">
                        </div>
                    </fieldset>
                </form>
            </div>
            <div class="payall">
                <form action="" method="post">
                    <input type="submit" value="Process" name="processAll">
                    <input type="reset" value="Reset">
                </form>
                <table>
                    <tr>
                        <th>EmpID</th>
                        <th>Gross Income</th>
                        <th>Tax</th>
                        <th>NSSA</th>
                        <th>Medical Aid</th>
                        <th>Net Income</th>
                    </tr>

                    <?php
                            $stmt2 = $connect->query('SELECT * FROM income');
                             while($rows = $stmt2->fetch(PDO::FETCH_ASSOC)){
                                echo'
                                <tr>
                                <td><input type="text" name="td_empID" id="td_empID" class="td_input" readonly value=' .$rows['empId'].'></td>
                                <td><input type="text" name="td_empID" id="td_empID" class="td_input" readonly value=' .'$'.round($rows['gross_income'],2).'></td>
                                <td><input type="text" name="td_empID" id="td_empID" class="td_input" readonly value='.'$' .round($rows['tax'],2).'></td>
                                <td><input type="text" name="td_empID" id="td_empID" class="td_input" readonly value=' .'$'.round($rows['nssa'],2).'></td>
                                <td><input type="text" name="td_empID" id="td_empID" class="td_input" readonly value=' .'$'.round($rows['medicals'],2).'></td>
                                <td><input type="text" name="td_empID" id="td_empID" class="td_input" readonly value='.'$' .round($rows['net_income'],2).'></td>
                                </tr>
                                ';
                                 }
                                ?>

                </table>

            </div>
        </div>

        <div class="footer">
            <p id="copyright">Copyright @EHC </p>
            <p id="signiture">Powered by FCtechnologies</p>
        </div>
    </div>
</body>

</html>