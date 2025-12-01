
<div class="col-lg-12">
    <div class="notifications-wrapper">
        <div class="notification-filters">
            <div class="row gx-2">
                <div class="col-xl-4 col-md-5 mb-2">
                    <div class="card-date">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="cyan-circle text-center me-2">
                                    <i class="bi bi-calendar3 "></i>
                                </div>
                                <div class="date-box w-90">
                                    <input type="hidden" value="{{ request()->date }}" class="start_date_day_summary_val" id="start_date_day_summary_val">
                                    <input type="text" name="datepicker" id="start_date_day_summary"
                                        placeholder="{{ request()->filled('date') ? PredefinedYearFormat(request()->date) : PredefinedYearFormat(date('Y-m-d')) }}" readonly>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-5 mb-2">
                    <select id="type" class="form-select">
                        <option value="">Select Notification Type</option>
                        <option value="1" {{ request()->type == 1 ? 'selected' : '' }}>Admission</option>
                        <option value="2" {{ request()->type == 2 ? 'selected' : '' }}>Move To Other Ward</option>
                        <option value="3" {{ request()->type == 3 ? 'selected' : '' }}>Move To Bed (Same Ward)</option>
                        <option value="4" {{ request()->type == 4 ? 'selected' : '' }}>Discharged</option>
                        <option value="4" {{ request()->type == 5 ? 'selected' : '' }}>Red Bed</option>
                        <option value="4" {{ request()->type == 6 ? 'selected' : '' }}>Green Bed</option>
                    </select>

                </div>
                <div class="col-xl-3 col-lg-4 col-md-5 mb-2" >
                    <input class="form-control" type="text" placeholder="Search" id="search_text"
                        aria-label="default input example" value="{{ request()->search_text }}">
                </div>
                <div class="col-xl-1 col-md-2 mb-2">
                    <button class="btn btn-search submit_button">Search</button>
                </div>
            </div>
        </div>
        <div class="notifications-data">
            <div class="card-table-listing">
                @if(count($data) > 0)
                    <table class="responsiveTable table-listing">
                        <thead>
                            <tr class="position-relative">
                                <th>Patient ID</th>
                                <th>Pas Number</th>
                                <th>Patient Name</th>
                                <th>Date & Time</th>
                                <th>Action</th>
                                <th>Admission Type</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $notification)
                                <tr>
                                    <td class="pivoted">
                                        <div class="tdBefore">Patient ID</div>
                                        <span>{{ $notification['camis_patient_id'] }}</span>
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">Pas Number</div>
                                        <span>{{ $notification['camis_patient_pas_number'] }}</span>
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">Patient Name</div>
                                        {{ $notification['camis_patient_name'] }}
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">Date & Time</div>
                                        {{ PredefinedDateFormatFor24Hour($notification['notification_time']) }}
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">Action</div>
                                        {{ $notification['action'] }}
                                    </td>
                                    <td class="pivoted">
                                        <div class="tdBefore">Admission Type</div>
                                        {{ ucwords($notification['admission_type']) }}
                                    </td>

                                    <td class="pivoted">
                                        <div class="tdBefore">Description</div>
                                        {{ $notification['string'] }}
                                    </td>
                                </tr>

                            @endforeach

                        </tbody>
                    </table>
                @else
                <div class="custom_not_found">{{ NotFoundMessage() }}</div>
                @endif
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('asset_v2/Generic/Js/moment.min.js') }}"></script>
<script src="{{ asset('asset_v2/Generic/Js/daterangepicker.js') }}"></script>
<script>
     $(function() {

             @if(!empty(request()->date))
         var start = moment('{{request()->date}}', 'YYYY-MM-DD');
             @else
         var start = moment().endOf('day');
         @endif

         function cb(start) {
             $('#start_date_day_summary_val').val(start.format('YYYY-MM-DD'));
             $('#start_date_day_summary').val(start.format('ddd MMMM D, YYYY'));
             if(start.format('YYYY-MM-DD') != '{{request()->date}}'){
                 $(".submit_button").click();
             }
         }


         $('#start_date_day_summary').daterangepicker({
             singleDatePicker: true,
             showDropdowns: true,
             autoApply: true,
             startDate: start,
             maxDate: moment().endOf('day'),
             locale: {
                 format: 'ddd MMMM D, YYYY'
             }
         }, cb);



     });
 </script>
<script>
    var windowWidth = window.innerWidth;
    var bgSticky = document.querySelector('.bg-sticky');
    if (windowWidth > 1026) {
        if (document.getElementById("marquee-content")) {
            document.getElementsByClassName("notification-filters")[0].style.top = "86px";



        }

    }
</script>
