<?php
session_start();
include "includes/db.php";
if (isset($_POST['status'])) {
    $query = "update tbl_213_device set device_status = " . $_POST['status'] . " " . (isset($_POST["usage"]) ? ", device_usage=device_usage+1 " : "") . " where device_id = " . $_POST['deviceID'];
    $result = mysqli_query($connection, $query);
} else if (isset($_POST['fav']) && $_POST['fav']!=2) {
    $query = "update tbl_213_device set device_fav = " . $_POST['fav'] . " where device_id=" . $_POST['deviceID'];
    $result = mysqli_query($connection, $query);
} else if (isset($_POST['delete'])) {
    if (isset($_POST['deviceID']))
        $query = "delete from tbl_213_device where device_id=" . $_POST['deviceID'];
    else if (isset($_POST['memberID']))
        $query = "delete from tbl_213_home where user_id=" . $_POST['memberID'] . " and home_id=" . $_POST['homeID'];
    $result = mysqli_query($connection, $query);
} else if (isset($_POST['permission'])) {
    $query = "update tbl_213_device set device_permission='" . $_POST['permission'] . "' where device_id=" . $_POST['deviceID'];
    $result = mysqli_query($connection, $query);
}
//
if (isset($_POST['fav'])) {
    $query = "SELECT * FROM tbl_213_device  where device_fav = 1 and home_id = " . $_SESSION["homeID"];
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
                <section class="sectionContainer" id="favoriteSection">
                    <h3>Favorites</h3>
                    <div id="favorite" class="carousel carousel-dark slide" data-bs-ride="carousel" data-bs-interval="false">
                        <div class="carousel-indicators" id="favorite-indicator">
                            <button type="button" data-bs-target="#favorite" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>';
        $counter = 0;
        $i = 1;
        while ($row) {
            ++$counter;
            if ($counter % 3 == 1 && $counter != 1) {
                echo '<button type="button" data-bs-target="#favorite" data-bs-slide-to="' . $i . '" aria-label="Slide ' . ++$i . '"></button>';
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
                                        <button class="functional functional functionalButton star star-full" value="' . $row["device_id"] . '"></button> ';
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
                                        <button class="functional functional functionalButton star star-full" value="' . $row["device_id"] . '"></button>';
                        break;
                    case 3:
                        echo ' <span class="vac-bg"></span>
                                            <h5>' . $row["device_name"] . '</h5>
                                            <div>
                                                <span class="time-sm vac-progress"></span>
                                                <span class="battery-md vac-battery"> Battery:  </span>
                                            </div>
                                            <label class="switch">
                                                <input class="slider-checkbox" type="checkbox" value="' . $row["device_id"] . '" ' . ($row["device_status"] ? 'checked' : '') . '>
                                                <span class="slider round"></span>
                                            </label>
                                            <button class="functional functional functionalButton star star-full" value="' . $row["device_id"] . '"></button>';
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
                                        <button class="functional functional functionalButton star star-full" value="' . $row["device_id"] . '"></button>';
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
                                        <button class="functional functional functionalButton star star-full" value="' . $row["device_id"] . '"></button>';
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
}
//
include "includes/disconnect.php";
