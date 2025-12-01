<div class="col-lg-12  ">
    <div class="row">
        <div class="col-lg-12" id="custom-tab">

            <!-- Nav tabs -->

            <div class="sticky-toprow" id="stickyToprow">
              <ul class="nav nav-tabs" role="tablist">
                <li class="mb-2">
                  <a class="tab-custom-btn click_dtoc_search_reset ">
                    <div class="tab-active">CDT Patients</div>
                  </a>
                </li>
                <li class="mb-2">
                  <a class="tab-custom-btn click_discharges_from_cdt " data-bs-toggle="tab" href="#dischargeFromCdt">
                    <div class="tab-active">Discharge From CDT</div>
                  </a>
                </li>
                <li class="mb-2">
                    <a class="tab-custom-btn click_discharges_from_ed_referral active" >
                      <div class="tab-active">ED Referral</div>
                    </a>
                </li>
              </ul>
            </div>

            <!-- Tab panes -->

            <div class="tab-content" id="tabcontent">
                <div id="cdtPatients" class="tab-pane active">


                    <div class="ed-referral-wrapper">
                        <div class="row g-2 mb-2 ed-referral-filters">
                          <div class="col-xxl-3 col-lg-4 col-md-8 col-12">
                            <div class="d-flex justify-content-between">
                              <input class="form-control" id="referral_page_search_query" type="text" placeholder="Search" aria-label="default input example">
                              <button type="button" class="btn btn-dark ms-2 click_search_referral_list">
                                <i class="bi bi-search"></i>
                              </button>
                            </div>
                          </div>
                          <div class="col-lg-2 col-md-4 col-12 offset-xxl-7 offset-lg-6 click_open_ed_referral_page_offcanvas">
                            <button type="button" class="btn btn-export w-100" >
                              <i class="bi bi-plus-lg me-2"></i>Add Patient
                            </button>
                          </div>
                        </div>
                        <div class="card-table-listing" id="ed_referral_patient_list">
                          @include('Dashboards.Camis.DischargeTracker.Partials.EDReferralPatientList')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="today_discharges_value" value="{{ $success_array['discharges_today'] }}">
<script>
    var windowWidth = window.innerWidth;
    if (windowWidth > 1400) {
      if (
        document.getElementById("marquee-content") &&
        document.getElementsByClassName(".bg-sticky") &&
        document.getElementsByClassName(".sticky-header")
      ) {
        document.getElementById("stickyToprow").style.top = "85px";
        document.getElementById("medfitRow").style.top = "142px";
        if (document.querySelector(".bg-sticky")) {
          var bgSticky = document.querySelector(".bg-sticky");
          bgSticky.style.top = "202px";
          var stickyHeader = document.querySelectorAll(".sticky-header");
          stickyHeader.forEach(function (header) {
            header.style.top = "202px";
          });
        }
      } else {
        document.getElementById("stickyToprow").style.top = "60px";
        if (document.querySelector(".bg-sticky")) {
          var bgSticky = document.querySelector(".bg-sticky");
          bgSticky.style.top = "180px";
          var stickyHeader = document.querySelectorAll(".sticky-header");
          stickyHeader.forEach(function (header) {
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
        if (document.querySelector(".bg-sticky")) {
          var bgSticky = document.querySelector(".bg-sticky");
          bgSticky.style.top = "198px";
          var stickyHeader = document.querySelectorAll(".sticky-header");
          stickyHeader.forEach(function (header) {
            header.style.top = "198px";
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

