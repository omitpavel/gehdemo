<div class="row g-2">
    <div class="col-6 mb-3">
      <button class="btn btn-comment" onclick="window.location.href = '{{ route('notification.index') }}'">View All</button>
    </div>
    <div class="col-6 mb-3">
      <button class="btn btn-reject" onclick="window.location.href = '{{ route('notification.all.approve') }}'">Mark all as Accepted
      </button>
    </div>
</div>
@foreach ($data as $notification)
    @if($notification['notification_type'] != 7)
        <div class="bg-notification-card">
            <div class="row g-2">
            <div class="col-8">
                <h6 class="mb-0">{{ $notification['camis_patient_name'] }} @if(!empty($notification['camis_patient_pas_number']))({{ $notification['camis_patient_pas_number'] }})@endif</h6>
                <span class="new-timestamp ">{{ $notification['format_time'] }} ago</span>
            </div>
            <div class="col-4">
                <span class="bg-notification primary-bg-notification">{{ $notification['type'] }}</span>
            </div>
            <div class="col-12">
                <p>{{ $notification['string'] }}</p>
            </div>
            <div class="text-end">
                <button class="btn btn-accept w-50 click_accept_notification" data-notification_time="{{$notification['time']  }}" data-notification_type="{{$notification['notification_type']  }}" data-patient_id="{{ $notification['patient_id'] }} ">Accepted</button>
            </div>
            </div>
        </div>
    @else


            <div class="bg-notification-card move_to_notification_{{ $notification['patient_id'] }}">
                <div class="transfer-notification-wrapper">
                    <div class="row g-2">
                        <div class="col-8">
                            <h6 class="mb-0">{{ $notification['camis_patient_name'] }} @if(!empty($notification['camis_patient_pas_number']))({{ $notification['camis_patient_pas_number'] }})@endif</h6>
                            <span class="new-timestamp ">{{ $notification['format_time'] }} ago</span>
                        </div>
                        <div class="col-4">
                            <span class="bg-notification primary-bg-notification">{{ $notification['type'] }}</span>
                        </div>
                        <div class="col-12">
                            <p>{{ $notification['string'] }}</p>
                        </div>
                        @if($notification['can_receive'] == 1)
                            <div class="row g-2" id="transferButtons">
                                <div class="col-6">
                                    <button class="btn btn-accept-transfer @if($notification['status'] == 1) active @endif @if(AllowedToMoveModifyPermission() && $notification['status'] != 1) accept_move_notification @endif" @if(!AllowedToMoveModifyPermission()) onclick="CommonLoginModalPopupOpenOnRequest();" @endif  data-user="{{ $notification['patient_id'] }}">Accept <img src="{{ asset('asset_v2/Template/icons/tick-circle.svg') }}" alt="" class="ms-3" width="18" height="18"></button>

                                </div>
                                <div class="col-6">
                                    <button class="btn btn-decline-transfer @if($notification['status'] == 2) active @endif @if(AllowedToMoveModifyPermission() && $notification['status'] != 2) declined_move_notification @endif" @if(!AllowedToMoveModifyPermission())  onclick="CommonLoginModalPopupOpenOnRequest();" @endif data-user="{{ $notification['patient_id'] }}" data-bs-toggle="modal" data-bs-target="#notification_reject_reason">Decline <img src="{{ asset('asset_v2/Template/icons/tick-circle.svg') }}" alt="" class="ms-3" width="18" height="18"></button>
                                </div>
                            </div>
                        @endif
                        <div class="col-12">
                            @if(in_array($notification['status'], [1,2]))

                                <div class="update-user-details">
                                    <span>{{ $notification['action_user'] }} @if($notification['status'] == 2)<span class="text-danger">@endif {{ $notification['status_formatted'] }}@if($notification['status'] == 2)</span>@endif On {{ $notification['action_time'] }}</span>
                                </div>
                                @if(in_array($notification['status'], [2]))
                                    <div class="update-reason">
                                        <span>Declined Reason : {{ $notification['declined_reason'] }}</span>
                                    </div>
                                @endif
                            @endif
                        </div>
                        @if($notification['can_receive'] == 0 && in_array($notification['status'], [2]))
                        <div class="col-12">
                            <div class="text-end">
                                <button class="btn btn-reject w-50 remove_allowed_to_move_notification" data-patient_id="{{ $notification['patient_id'] }}">Remove Allow To Move</button>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

    @endif
@endforeach


