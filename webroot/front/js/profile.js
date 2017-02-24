$(document).ready(function(){
    $(document).on('click', '.btn-toggle', openDrawer);
    
    function openDrawer(){
        $(this).toggleClass('open-drawer');
        $('.profile-informations').toggleClass('open-drawer');
    }
})