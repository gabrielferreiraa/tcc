$(document).ready(function () {
    $('.star-input').change(function () {
        var me = $(this);
        console.log(me.attr("value"));
    });
});