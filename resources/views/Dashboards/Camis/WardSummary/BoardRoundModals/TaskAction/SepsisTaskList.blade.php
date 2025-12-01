

<div class="leaflet-one-offcanvas offcanvas offcanvas-end camis_ward_summary_boardround_sub_inner_popup_common_class" tabindex="-1" id="sepsis_task_list" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header card-header fw-bold">
        <h6 class="mb-0" id="offcanvasRightLabel"> DP Sepsis Tasks</h6>
        <div class="">
            <button type="button" class="btn-grey text-end w-100" onclick="CloseOffcanvas('sepsis_task_list');" ><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                CLOSE</button>
        </div>
    </div>
    <div class="modal-popup-loader-content"></div>
    <div class="offcanvas-body ward_summary_sub_modal_inner_body">
        <div>
            <div class="header-primary">
                <h6>Automatically assign the following sepsis tasks:</h6>
            </div>
            <div class="questions-list">
                <ul id="sepsis_assigned_task">
                    @if(isset($success_array['sepsis_task']))
                        @foreach($success_array['sepsis_task'] as $task)
                            <li>{{ $task['auto_populate_task_name'] }} - {{ @$task['task_user_group']['task_group_name'] }}</li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
    </div>
    <div class="offcanvas-footer">
        <div class="row">
            <div class="col-lg-2 col-md-4 offset-lg-5 offset-md-4 ibox_modal_footer_button_class">
                <button class="btn btn-primary-grey" onclick="CloseOffcanvas('sepsis_task_list');"><img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt=""
                                                                                                                                    class="btn-icon-modal" width="12" height="12"><span>CLOSE</span>
                </button>
            </div>
        </div>
    </div>
</div>
