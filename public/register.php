<!DOCTYPE html>
<html>
    <head>
        <title>Register!!</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="styles/chess.css">
        <style>.error {color: #FF0000;}</style>
    </head>
    <body>
    <?php
        include 'connect.php';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // var_dump($_POST);
            $email = $username = $name = $password = $Err = "";
            $emailErr = $usernameErr = $nameErr = $passwordErr = $confpasswdErr = "";
            if (!empty($_POST["email"])) {
                $email = preprocess_input($_POST["email"]);
                if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
                    $emailErr = "Inavalid value";
                    $email="";
                }
            }else {
                $emailErr = "cannot be empty";
            }

            if (!empty($_POST["username"])) {
                $username = preprocess_input($_POST["username"]);
                if (!preg_match('/^[a-zA-Z][a-zA-Z0-9]*$/', $username)) {
                    $usernameErr = 'Invalid value';
                    $username = '';
                }elseif (!isAvail($username, $conn)) {
                    $usernameErr = "not available";
                    $username = "";
                }
            } else {
                $usernameErr = "cannot be empty";
            }

            if (!empty($_POST["name"])) {
                $name = preprocess_input($_POST["name"]);
                if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
                    $nameErr = "Invalid value";
                    $name = "";
                }
            }else {
                $name = "";
            }

            if (!empty($_POST["password"])) {
                $password = htmlspecialchars($_POST["password"]);
                if (!preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/", $password)) {
                    $passwordErr = 'Invalid password';
                    $password = '';
                }
            }else {
                $passwordErr = "cannot be empty";
            }

            if (!empty($_POST["confpasswd"])) {
                if (htmlspecialchars($_POST['password']) != htmlspecialchars($_POST['confpasswd'])) {
                    $confpasswdErr = 'Password does not match';
                }
            } else {
                $confpasswdErr = "cannot be empty";
            }

            $flag = insertUserData($conn, $email, $password, $name, $username);
            if (!$flag) {
                // die("ERROR: failed query");
                $Err = "ERROR: failed query";
            }else {
                echo "<script>alert('SUCCESS');  window.location='login.php';</script>";
            }

        }
        function preprocess_input($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            $data = strtolower($data);
            return $data;
        }
        function isAvail($email, $conn){
            $sql = "SELECT * FROM userData WHERE email='$email'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                return false; 
            } else {
                return true; 
            }
        }

        function insertUserData($conn, $email, $password, $name, $username){
            if (!empty($username) && !empty($email) && !empty($password)) {
                echo $username;
                // return true;
                $sql = "INSERT INTO userData (name, email, username, password) VALUES ('$name', '$email', '$username', '$password')";
                if (mysqli_query($conn, $sql)) {
                    return true; 
                } else {
                    return false; 
                }
            }else{
                return false;
            }
        }

?>
    <div class="l">
            <img class="logo" src="images/logo.png" alt="">
            <div class="icons" style="display: flex; flex-direction: column;">
                <div class="icon">
                    <img src="images/home.png" alt="">
                    <a href="index.html">
                        <div>Home</div>
                    </a>
                </div>
            </div>
        </div>
        <div class="m">
            <!-- <center> -->
                <div class="profile" style="display: flex, width=100%">
                    <p><span class="error">* required field.</span></p>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
                        <br>
                        <h3>
                            &nbsp; Email:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="text" name="email" style="width: 40%;" value="<?php  echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : "";?>">
                            <span class="error">* <?php echo $emailErr;?></span>
                        </h3> 
                        <h3>
                            &nbsp; Username: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="text" name="username" style="width: 40%;" value="<?php  echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : "";?>">
                            <span class="error">* <?php echo $usernameErr;?></span>
                        </h3>
                        <h3>
                            &nbsp; name: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="text" name="name" style="width: 40%;" value="<?php  echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : "";?>">
                            <span class="error"><?php echo $nameErr;?></span>
                        </h3>
                        <h3>
                            &nbsp;&nbsp;Password: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="password" name="password" style="width: 40%;">
                            <span class="error">* <?php echo $passwordErr;?></span>
                        </h3>
                        <h3>
                            &nbsp;&nbsp;Confirm Password: <input type="password" name="confpasswd" style="width: 40%;">
                            <span class="error">* <?php echo $confpasswdErr;?></span>
                        </h3>
                        <center>
                        <span class="error"><?php echo $Err;?></span><br>
                            <button type="submit" style="background-color: white; color: black;">Register</button></center>
                    </form>
                    <a href="login.php">Already have an account?</a>
                </div>
            <!-- </center> -->
        </div>
    </body>
</html>