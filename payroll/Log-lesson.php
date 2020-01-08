<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>lessons</title>
    <link rel="stylesheet" type="text/css" href="Log-lesson.css">
    <script src="Log-lesson.js"></script>
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
                        <a href="#">Home</a>
                    </li>
                    <li class="nav-items">
                        <a href="#">Manage Stuff</a>
                    </li>
                    <li class="nav-items">
                        <a href="#">Manage Reps</a>
                    </li>
                    <li class="nav-items">
                        <a href="#">Manage Deductables</a>
                    </li>
                    <li class="nav-items">
                        <a href="#">Calculate Income</a>
                    </li>
                    <li class="nav-items">
                        <a href="#">Manage Reports</a>
                    </li>
                </ul>
            </div>
            <div class="logoutButton">
            <button><a href="logout.php">Logout</a></button>
            </div>
        </div>

        <div class="statsbar">

        </div>

        <div class="main">
            <form action="">
                <div class="dropdown">
                    <label for="lesson">LESSON</label><br>
                    <select name="Subject" id="subjects">
                        <option value="Mathematics">Mathematics</option>
                        <option value="English">English</option>
                        <option value="Shona">Shona</option>
                        <option value="Biology">Biology</option>
                        <option value="Chemestry">Chemestry</option>                                      <option value="Accounts">Accounts</option>
                        <option value="Computers">Computers</option>
                        <option value="History">History</option>
                        <option value="Divinity">Divinity</option>
                        <option value="Economics">Economics</option>
                        <option value="Business Studies">Business Studies</option>
                     </select><br>
                    <label for="Level">CLASS</label><br>
                    <select name="level" id="classes">
                            <option value="Form 1">F1</option>
                            <option value="Form 2">F2</option>
                            <option value="Form 3">F3</option>
                            <option value="Form 4">F4</option>
                            <option value="Lower 6 Science">L6 Sciences</option>
                            <option value="Lower 6 Commercials">L6 Commercials</option>
                            <option value="Lower 6 Arts">L6 Arts</option>
                            <option value="Upper 6 Science">U6 Sciences</option>
                            <option value="Upper 6 Commercials">U6 Commercials</option>
                            <option value="Upper 6 Arts">U6 Arts</option>                    
                    </select><br>
                    <label for="Duration">DURATION</label><br>
                    <select name="lessonTime" id="LT">
                                            <option value="35">35 Minutes</option>
                                            <option value="70">70 Minutes</option>
                                            <option value="105">105 Minutes</option>
                   </select><br>
                </div>
                <label for="lesson">TOPIC COVERED</label><br>
                <input type="text" name="topic" placeholder="Topic Covered"><br>
                <input type="date" name="Date" id="Cdate"><br>
                <input type="submit" value="Time" onclick="InsertTime()" id="texts"><br>
                <input type="time" name="Time" id="Ctime"><br>
                <input type="submit" value="Submit">
                <input type="submit" value="Reset" onclick="reset()">
            </form>
        </div>

        <div class="footer">
            <p id="copyright">Copyright @EHC </p>
            <p id="signiture">Powered by FCtechnologies</p>
        </div>
    </div>
</body>

</html>