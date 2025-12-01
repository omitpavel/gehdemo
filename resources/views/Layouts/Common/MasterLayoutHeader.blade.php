@if (!in_array(Route::currentRouteName(), ['ed.performance', 'ed.home']))


    @if (isset($flash_notice) && $flash_notice != '')
        <div class="marquee-text d-none d-lg-block notification_text_top_header_marquee_parent" id="marquee-content">
            <marquee width="" direction="left" height="20px" class='notification_text_top_header_marquee'>
                {{ $flash_notice }}
            </marquee>
        </div>
    @endif

@endif
@include('Layouts.Common.TopMenu.ANE.MobileMenu')
@if (!in_array(Route::currentRouteName(), ['ed.home']))
    @include('Layouts.Common.TopMenu.MainTopMenu')
@endif
