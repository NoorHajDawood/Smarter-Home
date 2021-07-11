<?php
session_start();
if (!isset($_SESSION["userID"]) || $_SESSION["userID"] == 0)
    header("Location: login.php");
include "includes/db.php";
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
                    <li class="breadcrumb-item active" aria-current="page">Rooms</li>
                </ol>
            </nav>
            <h1>Rooms</h1>
            <!-- <button type="button" id="collapsibleTools" class="functionalButton toolsBtn"></button> -->
            <ul id="toolsContent">
                <li></li>
                <li> <button id="roomsEdit" type="button" class="functionalButton edit"></button></li>
                <li> <button id="roomsDelete" type="button" class="functionalButton trash "></button></li>
                <li> <button id="roomsAdd" type="button" class="functionalButton plusBtn "></button></li>
            </ul>
            <div id="toolsBlur" class="screenBlur"></div>
            <main id="rooms">
                <section class="listContaier">
                    <br>
                    <!-- <span>Sort: </span>
                        <select id="previewSelector" class="form-select selector d-inline" aria-label="Default select example">
                            <option value="0" selected disabled>Sort by</option>
                            <option value="Alphabet">Alphabet</option>
                            <option value="Power Consumption">Power Consumption</option>
                        </select> -->
                    <!-- //////////////////////////////////////////////////////// -->
                    <div class="rowContainer listItems">
                        <?php
                        $query = "SELECT device_location , count(*) as sum_devices from tbl_213_device  WHERE home_id = " . $_SESSION["homeID"] . " AND device_location!='' ";
                        $query = $query . " and (device_permission=";
                                if ($_SESSION["homePermission"] == "Owner" || $_SESSION["homePermission"] == "Admin")
                                    $query = $query . "'Admin' OR device_permission='Normal' OR device_permission='Guest')";
                                else if ($_SESSION["homePermission"] == "Normal")
                                    $query = $query . "'Normal' OR device_permission='Guest')";
                                else if ($_SESSION["homePermission"] == "Guest")
                                    $query = $query . "'Guest') ";   
                        $query = $query . " group by device_location order by device_location";
                        $query2 = "SELECT device_location , count(*) as sum_active from tbl_213_device  WHERE home_id = " . $_SESSION["homeID"] . " AND device_location!='' AND device_status=1 ";
                        $query2 = $query2 . " and (device_permission=";
                                if ($_SESSION["homePermission"] == "Owner" || $_SESSION["homePermission"] == "Admin")
                                    $query2 = $query2 . "'Admin' OR device_permission='Normal' OR device_permission='Guest')";
                                else if ($_SESSION["homePermission"] == "Normal")
                                    $query2 = $query2 . "'Normal' OR device_permission='Guest')";
                                else if ($_SESSION["homePermission"] == "Guest")
                                    $query2 = $query2 . "'Guest') ";   
                        $query2 = $query2 . " group by device_location  order by device_location";
                        $result = mysqli_query($connection, $query);
                        $result2 = mysqli_query($connection, $query2);
                        if (!$result) {
                            die("failed:(");
                        }
                        if (mysqli_num_rows($result2) == 0) {
                            $row2["device_location"] = "";
                            $row2["sum_active"] = 0;
                        } else
                            $row2 = mysqli_fetch_assoc($result2);
                        while ($row = mysqli_fetch_assoc($result)) {
                            // $row2 = mysqli_fetch_assoc($result2);
                            echo ' <a class="rectangle btnClickable listItem" href="devicesList.php?room=' . $row["device_location"] . '">
                             <span class="room-bg"></span>
                             <h5>' . $row["device_location"] . '</h5>
                             <div>
                                 <span>' . $row["sum_devices"] . ' Devices</span>';

                            if ($row2["device_location"] == $row["device_location"]) {
                                echo '<span>' . $row2["sum_active"] . ' Active </span>';
                                $row2 = mysqli_fetch_assoc($result2);
                                if (!$row2)
                                    $row2["device_location"] = "";
                            }
                            else {
                                echo '<span> 0 Active </span>';
                            }
                            echo '</div>
                             
                             </a>
                             ';
                        }
                        ?>
                    </div>
                </section>
            </main>
        </div>
    </div>
    <footer>
        <nav>
            <ul>
                <li><a class="homeButton-gray" href="index.php"><span>Home</span></a></li>
                <li class="selected"><a class="roomsButton" href="roomsList.php"><span>Rooms</span></a></li>
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