@props([
    'column_class' => 'col-xl-3 col-md-6 mb-4'
    ,'border_left_class' => 'primary'
    ,'card_class' => 'card shadow h-100 py-2'
])
<div class="{{ $column_class }}">
    <div class="{{ $card_class }} border-left-{{ $border_left_class }} ">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>