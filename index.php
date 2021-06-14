<?php
    include "includes/db.php";
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Smarter Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf"
        crossorigin="anonymous"></script>
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
                        <button class="btn btn-primary dropdown-parent home" type="button" data-bs-toggle="collapse"
                            data-bs-target="#homes" aria-expanded="false" aria-controls="homes">
                            My Homes</button>
                            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="collapse"
                                data-bs-target="#homes" aria-expanded="false" aria-controls="homes"></button>
                        
                        <div class="collapse" id="homes">
                            <ul>
                                <li><a class="profile myhome homeList" href="index.html?homeID=1">My Home</a></li>
                                <li><a class="profile addplace homeList" href="#">Add place</a></li>
                            </ul>
                        </div>
                    </li>
                    <li><hr></li>
                    <li><a class="profile roomsButton" href="roomsList.html">Rooms</a></li>
                    <li><a class="profile devicesButton" href="devicesList.html?roomID=0">Devices</a></li>
                    <li><a class="profile automationButton" href="#">Automations</a></li>
                    <li><a class="profile member" href="#">Members</a></li>
                    <li><hr></li>
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
            <button type="button" class="btn btn-secondary  dropdown-toggle dropdown-toggle-split headerIcon noti"
                data-bs-toggle="dropdown" aria-expanded="false">
                <span class="visually-hidden">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">You have no notifications</a></li>
            </ul>
            <button type="button" class="btn btn-secondary  dropdown-toggle dropdown-toggle-split headerIcon search"
                data-bs-toggle="dropdown" aria-expanded="false">
                <span class="visually-hidden">Toggle Dropdown</span>
            </button>
            <input type="text" name="search" placeholder="Search..." class="dropdown-menu">

            <button type="button" class="btn btn-secondary  dropdown-toggle dropdown-toggle-split headerIcon avatar"
                data-bs-toggle="dropdown" aria-expanded="false">
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
            <nav id="breadNav"
                style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" aria-current="page"><a href="#">Home</a></li>
                </ol>
            </nav>
            <h1>My Home</h1>
            <main>
                <section class="sectionContainer" id="previewSection">
                    <select id="previewSelector" class="form-select selector" aria-label="Default select example">
                        <option value="cameras">Cameras</option>
                        <option value="media" selected>Media</option>
                    </select>
                    <div id="mediaSection" class="media">
                        <iframe src="https://open.spotify.com/embed/album/2iER5YPSsq4WpokLnnQGCO" width="340"
                            height="170" frameborder="0" allowtransparency="true" allow="encrypted-media"></iframe>
                    </div>
                    <div id="cameraSection" class="carousel carousel-dark slide d-none" data-bs-ride="carousel"
                        data-bs-interval="false">
                        <div class="carousel-indicators" id="camera-indicator">
                            <button type="button" data-bs-target="#cameraSection" data-bs-slide-to="0" class="active"
                                aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#cameraSection" data-bs-slide-to="1"
                                aria-label="Slide 2"></button>
                            <button type="button" data-bs-target="#cameraSection" data-bs-slide-to="2"
                                aria-label="Slide 3"></button>
                        </div>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="images/backyard.png" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="images/front_shop.png" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="images/backyard.png" class="d-block w-100" alt="...">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#cameraSection"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#cameraSection"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </section>
                <hr>
                <section class="sectionContainer" id="favoriteSection">
                    <h3>Favorites</h3>
                    <div id="favorite" class="carousel carousel-dark slide" data-bs-ride="carousel"
                        data-bs-interval="false">
                        <div class="carousel-indicators" id="favorite-indicator">
                            <button type="button" data-bs-target="#favorite" data-bs-slide-to="0" class="active"
                                aria-current="true" aria-label="Slide 1"></button>
                        </div>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="rowContainer">
                                    <a class="rectangle btnClickable shortcut" href="object.html?objID=1">
                                        <span class="vac-bg"></span>
                                        <h5>iVaccum</h5>
                                        <div>
                                            <span class="time-sm">Off</span>
                                            <span class="location-sm">Living Room</span>
                                        </div>
                                        <label class="switch">
                                            <input type="checkbox">
                                            <span class="slider round"></span>
                                        </label>
                                        <button class="functional functionalButton star star-full"></button>
                                    </a>
                                    <a class="rectangle btnClickable shortcut" href="object.html?objID=2">
                                        <span class="tv-bg"></span>
                                        <h5>TV</h5>
                                        <div>
                                            <span class="location-sm">Living Room</span>
                                            <div class="centered">
                                                <button class="functional functionalButton previousBtn"></button>
                                                <button class="functional functionalButton nextBtn"></button>
                                            </div>
                                        </div>
                                        <label class="switch">
                                            <input type="checkbox">
                                            <span class="slider round"></span>
                                        </label>
                                        <button class="functional functionalButton star star-full"></button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <hr>
                <div class="clear"></div>
                <section class="sectionContainer" id="frequentlySection">
                    <h3>Frequently Used</h3>
                    <div id="frequent" class="carousel carousel-dark slide" data-bs-ride="carousel"
                        data-bs-interval="false">
                        <div class="carousel-indicators" id="frequent-indicator">
                            <button type="button" data-bs-target="#frequent" data-bs-slide-to="0" class="active"
                                aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#frequent" data-bs-slide-to="1"
                                aria-label="Slide 2"></button>
                        </div>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="rowContainer">
                                    <a class="rectangle btnClickable shortcut" href="object.html?objID=1">
                                        <span class="vac-bg"></span>
                                        <h5>iVaccum</h5>
                                        <div>
                                            <span class="time-sm">Off</span>
                                            <span class="location-sm">Living Room</span>
                                        </div>
                                        <label class="switch">
                                            <input type="checkbox">
                                            <span class="slider round"></span>
                                        </label>
                                        <button class="functional functionalButton star star-full"></button>
                                    </a>
                                    <a class="rectangle btnClickable shortcut" href="object.html?objID=3">
                                        <span class="ac-bg"></span>
                                        <h5>AC</h5>

                                        <div>
                                            <span class="temp-sm">22 ℃</span>
                                            <span class="location-sm">Living Room</span>
                                        </div>
                                        <div class="sideButtons">
                                            <button class="functional functionalButton plusBtn"></button>
                                            <button class="functional functionalButton minusBtn"></button>
                                        </div>
                                        <label class="switch">
                                            <input type="checkbox">
                                            <span class="slider round"></span>
                                        </label>
                                        <button class="functional functionalButton star star-empty"></button>
                                    </a>
                                    <a class="rectangle btnClickable shortcut" href="object.html?objID=2">
                                        <span class="tv-bg"></span>
                                        <h5>TV</h5>
                                        <div>
                                            <span class="location-sm">Living Room</span>
                                            <div class="centered">
                                                <button class="functional functionalButton previousBtn"></button>
                                                <button class="functional functionalButton nextBtn"></button>
                                            </div>
                                        </div>
                                        <label class="switch">
                                            <input type="checkbox">
                                            <span class="slider round"></span>
                                        </label>
                                        <button class="functional functionalButton star star-full"></button>
                                    </a>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="rowContainer">
                                    <a class="rectangle btnClickable shortcut" href="object.html?objID=5">
                                        <span class="lights-upside-bg"></span>
                                        <h5>Lights</h5>
                                        <div>
                                            <input type="range" disabled>
                                        </div>
                                        <label class="switch">
                                            <input type="checkbox">
                                            <span class="slider round"></span>
                                        </label>
                                        <button class="functional functionalButton star star-empty"></button>
                                    </a>
                                    <a class="rectangle btnClickable shortcut" href="object.html?objID=4">
                                        <span class="speakers-bg"></span>
                                        <h5>Speakers</h5>
                                        <div>
                                            <input type="range" disabled>
                                        </div>
                                        <label class="switch">
                                            <input type="checkbox">
                                            <span class="slider round"></span>
                                        </label>
                                        <button class="functional functionalButton star star-empty"></button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <hr>
                <section class="sectionContainer" id="automationSection">
                    <h3>Automation</h3>
                    <div id="automation" class="carousel carousel-dark slide" data-bs-ride="carousel"
                        data-bs-interval="false">
                        <div class="carousel-indicators" id="camera-indicator">
                            <button type="button" data-bs-target="#automation" data-bs-slide-to="0" class="active"
                                aria-current="true" aria-label="Slide 1"></button>
                        </div>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="rowContainer">
                                    <a class="rectangle btnClickable shortcut" href="#">
                                        <span class="sun-bg"></span>
                                        <h5>Morning</h5>
                                        <div class="automationShortcut">
                                            <span>Schedule: Daily at 7:00am</span>
                                        </div>
                                        <button class="functional functionalButton star star-full"></button>
                                    </a>
                                    <a class="rectangle btnClickable shortcut" href="#">
                                        <span class="home-bg"></span>
                                        <h5>Home</h5>
                                        <div class="automationShortcut">
                                            <span>Schedule: on Arrival</span>
                                        </div>
                                        <button class="functional functionalButton star star-full"></button>
                                    </a>
                                    <a class="rectangle btnClickable shortcut" href="#">
                                        <span class="shield-bg"></span>
                                        <h5>Lock</h5>
                                        <div class="automationShortcut">
                                            <span>Schedule: on Leave</span>
                                        </div>
                                        <button class="functional functionalButton star star-full"></button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <div class="clear"></div>
            </main>
        </div>
    </div>
    <footer>
        <nav>
            <ul>
                <li class="selected"><a class="homeButton" href="index.html"><span>Home</span></a></li>
                <li><a class="roomsButton-gray" href="roomsList.html"><span>Rooms</span></a></li>
                <li><a class="devicesButton-gray" href="devicesList.html?roomID=0"><span>Devices</span></a></li>
                <li><a class="automationButton-gray" href="#"><span>Automation</span></a></li>
            </ul>
        </nav>
    </footer>
</body>

</html>
<?php
    include "includes/disconnect.php";
?>