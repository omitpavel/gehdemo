 @php
     if (!isset($success_array['script_error_message'])) {
         $success_array['script_error_message'] = ErrorOccuredMessage();
     }
 @endphp
 <script>

     $.ajaxSetup({
         headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('data-token')
         }
     });
     var tok = "{{ csrf_token() }}";
     var script_error_message = "{{ $success_array['script_error_message'] }}";
     $(document).ready(function() {
         var pagetitle = document.title;
         var tok = "{{ csrf_token() }}";
         var pageurl = window.location.href;
         $.ajax({
             url: "<?= URL::to('governance/frontend/pagelogs') ?>",
             type: 'POST',
             dataType: 'json',
             data: {
                 "pageurl": pageurl,
                 "pagetitle": pagetitle,
                 "_token": tok
             },
             success: function(data) {

             }
         });
     });


 </script>
