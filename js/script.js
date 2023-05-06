$(document).ready(function () {
    $('a.nav-link.dropdown-toggle').click(function() {
        location.href = this.href;
    });
});