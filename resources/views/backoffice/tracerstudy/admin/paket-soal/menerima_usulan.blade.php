@if($data->menerima_usulan == 1)
<div class="form-check form-switch d-flex justify-content-center align-items-center">
    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked>
</div>
@else
<div class="form-check form-switch d-flex justify-content-center align-items-center">
    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" >
</div>
@endif