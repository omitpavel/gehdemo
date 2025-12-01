@if (count($patient_list) > 0)

    <table class="responsiveTable table-listing">
        <thead>
            <tr class="position-relative">
                <th>#</th>
                <th>Hospital Number</th>
                <th>Attendance ID</th>
                <th>Patient Name</th>
                <th>Registration Date</th>
                <th>Seen By Date/Time</th>
                <th>Seen By</th>
                <th>Final Location</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($patient_list as $speacitly)
                <tr class="ed_referral_patient_id_{{ $speacitly['symphony_attendance_id'] }}">
                    <td class="pivoted">
                        <div class="tdBefore">#</div>
                        {{ $loop->iteration }}
                    </td>
                    <td class="pivoted">
                        <div class="tdBefore">Hospital Number</div>
                        {{ $speacitly['symphony_pas_number'] }}
                    </td>
                    <td class="pivoted">
                        <div class="tdBefore">Attendance ID</div>
                        {{ $speacitly['symphony_attendance_id'] }}
                    </td>

                    <td class="pivoted">
                        <div class="tdBefore">Patient Name</div>
                        {{ ucfirst(strtolower($speacitly['symphony_patient_name'])) }}
                    </td>
                    <td class="pivoted">
                        <div class="tdBefore">Registration Date</div>
                        {{ PredefinedDateFormatFor24Hour($speacitly['symphony_registration_date_time']) }}
                    </td>

                    <td class="pivoted">
                        <div class="tdBefore">Seen By Date/Time</div>
                        {{ PredefinedDateFormatFor24Hour($speacitly['symphony_seen_date']) }}

                    </td>
                    <td class="pivoted">
                        <div class="tdBefore">Seen By</div>
                        {{ $speacitly['symphony_seen_by'] }}
                    </td>
                    <td class="pivoted">
                        <div class="tdBefore">Final Location</div>
                        {{ $speacitly['symphony_final_location'] }}
                    </td>
                    <td class="pivoted">
                        <div class="tdBefore">Action</div>
                        <button class="btn btn-remove click_remove_ed_referral_patient"
                            data-patient-id="{{ $speacitly['symphony_attendance_id'] }}">Remove </button>
                    </td>
                </tr>
            @endforeach


        </tbody>
    </table>
@else
    <div class="custom_not_found">{{ NotFoundMessage() }}</div>
@endif
<script>
    function safeStyle(id, prop, value) {
        const el = document.getElementById(id);
        if (el) el.style[prop] = value;
    }


    var windowWidth = window.innerWidth;
    if (windowWidth > 1400) {
        if (
            document.getElementById("marquee-content") &&
            document.getElementsByClassName(".bg-sticky") &&
            document.getElementsByClassName(".sticky-header")
        ) {
            safeStyle("stickyToprow", "top", "85px");
            safeStyle("medfitRow", "top", "145px");
            if (document.querySelector(".bg-sticky")) {
                var bgSticky = document.querySelector(".bg-sticky");
                bgSticky.style.top = "206px";
                var stickyHeader = document.querySelectorAll(".sticky-header");
                stickyHeader.forEach(function(header) {
                    header.style.top = "206px";
                });
            }
        } else {
            safeStyle("stickyToprow", "top", "60px");
            safeStyle("medfitRow", "top", "120px");
            if (document.querySelector(".bg-sticky")) {
                var bgSticky = document.querySelector(".bg-sticky");
                bgSticky.style.top = "180px";
                var stickyHeader = document.querySelectorAll(".sticky-header");
                stickyHeader.forEach(function(header) {
                    header.style.top = "180px";
                });
            }
        }
        if (document.getElementById("medfitRow")) {
            if (document.querySelector(".custom_not_found")) {
                var noRecords = document.querySelector(".custom_not_found");
                noRecords.style.marginTop = "53px";
            }
        }
    } else if (windowWidth > 1026 && windowWidth < 1399) {
        if (document.getElementById("marquee-content")) {
            safeStyle("stickyToprow", "top", "85px");
            safeStyle("medfitRow", "top", "146px");
            if (document.querySelector(".bg-sticky")) {
                var bgSticky = document.querySelector(".bg-sticky");
                bgSticky.style.top = "258px";
                var stickyHeader = document.querySelectorAll(".sticky-header");
                stickyHeader.forEach(function(header) {
                    header.style.top = "258px";
                });
            }
        }
        if (document.getElementById("medfitRow")) {
            if (document.querySelector(".custom_not_found")) {
                var noRecords = document.querySelector(".custom_not_found");
                noRecords.style.marginTop = "103px";
            }
        }
    }
</script>
