<?php
session_start();
if (!isset($_SESSION["userID"]) || $_SESSION["userID"] == 0)
    header("Location: login.php");
include "includes/db.php";
if (isset($_GET["homeID"])) {
    $query  = "SELECT * FROM tbl_213_home WHERE user_id='"
        . $_SESSION["userID"]
        . "' AND home_id='" . $_GET["homeID"] . "'";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_array($result);
    if (is_array($row)) {
        $_SESSION["homeID"] = $row["home_id"];
        $_SESSION["homePermission"] = $row["home_permission"];
        $_SESSION["homeName"] = $row["home_name"];
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

<body id="indexPage">
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
                    <li class="breadcrumb-item" aria-current="page"><a href="#">Home</a></li>
                </ol>
            </nav>
            <h1><?php echo $_SESSION["homeName"]; ?></h1>
            <main>
                <section class="sectionContainer" id="previewSection">
                    <select id="previewSelector" class="form-select selector" aria-label="Default select example">
                        <option value="cameras">Cameras</option>
                        <option value="media" selected>Media</option>
                    </select>
                    <div id="mediaSection" class="media">
                        <iframe id="spotify" width="340" height="170" frameborder="0" allowtransparency="true" allow="encrypted-media"></iframe>
                    </div>
                    <div id="cameraSection" class="carousel carousel-dark slide d-none" data-bs-ride="carousel" data-bs-interval="false">
                        <div class="carousel-indicators" id="camera-indicator">
                            <button type="button" data-bs-target="#cameraSection" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        </div>
                        <div id="camera-inner" class="carousel-inner">
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#cameraSection" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#cameraSection" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </section>
                <div id="favoriteAjax"></div>
                <div class="clear"></div>
                <?php
                $query = "SELECT * FROM tbl_213_device where device_usage > 3 and home_id = " . $_SESSION["homeID"];
                $query = $query . " and (device_permission=";
                if ($_SESSION["homePermission"] == "Owner" || $_SESSION["homePermission"] == "Admin")
                    $query = $query . "'Admin' OR device_permission='Normal' OR device_permission='Guest')";
                else if ($_SESSION["homePermission"] == "Normal")
                    $query = $query . "'Normal' OR device_permission='Guest')";
                else if ($_SESSION["homePermission"] == "Guest")
                    $query = $query . "'Guest')";
                $result = mysqli_query($connection, $query);
                if (!is_bool($result) && $row = mysqli_fetch_assoc($result)) {
                    echo '
                    <hr>
                    <section class="sectionContainer" id="frequentlySection">
                        <h3>Frequently Used</h3>
                        <div id="frequent" class="carousel carousel-dark slide" data-bs-ride="carousel" data-bs-interval="false">
                            <div class="carousel-indicators" id="frequent-indicator">
                                <button type="button" data-bs-target="#frequent" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>';
                    $counter = 0;
                    $i = 1;
                    while ($row) {
                        ++$counter;
                        if ($counter % 3 == 1 && $counter != 1) {
                            echo '<button type="button" data-bs-target="#frequent" data-bs-slide-to="' . $i . '" aria-label="Slide ' . ++$i . '"></button>';
                        }
                        $row = mysqli_fetch_assoc($result);
                    }
                    echo '</div>
                            <div class="carousel-inner">';
                    mysqli_free_result($result);
                    $counter = 0;
                    $result = mysqli_query($connection, $query);
                    $row = mysqli_fetch_assoc($result);
                    while ($row) {
                        echo '<div class="carousel-item ' . ($counter == 0 ? 'active' : '') . '">
                                            <div class="rowContainer">';
                        while (++$counter % 4 != 0 && $row) {
                            echo '<a class="rectangle btnClickable shortcut" href="object.php?deviceID=' . $row["device_id"] . '" >'; //value="' . $row["device_type"] . '"
                            switch ($row["device_type"]) {
                                case 1:
                                    echo '<span class="tv-bg"></span>
                                        <h5>' . $row["device_name"] . '</h5>
                                        <div>
                                            <span class="location-sm">' . $row["device_location"] . '</span>
                                            <div class="centered">
                                                <button class="functional functionalButton previousBtn"></button>
                                                <button class="functional functionalButton nextBtn"></button>
                                            </div>
                                        </div>
                                        <label class="switch">
                                            <input class="slider-checkbox" type="checkbox" value="' . $row["device_id"] . '" ' . ($row["device_status"] ? 'checked' : '') . '>
                                            <span class="slider round"></span>
                                        </label>
                                        <button class="functional functional functionalButton star star-' . ($row["device_fav"] == 1 ? "full" : "empty") . '" value="' . $row["device_id"] . '"></button> ';
                                    break;
                                case 2:
                                    echo ' <span class="ac-bg"></span>';
                                    echo '<h5>' . $row["device_name"] . '</h5>
                                        <div>
                                            <span class="temp-sm ac-temp">22 ℃</span>
                                            <span class="location-sm">' . $row["device_location"] . '</span>
                                        </div>
                                        <div class="sideButtons">
                                            <button class="functional functionalButton plusBtn"></button>
                                            <button class="functional functionalButton minusBtn"></button>
                                        </div>
                                        <label class="switch">
                                            <input class="slider-checkbox" type="checkbox" value="' . $row["device_id"] . '" ' . ($row["device_status"] ? 'checked' : '') . '>
                                            <span class="slider round"></span>
                                        </label>
                                        <button class="functional functional functionalButton star star-' . ($row["device_fav"] == 1 ? "full" : "empty") . '" value="' . $row["device_id"] . '"></button>';
                                    break;
                                case 3:
                                    echo ' <span class="vac-bg"></span>
                                        <h5>' . $row["device_name"] . '</h5>
                                        <div>
                                            <span class="time-sm vac-progress">Off</span>
                                            <span class="battery-md vac-battery"> Battery:  </span>
                                        </div>
                                        <label class="switch">
                                            <input class="slider-checkbox" type="checkbox" value="' . $row["device_id"] . '" ' . ($row["device_status"] ? 'checked' : '') . '>
                                            <span class="slider round"></span>
                                        </label>
                                    <button class="functional functional functionalButton star star-' . ($row["device_fav"] == 1 ? "full" : "empty") . '" value="' . $row["device_id"] . '"></button>';
                                    break;
                                case 4:
                                    echo '  <span class="lights-upside-bg"></span>';
                                    echo '<h5>' . $row["device_name"] . '</h5>
                                        <div>
                                            <input type="range" class="light-brightness"  device-id="' . $row["device_id"] . '" ' . ($row["device_status"] ? '' : 'disabled') . '>
                                        </div>
                                        <label class="switch">
                                            <input class="slider-checkbox" type="checkbox" value="' . $row["device_id"] . '" ' . ($row["device_status"] ? 'checked' : '') . '>
                                            <span class="slider round"></span>
                                        </label>
                                        <button class="functional functional functionalButton star star-' . ($row["device_fav"] == 1 ? "full" : "empty") . '" value="' . $row["device_id"] . '"></button>';
                                    break;
                                case 5:
                                    echo '  <span class="speakers-bg"></span>';
                                    echo '<h5>' . $row["device_name"] . '</h5>
                                        <div>
                                            <input type="range" class="speaker-volume"  device-id="' . $row["device_id"] . '" ' . ($row["device_status"] ? '' : 'disabled') . '>
                                        </div>
                                        <label class="switch">
                                            <input class="slider-checkbox" type="checkbox" value="' . $row["device_id"] . '" ' . ($row["device_status"] ? 'checked' : '') . '>
                                            <span class="slider round"></span>
                                        </label>
                                        <button class="functional functional functionalButton star star-' . ($row["device_fav"] == 1 ? "full" : "empty") . '" value="' . $row["device_id"] . '"></button>';
                                    break;
                            }
                            echo '</a>';
                            $row = mysqli_fetch_assoc($result);
                        }
                        echo '  </div>
                             </div>';
                    }
                    echo '</div>
                        </div>
                    </section>';
                    mysqli_free_result($result);
                }
                ?>
                <div class="clear"></div>
            </main>
        </div>
    </div>
    <footer>
        <nav>
            <ul>
                <li class="selected"><a class="homeButton" href="index.php"><span>Home</span></a></li>
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
include "includes/disconnect.php";
?>