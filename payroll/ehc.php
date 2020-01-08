<?php
	include 'config.php';
	include 'db.php';

	if(isset($_POST['login'])) {
		
		// Get data from FORM
		$username = $_POST['username'];
		$password = $_POST['passwd'];
		$_SESSION['user']= $username;
		
		$sql = 'SELECT * FROM user WHERE userId=?';
		$stmt= $connect->prepare($sql);
		$stmt->execute([$username]);
		if($stmt->rowCount()==1){
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
		}else{
			echo'
			<script>
				alert("Invalid Login Credentials");
			</script>
			';
				
		}
	 $sql='SELECT * FROM checkit WHERE id=:id';
     $stmt=$connect->prepare($sql);
     $stmt->execute([':id'=>1]);
	 $check=$stmt->fetch(PDO::FETCH_ASSOC);
	 $update=$check['count1']+1;
	 $sql='UPDATE checkit  SET count1=:add WHERE id=:id';
     $stmt=$connect->prepare($sql);
     $stmt->execute([':add'=>$update,':id'=>1]);
     
	}
?>