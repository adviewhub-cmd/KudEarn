@props([
'title',
'value',
'icon',
'color'=>'primary',
'footer'=>null
])

<div class="col-xl-3 col-md-6 mb-4">

<div class="card-modern h-100 p-4">

<div class="d-flex justify-content-between align-items-center">

<div>

<div class="stat-title">

{{ $title }}

</div>

<div class="stat-value">

{{ $value }}

</div>

@if($footer)

<small class="text-muted">

{{ $footer }}

</small>

@endif

</div>

<div>

<i class="bi {{ $icon }} fs-1 text-{{ $color }}"></i>

</div>

</div>

</div>

</div>