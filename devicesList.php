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
                                $query = "SELECT * FROM tbl_213_device where home_id = " . $_SESSION["homeID"] . (isset($_GET["room"]) ? " and device_location='" . $_GET["room"] . "'" : "");
                                $query = $query . " and (device_permission=";
                                if ($_SESSION["homePermission"] == "Owner" || $_SESSION["homePermission"] == "Admin")
                                    $query = $query . "'Admin' OR device_permission='Normal' OR device_permission='Guest')";
                                else if ($_SESSION["homePermission"] == "Normal")
                                    $query = $query . "'Normal' OR device_permission='Guest')";
                                else if ($_SESSION["homePermission"] == "Guest")
                                    $query = $query . "'Guest')";
                                if (isset($_GET["sort"])) {
                                    if ($_GET["sort"] == "Favorite")
                                        $query = $query . " order by device_fav desc";
                                    else if ($_GET["sort"] == "Power Consumption")
                                        $query = $query . " order by power_consumption desc";
                                    else if ($_GET["sort"] == "Frequently Used")
                                        $query = $query . " order by device_usage desc";
                                }
                                $result = mysqli_query($connection, $query);
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
                    <li class="breadcrumb-item active"><a href="roomsList.php">Rooms</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo (isset($_GET["room"]) ? $_GET["room"] : "Devices"); ?></li>
                </ol>
            </nav>
            <h1><?php echo (isset($_GET["room"]) ? $_GET["room"] : "Device List"); ?></h1>
            <!-- <button id="tools" class="functional functionalButton toolsBtn"></button> -->
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
            <!-- <button class="functional functionalButton listBtn"></button> -->
            <main id="devicesList">
                <section class="listContaier">
                    <span>Sort: </span>
                    <select id="previewSelector" class="form-select selector d-inline" aria-label="Default select example">
                        <option value="0" <?php if (!isset($_GET["sort"])) echo 'selected'; ?> disabled>Sort by</option>
                        <option value="All Devices" <?php if (isset($_GET["sort"]) && $_GET["sort"] == "All Devices") echo 'selected'; ?>>All Devices</option>
                        <option value="Favorite" <?php if (isset($_GET["sort"]) && $_GET["sort"] == "Favorite") echo 'selected'; ?>>Favorite</option>
                        <option value="Power Consumption" <?php if (isset($_GET["sort"]) && $_GET["sort"] == "Power Consumption") echo 'selected'; ?>>Power Consumption</option>
                        <option value="Frequently Used" <?php if (isset($_GET["sort"]) && $_GET["sort"] == "Frequently Used") echo 'selected'; ?>>Frequently Used</option>
                    </select>
                    <div class="rowContainer listItems">
                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<a class="rectangle btnClickable listItem" href="object.php?deviceID=' . $row["device_id"] . (isset($_GET["room"]) ? "&room=" . $_GET["room"] : "") . '"
                                     device-type="' . $row["device_type"] . '" device-location="' . $row["device_location"] . '" device-power="' . $row["power_consumption"] . '" 
                                      device-name="' . $row["device_name"] . '" >
                                <label class="switch">
                                    <input class="slider-checkbox" type="checkbox" value="' . $row["device_id"] . '" ' . ($row["device_status"] ? 'checked' : '') . '>
                                    <span class="slider round"></span>
                                </label>
                                <button class="functional functional functionalButton star star-' . ($row["device_fav"] == 1 ? "full" : "empty") . '" value="' . $row["device_id"] . '"></button>';
                            echo '<button class="functional functional functionalButton trash" value="' . $row["device_id"] . '"></button>';
                            echo '<button class="functional functional functionalButton edit" value="' . $row["device_id"] . '"></button>';
                            switch ($row["device_type"]) {
                                case 1:
                                    echo '<span class="tv-bg"></span>
                                            <h5>' . $row["device_name"] . '</h5>
                                            <div>
                                                <span class="remote-md tv-channel">Yes Action</span>
                                                <div class="functional position-relative volume">
                                                    <span class="speakers-md"></span>
                                                    <input type="range" class="functional tv-volume" device-id="' . $row["device_id"] . '" ' . ($row["device_status"] ? '' : 'disabled') . '>
                                                </div>
                                            </div>
                                            
                                            <div class="sideButtons">
                                                <button class="functional functional functionalButton nextVertical"></button>
                                                <button class="functional functional functionalButton previousVertical"></button>
                                            </div>';
                                    break;
                                case 2:
                                    echo '<span class="ac-bg"></span>';
                                    echo '<h5>' . $row["device_name"] . '</h5>
                                        <div>
                                            <span class="temp-md ac-temp">22 ℃</span>
                                            <div class="ac-buttons">
                                                <button class="functional ac-night"></button>
                                                <button class="functional ac-clock"></button>
                                                <button class="functional ac-hot"></button>
                                                <button class="functional ac-cold"></button>
                                                <button class="functional ac-water"></button>
                                                <button class="functional ac-cycle"></button>
                                            </div>
                                        </div>
                                        <div class="sideButtons">
                                            <button class="functional functional functionalButton plusBtn"></button>
                                            <button class="functional functional functionalButton minusBtn"></button>
                                        </div>';
                                    break;
                                case 3:
                                    echo '<span class="vac-bg"></span>
                                        <h5>' . $row["device_name"] . '</h5>
                                        <div class="tighter">
                                            <span class="time-md vac-progress">Off - 99%</span>
                                            <span class="battery-md vac-battery">Battery 0%</span>
                                        </div>';
                                    break;
                                case 4:
                                    echo '<span class="lights-upside-bg"></span>';
                                    echo '<h5>' . $row["device_name"] . '</h5>
                                        <div>
                                            <input type="range" class="functional light-brightness" device-id="' . $row["device_id"] . '" ' . ($row["device_status"] ? '' : 'disabled') . '>
                                        </div>';
                                    break;
                                case 5:
                                    echo '<span class="speakers-bg"></span>';
                                    echo '<h5>' . $row["device_name"] . '</h5>
                                        <div>
                                            <input type="range" class="functional speaker-volume" device-id="' . $row["device_id"] . '" ' . ($row["device_status"] ? '' : 'disabled') . '>
                                        </div>';
                                    break;
                            }
                            echo '</a>';
                        }
                        ?>
                    </div>
                </section>
                <div id="formBlur" class="screenBlur"></div>
                <form id="addDevice" class="formBox" action="./object.php?status=add" method="POST">
                    <h2 id="formTitle">Add Device</h2>
                    <h6>Device Type:</h6>
                    <select id="deviceType" name="deviceType" class="form-select" aria-label="Default select example" required>
                        <option value="" disabled selected>Type</option>
                        <option id="deviceType1" value="1">Television</option>
                        <option id="deviceType2" value="2">Air Conditioner</option>
                        <option id="deviceType3" value="3">Vacuum</option>
                        <option id="deviceType4" value="4">Lights</option>
                        <option id="deviceType5" value="5">Speakers</option>
                    </select>
                    </select>
                    <h6>Device Name:</h6>
                    <input name="deviceName" class="form-control" type="text" placeholder="Device Name">
                    <h6>Location:</h6>
                    <select id="roomSelect" name="deviceLocation" class="form-select" aria-label="Default select example" required>
                        <option value="" disabled selected>Location</option>
                        <?php
                        $query = "SELECT device_location from tbl_213_device  WHERE home_id = " . $_SESSION["homeID"] . " AND device_location!=''   group by device_location order by device_location";
                        $result = mysqli_query($connection, $query);
                        while ($row = mysqli_fetch_assoc($result)) {

                            echo '<option value="' . $row["device_location"] . '">' . $row["device_location"] . '</option>';
                        }

                        ?>
                        <option value="">None</option>
                    </select>
                    <h6>Or New Location:</h6>
                    <div class="row">
                        <input id="newRoomInput" type="text" class="form-control col"> <button id="newRoomButton" class="btn btn-light col">Add to List</button>
                    </div>
                    <h6>Power Consumption:</h6>
                    <input name="deviceConsumption" class="form-control" type="number" placeholder="Power Consumption" required>
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
                <li <?php if (!isset($_GET["room"])) echo 'class="selected"'; ?>><a class="devicesButton<?php if (isset($_GET["room"])) echo '-gray'; ?>" href="devicesList.php"><span>Devices</span></a></li>
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