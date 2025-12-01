<script>

    function ViewAllCommentsGlobal(camis_patient_id,ward_type) {

        if (camis_patient_id != '') {
            var token = "{{ csrf_token() }}";
            $.ajax({
                url: '{{ route('show.all_comments') }}',
                type: 'POST',
                data: {
                    "_token": token,
                    "patient_id": camis_patient_id,
                    "type": ward_type,
                },
                success: function(result) {
                    if (typeof result !== 'undefined') {

                        $('#show_patient_all_comments').html(result);

                        DisableLoaderAndMakeVisibleInnerBody();
                    } else {
                        CommonErrorModalPopupOpenOnRequest();
                    }

                },
                error: function(textStatus, errorThrown) {
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        } else {
            CommonErrorModalPopupOpenOnRequest();
        }

    }

    function ViewAllComments(camis_patient_id, doctor_at_night) {
        var comment_modal = new bootstrap.Offcanvas(document.getElementById(
            'viewAllComments'), {
            ariaControls: 'offcanvasRight'
        });

        comment_modal.show();

        if (camis_patient_id != '') {
            var token = "{{ csrf_token() }}";
            $.ajax({
                url: '{{ route('show.all_comments') }}',
                type: 'POST',
                data: {
                    "_token": token,
                    "patient_id": camis_patient_id,
                    "type": doctor_at_night,
                },
                success: function(result) {
                    if (typeof result !== 'undefined') {

                        $('#show_patient_all_comments').html(result);

                        DisableLoaderAndMakeVisibleInnerBody();
                    } else {
                        CommonErrorModalPopupOpenOnRequest();
                    }

                },
                error: function(textStatus, errorThrown) {
                    CommonErrorModalPopupOpenOnRequest();
                }
            });
        } else {
            CommonErrorModalPopupOpenOnRequest();
        }

    }
</script>
