

<div class="denied-login-modal modal fade" id="permission_modal" tabindex="-1" role="dialog" aria-hidden="true" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h6 class="modal-title" id="exampleModalLabel">Access Denied</h6>
                </div>
                <div>
                    <button type="button" class="btn-grey text-end w-100" onclick="CloseModalAndRemoveBackdrop();"> <img src="{{ asset('asset_v2/Template/icons/cancel.svg') }}" alt="" width="14" height="14" class="me-3">
                        CLOSE</button>
                </div>
            </div>
            <div class="modal-body">
                <div class="bg-login">
                    <div class="container">
                        <div class="row align-items-center">
                            <span class="login-logo p-b-49 d-none login_message" style="color: red;"></span>
                            <div class="col-xl-6 col-lg-6 offset-lg-3 offset-xl-3 ps-lg-0 pe-lg-0">


                                    <div class="d-md-none text-center mb-3">
                                        <img src="{{ asset('asset_v2/Template/images/iBox-Logo.svg') }}" alt=""
                                            class="img-fluid">
                                    </div>

                                    <div class="card-login">
                                        <div class="card-body pt-0">
                                            <div class="d-none d-md-block logo-section">
                                                <img src="{{ asset('asset_v2/Template/images/iBox-Logo_Name.svg') }}" alt="" class="img-logo">
                                            </div>
                                            <div class="d-md-flex align-items-center justify-content-between">
                                                <h6 class="fw-bold fs-6 pt-3">LOGIN</h6>
                                                <span>(Windows Credentials)</span>
                                            </div>
                                            <div class="mt-4">
                                                <div class="mb-3">
                                                    <label for="username"
                                                        class="form-label">USERNAME</label>

                                                    <input placeholder="" class="form-control " required="required"
                                                        autocomplete="off" id="username" name="username" type="text"
                                                        value="">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="password"
                                                        class="form-label">PASSWORD</label>
                                                    <input placeholder="" autocomplete="new-password"
                                                        class="form-control " required="required" id="password"
                                                        name="password" type="password" value="">

                                                </div>
                                                <div class="text-center d-none d-lg-block ">
                                                    <button class="btn btn-login w-100"
                                                        id="windows_to_show_load_prim_button_main"  onclick="ValidateLoginCredForm();">LOGIN</button>
                                                </div>
                                                <div class="text-center d-none d-lg-block">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center d-lg-none">
                                        <button class="btn btn-login" onclick="ValidateLoginCredForm();">LOGIN</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
