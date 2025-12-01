@extends('Layouts.Common.MasterLayout')
@section('page-title', 'Patient Search')
@section('page-top-title', 'Patient Search')

@section('header')
    @parent

    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/ResponsiveTable.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/TableListing.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/DischargesPatientDetails.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/DischargesTimeline.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/DischargesCommentHistory.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Ibox/Css/DischargeTrackerPatientDetails.css') }}"
        crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/DischargesPatientSearch.css') }}" crossorigin="anonymous">

@endsection

@section('modal')
    @include('Dashboards.Camis.DischargeTracker.Modals')
    @include('Common.Modals.CommonModals')
@endsection
@section('content')
    <div class="col-lg-12  ">

        <div class="sticky-toprow" id="stickyToprow">
            <div class="row gx-2 fixed-height">
                <div class="col-xl-3 col-md-5 mb-2">
                    <input class="form-control" type="text" placeholder="Search.." id="patient_key"
                        aria-label="default input example">
                </div>
                <div class="col-xl-1 col-md-2 mb-2">
                    <button class="btn btn-search" id="patient_search_button">Search</button>
                </div>
            </div>
        </div>


        <div id="contentSection_data" class="patient-search-contents">
            <div class="pt-4 custom_not_found">{{ NotFoundMessage() }}</div>
        </div>
    </div>

@endsection
@section('footer')
    @parent
    <script src="{{ asset('asset_v2/Ibox/Js/IboxPageRefresh.js') }}"></script>
    <script src="{{ asset('asset_v2/Ibox/Js/custom.js') }}"></script>
    @include('Dashboards.Camis.DischargeTracker.ViewAllcommentScript')
    <script>
        function DataPageLoad(patient_key) {
            @if (CheckSpecificPermission('discharge_tracker_patient_search_view'))
                if (patient_key != '') {
                    var token = "{{ csrf_token() }}";
                    $('.page-data-loader').show();
                    setTimeout(function() {
                        $.ajax({
                            _token: token,
                            url: "{{ route('discharged.search.data.load') }}",
                            type: 'POST',
                            data: {
                                "_token": token,
                                "patient_key": patient_key
                            },
                            success: function(response) {
                                if (response != "") {

                                    $('#contentSection_data').html(response);
                                    $('.SelectBoxWrap select').selectric('refresh');
                                    $('.page-data-loader').hide();
                                }
                            },
                            error: function(status, err) {
                                $('.page-data-loader').hide();
                            }
                        });
                    }, 2000)
                } else {
                    toastr.warning('Please Enter Something');
                }
            @else
                PermissionDeniedAlert();
            @endif
        }

        $('.form-control').keypress(function(e) {
            if (e.which == 13) {
                var patient_key = $('#patient_key').val();
                DataPageLoad(patient_key);
            }
        });
        $(document).on("click", "#patient_search_button", function(e) {
            var patient_key = $('#patient_key').val();
            DataPageLoad(patient_key);
        });
    </script>
    <script>
        var windowWidth = window.innerWidth;
        if (windowWidth > 1026) {
            if (document.getElementById("marquee-content")) {
                document.getElementById("stickyToprow").style.top = "85px";

            }

        }
    </script>
    <script>
        $(document).on("click", ".click_open_other_comment_offcanvas", function(event) {
            DisableButtonClickForPreventFurtherEvent('click_open_other_comment_offcanvas');
            var token = "{{ csrf_token() }}";
            var camis_patient_id = $(this).data('patient-id');
            $("#other_notes_patient_id").val(camis_patient_id);
            var other_notes_modal = new bootstrap.Offcanvas(document.getElementById(
                'camis_discharge_comment_offcanvas'), {
                relatedTarget: 'offcanvasRight',
                backdrop: false
            });
            other_notes_modal.show();


            CommonDisableEnableOnOpen();
            EnableLoaderAndMakeHiddenInnerBody();
            if (camis_patient_id != '') {
                var url = "{{ route('discharged.other.notes') }}";
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        "_token": token,
                        "camis_patient_id": camis_patient_id
                    },
                    success: function(result) {

                        if (result != '') {

                            $(".other_notes_hisotry").html(result.sections);
                            $("#other_notes_input").val(result.current_comment);


                            $("#other_notes_input").focus();

                            CommonDisableEnableOnOpen();
                            DisableLoaderAndMakeVisibleInnerBody();
                            DisableSaveButtonForModals();
                            if (result.current_comment != '') {
                                EnableDeleteButtonForModals();
                            } else {
                                DisableDeleteButtonForModals();
                            }
                        } else {
                            CommonErrorModalPopupOpenOnRequest();
                        }
                    },
                    error: function(textStatus, errorThrown) {
                        CloseOffcanvas('camis_discharge_comment_offcanvas');
                        CommonErrorModalPopupOpenOnRequest();
                    }
                });
            } else {
                CloseOffcanvas('camis_discharge_comment_offcanvas');
                CommonErrorModalPopupOpenOnRequest();
            }
        });
        $(document).on("keyup", "#other_notes_input", function(e) {
            var comment = $('#other_notes_input').val();
            if (comment != '') {
                EnableSaveButtonForModals();
            } else {
                DisableSaveButtonForModals();
            }
        });

        $(document).on("click", ".camis_patient_ward_save_discharge_comment", function(e) {
            var token = "{{ csrf_token() }}";
            var camis_patient_id = $("#other_notes_patient_id").val();
            var comment = $('#other_notes_input').val();

            if (comment == '') {
                toastr.warning('Please enter comment to save.');
                return false;
            }
            EnableSaveButtonLoadImageForModals();
            DisableSaveButtonForModals();
            $('.modal-dummy-content-loader').show();
            $('.other_notes_hisotry').html('');
            if (camis_patient_id != '') {
                console.log('success');
                var url = "{{ route('discharged.save.other.notes') }}";
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        "_token": tok,
                        "camis_patient_id": camis_patient_id,
                        "comment": comment
                    },
                    success: function(result) {
                        if (typeof result.message !== 'undefined') {


                            DisableSaveButtonLoadImageForModals();

                            EnableDeleteButtonForModals();
                            DisableSaveButtonForModals();
                            toastr.success('{{ DataUpdatedMessage() }}');
                            $('.other_notes_hisotry').html(result.sections);
                            CloseOffcanvas('camis_discharge_comment_offcanvas');
                        } else {
                            DisableSaveButtonLoadImageForModals();
                            EnableSaveButtonForModals();
                            CloseOffcanvas('camis_discharge_comment_offcanvas');
                            toastr.warning('{{ ErrorOccuredMessage() }}');
                            CommonErrorModalPopupOpenOnRequest();
                            $('.modal-dummy-content-loader').hide();
                        }
                    },
                    error: function(textStatus, errorThrown) {
                        DisableSaveButtonLoadImageForModals();
                        EnableSaveButtonForModals();
                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        CommonErrorModalPopupOpenOnRequest();
                        $('.modal-dummy-content-loader').hide();
                    }
                });
            } else {
                toastr.warning('{{ ErrorOccuredMessage() }}');
                CommonErrorModalPopupOpenOnRequest();
            }
        });

        $(document).on("click", ".camis_patient_ward_summary_boardround_remove_comment", function(e) {
            var token = "{{ csrf_token() }}";
            var camis_patient_id = $("#other_notes_patient_id").val();
            var comment = $('#discharges_latest_comment').val();
            EnableSaveButtonLoadImageForModals();
            DisableSaveButtonForModals();
            $('.modal-dummy-content-loader').show();

            if (camis_patient_id != '') {
                console.log('success');
                var url = "{{ route('site.discharges_patient.savecomments') }}";
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        "_token": tok,
                        "camis_patient_id": camis_patient_id,
                        "comment": ''
                    },
                    success: function(result) {
                        if (typeof result.message !== 'undefined') {

                            CloseOffcanvas('camis_discharge_comment_offcanvas');
                        } else {
                            DisableSaveButtonLoadImageForModals();
                            EnableSaveButtonForModals();
                            CloseOffcanvas('camis_discharge_comment_offcanvas');
                            toastr.warning('{{ ErrorOccuredMessage() }}');
                            CommonErrorModalPopupOpenOnRequest();
                            $('.modal-dummy-content-loader').hide();
                        }
                    },
                    error: function(textStatus, errorThrown) {
                        DisableSaveButtonLoadImageForModals();
                        EnableSaveButtonForModals();
                        toastr.warning('{{ ErrorOccuredMessage() }}');
                        CommonErrorModalPopupOpenOnRequest();
                        CloseOffcanvas('camis_discharge_comment_offcanvas');
                    }
                });
            } else {
                toastr.warning('{{ ErrorOccuredMessage() }}');
                CommonErrorModalPopupOpenOnRequest();
            }
        });
    </script>
@endsection
