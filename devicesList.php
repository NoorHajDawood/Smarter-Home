<?php
include "includes/db.php";
session_start();
$query = "SELECT * FROM tbl_213_device" . (isset($_GET["room"]) ? " where device_location='" . $_GET["room"] . "'" : "");
$result = mysqli_query($connection, $query);
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
                    <li><a class="profile avatar" href="#">Micheal Rand</a></li>
                    <li>
                        <button class="btn btn-primary dropdown-parent home" type="button" data-bs-toggle="collapse" data-bs-target="#homes" aria-expanded="false" aria-controls="homes">
                            My Homes</button>
                        <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="collapse" data-bs-target="#homes" aria-expanded="false" aria-controls="homes"></button>

                        <div class="collapse" id="homes">
                            <ul>
                                <li><a class="profile myhome homeList" href="index.html?homeID=1">My Home</a></li>
                                <li><a class="profile addplace homeList" href="#">Add place</a></li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <hr>
                    </li>
                    <li><a class="profile roomsButton" href="roomsList.html">Rooms</a></li>
                    <li><a class="profile devicesButton" href="devicesList.html?roomID=0">Devices</a></li>
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
        <a id="logo" href="index.html"></a>
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
                <li><a class="dropdown-item" href="#">My Profile</a></li>
                <li><a class="dropdown-item" href="#">Security</a></li>
                <li><a class="dropdown-item" href="#">Settings</a></li>
            </ul>
        </div>
    </header>
    <div class="content">
        <div id="wrapper">
            <nav id="breadNav" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active"><a href="roomsList.html">Rooms</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Living Room</li>
                </ol>
            </nav>
            <h1><?php echo (isset($_GET["room"]) ? $_GET["room"] : "Device List"); ?></h1>
            <!-- <button id="tools" class="functional functionalButton toolsBtn"></button> -->
            <button type="button" id="collapsibleTools" class="functionalButton toolsBtn"></button>
            <ul id="toolsContent">
                <li></li>
                <li> <button id="deviceEdit" type="button" class="functionalButton edit"></button></li>
                <li> <button id="deviceDelete" type="button" class="functionalButton trash "></button></li>
                <li> <button id="deviceAdd" type="button" class="functionalButton plusBtn "></button></li>
            </ul>
            <div id="toolsBlur" class="screenBlur"></div>
            <button class="functional functionalButton listBtn"></button>
            <main id="devicesList">
                <section class="listContaier">
                    <span>Sort: </span>
                    <select id="previewSelector" class="form-select selector d-inline" aria-label="Default select example">
                        <option value="power">Power Consumption</option>
                        <option value="count" selected>Frequently Used</option>
                        <option value="name">Favorite</option>
                    </select>
                    <div class="rowContainer listItems">
                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<a class="rectangle btnClickable listItem" href="object.php?deviceID=' . $row["device_id"] . '">
                                <label class="switch">
                                    <input type="checkbox" value="' . $row["device_id"] . '">
                                    <span class="slider round"></span>
                                </label>
                                <button class="functional functional functionalButton star star-'.($row["device_fav"]==1?"full":"empty").'"></button>';
                            switch ($row["device_type"]) {
                                case 1:
                                    echo '<span class="tv-bg"></span>
                                            <h5>' . $row["device_name"] . '</h5>
                                            <div>
                                                <span class="remote-md">Yes Action</span>
                                                <div class="functional position-relative volume">
                                                    <span class="speakers-md"></span>
                                                    <input type="range" class="functional">
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
                                            <span class="temp-md">22 ℃</span>
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
                                            <span class="time-md">Off - 99%</span>
                                            <span class="battery-md">Battery 0%</span>
                                        </div>';
                                    break;
                                case 4:
                                    echo '<span class="lights-upside-bg"></span>';
                                    echo '<h5>' . $row["device_name"] . '</h5>
                                        <div>
                                            <input type="range" class="functional" disabled>
                                        </div>';
                                    break;
                                case 5:
                                    echo '<span class="speakers-bg"></span>';
                                    echo '<h5>' . $row["device_name"] . '</h5>
                                        <div>
                                            <input type="range" class="functional" disabled>
                                        </div>';
                                    break;
                            }
                            echo '</a>';
                        }
                        ?>
                        <!-- <a class="rectangle btnClickable listItem" href="object.html?objID=2">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider round"></span>
                            </label>
                            <span class="tv-bg"></span>
                            <h5>TV</h5>
                            <div>

                                <span class="remote-md">Yes Action</span>
                                <div class="functional position-relative volume">
                                    <span class="speakers-md"></span>
                                    <input type="range" class="functional">
                                </div>

                            </div>

                            <button class="functional functional functionalButton star star-full"></button>
                            <div class="sideButtons">
                                <button class="functional functional functionalButton nextVertical"></button>
                                <button class="functional functional functionalButton previousVertical"></button>
                            </div>
                        </a>
                        <a class="rectangle btnClickable listItem" href="object.html?objID=3">
                            <span class="ac-bg"></span>
                            <h5>AC</h5>
                            <div>
                                <span class="temp-md">22 ℃</span>
                                <div class="ac-buttons">
                                    <button class="functional ac-night"></button>
                                    <button class="functional ac-clock"></button>
                                    <button class="functional ac-hot"></button>
                                    <button class="functional ac-cold"></button>
                                    <button class="functional ac-water"></button>
                                    <button class="functional ac-cycle"></button>
                                </div>
                            </div>
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider round"></span>
                            </label>
                            <button class="functional functional functionalButton star star-empty"></button>
                            <div class="sideButtons">
                                <button class="functional functional functionalButton plusBtn"></button>
                                <button class="functional functional functionalButton minusBtn"></button>
                            </div>
                        </a>
                        <a class="rectangle btnClickable listItem" href="object.html?objID=1">
                            <span class="vac-bg"></span>
                            <h5>iVacuum</h5>
                            <div class="tighter">
                                <span class="time-md">Off - 99%</span>
                                <span class="battery-md">Battery 0%</span>
                            </div>
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider round"></span>
                            </label>
                            <button class="functional functional functionalButton star star-full"></button>
                        </a>
                         <a class="rectangle btnClickable listItem" href="object.html?objID=5">
                            <span class="lights-upside-bg"></span>
                            <h5>Lights</h5>
                            <div>
                                <input type="range" class="functional" disabled>
                            </div>
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider round"></span>
                            </label>
                            <button class="functional functional functionalButton star star-empty"></button>
                        </a>
                        <a class="rectangle btnClickable listItem" href="object.html?objID=46">
                            <span class="speakers-bg"></span>
                            <h5>Speakers</h5>
                            <div>
                                <input type="range" class="functional" disabled>
                            </div>
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider round"></span>
                            </label>
                            <button class="functional functional functionalButton star star-empty"></button>
                        </a> -->
                    </div>
                </section>
                <div id="formBlur" class="screenBlur"></div>
                <form id="addDevice" class="formBox" action="./object.php?status=add" method="POST">
                    <h2>Add Device</h2>
                    <h6>Device Type:</h6>
                    <select name="deviceType" class="form-select" aria-label="Default select example">
                        <option value="" disabled selected>Type</option>

                        <option value="1">Television</option>
                        <option value="2">Air Conditioner</option>
                        <option value="3">Vacuum</option>
                        <option value="4">Lights</option>
                        <option value="5">Speakers</option>
                    </select>
                    <!-- <h6>Device Type:</h6> -->
                    <!-- <select name="deviceType" class="form-select" aria-label="Default select example">
                            <option value="" disabled selected>Device Type</option>

                            <option value="Admin">Light</option>
                            <option value="Guest">Smart Lock</option>
                            <option value="Normal">Speakers</option>
                            <option value="Normal">Vacuum</option> -->



                    </select>
                    <h6>Device Name:</h6>
                    <input name="deviceName" class="form-control" type="text" placeholder="Device Name">
                    <h6>Location:</h6>
                    <select name="deviceLocation" class="form-select" aria-label="Default select example">
                        <option value="" disabled selected>Location</option>

                        <option value="Living Room">Living Room</option>
                        <option value="Bedroom 1">Bedroom 1</option>
                        <option value="Bedroom 2">Bedroom 2</option>
                        <option value="Kitchen">Kitchen</option>
                        <option value="">None</option>

                    </select>
                    <h6>Power Consumption:</h6>
                    <input name="deviceConsumption" class="form-control" type="number" placeholder="Power Consumption">
                    <!-- <input id="status" type="hidden" name="status" value="add"> -->

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
                <li><a class="homeButton-gray" href="index.html"><span>Home</span></a></li>
                <li><a class="roomsButton-gray" href="roomsList.html"><span>Rooms</span></a></li>
                <li><a class="devicesButton-gray" href="devicesList.html?roomID=0"><span>Devices</span></a></li>
                <li><a class="automationButton-gray" href="#"><span>Automation</span></a></li>
            </ul>
        </nav>
    </footer>
</body>

</html>
<?php
mysqli_free_result($result);
include "includes/disconnect.php";
?>