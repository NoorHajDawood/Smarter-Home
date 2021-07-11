<?php
session_start();
if (!isset($_SESSION["userID"]) || $_SESSION["userID"] == 0)
    header("Location: login.php");
include "includes/db.php";
if (isset($_GET["status"])) {
    if ($_GET["status"] == "add") {
        $query =   "INSERT INTO tbl_213_device (device_type, device_name, device_location, power_consumption,home_id) 
            VALUES ('" . $_POST["deviceType"] . "','" . $_POST["deviceName"] . "','" . $_POST["deviceLocation"] . "','" . $_POST["deviceConsumption"] . "','" .  $_SESSION["homeID"] . "')";
        mysqli_query($connection, $query);
        $deviceID = $connection->insert_id;
    } else if ($_GET["status"] == "edit") {
        $query = "UPDATE tbl_213_device set device_type=" . $_POST["deviceType"] . ", device_name='" . $_POST["deviceName"] . "',
                             device_location='" . $_POST["deviceLocation"] . "', power_consumption=" . $_POST["deviceConsumption"] . " where device_id=" . $_GET["deviceID"];
        mysqli_query($connection, $query);
    }
}
if (!isset($deviceID)) {
    $deviceID = $_GET["deviceID"];
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
                                $query = "SELECT * FROM tbl_213_device where home_id = " . $_SESSION["homeID"] . " and device_id='" . $deviceID . "'";
                                $query = $query . " and (device_permission=";
                                if ($_SESSION["homePermission"] == "Owner" || $_SESSION["homePermission"] == "Admin")
                                    $query = $query . "'Admin' OR device_permission='Normal' OR device_permission='Guest')";
                                else if ($_SESSION["homePermission"] == "Normal")
                                    $query = $query . "'Normal' OR device_permission='Guest')";
                                else if ($_SESSION["homePermission"] == "Guest")
                                    $query = $query . "'Guest')";
                                $result = mysqli_query($connection, $query);
                                $row = mysqli_fetch_array($result);
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
                    <li class="breadcrumb-item active"><a href="devicesList.php<?php echo (isset($_GET["room"]) ? "?room=" . $_GET["room"] : ""); ?>"><?php echo (isset($_GET["room"]) ? $_GET["room"] : "Devices"); ?></a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo $row["device_name"]; ?></li>
                </ol>
            </nav>
            <h1><?php echo $row["device_name"]; ?></h1>
            <main id="objectMain">
                <section class="panel infoSection position-relative">
                    <span id="device-status">Status: <?php echo ($row["device_status"] ? "On" : "Off"); ?></span>
                    <label class="switch">
                        <input class="slider-checkbox" type="checkbox" value=<?php echo '"' . $row["device_id"] . '" ' . ($row["device_status"] ? 'checked' : '') ?>>
                        <span class="slider round"></span>
                    </label>
                    <button <?php echo 'class="functional functionalButton star star-' . ($row["device_fav"] == 1 ? "full" : "empty") . '" value="' . $row["device_id"] . '"' ?>></button>
                    <br>
                    <?php
                    switch ($row["device_type"]) {
                        case 1:
                            echo '<div class="sideButtons">
                            <button class="functional functionalButton nextVertical"></button>
                            <button class="functional functionalButton previousVertical"></button>
                        </div>
                                <ul class="objectControls">
                                    <li class="icons remote-bg tv-channel">Channel: Yes Action <input type="number" placeholder="#"></li>
                            <li class="icons volume-bg tv-volume">Volume: <input type="range"  device-id="' . $row["device_id"] . '" ' . ($row["device_status"] ? '' : 'disabled') . '></li>';
                            break;
                        case 2:
                            echo '  
                            <div class="sideButtons">
                            <button class="functional functional functionalButton plusBtn"></button>
                            <button class="functional functional functionalButton minusBtn"></button>
                        </div>
                            <ul class="objectControls">
                            <li class="icons ">
                            <div class="ac-buttons">
                            <button class="functional ac-night"></button>
                            <button class="functional ac-clock"></button>
                            <button class="functional ac-hot"></button>
                            <button class="functional ac-cold"></button>
                            <button class="functional ac-water"></button>
                            <button class="functional ac-cycle"></button>
                        </div>
                            
                            </li>
                            <li class="icons temp-bg ac-temp">AC-Temp: 22 ℃</li>';
                            break;
                        case 3:
                            echo ' <ul class="objectControls">
                                        <li class="vac-progress">Cleaned: </li>
                                        <li class="battery vac-battery"> Battery:  </li>
                                        <li class="cont vac-container"> Container:  </li>
                                        ';
                            break;
                        case 4:
                            echo ' <ul class="objectControls">
                                <li "><span>&#128161; Light:</span> <input class="light-brightness" type="range"  device-id="' . $row["device_id"] . '" ' . ($row["device_status"] ? '' : 'disabled') . '></li>';
                            break;
                        case 5:
                            echo '<ul class="objectControls"> 
                            <li class="media">
                                <iframe src="https://open.spotify.com/embed/album/2iER5YPSsq4WpokLnnQGCO" width="340"
                                    height="170" frameborder="0" allowtransparency="true" allow="encrypted-media"></iframe>
                            </li>
                                <li class="icons volume-bg">Volume: <input class="speaker-volume" type="range"  device-id="' . $row["device_id"] . '" ' . ($row["device_status"] ? '' : 'disabled') . '></li>';
                            break;
                    }
                    if ($row["device_location"] != "")
                        echo '<li class="location"> Location: ' . $row["device_location"] . '</li>
                    </ul>';
                    ?>
                </section>
                <section class="panel autosection">
                    <h4>Automation</h4>
                    <button class="functional functionalButton edit"></button>
                    <button class="functional functionalButton plusBtn"></button>
                    <div class="clear"></div>
                    <?php
                    if ($row["device_type"] == 3) {
                            echo '<div class="position-relative">
                                    <button class="btn btn-primary dropdown-parent clearToggle" type="button" data-bs-toggle="collapse" data-bs-target="#automation1" aria-expanded="false" aria-controls="automation1">
                                        Quick clean</button>
                                    <button type="button" class="btn btn-secondary dropdown-toggle clearToggle" data-bs-toggle="collapse" data-bs-target="#automation1" aria-expanded="false" aria-controls="automation1"></button>
                                    <div class="collapse" id="automation1">
                                        <div class="checkboxList">';
                            $query = "SELECT device_location FROM tbl_213_device WHERE home_id = " . $_SESSION["homeID"] . " and device_location !='' and device_location is not NULL GROUP BY device_location";
                            $resultRooms = mysqli_query($connection, $query);
                            $counter = 0;
                            while ($rowRooms = mysqli_fetch_assoc($resultRooms)) {
                                echo    '<div class="form-check">
                                                <input type="checkbox" class="form-check-input" value="volunteering" id="location' . ++$counter . '">
                                                <label for="location' . $counter . '" class="form-check-label">' . $rowRooms["device_location"] . '.</label>
                                            </div>';
                            }
                            mysqli_free_result($resultRooms);
                            echo
                            '</div>
                                    </div>
                                    <label class="switch">
                                        <input type="checkbox" >
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <hr class="small-hr">';
                    }
                    ?>
                    <div class="position-relative">
                        <button class="btn btn-primary dropdown-parent clearToggle" type="button" data-bs-toggle="collapse" data-bs-target="#automation2" aria-expanded="false" aria-controls="automation2">
                            My schedule</button>
                        <button type="button" class="btn btn-secondary dropdown-toggle clearToggle" data-bs-toggle="collapse" data-bs-target="#automation2" aria-expanded="false" aria-controls="automation2"></button>
                        <label class="switch">
                            <input type="checkbox">
                            <span class="slider round"></span>
                        </label>
                        <div class="collapse" id="automation2">
                            <div class="checkboxList">
                                <div class="row mb-4">
                                    <div class="row">
                                        <button class="buttonautomation buttonweek">S</button>
                                        <button class="buttonautomation buttonweek">M</button>
                                        <button class="buttonautomation buttonweek">T</button>
                                        <button class="buttonautomation buttonweek">W</button>
                                        <button class="buttonautomation buttonweek">T</button>
                                        <button class="buttonautomation buttonweek">F</button>
                                        <button class="buttonautomation buttonweek">S</button>
                                    </div>
                                    <div class="form-group row">
                                        <label for="example-time-input" class="col-2 col-form-label">Time:</label>
                                        <div class="col-5">
                                            <input class="form-control" type="time" value="13:45:00" id="example-time-input">
                                        </div>
                                    </div>
                                </div>
                                <?php
                                switch ($row["device_type"]) {
                                    case 1:
                                        echo '
                                        <ul class="objectControls">
                                        <li class="icons remote-bg">Channel: Netflix <input type="number" placeholder="#"></li>
                                        <li class="icons volume-bg">Volume: <input type="range"></li>
                                        </ul>
                                     
                                            ';
                                        break;
                                    case 2:
                                        echo '  
                                  
                                        <ul class="objectControls">
                                        <li class="icons ">
                                        <div class="ac-buttons">
                                        <button class="functional ac-night"></button>
                                        <button class="functional ac-clock"></button>
                                        <button class="functional ac-hot"></button>
                                        <button class="functional ac-cold"></button>
                                        <button class="functional ac-water"></button>
                                        <button class="functional ac-cycle"></button>
                                    </div>
                                        
                                        </li>
                                        <li class="icons temp-bg">AC-Temp: <input type="number"></li>
                                        </ul>
                                     
                                 ';
                                        break;
                                    case 3:
                                        $query = "SELECT device_location FROM tbl_213_device WHERE home_id = " . $_SESSION["homeID"] . " and device_location !='' and device_location is not NULL GROUP BY device_location";
                                        $resultRooms = mysqli_query($connection, $query);
                                        while ($rowRooms = mysqli_fetch_assoc($resultRooms)) {
                                            echo    '<div class="form-check">
                                                <input type="checkbox" class="form-check-input" value="volunteering" id="location' . ++$counter . '">
                                                <label for="location' . $counter . '" class="form-check-label">' . $rowRooms["device_location"] . '.</label>
                                            </div>';
                                        }
                                        mysqli_free_result($resultRooms);
                                        break;
                                    case 4:
                                        echo ' <ul class="objectControls">
                                         <li"><span>&#128161; Light:</span> <input type="range"></li>';
                                        break;
                                    case 5:
                                        echo '
                                        <div class="media">
                                        <iframe src="https://open.spotify.com/embed/album/2iER5YPSsq4WpokLnnQGCO" width="320"
                                            height="170" frameborder="0" allowtransparency="true" allow="encrypted-media"></iframe>
                                         </div>
                                        
                                        ';
                                        break;
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </section>
                <?php
                if ($_SESSION["homePermission"] == "Admin" || $_SESSION["homePermission"] == "Owner")
                    echo '
                    <section class="panel Permission">
    
    
                        <h4>Permission:</h4>
                        <select id="devicePermission" class="form-select" aria-label="Default select example">
                            <option disabled>Select a Permission</option>
                            <option ' . ($row["device_permission"] == "Admin" ? "selected" : "") . ' value="Admin">Admin</option>
                            <option ' . ($row["device_permission"] == "Normal" ? "selected" : "") . ' value="Normal">Normal</option>
                            <option ' . ($row["device_permission"] == "Guest" ? "selected" : "") . ' value="Guest">Guest</option>
                        </select>
                    </section>';
                ?>

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