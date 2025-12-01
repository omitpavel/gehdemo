@extends('Layouts.Common.MasterLayout')
@section('page-title', 'Bed Management')
@section('page-top-title', 'Bed Management')
@section('page-top-title-sub', 'autotimer')
@push('custom-style')
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/ResponsiveTable.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/BedManagementOne.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/BedsCount.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/HandoverDetails.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/PotentialDischargeList.css') }}" />
@endpush
@section('modal')
    @include('Dashboards.Camis.BedMatrix.Modals')
    @include('Common.Modals.CommonModals')
@endsection
@section('content')
    <input type="hidden" id="modal_ward_id" value="">
    <input type="hidden" id="modal_ibox_ward_id" value="">
    <input type="hidden" id="modal_bed_group_id" value="">
    <input type="hidden" id="modal_bed_group_number" value="">
    <div class="container-fluid refresh-content">

    </div>

@endsection
@section('footer')

    @parent
    <script type="text/javascript" src="{{ asset('asset_v2/Ibox/Js/AutoTimer.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('data-token')
            }
        });
        var ajax_refresh_url = "";
    </script>
    <script>
        function DataPageLoad(){
            $('.page-data-loader').show();
            $.ajax({
                _token:tok,
                url: "{{ route('bed.matrix.ajax') }}",
                type: 'POST',
                data: { _token: tok},
                success: function (result)
                {
                    $('.refresh-content').html(result);
                    $('.page-data-loader').hide();
                }
            });
        }


        $( document ).ready(function()
        {
            DataPageLoad();
        });



            $(document).on("click", ".show_bed", function (e)
            {
                    @if(CheckSpecificPermission('camis_list_view_ward_modal_view'))
                var token = "{{ csrf_token() }}";
                var ward_name = $(this).data('ward-name');
                var ward_id = $(this).data('bed-id');
                var extension = $(this).data('extension');
                $('#wardname').html(ward_name);

                $('.modal-popup-loader-content').show();
                var show_bed_modal = new bootstrap.Offcanvas(document.getElementById('bedsCount'), {
                    relatedTarget: 'offcanvasRight',
                    backdrop: 'static'
                });

                show_bed_modal.show();
                if (ward_id != '') {
                    $.ajax({
                        url: "{{ route('bed.matrix.modal') }}",
                        type: 'POST',
                        data: {
                            "_token": token,
                            "ward_id": ward_id
                        },
                        success: function(result) {
                                $('#modal_ward_id').val(ward_id);
                                $('#ward_content').html(result);
                                CommonDisableEnableOnOpen();
                                DisableLoaderAndMakeVisibleInnerBody();
                            $('.modal-popup-loader-content').hide();


                        },
                        error: function(textStatus, errorThrown) {
                            CommonErrorModalPopupOpenOnRequest();
                            $('.modal-popup-loader-content').hide();
                        }
                    });
                } else {
                    CommonErrorModalPopupOpenOnRequest();
                }
                @else
                    PermissionRestricted();
                @endif

            });








            $(document).on("click", ".update_bed_status", function (e)
            {
                @if(CheckSpecificPermission('camis_list_view_ward_modal_update'))
                var token = "{{ csrf_token() }}";
                var ward_bed_id = $(this).data('ward-bed-id');
                var ward_id = $(this).data('ward-id');
                var bed_no = $(this).data('ward-bed-no');


                setTimeout(function() {
                    var show_bed_modal = new bootstrap.Modal(document.getElementById('bed_details_modal'), {  backdrop: 'static' });
                    show_bed_modal.show();
                }, 1000);


                if (ward_id != '') {
                    $.ajax({
                        url: "{{ route('bed.matrix.bedstatus') }}",
                        type: 'POST',
                        data: {
                            "_token": token,
                            "ward_id": ward_id,
                            "ward_bed_id": ward_bed_id,
                            "bed_no": bed_no
                        },
                        success: function(result) {
                                $('#bed_status_data').html(result);
                                $('#ward_bed_no').html(bed_no);
                                CommonDisableEnableOnOpen();
                                DisableLoaderAndMakeVisibleInnerBody();
                                DisableSaveButtonForModals();
                                console.log = function () {};
                                console.clear();
                        },
                        error: function(textStatus, errorThrown) {
                            CommonErrorModalPopupOpenOnRequest();
                        }
                    });
                } else {
                    CommonErrorModalPopupOpenOnRequest();
                }
                @else
                PermissionRestricted();
                @endif

            });


        $(document).on("click", "#patient_name_show", function(e) {
            $("#patient_name_show").addClass("content_display_none");
            $("#patient_name_hide").removeClass("content_display_none");

            $(".patient_name_hide_on_request").addClass("content_display_none");
            $(".patient_name_show_on_request").removeClass("content_display_none");

            clear_patient_name_show = setTimeout(function() {
                $("#patient_name_hide").addClass("content_display_none");
                $("#patient_name_show").removeClass("content_display_none");

                $(".patient_name_show_on_request").addClass("content_display_none");
                $(".patient_name_hide_on_request").removeClass("content_display_none");
            }, 60000);
        });







            $(document).on("click", ".patient_search_button", function(e) {
            @if(CheckSpecificPermission('camis_list_view_ward_modal_update'))
                $('#patient_search_loader').show();
                $('#patient_search_list').hide();

                var token = "{{ csrf_token() }}";
                var name = $('#patient_search_value').val();
                if(name == ''){
                    toastr.error('Please Type Something');
                    return;
                }
                $.ajax({
                    url: "{{ route('CamisGetAllPatientID') }}",
                    type: 'POST',
                    data: {
                        "_token": token,
                        "name": name
                    },
                    success: function(result) {
                            $('#patient_search_list').html(result);
                            $('#patient_search_loader').hide();
                            $('#patient_search_list').show();
                            DisableSaveButtonForModals();
                            console.log = function () {};
                            console.clear();
                    },
                    error: function(textStatus, errorThrown) {
                        CommonErrorModalPopupOpenOnRequest();
                    }
                });
            @else
            PermissionRestricted();
            @endif
            });


            function SelectPatient(button) {
                @if(CheckSpecificPermission('camis_list_view_ward_modal_update'))
                $(button).toggleClass('active');

                $('.select_patient_pas').not(button).removeClass('active');
                var patient_id = $('.select_patient_pas.active').val();
                if(patient_id == undefined){
                    DisableSaveButtonForModals();
                } else {
                    EnableSaveButtonForModals();
                }
                @else
                PermissionRestricted();
                @endif
            }


            $(document).on("click", "#patient_name_hide", function(e) {
                $("#patient_name_hide").addClass("content_display_none");
                $("#patient_name_show").removeClass("content_display_none");

                $(".patient_name_show_on_request").addClass("content_display_none");
                $(".patient_name_hide_on_request").removeClass("content_display_none");
            });
            $(document).on("change", "input[name=bed_current_status]", function(e) {
                    @if(CheckSpecificPermission('camis_list_view_ward_modal_update'))
                var bed_current_status = $('input[name=bed_current_status]:checked').val();
                if(bed_current_status == 4){
                    $('.patient_search_class').removeClass("d-none");
                    $('#search_patient_id').focus();
                    $('.patient_search_class_input').removeClass("d-none");
                    DisableSaveButtonForModals();
                } else {
                    $('.patient_search_class').addClass("d-none");
                    $('.patient_search_class_input').addClass("d-none");
                    $('#search_patient_id').val('');

                    EnableSaveButtonForModals();
                }
                @else
                PermissionRestricted();
                @endif
            });
            $(document).on('click', '.click_open_close_bay_restriction', function(e) {
                    @if(CheckSpecificPermission('camis_list_view_ward_modal_update'))
                var bed_group_number = $(this).data('bed_group_number');
                var bed_group_id = $(this).data('bed_group_id');
                var ward_id = $(this).data('ward_id');
                var token = "{{ csrf_token() }}";
                if(bed_group_id != '' && bed_group_number !='' && ward_id != ''){
                    $("#modal_bed_group_id").val(bed_group_id);
                    $("#modal_bed_group_number").val(bed_group_number);
                    $("#modal_ibox_ward_id").val(ward_id);

                    var bay_close_modal = new bootstrap.Modal(document.getElementById('bayClose'), {
                        relatedTarget: 'offcanvasRight',
                        backdrop: 'static'
                    });

                    bay_close_modal.show();





                        $.ajax({
                            url: "{{ route('bed.matrix.baystatus') }}",
                            type: 'POST',
                            data: {
                                "_token": token,
                                "ward_id": ward_id,
                                "bed_group_id": bed_group_id,
                                "bed_group_number": bed_group_number
                            },
                            success: function(result) {
                                    $('input[name="input_bay_status"][value="'+result+'"]').prop('checked', true);

                                    CommonDisableEnableOnOpen();
                                    DisableLoaderAndMakeVisibleInnerBody();
                                    DisableSaveButtonForModals();
                                    console.log = function () {};
                                    console.clear();
                            },
                            error: function(textStatus, errorThrown) {
                                CommonErrorModalPopupOpenOnRequest();
                            }
                        });
                } else {
                    toastr.warning('Something Went Wrong');
                }
                @else
                PermissionRestricted();
                @endif
            });


            $(document).on('click', '.camis_patient_ward_summary_boardround_save_bay_status', function(e) {
                @if(CheckSpecificPermission('camis_list_view_ward_modal_update'))
                var token = "{{ csrf_token() }}";
                var ward_id = $('#modal_ibox_ward_id').val();
                var ibox_bed_group_id = $('#modal_bed_group_id').val();
                var ibox_bed_group_number = $('#modal_bed_group_number').val();
                var status = $('input[name=input_bay_status]:checked').val();
                if(status == ''){
                    toastr.error('Please Select An Option');
                    return;
                }

                if(modal_ibox_ward_id == '' || modal_bed_group_id == '' || modal_bed_group_number == ''){
                    toastr.error('Something Went Wrong');
                    return;
                }



                var url = "{{ route('SaveBayStatus') }}";
                if (ward_id != '') {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            '_token': tok,
                            'ibox_bed_group_id': ibox_bed_group_id,
                            'ward_id': ward_id,
                            'ibox_bed_group_number': ibox_bed_group_number,
                            'status': status

                        },
                        success: function(result) {
                            if (typeof result.message !== 'undefined') {



                                if($('#bay_class_'+ward_id+'_'+ibox_bed_group_number+'_'+ibox_bed_group_id).hasClass('bay-closed')){
                                    $('#bay_class_'+ward_id+'_'+ibox_bed_group_number+'_'+ibox_bed_group_id).removeClass('bay-closed');
                                }

                                if($('#bay_class_'+ward_id+'_'+ibox_bed_group_number+'_'+ibox_bed_group_id).hasClass('bay-restricted')){
                                    $('#bay_class_'+ward_id+'_'+ibox_bed_group_number+'_'+ibox_bed_group_id).removeClass('bay-restricted');
                                }
                                $('#bay_status_'+ward_id+'_'+ibox_bed_group_number+'_'+ibox_bed_group_id).html(result.button_text);
                                $('#bay_class_'+ward_id+'_'+ibox_bed_group_number+'_'+ibox_bed_group_id).addClass(result.text);
                                toastr.success('Bay Status Update Successfully')
                                $("#bayClose").modal('hide');
                            } else {
                                DisableSaveButtonLoadImageForModals();
                                EnableSaveButtonForModals();
                                toastr.warning('{{ ErrorOccuredMessage() }}');
                                CommonErrorModalPopupOpenOnRequest();
                            }
                        },
                        error: function(textStatus, errorThrown) {
                            DisableSaveButtonLoadImageForModals();
                            EnableSaveButtonForModals();
                            toastr.warning('{{ ErrorOccuredMessage() }}');
                            CommonErrorModalPopupOpenOnRequest();
                        }
                    });
                } else {
                    DisableSaveButtonLoadImageForModals();
                    EnableSaveButtonForModals();
                    CommonErrorModalPopupOpenOnRequest();
                }
                @else
                PermissionRestricted();
                @endif
            });

            $(document).on('click', '.camis_patient_ward_summary_boardround_save_bed_status', function(e) {
                @if(CheckSpecificPermission('camis_list_view_ward_modal_update'))
                var token = "{{ csrf_token() }}";
                var ward_bed_id = $('#ward_bed_id').val();
                var ward_id = $('#ward_id').val();
                var bed_current_status = $('input[name=bed_current_status]:checked').val();
                var patient_id = $('.select_patient_pas.active').val();

                if(bed_current_status == ''){
                    toastr.error('Please Select An Option');
                    return;
                }

                if(bed_current_status == 4 && patient_id == undefined){
                    toastr.error('Please Choose A Patient');
                    return;
                }

                CommonDisableEnableOnSave();
                EnableSaveButtonLoadImageForModals();
                DisableSaveButtonForModals();
                var url = "{{ route('SaveBedStatus') }}";
                if (ward_bed_id != '') {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            '_token': tok,
                            'ward_bed_id': ward_bed_id,
                            'ward_id': ward_id,
                            'bed_status': bed_current_status,
                            'patient_id': patient_id

                        },
                        success: function(result) {
                            if (typeof result.message !== 'undefined') {
                                if(result.patient_found == 1){
                                    $('#ward_close_status_'+ward_bed_id).html(result.text);
                                    DisableSaveButtonLoadImageForModals();
                                    EnableSaveButtonForModals();
                                    toastr.success('Bed Status Updated');
                                    console.log = function () {};
                                    console.clear();
                                    $('#bed_details_modal').modal('hide');

                                    $('.modal-backdrop').remove();
                                    return;
                                } else {
                                    DisableSaveButtonLoadImageForModals();
                                    EnableSaveButtonForModals();
                                    toastr.error('No Patients Found With The Given Patient ID');
                                    console.log = function () {};
                                    console.clear();
                                    return;
                                }

                            } else {
                                DisableSaveButtonLoadImageForModals();
                                EnableSaveButtonForModals();
                                toastr.warning('{{ ErrorOccuredMessage() }}');
                                CommonErrorModalPopupOpenOnRequest();
                            }
                        },
                        error: function(textStatus, errorThrown) {
                            DisableSaveButtonLoadImageForModals();
                            EnableSaveButtonForModals();
                            toastr.warning('{{ ErrorOccuredMessage() }}');
                            CommonErrorModalPopupOpenOnRequest();
                        }
                    });
                } else {
                    DisableSaveButtonLoadImageForModals();
                    EnableSaveButtonForModals();
                    CommonErrorModalPopupOpenOnRequest();
                }
                @else
                PermissionRestricted();
                @endif
            });

            $(document).on('click', '.close_bed_update', function(e) {

                $('#bed_details_modal').modal('hide');
                $('.modal-backdrop').remove();
            });


        $(document).on("click", ".click_open_definite_discharges", function(e) {
            var token = "{{ csrf_token() }}";
            $('#definite_patient_list_data').html('');

            var history_modal = new bootstrap.Offcanvas(document.getElementById('definite_patient_modal'), {
                relatedTarget: 'offcanvasRight',
                backdrop: 'static'
            });

            history_modal.show();
            CommonDisableEnableOnOpen();
            var url = "{{ route('bed.matrix.pd_modal') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": token,
                    "type": '2'
                },
                success: function(result) {
                        if (typeof result != '') {

                                $('#definite_patient_list_data').html(result);
                                DisableLoaderAndMakeVisibleInnerBody();
                        } else {
                            CommonErrorModalPopupOpenOnRequest();
                        }

                    },
                error: function(textStatus, errorThrown) {
                    CommonErrorModalPopupOpenOnRequest();
                }
            });

        });

        $(document).on("click", ".click_open_potential_discharges", function(e) {
            var token = "{{ csrf_token() }}";
            $('#definite_patient_list_data').html('');

            var history_modal = new bootstrap.Offcanvas(document.getElementById('potential_patient_modal'), {
                relatedTarget: 'offcanvasRight',
                backdrop: 'static'
            });

            history_modal.show();
            CommonDisableEnableOnOpen();
            var url = "{{ route('bed.matrix.pd_modal') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": token,
                    "type": '1'
                },
                success: function(result) {
                        if (typeof result != '') {

                                $('#potential_patient_list_data').html(result);
                                DisableLoaderAndMakeVisibleInnerBody();
                        } else {
                            CommonErrorModalPopupOpenOnRequest();
                        }

                    },
                error: function(textStatus, errorThrown) {
                    CommonErrorModalPopupOpenOnRequest();
                }
            });

        });
        function CloseBedCountModal(){
            $('.refresh-content').html('');
            CloseOffcanvas('bedsCount');
            DataPageLoad();
        }
    </script>

@endsection
