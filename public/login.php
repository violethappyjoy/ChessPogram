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
                        <button type="submit" style="background-color: white; color: black;">Login</button>
                        <br>
                    </form>
                </div>
            </center>
        </div>
    </body>
</html>