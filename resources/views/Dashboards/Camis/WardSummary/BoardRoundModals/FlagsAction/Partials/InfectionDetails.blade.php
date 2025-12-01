
@if(count($result_data) < 1)
<div class="card-infection-data clone-me ">
    <div class="header-chart">
        <h6 class="title">Infection Risk List</h6>
        <div class="section-buttons">
            <div class="primary-btn" id="primaryInfectionButton">
                <button class="btn btn-primary-grey me-2 make_primary_infection active"><img
                        src="{{ asset('asset_v2/Template/icons/tick-circle.svg') }}" alt="" class="ms-3" width="16"
                        height="16">Primary
                    Infection</button>
            </div>
            <button class="btn btn-primary-grey infection_risk_delete"><i
                    class="bi bi-trash3-fill me-2"></i>Delete</button>
        </div>
    </div>
    <div class="data-section">
        <div class="row g-2">
            <div class="col-lg-3 col-md-6">
                <button type="button" class="btn btn-primary-grey infection_risk_button">QUERY</button>
            </div>
            <div class="col-lg-3 col-md-6">
                <button type="button" class="btn btn-primary-grey infection_risk_button">CONFIRMED</button>
            </div>
            <div class="col-lg-3 col-md-6">
                <button type="button" class="btn btn-primary-grey infection_risk_button">RESOLVED</button>
            </div>
            <div class="col-lg-3 col-md-6">
                <button type="button" class="btn btn-primary-grey infection_risk_button">CAN STAY IN
                    BAY</button>
            </div>
        </div>
        <div class="row gx-2 mt-2">
            <div class="col-md-6">
                <label for="exampleFormControlTextarea1" class="form-label">Infection
                    Risk</label>
            <select class="form-select ic_id" aria-label="Default select example">
                <option value="">Select Infection Risk</option>
                @if (!empty($success_array['infection_control']))
                    @foreach ($success_array['infection_control'] as $row)
                        <option value="{{ $row->id }}" data-infection-name="{{ $row->infection_list_show_data_name }}">{{ $row->infection_list_show_data_name }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="col-md-6">
            <label for="exampleFormControlTextarea1" class="form-label">Next Review
                Date</label>
            <input type="text" class="form-control ic_date" placeholder="Select date">
        </div>
        </div>
    </div>
</div>
@else
@foreach($result_data as $ic_data)

<div class="card-infection-data clone-me ">
    <div class="header-chart">
        <h6 class="title">Infection Risk List</h6>
        <div class="section-buttons">
            <div class="primary-btn" id="primaryInfectionButton">
                <button class="btn btn-primary-grey me-2 make_primary_infection @if($ic_data['is_primary'] == 'true') active @endif"><img
                        src="{{ asset('asset_v2/Template/icons/tick-circle.svg') }}" alt="" class="ms-3" width="16"
                        height="16">Primary
                    Infection</button>
            </div>
            <button class="btn btn-primary-grey infection_risk_delete"><i
                    class="bi bi-trash3-fill me-2"></i>Delete</button>
        </div>
    </div>
    <div class="data-section">
        <div class="row g-2">
            <div class="col-lg-3 col-md-6">
                <button type="button" class="btn btn-primary-grey infection_risk_button @if($ic_data['infection_type'] == 'QUERY') active @endif">QUERY</button>
            </div>
            <div class="col-lg-3 col-md-6">
                <button type="button" class="btn btn-primary-grey infection_risk_button @if($ic_data['infection_type'] == 'CONFIRMED') active @endif">CONFIRMED</button>
            </div>
            <div class="col-lg-3 col-md-6">
                <button type="button" class="btn btn-primary-grey infection_risk_button @if($ic_data['infection_type'] == 'RESOLVED') active @endif">RESOLVED</button>
            </div>
            <div class="col-lg-3 col-md-6">
                <button type="button" class="btn btn-primary-grey infection_risk_button @if($ic_data['infection_type'] == 'CANSTAYINBAY') active @endif">CAN STAY IN
                    BAY</button>
            </div>
        </div>
        <div class="row gx-2 mt-3">
            <div class="col-md-6">
                <label for="exampleFormControlTextarea1" class="form-label">Infection
                    Risk</label>
                <select class="form-select ic_id" aria-label="Default select example">
                    <option value="">Select Infection Risk</option>
                    @if (!empty($success_array['infection_control']))
                        @foreach ($success_array['infection_control'] as $row)
                            <option value="{{ $row->id }}" data-infection-name="{{ $row->infection_list_show_data_name }}" @if($ic_data['infection_id'] == $row->id) selected @endif>{{ $row->infection_list_show_data_name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="col-md-6">
                <label for="exampleFormControlTextarea1" class="form-label">Next Review
                    Date</label>
                <input type="text" class="form-control ic_date" placeholder="Select date" @if(isset($ic_data['next_review_date']) && !is_null($ic_data['next_review_date']) && !empty($ic_data['next_review_date'])) value="{{ $ic_data['next_review_date'] }}" @endif>
            </div>
        </div>
    </div>
</div>
@endforeach
@endif
