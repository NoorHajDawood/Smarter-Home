<?php
session_start();
if (!isset($_SESSION["userID"]) || $_SESSION["userID"] == 0)
    header("Location: login.php");
include "includes/db.php";
if (isset($_GET["status"])) {
    $query1 = "SELECT user_id from tbl_213_user where user_email='" . $_POST["memberEmail"] . "'";
    $result1 =   mysqli_query($connection, $query1);
    $row = mysqli_fetch_assoc($result1);
    if ($_GET["status"] == "add") {
        $query =   "INSERT INTO tbl_213_home (home_id, user_id, home_name, home_permission) 
            VALUES (" .   $_SESSION["homeID"] . "," . $row["user_id"] . ",'" . strtok($_SESSION["userName"], " ") . "s Home" . "','" . $_POST["memberPermission"] . "')";
        mysqli_query($connection, $query);
    } else if ($_GET["status"] == "edit") {
        $query = "UPDATE tbl_213_home SET home_permission='" . $_POST["memberPermission"] . "' 
                     where user_id=" . $row["user_id"] . " and home_id=" .   $_SESSION["homeID"];
        mysqli_query($connection, $query);
    }
}
?>
<!DOCTYPE html>
<html>

<head>
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
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="favicon.ico">
</head>

<body>
    <header>
        <nav id="navBurger">
            <div id="menuToggle">
                <input id="burgerInput" type="checkbox" />
                <span></span>
                <span></span>
                <span></span>
                <ul id="menuBurger" class="menu">
                    <li> <a href="profile.php"> <i class="avatar">.</i> <?php echo $_SESSION["userName"]; ?> </a></li>
                    <li>
                        <button class="btn btn-primary dropdown-parent home" type="button" data-bs-toggle="collapse" data-bs-target="#homes" aria-expanded="false" aria-controls="homes">
                            My Homes</button>
                        <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="collapse" data-bs-target="#homes" aria-expanded="false" aria-controls="homes"></button>
                        <div class="collapse" id="homes">
                            <ul>
                                <?php
                                $query = "SELECT * FROM tbl_213_home WHERE home_id = " . $_SESSION["homeID"];
                                $result = mysqli_query($connection, $query);
                                $row = mysqli_fetch_assoc($result);
                                ?>
                                <li><a class="profile myhome homeList" href="index.php?homeID=" <?php echo $_SESSION["homeID"]; ?>> <?php echo $_SESSION["homeName"]; ?></a></li>
                                <?php
                                mysqli_free_result($result);
                                $query = "SELECT * FROM tbl_213_home WHERE user_id = " . $_SESSION["userID"] . " and home_id != " . $_SESSION["homeID"];
                                $result = mysqli_query($connection, $query);
                                if (!is_bool($result)) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo '<li><a class="profile myhome homeList" href="index.php?homeID=' .  $row["home_id"] . '">' . $row["home_name"] . '</a></li>';
                                    }
                                }
                                mysqli_free_result($result);
                                ?>
                                <li><a class="profile addplace homeList" href="#">Add place</a></li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <hr>
                    </li>
                    <li><a class="profile roomsButton" href="roomsList.php">Rooms</a></li>
                    <li><a class="profile devicesButton" href="devicesList.php">Devices</a></li>
                    <li><a class="profile automationButton" href="#">Automations</a></li>
                    <li><a class="profile member" href="#">Members</a></li>
                    <li>
                        <hr>
                    </li>
                    <li><a class="profile history" href="#">History</a></li>
                    <li><a class="profile setting" href="#"></a></li>
                    <li><a class="profile help" href="#">help</a></li>
                    <li>
                        <h6>Noor & Bader &copy;</h6>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="container-fluid"></div>
        <a id="logo" href="index.php"></a>
        <div id="burgerBlur" class="screenBlur"></div>
        <div class="btn-group">
            <button type="button" class="btn btn-secondary  dropdown-toggle dropdown-toggle-split headerIcon noti" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="visually-hidden">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">You have no notifications</a></li>
            </ul>
            <button type="button" class="btn btn-secondary  dropdown-toggle dropdown-toggle-split headerIcon search" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="visually-hidden">Toggle Dropdown</span>
            </button>
            <input type="text" name="search" placeholder="Search..." class="dropdown-menu">
            <button type="button" class="btn btn-secondary  dropdown-toggle dropdown-toggle-split headerIcon avatar" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="visually-hidden">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="profile.php">My Profile</a></li>
                <li><a class="dropdown-item" href="#">Security</a></li>
                <li><a class="dropdown-item" href="#">Settings</a></li>
                <li><a class="dropdown-item" href="login.php?state=logout">Log Out</a></li>
            </ul>
        </div>
    </header>
    <div class="content">
        <div id="wrapper">
            <nav id="breadNav" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Rooms</li>
                </ol>
            </nav>
            <h1>Members</h1>
            <?php
            if ($_SESSION["homePermission"] == "Admin" || $_SESSION["homePermission"] == "Owner")
                echo '<button type="button" id="collapsibleTools" class="functionalButton toolsBtn"></button>';
            ?>
            <ul id="toolsContent">
                <li></li>
                <li> <button id="editButton" type="button" class="functionalButton edit"></button></li>
                <li> <button id="deleteButton" type="button" class="functionalButton trash "></button></li>
                <li> <button id="addButton" type="button" class="functionalButton plusBtn "></button></li>
            </ul>
            <div id="toolsBlur" class="screenBlur"></div>
            <main id="memberMain">
                <section class="listContaier">
                    <br>
                    <div class="rowContainer listItems" home-id="<?php echo $_SESSION["homeID"]; ?>">
                        <?php
                        $query = "SELECT * FROM tbl_213_user as user inner join tbl_213_home as home on user.user_id = home.user_id where home_id=" . $_SESSION["homeID"];
                        $result = mysqli_query($connection, $query);
                        if (!$result) {
                            die("failed:(");
                        }
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo ' <div class="rectangle btnClickable listItem" member-email="' . $row["user_email"] . '" member-permission="' . $row["home_permission"] . '">';
                            if ($row["home_permission"] != "Owner") {
                                echo '<button class="functional functional functionalButton trash" value="' . $row["user_id"] . '"></button>';
                                echo '<button class="functional functional functionalButton edit" value="' . $row["user_id"] . '"></button>';
                            }
                            echo '<img class="member-picture" src="' . $row["user_picture"] . '"> 
                             <h5>' . $row["user_name"] . '</h5>
                             <div>
                                 <span>Permission: ' . $row["home_permission"] . '</span>';
                            echo '</div>
                             
                             </div>
                             ';
                        }
                        ?>
                    </div>
                </section>
                <div id="formBlur" class="screenBlur"></div>
                <form id="addMember" class="formBox" action="#" method="POST">
                    <h2 id="formTitle">Add Member</h2>
                    <h6>Member Email:</h6>
                    <input name="memberEmail" class="form-control" required type="text" placeholder="Member Email">
                    <h6>Permission:</h6>
                    <select name="memberPermission" class="form-select" required aria-label="Default select example">
                        <option disabled>Select a Permission</option>
                        <option value="Admin">Admin</option>
                        <option value="Normal">Normal</option>
                        <option value="Guest">Guest</option>
                    </select>
                    <div class="submite-cancel">
                        <button type="button" class="btn btn-dark cancelForm">Cancel</button>
                        <div class="vertical-line-1"></div>
                        <input type="submit" value="Add" class="btn btn-success"></input>
                    </div>
                </form>
            </main>
        </div>
    </div>
    <footer>
        <nav>
            <ul>
                <li><a class="homeButton-gray" href="index.php"><span>Home</span></a></li>
                <li><a class="roomsButton-gray" href="roomsList.php"><span>Rooms</span></a></li>
                <li><a class="devicesButton-gray" href="devicesList.php"><span>Devices</span></a></li>
                <li><a class="automationButton-gray" href="#"><span>Automation</span></a></li>
            </ul>
        </nav>
    </footer>
    <span id="profilePicture" class="visually-hidden"><?php echo $_SESSION["userPicture"]; ?></span>
</body>

</html>
<?php
mysqli_free_result($result);
include "includes/disconnect.php";
?>