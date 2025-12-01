@extends('Layouts.Common.MasterLayout')
@section('page-title', 'Month Summary')
@section('page-top-title', 'Month Summary')

@section('header')
    @parent
     <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/ResponsiveTable.css') }}" crossorigin="anonymous">
     <link rel="stylesheet" href="{{ asset('asset_v2/Template/Css/MonthSummary.css') }}" crossorigin="anonymous">
@endsection

@section('modal')
    @include('Dashboards.Camis.DischargeTracker.Modals')
    @include('Common.Modals.CommonModals')
@endsection
@section('content')
    <div class="contentSection" id="contentSection_data">
    </div>
    </div>
@endsection
@section('footer')
    @parent
    <script src="{{ asset('asset_v2/Ibox/Js/IboxPageRefresh.js') }}"></script>
    <script src="{{ asset('asset_v2/Ibox/Js/custom.js') }}"></script>

    <script>
        function DataPageLoad(month){
            @if(CheckSpecificPermission('discharge_tracker_month_summary_view'))
                var token               = "{{ csrf_token() }}";
                $('.page-data-loader').show();
                setTimeout(function() {
                    $.ajax({
                        _token: token,
                        url: "{{ route('discharged.month.data.load') }}",
                        type: 'POST',
                        data: { "_token": token, "month": month},
                        success: function (response)
                        {
                            if(response != ""){

                                $('#contentSection_data').html(response);
                                $('.SelectBoxWrap select').selectric('refresh');
                                $('.page-data-loader').hide();
                            }
                        },
                        error: function(status, err){
                            $('.page-data-loader').hide();
                        }
                    });
                },2000)
            @else
                PermissionDeniedAlert();
            @endif
        }



        function DtocModal(camis_patient_id){
            var token           = "{{ csrf_token() }}";
            var ward_id         = $('#ward_id').val();
            var medfit          = $('#medfit_value').val();
            var search_text     = $('#search_text').val();
            $(".modal-popup-loader-content").show();
            if(camis_patient_id != ''){
                $.ajax({
                    _token: token,
                    url: "{{ route('discharged.fetch.dtoc.info') }}",
                    type: 'POST',
                    data: { "_token": token, "camis_patient_id": camis_patient_id, "ward_id": ward_id, "medfit": medfit, "search_text": search_text},
                    success: function (response)
                    {
                        $('#dtoc_data').html(response);
                        if (!$('#patientDetails').hasClass('show')) {
                            var dtoc_modal = new bootstrap.Modal(document.getElementById('patientDetails'), {
                                backdrop: 'static'
                            });
                            dtoc_modal.show();
                        }


                        DisableLoaderAndMakeVisibleInnerBody();
                        CommonDisableEnableOnSave();
                    },
                    error: function(textStatus, errorThrown) {
                        CommonErrorModalPopupOpenOnRequest();
                    }
                });
            } else {
                CommonErrorModalPopupOpenOnRequest();
            }
        }

        $( document ).ready(function()
        {
            var month         = $('#month').val();
            DataPageLoad(month);
        });


        $(document).on("click", ".export_discharge_tracker", function (e){
            var token = "{{ csrf_token() }}";
            var ward_id = $('#ward_id').val();
            var medfit = $('#medfit_value').val();
            var search_text = $('#search_text').val();

            var url = "{{ route('discharged.export') }}?ward_id=" + ward_id + "&medfit=" + medfit + "&search_text=" + search_text;

            window.open(url, '_blank');
        });


        $(document).on("click", ".print_discharge_tracker", function (e){
            var print_title =
            '<div class="print_title_star_styling_head" style="border-radius:8px;">Discharge Tracker </div>';
            var html_to_print = $(".discharge-tracker").html();
            var printContents = print_title +
            '<div class="col-md-12 padding-zero" id="symphony_data_search_show_data_sec_body_print_show">' +
            html_to_print + '</div>';
            var newWin = window.open('', 'Print-Window');
            newWin.document.open();
            newWin.document.write('<html><style>' +
                '@import url("{{ asset('asset_v2/Generic/bootstrap/css/bootstrap.min.css') }}");' +
                '@import url("{{ asset('asset_v2/Ibox/Css/CustomBootstrapPrint.css') }}");' +
                '@import url("{{ asset('asset_v2/Template/Css/Style.css') }}");' +
                '@import url("{{ asset('asset_v2/Template/Css/StyleNew.css') }}");' +
                '@import url("{{ asset('asset_v2/Template/Css/ResponsiveTable.css') }}");' +
                '@import url("{{ asset('asset_v2/Template/Css/DischargeTracker.css') }}");' +
                '@import url("{{ asset('asset_v2/Template/Css/DischargesPatientDetails.css') }}");' +
                '@import url("{{ asset('asset_v2/Template/Css/ResponsiveTable.css') }}");' +
                '</style><body onload="window.print()"><div class="ae-summary-offcanvas">' + printContents +'</div></body></html>');

            var buttons = newWin.document.getElementsByTagName('button');
            for (var i = 0; i < buttons.length; i++) {
            buttons[i].style.display = 'none';
            }
            setTimeout(function () {
                newWin.print();
                newWin.close();
            }, 1000);

        });

    </script>
    <script>

        $(document).on("change", "#month", function (e)
        {
            var month         = $('#month').val();
            DataPageLoad(month);
        });



    </script>

@endsection
