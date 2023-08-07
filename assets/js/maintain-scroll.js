// cited from https://stackoverflow.com/questions/29203312/how-can-i-retain-the-scroll-position-of-a-scrollable-area-when-pressing-back-but
$(document).ready(function () {
    var pathName = document.location.pathname;
    window.onbeforeunload = function () {
        var scrollPosition = $(document).scrollTop();
        sessionStorage.setItem("scrollPosition" + pathName, scrollPosition.toString());
    }
    if (sessionStorage["scrollPosition" + pathName]) {
        $(document).scrollTop(sessionStorage.getItem("scrollPosition" + pathName));
    }
});