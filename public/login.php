<?PHP session_start();?>
<!DOCTYPE html>
<html>
    <head>
        <title>Login!!</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="styles/chess.css">
        <style>.error {color: #FF0000;}</style>
    </head>
    <body>
        <?php
        include("connect.php");
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            var_dump($_POST);
            $username = $password = "";
            $Err = "";
            $username=preprocess_input($_POST['username']);
            $password=htmlspecialchars($_POST['password']);
            $Err = validate_cred($username, $password, $conn);
        }
        function preprocess_input($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            $data = strtolower($data);
            return $data;
        }

        function validate_cred($username, $password, $conn){
            $stmt = mysqli_prepare($conn, "SELECT * FROM userData WHERE username = ?");
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);
                if($password == $row['password']){
                    $_SESSION["username"] = $username;
                    echo "<script>alert('SUCCESS');  window.location='home.php';</script>";
                    exit;
                }else {
                    return 'ERROR: Wrong password<br>';
                }
            }else {
                return 'ERROR: username or password not found!<br>';
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
            <center>
                <div class="profile" style="display: flex, width=100%">
                    <form method="post" action="<?PHP echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
                        <br>
                        <h3>Username: <input type="text" name="username" style="width: 40%;" value="<?php  echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : "";?>"></h3>
                        <h3>Password: &nbsp;<input type="password" name="password" style="width: 40%;"></h3>
                        <span class="error"><?php echo $Err;?></span>
                        <button type="submit" style="background-color: white; color: black;">Login</button>
                        <br>
                    </form>
                    <a href="register.php">Don't have an account?</a>
                </div>
            </center>
        </div>
    </body>
</html>