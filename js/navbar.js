/*Shy Navbar*/
/* When the user scrolls down, hide the navbar. When the user scrolls up, show the navbar */
var prevScrollpos = window.pageYOffset;
const social_array = ["spotify", "youtube", "facebook", "instagram"];
window.onscroll = function () {
    let i;
    var currentScrollPos = window.pageYOffset;
    if (prevScrollpos <= currentScrollPos) {
        document.getElementById("navbar").style.top = "-75px";
        document.getElementById("social-bar").style.left = "-160px";
        /*for (x of social_array) {
            document.getElementById(x).style.left = "-160px";
            console.log(x);
        }*/

    } else {
        document.getElementById("navbar").style.top = "0";
        document.getElementById("social-bar").style.left = "1rem";

        /*for (x of social_array) {
            document.getElementById(x).style.left = "";
            console.log(x);
        }*/
    }
    prevScrollpos = currentScrollPos;
}
