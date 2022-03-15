$(document).ready(function () {
    let arr, element, clas;
    element = document.getElementById("user-menu");
    clas = "open";
    arr = element.className.split(" ");
    if (arr.indexOf(clas) === -1) {
        element.className += " " + clas;
    }
    document.title = "TF | Dashboard";
});
