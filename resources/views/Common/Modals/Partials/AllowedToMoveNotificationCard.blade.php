<div class="transfer-notification-wrapper">
    <div class="row g-2">
        <div class="col-8">
            <h6 class="mb-0">{{ $patient_name }} @if(!empty($pass_number))({{ $pass_number }})@endif</h6>
            <span class="new-timestamp ">{{ PatientLos($notification['updated_at']) }} ago</span>
        </div>
        <div class="col-4">
            <span class="bg-notification primary-bg-notification">Allowed To Move</span>
        </div>
        <div class="col-12">
            <p>{{ $string }}</p>
        </div>
        <div class="row g-2" id="transferButtons">
            <div class="col-6">
                <button class="btn btn-accept-transfer  @if($notification['status'] == 1) active @endif  @if(AllowedToMoveModifyPermission() && $notification['status'] != 1) accept_move_notification @endif" @if(!AllowedToMoveModifyPermission()) onclick="CommonLoginModalPopupOpenOnRequest();" @endif  data-user="{{ $notification['patient_id'] }}">Accept <img src="{{ asset('asset_v2/Template/icons/tick-circle.svg') }}" alt="" class="ms-3" width="18" height="18"></button>

            </div>
            <div class="col-6">
                <button class="btn btn-decline-transfer  @if($notification['status'] == 2) active @endif @if(AllowedToMoveModifyPermission() && $notification['status'] != 2) declined_move_notification @endif" @if(!AllowedToMoveModifyPermission())  onclick="CommonLoginModalPopupOpenOnRequest();" @endif data-user="{{ $notification['patient_id'] }}" data-bs-toggle="modal" data-bs-target="#notification_reject_reason">Decline <img src="{{ asset('asset_v2/Template/icons/tick-circle.svg') }}" alt="" class="ms-3" width="18" height="18"></button>
            </div>
        </div>
        <div class="col-12">
            @if(in_array($notification['status'], [1,2]))

                <div class="update-user-details">
                    <span>{{ $action_user }} @if($notification['status'] == 2)<span class="text-danger">@endif {{ $status_formatted }}@if($notification['status'] == 2)</span>@endif On {{ $action_time }}</span>
                </div>
                @if(in_array($notification['status'], [2]))
                    <div class="update-reason">
                        <span>Declined Reason : {{ $declined_reason }}</span>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
