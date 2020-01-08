<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Eastern Heights College</title>
    <link rel="stylesheet" type="text/css" href="ehc.css">
</head>

<body>
    <div class="header">
        <img src="EHC LOGO.png" alt="logo" height="80px" width="200px">
        <h1>EASTERN HEIGHTS COLLEGE</h1>
        <p>Inspiring tomorrow's professionals</p>
    </div>

    <form class="box" action="ehc.php" method="post">
        <input type="text" name="username" placeholder="Enter Username" autocomplete="off" required><br>
        <input type="password" name="passwd" placeholder="Enter Password" required><br>
        <input type="submit" value="Log In" name="login">
        <?php
		if(isset($err)){
            echo'<p style="color:red">'.$err.'</p>';
        }
	    ?> 
    </form>
  
</body>

</html>
<?php
	include 'config.php';

	if(isset($_POST['login'])) {
		
		// Get data from FORM
		$username = $_POST['username'];
		$password = $_POST['passwd'];
		$_SESSION['user']= $username;
		
		$sql = 'SELECT * FROM user WHERE userId=?';
		$stmt= $connect->prepare($sql);
        $stmt->execute([$username]);
        $user = $stmt->rowCount();
		if($user==1){
		    $rows = $stmt->fetch(PDO::FETCH_ASSOC);
			$check=$rows['userId'];
			$checkpass =$rows['password'];
			$access=$rows['access'];
			global $username;
			if(($username==$check)&&($access=='admin')&&($password=$checkpass)){
				var_dump($rows);
				header('Location: home.php');
				exit;
			}
			if (($username==$check)&&($access=='standard')&&($password=$checkpass)) {

				header('Location: user-home.php');
				exit;
			}
			if (($username==$check)&&($access=='student')&&($password=$checkpass)) {
				header('Location: setting.php');
				exit;
			}
		}
	      $err='Invalid Login';
		
	}
?>