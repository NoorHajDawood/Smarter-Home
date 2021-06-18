var burgerHidden = true;
function burgerToggle() {
    if (burgerHidden) {
        // $('#burgerBlur').css('opacity', '60%');
        $('#burgerBlur').css('display', 'block');
        burgerHidden = false;
    }
    else {
        // $('#burgerBlur').css('opacity', '0%');
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
    $('#addDevice').show();
    $('#addDevice').attr('action', './object.php?status=add');
    $('#formBlur').show();
}
function editDeviceButton() {
    $('#toolsBlur').click();
    $('.listItem .edit').show();
    // $('#toolsBlur').css('display', 'block');
    // $('#addDevice').show();
    // $(':input[name="deviceType"]').val();
    $('#formBlur').show();
}
function deleteDeviceButton() {
    $('#toolsBlur').click();
    $('.listItem .trash').show();
    // $('#toolsBlur').css('display', 'block');
    // $('#addDevice').show();
    // $(':input[name="deviceType"]').val();
    $('#formBlur').show();
}

function editDeviceForm() {
    $('#formTitle').html('Edit Device');
    $('#addDevice').attr('action', './object.php?deviceID=' + this.value + '&status=edit');
    $(':input[name=deviceType]').val($(this).parent().attr('device-type'));
    $(':input[name=deviceName]').val($(this).parent().attr('device-name'));
    $(':input[name=deviceLocation]').val($(this).parent().attr('device-location'));
    $(':input[name=deviceConsumption]').val($(this).parent().attr('device-power'));
    $(':input[type=submit]').val("Edit");

    $('#addDevice').show();
}

function deleteDeviceForm() {
    $('#formBlur').click();
    $(this).parent().remove();
    callAjax("deviceID=" + this.value + "&delete=true");

}

function updateDeviceFromJson() {
    $.getJSON("data/SmarterHome.json", function (data) {
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
        cache: true
    });
}

function updateDeviceStatusSlider() {
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
    $('.star').click(function () {
        var dataString = "deviceID=" + this.value + "&fav=";
        console.log(this.value);
        if ($(this).hasClass("star-full")) {
            $(this).removeClass("star-full");
            $(this).addClass("star-empty");
            $(this).parent().hide();
            dataString += "0";
        } else {
            dataString += "1";
            $(this).removeClass("star-empty");
            $(this).addClass("star-full");
        }
        console.log(dataString);
        callAjax(dataString);
    });
}

function getDeviceID() {

    var aKeyValue = window.location.search.substring(1).split('&'), deviceID = aKeyValue[0].split("=")[1];

    return deviceID;




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

        $('#deviceAdd').click(addDeviceForm);
        $('#deviceEdit').click(editDeviceButton);
        $('#deviceDelete').click(deleteDeviceButton);

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
        console.log(profilePicture);
        $('.avatar').each(function () {
            $(this).css('background-image', "url(" + profilePicture + ")");
            $(this).css('border-radius', "50%");
        });

        // $('.avatar').css('backgroundImage','profilePicture')
        // function getSelectValue() {
        //     var selectedValue = document.getElementById("previewSelector").value;
        //     alert(selectedValue);
        //     console.log(selectedValue);
        // }
        // getSelectValue();

        var selectedOP = document.getElementById("previewSelector");
        function show() {
            var as = this.value;
            var strUser = selectedOP.options[selectedOP.selectedIndex].value;
            window.location.replace(window.location.pathname + "?sort=" + as);
        }
        if (selectedOP)
            selectedOP.onchange = show;

        $('#devicePermission').change(function(){
            callAjax("deviceID=" + getDeviceID() + "&permission="+this.value);
        })

        updateDeviceFromJson();
        updateDeviceStatusSlider();
        updateDeviceFavorite();

        $('#profileEdit').click(function () {
            $('.hide').show();
            $('.shown').hide();
        });
        // $('#ajaxForm').submit(ajaxFormOverride());
    }

});



