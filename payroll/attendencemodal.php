<?php

     include 'config.php';
    
       // attendence modal logging

        if(isset($_POST['log-in'])){

            $empID = $_POST['empID'];
            $logtime = date('H:i:s');
            $Date= $_POST['dat'];
            global $status;
            if(date('H')>7){
             $status ='late';
            }else{
                $status ='ontime';
            }

            $errMsg = '';
            if($empID == '')
                $errMsg = 'Fill in all text fields';
            if($Date == '')
                $errMsg = 'Fill in all text fields';
    
            if($errMsg == ''){
                try {
                    $sql =  'INSERT INTO attendence(empId,dates,timeIN,status) VALUES(?,?,?,?)';
                    $stmt = $connect->prepare($sql);
                    $stmt->execute([$empID,$Date,$logtime,$status]);
                    $errMsg = 'Attendence log successfull';
                    header('Location:user-home.php');
                }
                catch(PDOException $e) {
                    echo $e->getMessage();
                }
            }
        }

?>