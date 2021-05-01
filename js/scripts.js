var burgerHidden = true;
function burgerToggle() {
    if (burgerHidden) {
        $('#burgerBlur').css('opacity', '60%');
        $('#burgerBlur').css('display', 'block');
        burgerHidden = false;
    }
    else {
        $('#burgerBlur').css('opacity', '0%');
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
            var child = this.nextSibling;
            if (child.style.transform == 'rotate(180deg)')
                child.style.transform = 'none';
            else
                child.style.transform = 'rotate(180deg)';
        };
    }
}



$(document).ready(function () {
    $('#burgerInput').click(burgerToggle);
    $('#previewSelector').change(mediaCamera);
    functionlPropagation();
    $('#burgerBlur').click(function () {
        $('#burgerInput').click();
    });
    Arrow();

    // $('#tools').click(function(){
    //     var child = this.nextSibling;
    //     child.style.top = "35px";
    //     child.style.right = '25px';
    //     // $('#tools-menu').css('rig' ,'25px');
        
    // });
});



