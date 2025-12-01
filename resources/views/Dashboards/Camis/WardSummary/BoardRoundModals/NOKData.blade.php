<div class="text-red">
    <p class="p-2">If this data is not accurate then please update this in CAMIS.
        Thanks!</p>
</div>
<div class="row mb-3">
    <div>
        <ul class="bg-ul-grey">
            <li>Name</li>
            <li>{{ $patient_nok->nok_name }}</li>
        </ul>
        <ul>
            <li>Address</li>
            <li>{{ $patient_nok->nok_address }}</li>
        </ul>
        <ul class="bg-ul-grey">
            <li>Home Telephone Number</li>
            <li>{{ $patient_nok->hometelnumber }}</li>
        </ul>
        <ul>
            <li>Work Telephone Number</li>
            <li>{{ $patient_nok->worktelnumber }}</li>
        </ul>
    </div>
</div>
