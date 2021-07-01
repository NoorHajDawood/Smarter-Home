<?php
session_start();
if (!isset($_SESSION["userID"]) || $_SESSION["userID"] == 0)
    header("Location: login.php");
include "includes/db.php";
if (isset($_POST["userEmail"])) {
    $query  = "SELECT * FROM tbl_213_user WHERE user_email='"
        . $_POST["userEmail"]
        . "'";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);
    if (is_array($row) && $row["user_email"] != $_SESSION["userEmail"]) {
        $message = "Email is already in use!";
    } else {
        $query =   "UPDATE tbl_213_user SET ";
        if (!empty($_POST["userName"]))
            $query = $query . "user_name='" . $_POST["userName"] . "', ";
        if (!empty($_POST["userEmail"]))
            $query = $query . "user_email='" . $_POST["userEmail"] . "', ";
        if (!empty($_POST["userPassword"]))
            $query = $query . "user_pass='" . $_POST["userPassword"] . "', ";
        if (!empty($_POST["userPicture"]))
            $query = $query . "user_picture='" . $_POST["userPicture"] . "'";
        $query = $query . " where user_id=" . $_SESSION["userID"];
        $result = mysqli_query($connection, $query);
        if ($result) {
            if (!empty($_POST["userName"]))
                $_SESSION["userName"] = $_POST["userName"];
            if (!empty($_POST["userEmail"]))
                $_SESSION["userEmail"] = $_POST["userEmail"];
            if (!empty($_POST["userPicture"]))
                $_SESSION["userPicture"] = $_POST["userPicture"];
        } else {
            $message = "Something has went wrong";
        }
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
                    <li><a class="profile member" href="memberList.php">Members</a></li>
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
                    <li class="breadcrumb-item active" aria-current="page">Profile</li>
                </ol>
            </nav>
            <h1>My Profile</h1>
            <main id="profileMain">
                <div class="row gutters-sm">
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-column align-items-center text-center">
                                    <img src="<?php echo $_SESSION["userPicture"]; ?>" alt="Admin" class="rounded-circle">
                                    <div class="mt-3">
                                        <h4><?php echo $_SESSION["userName"] ?></h4>
                                        <!-- <p class="text-secondary mb-1"><?php echo $homeName; ?></p>
                                        <p class="text-muted font-size-sm">Bay Area, San Francisco, CA</p>
                                        <button class="btn btn-primary">Follow</button>
                                        <button class="btn btn-outline-primary">Message</button> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    if (isset($message))
                        echo  '<div class="alert alert-danger space" role="alert">' . $message . '</div>';
                    ?>
                    <div class="col-md-8">
                        <div class="card mb-3">
                            <div class="card-body">
                                <form action="#" method="post">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Full Name</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary shown">
                                            <?php
                                            $query  = "SELECT * FROM tbl_213_user WHERE user_id=" . $_SESSION["userID"];
                                            $result = mysqli_query($connection, $query);
                                            $row = mysqli_fetch_assoc($result);
                                            echo $row["user_name"];
                                            ?>
                                        </div>
                                        <div class="col-sm-9 text-secondary hide">
                                            <?php echo '<input class="" name="userName" type="text" required placeholder="Full Name"
                                                value="' . $row["user_name"] . '">'; ?>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Email</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary shown">
                                            <?php
                                            echo $row["user_email"];
                                            ?>
                                        </div>
                                        <div class="col-sm-9 text-secondary hide">
                                            <?php echo '<input class="hide" name="userEmail" type="text" required placeholder="Email Address"
                                                value="' . $row["user_email"] . '">'; ?>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="hide">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Password</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <?php echo '<input name="userPassword" type="password" class="pass-key" placeholder="Password" value="">'; ?>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Picture</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary shown">
                                            <?php
                                            echo $row["user_picture"];
                                            ?>
                                        </div>
                                        <div class="col-sm-9 text-secondary hide">
                                            <?php echo '<input class="hide" name="userPicture" type="text" required placeholder="Email Address"
                                                value="' . $row["user_picture"] . '">'; ?>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row hide">
                                        <div class="col-sm-12">
                                            <a type="button" class="btn btn-secondary" href="profile.php">Cancel</a>
                                            <input type="submit" value="Edit" class="btn btn-success"></input>
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-danger float-end" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                                Delete Account
                                            </button>
                                            <!-- Modal -->
                                            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Deactivate Account</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to delete your account?
                                                            <br>
                                                            This proccess is unreversable!
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button id="deleteAccount" type="button" class="btn btn-danger">Delete</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="row shown">
                                    <div class="col-sm-12">
                                        <button id="profileEdit" class="btn btn-info ">Edit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row gutters-sm">
                            <div class="col-sm-6 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h6 class="d-flex align-items-center mb-3">Home List</h6>
                                        <ul>
                                            <?php
                                            mysqli_free_result($result);
                                            $query = "SELECT * FROM tbl_213_home WHERE home_id = " . $_SESSION["homeID"];
                                            $result = mysqli_query($connection, $query);
                                            $row = mysqli_fetch_assoc($result);
                                            ?>
                                            <li><a class="profile myhome homeList" href="index.php?homeID=" <?php echo $_SESSION["homeID"]; ?>> <?php echo $homeName = $row["home_name"]; ?></a></li>
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
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h6 class="d-flex align-items-center mb-3">Room List</h6>
                                        <ul>
                                            <?php
                                            $query = "SELECT device_location from tbl_213_device  WHERE home_id = " . $_SESSION["homeID"] . " AND device_location!=''   group by device_location order by device_location";
                                            $result = mysqli_query($connection, $query);
                                            if (!$result) {
                                                die("failed:(");
                                            }
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo '<li><a class="profile roomsButton homeList" href="devicesList.php?room=' . $row["device_location"] . '">' . $row["device_location"] . '</a></li>';
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
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