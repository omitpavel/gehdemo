$(function() {
    if ($(window).width() < 1368) {
        $('#common_page_tab_nav_contents').find('.responsive_tab_trigger').first().addClass('active');
    }
    $(".responsive_tab_trigger").click(function(e) {
        if (e.target.classList.contains("active")) 
        {

            $("body").find(".tab-pane-page").removeClass("active");
            $("body").find(".tab-pane-page").removeClass("show");
            $("body").find(".tab-pane-page").removeClass("fade");
            $("body").find(".responsive_tab_trigger").removeClass("active");

            e.target.classList.remove("active");
            e.target.nextElementSibling.classList.remove("active");
        } 
        else 
        {

            $("body").find(".tab-pane-page").removeClass("active");
            $("body").find(".tab-pane-page").removeClass("show");
            $("body").find(".tab-pane-page").removeClass("fade");
            $("body").find(".responsive_tab_trigger").removeClass("active");

            e.target.classList.add("active");
            e.target.nextElementSibling.classList.add("active");
        }
    });
});