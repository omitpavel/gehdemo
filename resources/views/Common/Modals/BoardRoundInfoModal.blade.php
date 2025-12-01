
@if(Route::currentRouteName() != 'site.stranded_patients')
    @push('template-style')
        <link rel="stylesheet" href="{{ asset('asset_v2/Ibox/Css/BoardRoundPopup.css') }}">
        <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/WardContent.css') }}">

    @endpush
@endif


<div class="board-round-offcanvas offcanvas offcanvas-end" tabindex="-1" id="boardRound" aria-labelledby="offcanvasRightLabel"   data-bs-backdrop="static">

    <div class="offcanvas-header card-header fw-bold">
        <div class="d-flex align-items-center justify-content-between w-100">
            <div class="">
                <h6 class="mb-0" id="offcanvasRightLabel">BOARD ROUND</h6>
            </div>
            <div class="">
                <button type="button" class="btn-grey text-end w-100 close_board_round_offcanvas" @if(Route::currentRouteName() != 'site.stranded_patients') onclick="CloseOffcanvas('boardRound');" @endif><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                    CLOSE</button>
            </div>
        </div>
    </div>
    <div class="offcanvas-body @if(Route::currentRouteName() == 'site.stranded_patients') los-board-round @endif">
        <div class="modal-dummy-content-loader" id="modal-data-loader" style="display: none;"></div>
        @if(Route::currentRouteName() == 'site.stranded_patients')
            <div>
                <button class="btn bg-lock mb-2 w-100 modal-locked content_display_none" id="lock_all_image"><img src="{{ asset('asset_v2/Template/icons/lock.svg') }}" alt="" width="20" class="me-3">
                    <span class="locked_user_name_to_show">Locked By
                    <span class="locked_by_name"></span></span></button>
            </div>
        @endif
        <div class="row">
            <div class="container-fluid append_to_content" @if(Route::currentRouteName() != 'site.stranded_patients') style="pointer-events: none;" @endif>

            </div>
        </div>

    </div>
    <div class="offcanvas-footer">
        <div class="row">
            <div class="col-lg-2 col-md-4 offset-lg-5 offset-md-4">
                <button class="btn btn-primary-grey close_board_round_offcanvas" @if(Route::currentRouteName() != 'site.stranded_patients') onclick="CloseOffcanvas('boardRound');" @endif><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" class="btn-icon-modal" width="12" height="12"><span>CLOSE</span>
                </button>
            </div>
        </div>
    </div>
</div>

