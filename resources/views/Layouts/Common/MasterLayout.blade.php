<!DOCTYPE html>
<html lang="en">

<head>
    @include('Layouts.Common.MasterLayoutMetaData')
    <title>@yield('page-title')</title>
    <link rel="stylesheet" href="{{ asset('asset_v2/Generic/Css/JqueryUi.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/jquery.multiselect.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Ibox/Css/IboxCommonStyles.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Generic/bootstrap/css/bootstrap.min.css') }}"
        crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Generic/bootstrap/icons/font/bootstrap-icons.css') }}"
        crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Ibox/Css/IboxCustomStyles.css') }}" crossorigin="anonymous" />

    @yield('ane-css')
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/Style.css') }}" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/Modal.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Generic/Css/Selectric.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/Selectric.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/Sidebar.css') }}" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Generic/Css/toastr.min.css') }}" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('asset_v2/Generic/clockpicker/clockpicker.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Generic/clockpicker/standalone.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/ResponsiveTable.css') }}" crossorigin="anonymous" />

    @stack('template-style')
    @stack('custom-style')
    <script type="text/javascript" src="{{ asset('asset_v2/Generic/Js/Jquery.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset_v2/Generic/Js/JqueryUi.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset_v2/Generic/Js/JqueryMigrate.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset_v2/Generic/Js/JquerySelectric.js') }}"></script>
    <script src="{{ asset('asset_v2/Generic/Js/Popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset_v2/Generic/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('asset_v2/Template/js/jquery.multiselect.js') }}"></script>
    <script src="{{ asset('asset_v2/Generic/clockpicker/clockpicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset_v2/Generic/Js/toastr.min.js') }}"></script>
    @yield('header')
</head>

<body>
    @include('Common.Modals.CommonLoginModal')
    @if (session()->get('is_site_team') == 1 ||
            !is_numeric(\App\Models\Common\User::find(session()->get('LOGGED_USER_ID', ''))->user_type ?? 0))

        @if (
            !in_array(Route::currentRouteName(), [
                'ward.boardround',
                'ward.sdec.boardround',
                'ward.frailty.boardround',
                'ward.discharge.lounge.boardround',
            ]))
            @include('Common.Modals.SiteTeamNotification')
        @endif
    @endif
    @yield('modal')
    @if (!in_array(Route::currentRouteName(), ['speciality.referral']))
        <div class="loader-bg hide-on-first-load">
            <span class="screen-center"></span>
        </div>
        <div class="page-data-loader" style="z-index: 99999;"></div>
        <div class="page-loader"></div>
    @endif

    @include('Layouts.Common.MasterLayoutHeader')
    <div class="container-fluid page-body-wrapper  @if (in_array(Route::currentRouteName(), [
            'ward.sdec.boardround',
            'ward.frailty.boardround',
            'ward.discharge.lounge.boardround',
        ])) sdec-board-round @endif @if (in_array(Route::currentRouteName(), ['ward.boardround']) && request()->route('ward') === 'rltsauip') sau-board-round @endif"
        id="page-wrapper">
        @include('Layouts.Common.MasterLayoutSideBar')
        <div class="main-panel @if (in_array(Route::currentRouteName(), [
                'ward.boardround',
                'ward.sdec.boardround',
                'ward.frailty.boardround',
                'ward.discharge.lounge.boardround',
            ])) board-round-wrapper @endif" id="content">
            <div
                class="row @if (Route::currentRouteName() != 'ward.boardround') mb-2 @endif @if (Route::currentRouteName() === 'ward.ward-details' && request()->route('ward') === 'rltsauip') sau-wrapper @endif @if (Route::currentRouteName() === 'ward.sdec') sdec-wrapper @endif">
                @yield('content')
            </div>
        </div>
    </div>
    <div class="patient-search-modal modal fade camis_ward_summary_boardround_sub_inner_popup_common_class"
        id="ibox_open_patient_search_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h6 class="modal-title" id="exampleModalLabel">Patient Search</h6>
                    </div>
                    <div>
                        <button type="button" class="btn-grey text-end w-100" data-bs-dismiss="modal"
                            data-bs-target="#ibox_open_patient_search_modal" aria-label="Close"><img
                                src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14"
                                height="14" class="me-3">
                            CLOSE</button>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="">
                        <label for="global_patient_search_input" class="form-label">Hospital Number/Patient Name</label>
                        <input type="text" class="form-control" id="global_patient_search_input" placeholder="">
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-lg-10 offset-lg-1">
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <button class="btn btn-primary-grey global_patient_search_button"><img
                                            src="{{ asset('asset_v2/Template/icons/search-black.svg') }}"
                                            alt="" class="btn-icon-modal" width="18"
                                            height="18"><span>SEARCH</span>
                                    </button>
                                </div>
                                <div class="col-md-6">
                                    <button class="btn btn-primary-grey" data-bs-dismiss="modal"
                                        data-bs-target="#ibox_open_patient_search_modal"><img
                                            src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt=""
                                            class="btn-icon-modal" width="12" height="12"><span>CANCEL</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('footer')
        @include('Layouts.Common.MasterLayoutFooter')
        <section id="scroll-up" style=""><i class="bi bi-arrow-up-short"></i></section>
        @include('Common.Scripts.FooterScripts')
        @include('Common.Scripts.GlobalPrint')
        <!-- ///////////////////ibox Scripts//////////////////// -->
        <script src="{{ asset('asset_v2/Template/js/script.js') }}"></script>
        {!! Toastr::message() !!}
        <script type="text/javascript" src="{{ url('asset_v2/Ibox/Js/IboxCommonScript.js') }}"></script>
        <script type="text/javascript" src="{{ asset('asset_v2/Generic/Js/crypto-js.min.js') }}"></script>
        @stack('custom-script')
        <script>
            $(document).ready(function() {

                $('[data-bs-toggle="tooltip"]').tooltip();

                $(document).on('mouseenter', '[data-bs-toggle="tooltip"]', function() {
                    var $element = $(this);
                    if (!$element.data('bs.tooltip')) {
                        $element.tooltip();
                        $element.tooltip('show');
                    }
                });

                $(document).on('mouseleave', '[data-bs-toggle="tooltip"]', function() {
                    var $element = $(this);
                    if ($element.data('bs.tooltip')) {
                        $element.tooltip('hide');
                    }
                });
            });
            $(document).ajaxSuccess(function(event, xhr, settings) {
                $('select').each(function() {
                    if (!$(this).attr('multiple') && $(this).attr('id') !==
                        'boardround_patient_allowed_to_be_moved_to' && $(this).attr('id') !==
                        'breach_reason_update_id_to_store_field' && $(this).attr('id') !==
                        'ibox_pathway_data_update') {
                        $(this).selectric();
                    }
                });
            });

            $(document).on("click", ".click_open_global_patient_search", function(e) {
                var token = "{{ csrf_token() }}";
                DisableButtonClickForPreventFurtherEvent('click_open_global_patient_search');

                var ibox_open_patient_search_modal = new bootstrap.Modal(document.getElementById(
                    'ibox_open_patient_search_modal'));

                ibox_open_patient_search_modal.show();
                $('#global_patient_search_input').focus();
                CommonDisableEnableOnOpen();
                DisableLoaderAndMakeVisibleInnerBody();
                EnableSaveButtonForModals();

            });


            function closeModal(modalId) {

                const $m = $('#' + modalId);
                $m.removeClass('show').attr('aria-hidden', 'true').css('display', 'none');
                $('body').removeClass('modal-open').css('overflow', '');
                $('.modal-backdrop').remove();
            }
            $(document).on("click", ".accept_move_notification", function(e) {
                var patient_id = $(this).data('user');

                var token = "{{ csrf_token() }}";
                DisableButtonClickForPreventFurtherEvent('accept_move_notification');
                var url = "{{ route('notification.move.to.action') }}";
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        "_token": token,
                        "patient_id": patient_id,
                        "reject_reason": '',
                        "action": 'accept'
                    },
                    success: function(result) {
                        if (result.status == 1) {
                            toastr.success('Notification Accepted');
                            $('.move_to_notification_' + patient_id).html(result.html);

                        } else {
                            toastr.error('Something Went Wrong.');
                        }
                    },
                    error: function(textStatus, errorThrown) {
                        CommonErrorModalPopupOpenOnRequest();
                    }
                });

            });
            $(document).on("click", ".camis_patient_ward_summary_boardround_save_move_to_reject_reason", function(e) {
                var patient_id = $('#move_to_notification_patient_id').val();
                var reject_reason = $('#move_to_notification_reject_reason').val();
                if (reject_reason == '') {
                    toastr.warning('Please Enter Reason');
                    $('#move_to_notification_reject_reason').focus();
                    return false;
                }

                var token = "{{ csrf_token() }}";
                DisableButtonClickForPreventFurtherEvent('declined_move_notification');
                var url = "{{ route('notification.move.to.action') }}";
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        "_token": token,
                        "patient_id": patient_id,
                        "reject_reason": reject_reason,
                        "action": 'decline'
                    },
                    success: function(result) {
                        if (result.status == 1) {
                            toastr.success('Notification Declined');
                            closeModal('notification_reject_reason');
                            $('.move_to_notification_' + patient_id).html(result.html);

                        } else {
                            toastr.error('Something Went Wrong.');
                        }
                    },
                    error: function(textStatus, errorThrown) {
                        closeModal('notification_reject_reason');
                        CommonErrorModalPopupOpenOnRequest();
                    }
                });

            });



            $(document).on("click", ".declined_move_notification", function(e) {
                $('#move_to_notification_patient_id').val('');
                $('#move_to_notification_reject_reason').val('');
                var patient_id = $(this).data('user');
                var token = "{{ csrf_token() }}";
                DisableButtonClickForPreventFurtherEvent('declined_move_notification');

                var ibox_open_patient_search_modal = new bootstrap.Modal(
                    document.getElementById('notification_reject_reason'), {
                        backdrop: false,
                        keyboard: false
                    }
                );
                $('.modal-backdrop').remove();
                $('#move_to_notification_reject_reason').focus();
                $('#move_to_notification_patient_id').val(patient_id);
                CommonDisableEnableOnOpen();
                DisableLoaderAndMakeVisibleInnerBody();
                DisableSaveButtonForModals();

            });
            $(document).on("keyup", "#move_to_notification_reject_reason", function(e) {
                var delete_reason = $('#move_to_notification_reject_reason').val();
                if (delete_reason != '') {
                    EnableSaveButtonForModals();
                } else {
                    DisableSaveButtonForModals();
                }
            });
            $(document).on("click", ".global_patient_search_button", function(e) {
                var global_patient_search_input = $('#global_patient_search_input').val();
                if (global_patient_search_input != '') {
                    var url_for_patient_search = '{{ route('global.patient.search') }}?data=' +
                        global_patient_search_input;
                    window.location.href = url_for_patient_search;
                } else {
                    toastr.warning('Please Enter Anything For Search');
                }
            });

            $(document).on("keypress", "#global_patient_search_input", function(e) {
                var key = e.which;
                if (key == 13) {
                    var global_patient_search_input = $('#global_patient_search_input').val();
                    if (global_patient_search_input != '') {
                        var url_for_patient_search = '{{ route('global.patient.search') }}?data=' +
                            global_patient_search_input;
                        window.location.href = url_for_patient_search;
                    } else {
                        toastr.warning('Please Enter Anything For Search');
                    }
                }
            });

            function ValidateLoginCredForm() {

                $('.loader-bg').show();

                $.get('/csrf-token', function(data) {
                    var token = data.token;

                    PerformLogin(token);
                }).fail(function() {
                    $('.loader-bg').hide();
                    $('.login_message').css('color', 'red');
                    $('.login_message').removeClass('d-none').html('Failed to retrieve CSRF token.');
                });
            }

            function PerformLogin(token) {
                var usernameElement = document.getElementById('username');
                var passwordElement = document.getElementById('password');

                var username = usernameElement.value;
                var password = passwordElement.value;

                var key = CryptoJS.enc.Hex.parse(CryptoJS.SHA256('iboxv4').toString(CryptoJS.enc.Hex));

                var ivUsername = CryptoJS.lib.WordArray.random(16);
                var ivPassword = CryptoJS.lib.WordArray.random(16);

                var encryptedUsername = CryptoJS.AES.encrypt(username, key, {
                    iv: ivUsername,
                    mode: CryptoJS.mode.CBC,
                    padding: CryptoJS.pad.Pkcs7
                }).toString();

                var encryptedPassword = CryptoJS.AES.encrypt(password, key, {
                    iv: ivPassword,
                    mode: CryptoJS.mode.CBC,
                    padding: CryptoJS.pad.Pkcs7
                }).toString();

                var ivUsernameHex = ivUsername.toString(CryptoJS.enc.Hex);
                var ivPasswordHex = ivPassword.toString(CryptoJS.enc.Hex);

                if (ivUsernameHex && encryptedUsername && ivPasswordHex && encryptedPassword) {
                    var ec_username = ivUsernameHex + ':' + encryptedUsername;
                    var ec_password = ivPasswordHex + ':' + encryptedPassword;

                    if (!$('.login_message').hasClass('d-none')) {
                        $('.login_message').addClass('d-none');
                    }

                    $.ajax({
                        url: '{{ url('users/login') }}',
                        type: 'POST',
                        data: {
                            "_token": token,
                            "username": ec_username,
                            "password": ec_password
                        },
                        success: function(result) {
                            if (result.status == 1) {

                                window.location.replace("{{ url('home') }}");
                            } else {
                                $('.login_message').css('color', 'red');
                                $('.login_message').html(result.message);
                                if ($('.login_message').hasClass('d-none')) {
                                    $('.login_message').removeClass('d-none');
                                }
                                $('.loader-bg').hide();
                            }
                        },
                        error: function(xhr, status, error) {
                            $('.loader-bg').hide();
                            $('.login_message').css('color', 'red');
                            if ($('.login_message').hasClass('d-none')) {
                                $('.login_message').removeClass('d-none');
                            }


                            try {
                                var response = JSON.parse(xhr.responseText);

                                $('.login_message').html(response.message);
                            } catch (e) {
                                $('.login_message').html('An error occurred: " + error');
                            }


                        }
                    });
                } else {
                    $('.loader-bg').hide();
                    toastr.warning('Something Went Wrong.');
                }
            }
            @if (session()->get('is_site_team') == 1 ||
                    !is_numeric(\App\Models\Common\User::find(session()->get('LOGGED_USER_ID', ''))->user_type ?? 0))

                function NotificationCount() {
                    var currentRoute = "{{ Route::currentRouteName() }}";
                    var token = "{{ csrf_token() }}";
                    var url = "{{ route('notification.topcount') }}";

                    @if (Route::currentRouteName() == 'ward.ward-details' || Route::currentRouteName() == 'ward.boardround')
                        var current_ward = "{{ request()->route('ward') }}";
                    @else
                        var current_ward = '';
                    @endif




                    $.ajax({

                        url: url,
                        type: 'POST',
                        data: {
                            "_token": token,
                            currentRoute: currentRoute,
                            current_ward: current_ward
                        },
                        success: function(result) {
                            if (result < 1) {
                                if (!$('.notification_alert_class').hasClass('d-none')) {
                                    $('.notification_alert_class').addClass('d-none');
                                }
                            } else {
                                if ($('.notification_alert_class').hasClass('d-none')) {
                                    $('.notification_alert_class').removeClass('d-none');
                                }
                            }
                            $('.count_my_notification').html(result);
                        }
                    });
                }


                $(document).ready(function() {
                    NotificationCount();
                });

                $(document).on("click", ".remove_allowed_to_move_notification", function(e) {

                    var camis_patient_id = $(this).data('patient_id');
                    if (camis_patient_id != '') {
                        CommonToHideSubInnerPopupBoardround();
                        var url = "{{ route('RemoveAllowedToBeMoved') }}";
                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: {
                                "_token": tok,
                                "camis_patient_id": camis_patient_id
                            },
                            success: function(result) {
                                if (typeof result.message !== 'undefined') {
                                    $('.move_to_notification_'+camis_patient_id).remove();
                                    toastr.success(result.message);
                                } else {

                                    toastr.warning('{{ ErrorOccuredMessage() }}');
                                }
                            },
                            error: function(textStatus, errorThrown) {
                                toastr.warning('{{ ErrorOccuredMessage() }}');
                            }
                        });
                    } else {
                        toastr.warning('{{ ErrorOccuredMessage() }}');
                    }

                });


                $(document).on("click", ".click_view_site_team_notification", function(e) {

                    CommonDisableEnableOnOpen();
                    DisableButtonClickForPreventFurtherEvent('click_view_site_team_notification');
                    var url = "{{ route('notification.offcanvas') }}";
                    var currentRoute = "{{ Route::currentRouteName() }}";
                    @if (Route::currentRouteName() == 'ward.ward-details' || Route::currentRouteName() == 'ward.boardround')
                        var current_ward = "{{ request()->route('ward') }}";
                    @else
                        var current_ward = '';
                    @endif


                    $.ajax({
                        url: url,
                        type: 'GET',
                        data: {
                            _token: "{{ csrf_token() }}",
                            currentRoute: currentRoute,
                            current_ward: current_ward
                        },
                        success: function(result) {
                            if (result != '{{ PermissionDenied() }}') {
                                $('.site_team_notification_offcanvas_data').html(result);
                                DisableLoaderAndMakeVisibleInnerBody();
                            } else {
                                CloseOffcanvas('site_team_notification_offcanvas');
                                DisableLoaderAndMakeVisibleInnerBody();
                                toastr.error('Permission Restricted.');
                            }
                        },
                        error: function(textStatus, errorThrown) {
                            CloseOffcanvas('site_team_notification_offcanvas');
                            CommonErrorModalPopupOpenOnRequest();
                        }
                    });
                });



                $(document).on("click", ".click_accept_notification", function(e) {

                    var token = "{{ csrf_token() }}";
                    var patient_id = $(this).data('patient_id');
                    var notification_time = $(this).data('notification_time');
                    var notification_type = $(this).data('notification_type');
                    var url = "{{ route('notification.single.approve') }}";
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            "_token": token,
                            "patient_id": patient_id,
                            "notification_time": notification_time,
                            "notification_type": notification_type
                        },
                        success: function(result) {
                            toastr.success('Notification Accepted');
                            $('.site_team_notification_offcanvas_data').html(result);
                            NotificationCount();
                        }
                    });
                });
            @endif
        </script>
    @show
</body>
{!! Toastr::message() !!}

</html>
