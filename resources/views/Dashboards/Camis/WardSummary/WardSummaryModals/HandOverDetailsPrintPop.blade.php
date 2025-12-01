<input type="hidden" name="handover_ward_id" id="handover_ward_id" value="">
<input type="hidden" name="handover_ward_short_name" id="handover_ward_short_name" value="">
<div class="modal fade" id="HandOverPrintFilterPopup" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="HandOverPrintFilterPopupLabel" style="display: none;" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
          <div class="modal-body">
              <div class="row ">
                  <div class="col-lg-12 ">
                      <div class="card-ed infection-risk-modal">
                          <div class="card-header fw-bold d-flex align-items-center justify-content-between ">
                            Handover Print Customization
                              <button type="button" class="btn-close" id="HandOverPrintFilterPopupCancel" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="card-body">
                              <div class="row mb-3">
                                  <div class="col-12 ">
                                      <div class="mb-2">
                                          <select class="form-select" aria-label="Default select example" id="consultant_dropdown">

                                          </select>
                                      </div>
                                      <div class="mb-2">
                                        <select class="form-select" aria-label="Default select example" id="bed_group_dropdown">

                                        </select>
                                    </div>
                                    <div class="mb-2 mt-3">
                                        <input  type="checkbox" name="hand_over_bay_break" id="hand_over_bay_break" value="1" >
                                        <label class="pl-1">Page Break After Each Bay</label>
                                    </div>
                                  </div>
                              </div>
                              <div class="row" id="grey-btns-group">
                                  <div class="col-lg-8 offset-lg-3">
                                      <div class="row">
                                          <div class="col-lg-4 col-md-4 mb-2 ps-md-1 pe-md-1">
                                              <button class="btn btn-breach-grey w-100 " onclick="PrintHandoverDetailsWithFilter()"><img
                                                src={{ asset("/asset_v2/Template/icons/print.svg") }} alt="" class="btn-icon-modal"
                                                      width="16" height="16"><span>PRINT</span>
                                              </button>
                                          </div>
                                          <div class="col-lg-4 col-md-4 mb-2 ps-md-1">
                                              <button class="btn btn-breach-grey w-100" id="HandOverPrintFilterPopupCancel" data-bs-dismiss="modal" aria-label="Close"><img
                                                src={{ asset("/asset_v2/Template/icons/cancel.svg") }} alt="" class="btn-icon-modal"
                                                      width="12" height="12"><span>CANCEL</span>
                                              </button>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>

                  </div>
              </div>
          </div>
      </div>
  </div>
</div>

