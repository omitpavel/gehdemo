function openNav() {
    document.getElementById("mySidenav").style.width = "100%";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}

// Scroll To Top

$(window).scroll(function() {
    if ($(this).scrollTop() > 100) {
        $('#scroll-up').fadeIn();
    } else {
        $('#scroll-up').fadeOut();
    }
});
$('#scroll-up').click(function() {
    $('html, body').animate({
        scrollTop: 0
    }, 800);
    return false;
});


// Dynamically Space Managing - Marquee, Topbar and Side bar

if ((document.querySelector("#sidebar")) || (document.querySelector("#content"))) {
    if (document.getElementById("sidebar")) {
        // document.getElementById("content").style.width = "calc(100% - 100px)";
    } else {
        document.getElementById("content").style.width = "100%";
        document.getElementById("content").style.paddingLeft = "0"
    }
}

if ((document.querySelector("#marquee-content")) && (document.querySelector("#content")) &&
    (document.querySelector("#page-wrapper")) || (document.querySelector("#topbar"))) {
    if ((document.getElementById("marquee-content")) && (document.getElementById("topbar"))) {
        document.getElementById("page-wrapper").style.marginTop = "95px";
    } else {
        document.getElementById("page-wrapper").style.marginTop = "70px";
        document.getElementById("topbar").style.marginTop = "0px";

    }
}



if (document.getElementById("topbar")) {
    // document.getElementById("page-wrapper").style.marginTop = "105px";
} else {
    document.getElementById("page-wrapper").style.marginTop = "20px";

}

function pictureChange() {
    document.getElementById('theImage').src = "./images/opel_2.png";
}