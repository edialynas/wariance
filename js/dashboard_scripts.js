
// ================== Global Dashboard Variables ================
// var httpConn = new XMLHttpRequest(); // klish me http kai pairnei ena xml
// httpConn.open("GET","php/start_session.php",false);
// httpConn.send(null);

var httpConn = new XMLHttpRequest();
httpConn.open("GET","php/welcome_user.php",false);
httpConn.send(null);
var username = httpConn.responseText;


// ==============================================================
window.onload = function dispUser() {
    document.getElementById("username").innerHTML = username;
}
// window.onload = dispUser;

// ======================= Scrollup Button ======================
// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("myScrollUpBtn").style.display = "block";
    } else {
        document.getElementById("myScrollUpBtn").style.display = "none";
    }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}
// ==============================================================