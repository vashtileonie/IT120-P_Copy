@props([
    'type' => 'error'
    ,'id' => ''
])

<div role="alert"
        {{ 
            $attributes->class([
                'alert-danger' => $type === 'error'
                ,'alert-info' => $type === 'info'
                ,'alert-primary' => $type == 'primary'
                ,'alert-success' => $type === 'success'
                ,'alert-warning' => $type === 'warning'
                ,'alert alert-dismissible fade show pt-2'
            ]) 
        }}
        id="{{ $id }}"
        >
    {{ $slot }}

    <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="padding: 0.3rem 1.25rem;">
        <span aria-hidden="true">&times;</span>
    </button>
</div>