

<div class="potential-discharge-offcanvas offcanvas offcanvas-end" tabindex="-1" id="camisHelp"
     aria-labelledby="offcanvasRightLabel">

    <div class="offcanvas-header card-header fw-bold ">
        <h6 class="mb-0" id="offcanvasRightLabel">HELP</h6>
        <div class="">
            <button type="button" class="btn-grey text-end w-100" onclick="CloseOffcanvas('camisHelp');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                CLOSE</button>
        </div>
    </div>
    <div class="offcanvas-body">
        <div class="row">
            <div class="col-lg-12" id="custom-tab">
                <div class="col-md-12 padding-zero popup_alert_response_show_div"></div>
                <ul class="nav nav-tabs" role="tablist">
                    <li class="mb-2">
                        <a class="tab-custom-btn active active"
                           id=""
                           data-bs-target="#bed_summary" type="button"
                           role="tab" aria-controls="ane_opel_ed_status_data"
                           aria-selected="true" data-bs-toggle="tab"><div class="tab-active">Bed Summary
                           </div> </a>
                    </li>
                    <li class="mb-2">
                        <a class="tab-custom-btn"
                           id="" data-bs-toggle="tab"
                           data-bs-target="#board_round" type="button"
                           role="tab" aria-controls="ane_opel_ward_status_data"
                           aria-selected="false">
                           <div class="tab-active">Board Round</div>

                        </a>
                    </li>

                </ul>


                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade active show" id="bed_summary" role="tabpanel" aria-labelledby="">
                        <img src="{{ asset('asset_v2/Ibox/Images/'.GetCamisInfoHelp()['board_round'])}}" style="height:85vh;">
                    </div>


                    <div class="tab-pane fade " id="board_round" role="tabpanel" aria-labelledby="">
                        <img src="{{ asset('asset_v2/Ibox/Images/'.GetCamisInfoHelp()['bed_summary'])}}" style="height:85vh;">
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

