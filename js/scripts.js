var burgerHidden = true;
function burgerToggle() {
    if (burgerHidden) {
        $('#burgerBlur').css('display', 'block');
        burgerHidden = false;
    }
    else {
        $('#burgerBlur').css('display', 'none');
        burgerHidden = true;
    }
}
function functionlPropagation() {
    var array = $('.functional');
    for (var elemnt of array) {
        elemnt.onclick = function (e) {
            e.stopPropagation();
            e.preventDefault();
        };
    }
}
function mediaCamera() {
    if (this.value == "cameras") {
        $('#cameraSection').removeClass('d-none');
        $('#mediaSection').addClass('d-none');
    }
    else {
        $('#mediaSection').removeClass('d-none');
        $('#cameraSection').addClass('d-none');
    }
}
function Arrow() {
    var array = $('.dropdown-toggle:not(.headerIcon)');
    for (var elemnt of array) {
        elemnt.onclick = function () {
            if (this.style.transform == 'rotate(180deg)')
                this.style.transform = 'none';
            else
                this.style.transform = 'rotate(180deg)';
        };
    }
    array = $('.dropdown-parent');
    for (var elemnt of array) {
        elemnt.onclick = function () {
            var child = this.nextElementSibling;
            if (child.style.transform == 'rotate(180deg)')
                child.style.transform = 'none';
            else
                child.style.transform = 'rotate(180deg)';
        };
    }
}
function toolsClick() {
    var content = this.nextElementSibling;
    if (content.style.maxHeight) {
        content.style.border = "none";
        content.style.maxHeight = null;
        $('#toolsBlur').css('display', 'none');
    } else {
        content.style.border = "solid 2px";
        content.style.borderTop = "none";
        content.style.maxHeight = content.scrollHeight + "px";
        $('#toolsBlur').css('display', 'block');
    }
}
function addDeviceForm() {
    $('#toolsBlur').click();
    $(':input[name="memberEmail"]').prop('disabled', false);;
    $('.formBox').show();
    $('#addDevice').attr('action', './object.php?status=add');
    $('#addMember').attr('action', './memberList.php?status=add');

    if (getPageName(window.location.pathname).toUpperCase() == 'devicesList'.toUpperCase())
        $('#formTitle').html('Add Device');
    else
        $('#formTitle').html('Add Member');
    $(':input[name=memberEmail]').val('');
    $(':input[name=memberPermission]').val('Admin');
    selectElement = document.getElementById('deviceType');
    if (selectElement)
        selectElement.getElementsByTagName('option')[0].selected = 'selected';
    $(':input[name=deviceName]').val('');
    selectElement = document.getElementById('roomSelect');
    if (selectElement)
        selectElement.getElementsByTagName('option')[0].selected = 'selected';
    $(':input[name=deviceConsumption]').val('');
    $(':input[type=submit]').val("Add");
    $(':input[name="memberEmail"]').prop('disabled', false);
    // $('.formBox').show();

    $('#formBlur').show();
}
function editDeviceButton() {
    $('#toolsBlur').click();
    $('.listItem .edit').show();
    $('#formBlur').show();
}
function deleteDeviceButton() {
    $('#toolsBlur').click();
    $('.listItem .trash').show();
    $('#formBlur').show();
}
function editDeviceForm() {
    if (getPageName(window.location.pathname).toUpperCase() == 'devicesList'.toUpperCase())
        $('#formTitle').html('Edit Device');
    else
        $('#formTitle').html('Edit Member');
    $('#addDevice').attr('action', './object.php?deviceID=' + this.value + '&status=edit');
    $('#addMember').attr('action', './memberList.php?memberID=' + this.value + '&status=edit');
    $(':input[name=memberEmail]').val($(this).parent().attr('member-email'));
    $(':input[name=memberPermission]').val($(this).parent().attr('member-permission'));
    $(':input[name=deviceType]').val($(this).parent().attr('device-type'));
    $(':input[name=deviceName]').val($(this).parent().attr('device-name'));
    $(':input[name=deviceLocation]').val($(this).parent().attr('device-location'));
    $(':input[name=deviceConsumption]').val($(this).parent().attr('device-power'));
    $(':input[type=submit]').val("Edit");
    $(':input[name="memberEmail"]').prop('disabled', true);
    $('.formBox').show();
}
function getPageName(url) {
    var index = url.lastIndexOf("/") + 1;
    var filenameWithExtension = url.substr(index);
    var filename = filenameWithExtension.split(".")[0];
    return filename;
}
function deleteDeviceForm() {
    var page = getPageName(window.location.pathname);
    $('#formBlur').click();
    if (page.toUpperCase() == "devicesList".toUpperCase()) {
        callAjax("deviceID=" + this.value + "&delete=true");
    }
    else if (page.toUpperCase() == "memberList".toUpperCase()) {
        callAjax("memberID=" + this.value + "&homeID=" + $('.listItems').attr('home-id') + "&delete=true");
    }
    $(this).parent().remove();
}
function updateDeviceFromJson(flag) {
    $.getJSON("data/SmarterHome.json", function (data) {
        if (getPageName(window.location.pathname).toUpperCase() == "index".toUpperCase() && flag) {
            $('#spotify').attr('src', data.media);
            for(var i = 1; i < data.cameras.length; i++) {
                $('#camera-indicator').append('<button type="button" data-bs-target="#cameraSection" data-bs-slide-to="'+i+'" aria-label="Slide '+(i+1)+'"></button>');
            }
            for(var i = 0; i < data.cameras.length; i++) {
                $('#camera-inner').append('<div class="carousel-item '+(i==0?'active':'')+'"> <img src="'+data.cameras[i].img+'" class="d-block w-100" alt="Camera'+(i+1)+'" title="Camera'+(i+1)+'"> </div>');
            }
        }
        $.each(data.devices, function () {
            switch (this.type) {
                case 1:
                    $('.tv-channel').html(this.params[0].value);
                    $('.tv-volume').attr('value', this.params[1].value);
                    break;
                case 2:
                    $('.ac-temp').html(this.params[0].value + " &#8451");
                    break;
                case 3:
                    $('.vac-battery').html("Battery: " + this.params[0].value + "%");
                    $('.vac-container').html("Container: " + this.params[1].value + "%");
                    $('.vac-progress').html("Cleaned: " + this.params[2].value + "%");
                    break;
                case 4:
                    $('.light-brightness').attr('value', this.params[0].value);
                    break;
                case 5:
                    $('.speaker-volume').attr('value', this.params[0].value);
                    break;
            }
        });
    });
}
function callAjax(dataString) {
    $.ajax({
        type: "POST",
        url: "action.php",
        data: dataString,
        cache: true,
        success: function (html) {
            if (dataString.includes("fav")) {
                $('#favoriteAjax').html(html);
                functionlPropagation();
                updateDeviceFromJson(false);
                updateDeviceStatusSlider();
                updateDeviceFavorite();
            }
        }
    });
}
function updateDeviceStatusSlider() {
    $('.slider-checkbox').unbind('change');
    $('.slider-checkbox').change(function () {
        var dataString = "deviceID=" + this.value + "&status=";
        $('.slider-checkbox:input[value="' + this.value + '"]').not(this).prop('checked', this.checked);
        $(':input[device-id="' + this.value + '"]').not(this).prop('disabled', !this.checked);
        if (this.checked) {
            dataString += "1";
            $('#device-status').html("Status: On");
            dataString += "&usage=plus"
        } else {
            dataString += "0";
            $('#device-status').html("Status: Off");
        }
        callAjax(dataString);
    });
}
function updateDeviceFavorite() {
    $('.star').unbind('click');
    $('.star').click(function () {
        stars = $('.star[value="' + this.value + '"]');
        var dataString = "deviceID=" + this.value + "&fav=";
        if ($(this).hasClass("star-full")) {
            stars.removeClass("star-full");
            stars.addClass("star-empty");
            if (getPageName(window.location.pathname).toUpperCase() == "index".toUpperCase()) {
                if ($(this).parents('#favoriteSection').length)
                    $(this).parent().remove();
                else
                    $('a[href$="deviceID=' + this.value + '"').not($(this).parent()).remove();
            }
            dataString += "0";
        } else {
            dataString += "1";
            $(this).removeClass("star-empty");
            $(this).addClass("star-full");
        }
        callAjax(dataString);
    });
}
function getDeviceID() {
    var aKeyValue = window.location.search.substring(1).split('&'), deviceID = aKeyValue[0].split("=")[1];
    return deviceID;

}
function sortSelect() {
    var as = this.value;
    window.location.replace(window.location.pathname + "?sort=" + as);
}
$(document).ready(function () {
    if ($('body').attr('id') == "loginPage") {
        const pass_field = document.querySelector(".pass-key");
        const showBtn = document.querySelector(".show");
        showBtn.addEventListener("click", function () {
            if (pass_field.type === "password") {
                pass_field.type = "text";
                showBtn.textContent = "HIDE";
                showBtn.style.color = "#3498db";
            } else {
                pass_field.type = "password";
                showBtn.textContent = "SHOW";
                showBtn.style.color = "#222";
            }
        });
    }
    else {
        if ($('body').attr('id') == "indexPage") {
            callAjax("fav=2");
        }
        $('#burgerInput').click(burgerToggle);
        $('#previewSelector').change(mediaCamera);
        functionlPropagation();
        $('#burgerBlur').click(function () {
            $('#burgerInput').click();
        });
        Arrow();
        var tools = document.getElementById("collapsibleTools");
        $('#collapsibleTools').click(toolsClick);
        $('#toolsBlur').click(function () {
            tools.click();
        });
        $('#addButton').click(addDeviceForm);
        $('#editButton').click(editDeviceButton);
        $('#deleteButton').click(deleteDeviceButton);
        $('.listItem .edit').click(editDeviceForm);
        $('.listItem .trash').click(deleteDeviceForm);
        $('#formBlur').click(function () {
            $('#formBlur').hide();
            $('.formBox').each(function () {
                $(this).hide();
            });
            $('.listItem .edit').hide();
            $('.listItem .trash').hide();
        });
        $('.cancelForm').each(function () {
            $(this).click(function () {
                $('#formBlur').click();
            });
        });
        profilePicture = $('#profilePicture').text();
        $('.avatar').each(function () {
            $(this).css('background-image', "url(" + profilePicture + ")");
            $(this).css('border-radius', "50%");
        });
        if (getPageName(window.location.pathname).toUpperCase() != "index".toUpperCase()) {
            var selectedOP = document.getElementById("previewSelector");
            if (selectedOP)
                selectedOP.onchange = sortSelect;
        }
        $('#devicePermission').change(function () {
            callAjax("deviceID=" + getDeviceID() + "&permission=" + this.value);
        })
        updateDeviceFromJson(true);
        updateDeviceStatusSlider();
        updateDeviceFavorite();
        $('#profileEdit').click(function () {
            $('.hide').show();
            $('.shown').hide();
        });
        $('#newRoomButton').click(function myFunction() {
            var x = document.getElementById("roomSelect");
            var option = document.createElement("option");
            option.text = $('#newRoomInput').val();
            x.add(option);
            $(option).prop('selected', true);
            return false;
        });
        $('#deleteAccount').click(function () {
            window.location.href = "login.php?delete=true";
        });
    }
});
