<?php
include "includes/db.php";
session_start();
if (isset($_SESSION["userID"]) and $_SESSION["userID"]!=0 and isset($_GET["delete"]) and $_GET["delete"] == "true" and isset($_SESSION["userID"]) and $_SESSION["userID"] != 0) {
    $query = "delete from tbl_213_user where user_id=" . $_SESSION["userID"];
    $result = mysqli_query($connection, $query);
    session_unset();
    session_destroy();
} elseif (isset($_GET["state"]) and $_GET["state"] == "logout") {
    session_unset();
    session_destroy();
}
if(!empty($_POST["userEmail"])) { // true if form was submitted
    $query  = "SELECT * FROM tbl_213_user WHERE user_email='"
        . $_POST["userEmail"]
        . "'";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);
    if (isset($_GET["state"]) && $_GET["state"] == "signup") {
        echo 'signup';
        if (is_array($row)) {
            $message = "Email is already in use!";  // ****** just replay email
        } else {
            echo 'else';
            $query =   "INSERT INTO tbl_213_user (user_name, user_email, user_pass, user_picture) 
                            VALUES ('" . $_POST["userName"] . "','" . $_POST["userEmail"] . "','" . $_POST["userPassword"] . "','" . $_POST["userPicture"] . "')";
            $result = mysqli_query($connection, $query);
            $userid = $connection->insert_id;
            $query = "INSERT INTO tbl_213_home (user_id, home_name, home_permission) 
                            VALUES ('" .  $userid . "','" . $_POST["userHome"] . "','Owner')";
            $result = mysqli_query($connection, $query);
            header('Location: ./login.php');
        }
    } else {
        if (is_array($row)) {
            if ($row["user_pass"] == $_POST["userPassword"]) {
                if (session_status() != PHP_SESSION_ACTIVE)
                    session_start();
                $_SESSION["userID"] = $row["user_id"];
                $_SESSION["userName"] = $row["user_name"];
                $_SESSION["userEmail"] = $row["user_email"];
                $_SESSION["userPicture"] = $row["user_picture"];
                $query  = "SELECT * FROM tbl_213_home WHERE user_id='"
                    . $_SESSION["userID"]
                    . "' AND home_permission='Owner' LIMIT 1";
                $result = mysqli_query($connection, $query);
                $row = mysqli_fetch_array($result);
                $_SESSION["homeID"] = $row["home_id"];
                $_SESSION["homePermission"] = $row["home_permission"];
                $_SESSION["homeName"] = $row["home_name"];
                header('Location: ./index.php');
            } else {
                $message = "Incorrect Password!";
            }
        } else {
            $message = "Incorrect Email!";
        }
    }
}
?>
<!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <meta charset="UTF-8">
    <title>Smarter Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <!-- Font - Montserrat -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <!-- Local Includes -->
    <script src="js/scripts.js"></script>
    <link rel="icon" type="image/png" href="favicon.ico">
    <link rel="stylesheet" href="css/style.css">
</head>

<body id="loginPage" class="bg-img">
    <header>
        <a id="logo" href="#"></a>
    </header>
    <main>
        <div class="content">
            <h1>
                <?php
                if (isset($_GET["state"]) and $_GET["state"] == "signup")
                    echo 'Signup Form';
                else
                    echo 'Login Form';
                ?>
            </h1>
            <form action="#" method="post">
                <?php
                if (isset($_GET["state"]) and $_GET["state"] == "signup") {
                    echo '
                            <div class="field">
                  		        <span class="fa fa-user"></span>
                 	            <input name="userName" type="text" required placeholder="Full Name"
                                 value="' . (isset($_POST["userName"]) ? $_POST["userName"] : "") . '">
             		        </div>';
                }
                ?>
                <div class="field space">
                    <span class="fa fa-user"></span>
                    <input name="userEmail" spaceholder="Email Address" type="text" required placeholder="Email" value="<?php if (isset($_POST['userEmail'])) echo $_POST['userEmail']; ?>">
                </div>
                <?php
                if (isset($_GET["state"]) and $_GET["state"] == "signup" and isset($message))
                    echo '<div class="signup">' . $message . '
                </div>';
                ?>
                <div class="field space">
                    <span class="fa fa-lock"></span>
                    <input name="userPassword" type="password" class="pass-key" required placeholder="Password" value="<?php if (isset($_POST['userPassword'])) echo $_POST['userPassword']; ?>">
                    <span class="show">SHOW</span>
                </div>
                <?php
                if (!isset($_GET["state"]) or $_GET["state"] != "signup")
                    echo (isset($message) ?  '<div class="alert alert-danger space" role="alert">
                    ' . $message . '
                  </div>' : "")
                        . '<div class="pass">
                        <a href="#">Forgot Password?</a>
                    </div>';
                ?>
                <?php
                if (isset($_GET["state"]) and $_GET["state"] == "signup") {
                    echo '
                 			    <div class="field space">
                      		        <span class="fas fa-home"></span>
                     		        <input name="userHome" type="text" required placeholder="Home Name"
                                     value="' . (isset($_POST["userHome"]) ? $_POST["userHome"] : "") . '">
                   				</div>';
                }
                if (isset($_GET["state"]) and $_GET["state"] == "signup") {
                    echo '
                 			    <div class="field space">
                      		        <span class="fas fa-portrait"></span>
                     		        <input name="userPicture" type="url" required placeholder="Profile Picture"
                                     value="' . (isset($_POST["userPicture"]) ? $_POST["userPicture"] : "") . '">
                   				</div>';
                }
                ?>
                <div class="field space">
                    <input type="submit" value="<?php
                                                if (isset($_GET["state"]) and $_GET["state"] == 'signup') {
                                                    echo 'SIGN UP';
                                                } else {
                                                    echo 'LOGIN';
                                                } ?> ">
                </div>
            </form>
            <?php
            if (isset($_GET["state"]) and $_GET["state"] == "signup")
                echo '<div class="signup">Already have an account?
                        <a href="login.php">Login Now</a>
                    </div>';
            else
                echo '<div class="signup">Dont have account?
                        <a href="login.php?state=signup">Signup Now</a>
                    </div>';
            ?>
        </div>
    </main>

</body>

</html>
<?php
include "includes/disconnect.php";
?>