/*Shy Navbar*/
    /* When the user scrolls down, hide the navbar. When the user scrolls up, show the navbar */
    var prevScrollpos = window.pageYOffset;
    window.onscroll = function () {
    var currentScrollPos = window.pageYOffset;
    if (prevScrollpos > currentScrollPos) {
    document.getElementById("navbar").style.top = "0";
    document.getElementById("social-bar").style.left = "1rem";
} else {
    document.getElementById("navbar").style.top = "-75px";
    document.getElementById("social-bar").style.left = "-160px";

    }
    prevScrollpos = currentScrollPos;
}
