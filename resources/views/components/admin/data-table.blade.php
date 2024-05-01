@props([
    'route'
    ,'columns'
    ,'route_params' => []
    ,'title' => ''
    ,'title_params' => []
])

@if ($title)
    <h6 class="g-0 mx-0 mt-1 p-0 text-black-50 font-weight-bold">
        {{ label($title, $title_params) }}
    </h6>    
@endif

<div class="table-responsive">
    <table class="table table-bordered dataTable" 
            width="100%" cellspacing="0" 
            data-source="{{ navigateToLink($route, $route_params) }}"
            data-columns="{{ json_encode($columns, JSON_HEX_TAG) }}"
            {{ $attributes }}>
        <thead>
            <tr>
                {{ $slot }}
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>