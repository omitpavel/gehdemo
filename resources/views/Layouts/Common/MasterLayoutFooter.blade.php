    @php
        $display_footer_text_name = Session::get('LOGGED_USER_FOOTER_TEXT_SHOW') ?? '';
    @endphp
    {{-- <div style='height:50px;'>&nbsp;</div>
    <div class="footerWrap show footershadow">
        <div class="version">
            <a href=""> Version 1.000.001 </a>
        </div>
        @if ($display_footer_text_name != '')
            <div class="signin">Logged In As <span class="logged_user_names">{{ $display_footer_text_name }}</span></div>
        @endif
    </div> --}}
