<?php
    include 'config.php';

    if(isset($_SESSION['user'])){
        if(isset($_POST['changepas'])){

            $empid = $_SESSION['user'];
            $oldpass =$_POST['oldpass'];
            $newpass = $_POST['newpass'];
            $confirmpass = $_POST['confirmpass'];
            $er="";
            $sql= 'SELECT password FROM user WHERE userId=:id';
            $stmt = $connect->prepare($sql);
            $stmt->execute([':id'=>$empid]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            if($oldpass == $data['password']){
                if($newpass == $confirmpass){
                    $sql = 'UPDATE user SET password=:newpass WHERE userId=:id';
                    $statement = $connect->prepare($sql);
                    $statement->execute([':newpass' => $newpass, ':id' => $empid]);
                        // header('Location:setting.php');
                    $er="Password sucessully changed";
            
                }else{
                    $er ="Password does not match";
                }
            }else{
                $er="current password does not match";
            }
        }
    }else{
        header('Location:login.php');
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="password.css">
    <title>Settings</title>
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
                <p>Welcome</p>
                <label for="Name"></label>
            </div>
        </div>
        < <div class="navbar">
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
            <h1>Password</h1>
        </div>

        <div class="main">
            <div class="modal_content">
                <form action="" method="post" id="changepass">
                    <h1>Change Password</h1>
                    <label for="lesson">Employee ID</label><br>
                    <input type="text" name="empid" readonly value="<?php echo $_SESSION['user']; ?>" style="text-align:centre;"><br>
                    <label for="">Current Password</label><br>
                    <input type="password" name="oldpass" id="oldpass" required><br>
                    <div class="pass">
                        <div class="newpass">
                            <label for="">New Password</label>
                            <input type="password" name="newpass" id="newpass" required>
                        </div>
                        <div class="confirmpass">
                            <label for="">Confirm Password</label>
                            <input type="password" name="confirmpass" id="confirmpass" required>
                        </div>
                    </div>
                    <label for="" style="color:red;"><?php if(isset($er)){
                        echo $er;
                    } ?></label><br>
                    <input type="submit" value="Submit" name="changepas">
                    <input type="reset" value="Reset">
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