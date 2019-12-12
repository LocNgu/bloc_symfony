window.onscroll = scrollFunction;
document.getElementById("to-top").onclick = toTop;

function scrollFunction() {
    if (document.body.scrollTop > 500 || document.documentElement.scrollTop > 500) {
        document.getElementById("to-top").style.display = "block";
    } else {
        document.getElementById("to-top").style.display = "none";
    }
}

function toTop() {
    document.body.scrollTop = 0; // For Safari
    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera

}
