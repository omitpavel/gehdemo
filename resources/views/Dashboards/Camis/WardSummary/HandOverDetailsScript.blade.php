<script>
   function HandOverDetailsModal(ward_id) {
       $('.page-data-loader').show();
       var url = "{{ route('HandOverDetailsModal') }}";
       $.ajax({
           _token:tok,
           url: url,
           type: 'GET',
           data:{
               ward_id: ward_id
           },

           success: function (result)
           {
                if(result != '{{PermissionDenied()}}'){
                    $('#HandOverModalContent').html(result);
                    $('.page-data-loader').hide();
                } else {
                    CommonLoginModalPopupOpenOnRequest();
                }
           }
       });
   }

</script>

<script>
    function NextPatient(ward_id, patient_id) {
        $('.page-data-loader').show();
        var url = "{{ route('HandOverDetailsModal') }}";
        $.ajax({
            _token:tok,
            url: url,
            type: 'GET',
            data:{
                ward_id: ward_id,
                patient_id: patient_id
            },

            success: function (result)
            {
                $('#HandOverModalContent').html(result);
                $('.page-data-loader').hide();
            }
        });
    }

</script>
<script>
    function PreviousPatient(ward_id, patient_id) {
        $('.page-data-loader').show();
        var url = "{{ route('HandOverDetailsModal') }}";
        $.ajax({
            _token:tok,
            url: url,
            type: 'GET',
            data:{
                ward_id: ward_id,
                patient_id: patient_id
            },

            success: function (result)
            {
                $('#HandOverModalContent').html(result);
                $('.page-data-loader').hide();
            }
        });
    }

</script>

<script>
    function CheckboxPainAnalgesia() {
        if ($("#handover_pain_analgesia").is(":checked")) {
            $("#handover_pain_analgesia").val(1);
            $('#refer_to_epma').css('display','inline-block');
        } else {
            $("#handover_pain_analgesia").val(0);
            $('#refer_to_epma').css('display','none');
        }
    }
</script>

<script>
    $(document).on("change", "#consultant_dropdown", function(e) {
        var consultant = $('#consultant_dropdown').val();
        var ward_id = $('#ward_id').val();

        var url = "{{ route('ConsultantByBay') }}";
        $.ajax({
            _token:tok,
            url: url,
            type: 'GET',
            data:{
                ward_id: ward_id,
                consultant: consultant,

            },

            success: function (result)
            {
                console.log(result);
                $('#bed_group_dropdown').html(result);
                $('.page-data-loader').hide();
            }
        });
    });


</script>

<script>
   function GetPatientByBedNo(ward_id,group_name,group_number,bed_no){
       $('.page-data-loader').show();
       var url = "{{ route('HandOverDetailsModal') }}";
       $.ajax({
           _token:tok,
           url: url,
           type: 'GET',
           data:{
               ward_id: ward_id,
               group_name: group_name,
               group_number: group_number,
               bed_no: bed_no
           },

           success: function (result)
           {
               $('#HandOverModalContent').html(result);
               $('.page-data-loader').hide();
           }
       });
    }
</script>

<script>

    function CheckedLabeld(input_name,id) {
        var label_id = $('#'+id+'_label');
        var checkbox = $('#' + id);

        var innerDiv = $(label_id).find('.tick_icon');

        if($(label_id).hasClass('handover_check')){
            $(label_id).removeClass('handover_check');
            $(innerDiv).removeClass('green_tick_active');
            $(innerDiv).css('display','none');
            checkbox.prop('checked', false);
        }else{
            $(innerDiv).addClass('green_tick_active');
            $(innerDiv).css('display','block');
            $(label_id).addClass('handover_check');
            checkbox.prop('checked', true);
        }
        if(input_name == 's_surface'){
            var S_interface = [];
            $('input[name="s_surface[]"]:checked').each(function() {
                S_interface.push($(this).val());
            });
            $('#s_surface_value').val(S_interface);
        }
        if(input_name == 'n_nutrition'){
            var N_nutrition = [];
            $('input[name="n_nutrition[]"]').each(function() {
                if($(this).val() == 'Special Diet'){
                    if ($(this).is(":checked")) {

                        $("#handover_diet_comment").css("display", "block");
                    } else {

                        $("#handover_diet_comment").css("display", "none");
                    }
                }
            });
            $('input[name="n_nutrition[]"]:checked').each(function() {
                N_nutrition.push($(this).val());

            });
            $('#n_nutation_value').val(N_nutrition);
        }




        var isChecked = $(checkbox).is(':checked');


    }
</script>


<script>
    function SaveHandOverDetails(camis_patient_id,button_type){
        @if(CheckSpecificPermission('camis_handover_modal_add') || CheckSpecificPermission('camis_handover_modal_update'))
            $('.page-data-loader').show();

            var handover_repositioning_routine = $('#repositioning_routine').val();
            var ward_id = $('#ward_id').val();
            var hand_over_skin_conditioning = $('#skin_conditioning').val();
            var hand_over_dressings = $('#dressing').val();
            var hand_over_mobility = $('#mobility').val();
            var hand_over_equipment = $('#equipment').val();
            var hand_over_assistance_needed = $('#assistance_needed').val();
            var hand_over_i_continence = $('#i_continence').val();
            var hand_over_varience_store = $('#varience_store').val();
            var hand_over_obs = $('#obs_varience').val();
            var handover_pain_analgesia = $('#handover_pain_analgesia').val();
            var hand_over_special_diet_comment = $('#hand_over_special_diet_comment').val();
            var hand_over_comment = $('#ibox_handover_comment').val();
            var S_interface = $('#s_surface_value').val();
            var n_nutrition = $('#n_nutation_value').val();



            var url = "{{ route('HandOverDetailsModal') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": tok,
                    "ward_id": ward_id,
                    "button_type": button_type,
                    "camis_patient_id": camis_patient_id,
                    "repositioning_routine":handover_repositioning_routine,
                    "skin_conditioning":hand_over_skin_conditioning,
                    "dressings":hand_over_dressings,
                    "mobility":hand_over_mobility,
                    "equipment":hand_over_equipment,
                    "assistance_needed":hand_over_assistance_needed,
                    "varience_store":hand_over_varience_store,
                    "special_diet_comment":hand_over_special_diet_comment,
                    "obs":hand_over_obs,
                    "pain_analgesia":handover_pain_analgesia,
                    "hand_over_comment": hand_over_comment,
                    "s_surface":S_interface,
                    "i_continence":hand_over_i_continence,
                    "n_nutrition":n_nutrition
                },
                success: function(result) {
                    $('#HandOverModalContent').html(result);
                    $('.page-data-loader').hide();

                }
            });
        @else
            PermissionDeniedAlert();
        @endif
    }

</script>

<script>
    function ShowHandoverFilterPopUp(ward_id,patient_id){
        @if(CheckSpecificPermission('camis_handover_modal_print'))
            $('#ward_id').val(ward_id);
            $('#patient_id').val(patient_id);
            $('#handoverModal').modal('hide');
            $('#HandOverPrintFilterPopUpModal').modal('show');

            var url = "{{ route('PrintHandOverPopUpContent') }}";

            $.ajax({
                url: url,
                type: 'get',
                data: {
                    ward_id:ward_id,
                    patient_id:patient_id,
                },

                success: function(result) {
                    $('#HandOverModalPopUpContent').html(result);
                    $('.page-data-loader').hide();
                }
            });
        @else
            PermissionDeniedAlert();
        @endif

    }

</script>

<script>
    function ShowHandoverFilterPopUpClose(){
        var ward_id = $('#ward_id').val();
        var patient_id = $('#patient_id').val();
        console.log(patient_id);
        $('#HandOverPrintFilterPopUpModal').modal('hide');
        $('#handoverModal').modal('show');
        $('.page-data-loader').show();
        var url = "{{ route('HandOverDetailsModal') }}";
        $.ajax({
            _token:tok,
            url: url,
            type: 'GET',
            data:{
                ward_id: ward_id,
                patient_id: patient_id
            },

            success: function (result)
            {
                $('#HandOverModalContent').html(result);
                $('.page-data-loader').hide();
            }
        });



    }

</script>

<script>
    function PrintHandoverDetailsWithFilterData(){

        var bed_group           = $('#bed_group_dropdown').val();
        var consultant          = $('#consultant_dropdown').val();
        var ward_id             = $('#ward_id').val();
        console.log(ward_id);
        console.log(consultant);
        console.log(bed_group);
        var is_page_break       = 0;

        if ($("#hand_over_bay_break").is(":checked"))
        {
            is_page_break       = 1;
        }

        $.ajax({
            url: "{{ route('handover.print') }}",
            type: 'GET',
            data: {
                "_token": tok,
                "bed_group":bed_group,
                "consultant":consultant,
                "ward_id":ward_id,
                "is_page_break": is_page_break
            },
            success: function(response) {
                if (response != "" ) {

                var printContents = response;
                var w = window.open("data:text/html,.");

                var title = '@if(isset($success_array['ward_details']['ward_name'])) {{ $success_array['ward_details']['ward_name'] }} - @endif HANDOVER';


                var currnet_time = moment();
                var formatted_current_time = currnet_time.format('ddd Do MMM YYYY, HH:mm');
                var print_title = `
                <div style="position: relative;">
                    <div style="font-size: 15px; font-weight: 600; text-align: center;">
                        ${title}
                    </div>
                    <div
                        style="position: absolute; right: 8px; top: 50%; transform: translateY(-50%); font-size: 12px; font-weight: 400;">
                        ${formatted_current_time}
                    </div>
                </div>
                `;
                var html = print_title+ '' +
                    printContents + '';

                $(w.document.body).html(html);

                $(w.document.head).append('<title>.</title>');
                $(w.document.head).append('<link rel="stylesheet" type ="text/css" href="{{ asset('asset_v2/Template/Css/bootstrap.min.css') }}">');
                $(w.document.head).append('<link rel="stylesheet" type ="text/css" href="{{ asset('asset_v2/Template/Css/ResponsiveTable.css') }}">');
                $(w.document.head).append('<link rel="stylesheet" type ="text/css" href="{{ asset('asset_v2/Template/Css/Style.css') }}">');

                $(w.document.head).append('<link rel="stylesheet" type="text/css" href="{{ asset('asset_v2/Template/Css/Print.css') }}">');
                $(w.document.head).append('<link rel="stylesheet" type="text/css" href="{{ asset('asset_v2/Template/Css/PrintHandoverDetails.css') }}">');
                $(w.document.head).append('<style>@media print { body { background-color: #fff;  } @page { margin-bottom: 0.5in; } }</style>');


                setTimeout(function () {
                    w.onafterprint = w.close;
                    w.print();
                }, 1000);

                }
                else{
                CommonErrorModalPopupOpenOnRequest();
                }
            },
            error: function(status, error){
                CommonErrorModalPopupOpenOnRequest();
            }
        });
    }
</script>
