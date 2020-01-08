<?php

     include 'config.php';
    // lesson logging modal
    	if(isset($_POST['loglesson'])){

            $empId = $_POST['empId'];
            $lesson = $_POST['lesson'];
            $class = $_POST['class'];
            $duration = $_POST['lessonTime'];
            $topic = $_POST['topic'];
            $date= $_POST['Date'];
            $stdId= $_POST['stdId'];
            $time = date('H:i:sA');

            $errMsg = '';
            if($empId == '')
                $errMsg = 'Enter your employee ID';
            if($lesson == '')
                $errMsg = 'Enter lesson name';
            if($duration == '')
                $errMsg = 'Enter lesson duration';
            
            $sql='SELECT contract FROM employee WHERE empId=?';
            $stmt= $connect->prepare($sql);
            $stmt->execute([$empId]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            $check = $data['contract'];

            if($check=='permant'){
                $errMsg='Access Denied';
            }

    
            if($errMsg == ''){
                try {
                    $sql ='INSERT INTO logsheet(empId,lesson,class,date,time,duration,topic,stdId) VALUES(?,?,?,?,?,?,?,?)';
                    $stmt = $connect->prepare($sql);
                    $stmt->execute([$empId,$lesson,$class,$date,$time,$duration,$topic,$stdId]);
                    $errMsg = 'Registration successfull';
                    //update hours worked
                    $stmt2 = $connect->query('SELECT * FROM work_hours');
                    while($row = $stmt2->fetch(PDO::FETCH_ASSOC)){
                        $check = $row['empId'];
                        $wrkhrs = $row['accumhours'];  
                        global $empId;
                        if($empId==$check){
                            global $duration;
                            $wrkhrs = $wrkhrs + $duration;
                            // echo $wrkhrs;
                            $sql = 'UPDATE work_hours SET accumhours=:hrs WHERE empId=:id';
                            $statement = $connect->prepare($sql);
                            $statement->execute([':hrs' => $wrkhrs, ':id' => $empId]);
                            header('Location:user-home.php');
                        }
                    }
                }
                catch(PDOException $e) {
                    echo $e->getMessage();
                }
            }
        
    
        if(isset($_GET['action']) && $_GET['action'] == 'joined') {
            $errMsg = 'Registration successfull';
        }
     }
?>