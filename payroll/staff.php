<?php
        include 'config.php';
        if(isset($_SESSION['user'])){
            $user= $_SESSION['user'];
        }else{
            header('Location:login.php');
        }
        if(isset($_POST['submit'])){
            $empId = $_POST['empId'];
            $_SESSION['empID']= $empId;
            $fname = $_POST['fname'];
            $sname = $_POST['sname'];
            $salutation = $_POST['salutation'];
            $id = $_POST['id'];
            $dob = $_POST['dob'];
            $sex = $_POST['gender'];
            $address = $_POST['address'];
            $level = $_POST['level'];
            $contract = $_POST['contract'];
            $paymethod = $_POST['paymethod'];
            $bank = $_POST['banks'];
            $bankAcc = $_POST['bankAcc'];
            $ecocash = $_POST['ecocash'];
            $accs =  'standard';
            global $accs;
            if($level== 1){
                $accs = 'admin';
            }

        $errMsg = '';
            if($empId == '')
                $errMsg = 'Enter your employee ID';
            if($fname == '')
                $errMsg = 'Enter employee name';
            if($sname == '')
                $errMsg = 'Enter employee surname';
            if($id == '')
                $errMsg = 'Enter employee national ID';
            // if($bank == '')
            //     $errMsg = 'Enter employee Bank name';
            // if($bankAcc == '')
            //     $errMsg = 'Enter employee Bank Account';
    
            if($errMsg == ''){
                try {
                        $sql =  'INSERT INTO employee(empId,fname,sname,salutation,nationalId,dob,sex,address,contract,level,payment_method,bank,account,ecocash) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
                        $stmt = $connect->prepare($sql);
                        $stmt->execute([$empId,$fname,$sname,$salutation,$id,$dob,$sex,$address,$contract,$level,$paymethod,$bank,$bankAcc,$ecocash]);
                }
                catch(PDOException $e) {
                    echo $e->getMessage();
                }
            }
        }
    
        if(isset($_GET['action']) && $_GET['action'] == 'joined') {
            $errMsg = 'Registration successfull';
        }

        $stmt2 = $connect->query('SELECT * FROM employee');
        while($rows = $stmt2->fetch(PDO::FETCH_ASSOC)){
            $check=$rows['empId'];
            global $empId;
            if($empId==$check){
                 //insert user credentials
                 $errMsg = 'Registration successfull';
                 global $accs;
            $sql3 = 'INSERT INTO user(userID,password,access) VALUE(?,?,?)';
            $stmt3 = $connect->prepare($sql3);
            $stmt3->execute([$empId,'default',$accs]);
            //initialise work hours file
            $sql4 = 'INSERT INTO work_hours(empId,accumHours) VALUE(?,?)';
            $stmt4 = $connect->prepare($sql4);
            global $empId;
            $stmt4->execute([$empId,0]);
            //initialise income file
            $sql5 = 'INSERT INTO income(empId,gross_income,tax,nssa,medicals,net_income) VALUE(?,?,?,?,?,?)';
            $stmt5 = $connect->prepare($sql5);
            global $empId;
            $stmt5->execute([$empId,0,0,0,0,0]);
            }
        }
        
        if(isset($_POST['view'])){
            $empId = $_POST['empId'];
            $sql = 'SELECT * FROM employee WHERE empId=?';
            $stmt = $connect->prepare($sql);
            $stmt->execute([$empId]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            $empId1 = $data['empId'];
            $fname1 = $data['fname'];
            $sname1 = $data['sname'];
            $salutation1 = $data['salutation'];
            $id1 = $data['nationalId'];
            $dob1 = $data['dob'];
            $sex1 = $data['sex'];
            $address1 = $data['address'];
            $level1 = $data['level'];
            $contract1 = $data['contract'];
            $paymethod1 = $data['payment_method'];
            $bank1 = $data['bank'];
            $bankAcc1 = $data['account'];
            $ecocash1 = $data['ecocash'];
        }

        if(isset($_POST['update'])){
            $empId = $_POST['empId'];
            $fname = $_POST['fname'];
            $sname = $_POST['sname'];
            $salutation = $_POST['salutation'];
            $id = $_POST['id'];
            $dob = $_POST['dob'];
            $sex = $_POST['gender'];
            $address = $_POST['address'];
            $level = $_POST['level'];
            $contract = $_POST['contract'];
            $paymethod = $_POST['paymethod'];
            $bank = $_POST['banks'];
            $bankAcc = $_POST['bankAcc'];
            $ecocash = $_POST['ecocash'];
            $accs =  'standard';
            global $accs;
            if($level== 1){
                $accs = 'admin';
            }
            $sql1='DELETE FROM employee WHERE empId=:empid';
            $stmt1 = $connect->prepare($sql1);
            $stmt1->execute([':empid'=>$empId]);

            $sql =  'INSERT INTO employee(empId,fname,sname,salutation,nationalId,dob,sex,address,contract,level,payment_method,bank,account,ecocash) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
                        $stmt = $connect->prepare($sql);
                        $stmt->execute([$empId,$fname,$sname,$salutation,$id,$dob,$sex,$address,$contract,$level,$paymethod,$bank,$bankAcc,$ecocash]);
            while($rows = $stmt2->fetch(PDO::FETCH_ASSOC)){
                $check=$rows['empId'];
                global $empId;
                if($empId==$check){
                    //insert user credentials
                    $errMsg = 'Registration successfull';
                     global $accs;
                    $sql3 = 'UPDATE user SET access=? WHERE userId=$empId';
                    $stmt3 = $connect->prepare($sql3);
                    $stmt3->execute([$accs]);
                    //initialise work hours file
                    }
        }
    }
    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ehc staff</title>
    <link rel="stylesheet" type="text/css" href="ehcstaff.css">
    <script>

      function isNumber(evt){
        var iKeyCode=(evt.which) ? evt.which : evt.iKeyCode
        if (iKeyCode != 46 && iKeyCode >31 && (iKeyCode<48|| iKeyCode>57))
        return false;
        return true;
      }
    </script>
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
            <h1 style ="color:beige; ">Staff</h1>
            <?php
				if(isset($errMsg)){
					echo '<div style="color:#FF0000;text-align:center;font-size:17px;">'.$errMsg.'</div>';
				}
			?> 
        </div>
        <!-- main tab-->
        <div class="main">
            <form action="" method="post">
                <fieldset id="photo">
                    <legend>Employee List</legend>
                    <table>
                        <tr>
                            <th>Employee ID</th>
                            <th>Surname</th>
                        </tr>
                        <?php
                                $stmt3 = $connect->query('SELECT * FROM employee');
                                 while($rows = $stmt3->fetch(PDO::FETCH_ASSOC)){
                                    echo'
                                    <tr>
                                    <td>' .$rows['empId'].'</td>
                                    <td> ' .$rows['sname'].'</td>
                                    </tr>
                                    ';
                                     }
                                    ?>
                    </table>
                </fieldset>
                <fieldset id="personal_details">
                    <legend>Personal Details</legend>
                    <label for="manage">Employee ID</label><br>
                    <input type="text" name="empId" value="<?php if(isset($empId1)){echo $empId1;} ?>" ><br>
                    <label for="manage">First Name</label><br>
                    <input type="text" name="fname" value="<?php if(isset($fname1)){echo $fname1;} ?>"><br>
                    <label for="manage">Surname</label><br>
                    <input type="text" name="sname" value="<?php if(isset($sname1)){echo $sname1;} ?>"v><br>
                    <label for="manage">National ID</label><br>
                    <input type="text" name="id" value="<?php if(isset($id1)){echo $id1;} ?>"><br>
                    <label for="manage">Date Of Birth</label><br>
                    <input type="date" name="dob" value="<?php if(isset($dob1)){echo $dob1;} ?>"><br>
                    <label for="manage">Gender</label><br>
                    <input type="text" name="gender" value="<?php if(isset($sex1)){echo $sex1;} ?>"><br>
                    <label for="manage">Salutation</label><br>
                    <input type="text" name="salutation" value="<?php if(isset($salutation1)){echo $salutation1;} ?>"><br>
                    <label for="manage">Physical Address</label><br>
                    <textarea name="address" cols="20" rows="4" ><?php if(isset($address1)){echo $address1;} ?></textarea><br>
                </fieldset>
                <fieldset id="work_details">
                    <legend>Work Details</legend>
                    <label for="manage">Contract Type</label><br>
                    <input list="contract" name="contract" value="<?php if(isset($contract1)){echo $contract1;} ?>">
                    <datalist id="contract">
                                            <option value="permant">
                                            <option value="temporal">
                    </datalist><br>
                    <label for="manage">Position</label><br>
                    <input list="level" name="level" value="<?php if(isset($leve1)){echo $level1;} ?>">
                    <datalist id="level">
                                            <option value="1 :Top Admin">
                                            <option value="2 :Middle Admin">
                                            <option value="3 :Low Admin">
                                            <option value="4 :Teachers">
                    </datalist><br>
                    <label for="manage">Payment Method</label><br>
                    <input list="payment_method" name="paymethod" value="<?php if(isset($paymethod1)){echo $paymethod1;} ?>">
                    <datalist id="payment_method">
                                            <option value="bank">
                                            <option value="ecocash">
                    </datalist><br>
                    <label for="manage">Bank</label><br>
                    <input list="banks" name="banks" value="<?php if(isset($bank1)){echo $bank1;} ?>">
                    <datalist id="banks">
                                      <option value="Baclays Bank">
                                      <option value="ZB Bank">
                                      <option value="Stanchart Bank">
                                      <option value="CBZ Bank">
                                      <option value="CABS Bank">
                                      <option value="EcoBank">
                                      <option value="NMB Bank">
                                    </datalist>
                    <label for="manage">Bank Acc</label><br>
                    <input type="text" name="bankAcc" value="<?php if(isset($bankAcc1)){echo $bankAcc1;} ?>" onkeypress="javascript:return isNumber(event)"><br>
                    <label for="manage">Ecocash Number</label><br>
                    <input type="text" name="ecocash" value="<?php if(isset($ecocash1)){echo $ecocash1;} ?>" onkeypress="javascript:return isNumber(event)"><br>
                    <input type="submit" value="Save" name="submit">
                    <input type="submit" value="View" name="view">
                    <input type="submit" value="Update" name="update">
                    <input type="reset" value="Reset" style="margin-top:10px;">
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