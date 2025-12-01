<div class="col-lg-12  ">
    <div class="row" id="covid19-wards">
        <div class="col-lg-4 col-md-6 pe-md-1">
            <div class="rectangle-block-1 mb-1">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="d-flex justify-content-between rectangle-block-2">
                            <p class="mb-0 fw-bold">Medical Wards</p>
                        </div>
                    </div>
                </div>
                @if (isset($success_array['medical_wards']) && count($success_array['medical_wards']) > 0)
                    @foreach ($success_array['medical_wards'] as $item)
                        <div class="{{$loop->odd ? "bg-white" : "bg-grey"}} p-2">
                            <div class="row align-items-center">
                                <div class="col-lg-6 col-md-6">
                                    <p class="mb-0">{{ $item['ward_name'] }}</p>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <select class="form-select w-100" aria-label="Default select example" name="infection_close_status" id="infection_close_status_{{ $item['id'] }}" onchange="SaveInfectionCloseStatus({{ $item['id'] }})">
                                        <option value="" disabled>Please choose</option>
                                        @if (count($success_array['ic_drop_list_arr'] )>0)
                                            @foreach ($success_array['ic_drop_list_arr']  as $key => $ic_drop)
                                                <option value="{{ $key }}" @if ($key == $item['infection_close_status']) selected @endif>{{ $ic_drop }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="col-lg-4 col-md-6 ps-md-1 pe-lg-1">
            @if (isset($success_array['assessment_wards']) && count($success_array['assessment_wards']) > 0)
                <div class="rectangle-block-1 mb-2 ">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="d-flex justify-content-between rectangle-block-2">
                                <p class="mb-0 fw-bold">Assessment Wards</p>
                            </div>
                        </div>
                    </div>

                    @foreach ($success_array['assessment_wards'] as $item)
                        <div class="{{$loop->odd ? "bg-grey" : "bg-white"}} p-2">
                            <div class="row align-items-center">
                                <div class="col-lg-6 col-md-6">
                                    <p class="mb-0">{{ $item['ward_name'] }}</p>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <select class="form-select w-100" aria-label="Default select example" name="infection_close_status" id="infection_close_status_{{ $item['id'] }}" onchange="SaveInfectionCloseStatus({{ $item['id'] }})">
                                        <option value="" disabled>Please choose</option>
                                        @if (count($success_array['ic_drop_list_arr'] )>0)
                                            @foreach ($success_array['ic_drop_list_arr']  as $key => $ic_drop)
                                                <option value="{{ $key }}" @if ($key == $item['infection_close_status']) selected @endif>{{ $ic_drop }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
            @if (isset($success_array['surgical_wards']) && count($success_array['surgical_wards']) > 0)
                <div class="rectangle-block-1 mb-1 ">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="d-flex justify-content-between rectangle-block-2">
                                <p class="mb-0 fw-bold">Surgical Wards</p>
                            </div>
                        </div>
                    </div>

                    @foreach ($success_array['surgical_wards'] as $item)
                        <div class="{{$loop->odd ? "bg-white" : "bg-grey"}} p-2">
                            <div class="row align-items-center">
                                <div class="col-lg-6 col-md-6">
                                    <p class="mb-0">{{ $item['ward_name'] }}</p>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <select class="form-select w-100" aria-label="Default select example" name="infection_close_status" id="infection_close_status_{{ $item['id'] }}" onchange="SaveInfectionCloseStatus({{ $item['id'] }})">
                                        <option value="" disabled>Please choose</option>
                                        @if (count($success_array['ic_drop_list_arr'] )>0)
                                            @foreach ($success_array['ic_drop_list_arr']  as $key => $ic_drop)
                                                <option value="{{ $key }}" @if ($key == $item['infection_close_status']) selected @endif>{{ $ic_drop }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        <div class="col-lg-4 ps-lg-1">
            <div class="rectangle-block-1 mb-1 ">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="d-flex justify-content-between rectangle-block-2">
                            <p class="mb-0 fw-bold">Other Wards</p>
                        </div>
                    </div>
                </div>
                @if (isset($success_array['other_wards']) && count($success_array['other_wards']) > 0)
                    @foreach ($success_array['other_wards'] as $item)
                        <div class="{{$loop->odd ? "bg-white" : "bg-grey"}} p-2">
                            <div class="row align-items-center">
                                <div class="col-lg-6 col-md-6">
                                    <p class="mb-0">{{ $item['ward_name'] }}</p>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <select class="form-select w-100" aria-label="Default select example" name="infection_close_status" id="infection_close_status_{{ $item['id'] }}" onchange="SaveInfectionCloseStatus({{ $item['id'] }})">
                                        <option value="" disabled>Please choose</option>
                                        @if (count($success_array['ic_drop_list_arr'] )>0)
                                            @foreach ($success_array['ic_drop_list_arr']  as $key => $ic_drop)
                                                <option value="{{ $key }}" @if ($key == $item['infection_close_status']) selected @endif>{{ $ic_drop }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

            </div>
        </div>
    </div>
</div>
