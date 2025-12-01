<script>
  function BoardRoundInfo(camis_patient_id, ward_name) {
      var token = "{{ csrf_token() }}";
      var modal = document.getElementById('boardRound');

      DisableButtonClickForPreventFurtherEvent('click_popup_open_ibox_board_round_admitting_reason');
      if (camis_patient_id != '') {

            if(ward_name == 'rltsauip'){
                if(!$('#boardRound').hasClass('sau-board-round-offcanvas')){
                    $('#boardRound').addClass('sau-board-round-offcanvas');
                }
                if($('#boardRound').hasClass('board-round-offcanvas')){
                    $('#boardRound').removeClass('board-round-offcanvas');
                }
            } else {
                if($('#boardRound').hasClass('sau-board-round-offcanvas')){
                    $('#boardRound').removeClass('sau-board-round-offcanvas');
                }
                if(!$('#boardRound').hasClass('board-round-offcanvas')){
                    $('#boardRound').addClass('board-round-offcanvas');
                }
            }
          var board_round = new bootstrap.Offcanvas(document.getElementById('boardRound'), {
              relatedTarget: 'offcanvasRight',

          });
          board_round.show();
          $('.append_to_content').html('');
          $('#modal-data-loader').show();
          var url = "{{ route('GetBoardRoundSummery') }}";
          $.ajax({
              url:url,
              type: 'POST',
              data: {
                  '_token': token,
                  'camis_patient_id': camis_patient_id
              },
              success: function(result) {

                  $('#modal-data-loader').hide();
                  $('.append_to_content').html(result);
                  function disableEvents(event) {
                      event.preventDefault();
                      event.stopPropagation();
                  }
                  modal.addEventListener('click', disableEvents);
                  modal.addEventListener('keydown', disableEvents);
                  $('#board_round_modal').html(' <button type="button" class="btn btn-allebone w-100 close_board_round close_board_round_modal" data-bs-dismiss="modal" aria-label="Close"> \n' +
                      '\n' +
                      '        <img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" class="btn-icon" width="14">        <span>Close</span>\n' +
                      '            </button>');


                  $('.camis_patient_ward_summary_boardround_save_admitting_reason ').hide();

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
