<script>


    function PatientInfo(id) {
        var token = "{{ csrf_token() }}";

        var ibox_open_patient_search_modal = new bootstrap.Offcanvas(document.getElementById('dischargeSummary'), {
            relatedTarget: 'offcanvasRight',
            backdrop: 'static'
        });

        ibox_open_patient_search_modal.show();

        $('.modal-popup-loader-content').show();
        CommonDisableEnableOnOpen();
        $('#summery_data').html('');

        @if(request()->routeIs('global.patient.search'))

        var url = "{{ route('global.patient.search.inpatients.modal',':patientId') }}";
        @else
        var url = "{{ route('site.discharges_patient.modal',':patientId') }}";
            @endif
        url = url.replace(':patientId', id);
        $.ajax({
            url: url,
            type: 'GET',
            success: function (result)
            {
                $('#summery_data').html(result);
                $('.modal-popup-loader-content').hide();
                DisableLoaderAndMakeVisibleInnerBody();
            },
            error: function(textStatus, errorThrown) {
                $('.modal-popup-loader-content').hide();
                CloseOffcanvas('dischargeSummary');
                CommonErrorModalPopupOpenOnRequest();
            }
        });
    }


    function DischargeModalPrint() {
        var id = $('#discharged_patients_print_id').val();
            @if(request()->routeIs('global.patient.search'))

        var url = "{{ route('global.patient.search.inpatients.modal-print',':patientId') }}";
            @else
        var url = "{{ route('site.discharges_patient.modal-print',':patientId') }}";
            @endif

        url = url.replace(':patientId', id);
        var newWindow = window.open(url, '_blank');

    }

    $(document).on("click", ".print_ibox_discharge_summary", function (e){
        var w = window.open();
        var html_to_print = $(".ibox_discharge_summary_body").html();
        var title = 'IBOX DISCHARGE SUMMARY';
        var print_title =
        '<div class="print_title_star_styling_head" style="border-radius:8px; justify-content: center; display: flex; padding-top: 16px; padding-bottom: 40px;font-size: 15px;font-weight: 600;">'+title+'</div>';

        var html = print_title +
        '<div class="col-md-12 padding-zero" id="symphony_data_search_show_data_sec_body_print_show">' +
        html_to_print + '</div>';

        $(w.document.body).html(html);
        var buttons = w.document.getElementsByTagName('button');
        for (var i = 0; i < buttons.length; i++) {
            if (!buttons[i].classList.contains('allowed')) {
                buttons[i].style.display = 'none';
            }
        }

        $(w.document.head).append('<link rel="stylesheet" type ="text/css" href="{{ asset('asset_v2/Template/Css/bootstrap.min.css') }}">');
        $(w.document.head).append('<link rel="stylesheet" type ="text/css" href="{{ asset('asset_v2/Template/Css/ResponsiveTable.css') }}">');
        $(w.document.head).append('<link rel="stylesheet" type ="text/css" href="{{ asset('asset_v2/Template/Css/Style.css') }}">');
        $(w.document.head).append('<link rel="stylesheet" type="text/css" href="{{ asset('asset_v2/Template/Css/DischargeSummary.css') }}">');
        $(w.document.head).append('<link rel="stylesheet" type ="text/css" href="{{ asset('asset_v2/Template/Css/Print.css') }}">');
        setTimeout(function () {
            w.onafterprint = w.close;
            w.print();
        }, 1000);
    });
</script>


