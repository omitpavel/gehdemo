jQuery(document).ready(function(e) {
    var interval;

    function startCycle() {
        interval = setInterval(function() {
            PageDataLoadOnRefreshes();
        }, 180000);
    }


    function PageDataLoadOnRefreshes() {
        if (typeof ajax_refresh_url !== 'undefined') {
            if (ajax_refresh_url != '') {
                $.ajax({
                    url: ajax_refresh_url,
                    type: 'GET',
                    success: function(page_load_data) {
                        $('.page-data-loader').show();
                        $('.refresh-content').html(page_load_data);
                        if (typeof CommonJsFunctionCallAfterContentRefersh == 'function') {
                            CommonJsFunctionCallAfterContentRefersh();
                        }
                        setTimeout(function() {
                            $('.page-data-loader').hide();
                        }, 500);
                    }
                });
            }
        }
    }
    startCycle();
});
