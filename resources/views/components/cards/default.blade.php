@props([
    'name'
    ,'value'
    ,'icon'
    ,'border_left_class' => 'primary'
    ,'name_color' => 'primary'
])
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-{{ $border_left_class }} shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-{{ $name_color }} text-uppercase mb-1">{{ label($name) }}</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $value }}</div>
                </div>
                <div class="col-auto">
                    <i class="{{ $icon }} fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>