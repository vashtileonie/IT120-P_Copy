@props([
    'name'
    ,'id' => ''
    ,'inline' => true
    ,'label' => ''
    ,'placeholder' => ''
    ,'form_group_class' => ''
    ,'image' => ''
])

<x-form.form-group :name="$name" :label="$label" :$form_group_class :inline="$inline">
    @php
        if ($placeholder) { 
            $lbl = label($placeholder);
            $lbl = $lbl === 'labels.'.$placeholder ? str_replace('labels.','',$lbl) : $lbl;
        } else {
            $lbl = label($name);
        }

        $grid = 9;
        $is_file = false;
        if ($attributes['type'] == 'file'
            && ! empty($image)
        ) {
            $grid = 6;
            $is_file = true;
        }
    @endphp

    @if ($inline)
        <div class="col-sm-{{ $grid }}">
    @endif
        <input id="{{ $id ?? $name }}"
            name="{{ $name }}"
            value="{!! $attributes['type'] != 'password' ? (($attributes['value'] ?? false) ? old($name, $attributes['value']) : old($name)) : '' !!}"
            {{ 
                $attributes([
                    'class' => 'form-control'
                    ,'placeholder' => $lbl
                    ]) 
            }}
            >
    @if ($inline)
        </div>
    @endif

    @if ($is_file)
        @if($inline)
            <div class="col-sm-3">
        @endif
            <x-form.button-link name="view_image" icon="fa fa-eye" class="btn-block" data-toggle="modal" data-target="#viewImage{{ $name }}Modal" />
            <x-modal id="viewImage{{ $name }}Modal" title="view_image" alert="true">
                <div class="text-center">
                    <img src="{{ $image }}" class="img-fluid">
                </div>
            </x-modal>
        @if ($inline)
            </div>
        @endif
    @endif
</x-form.form-group>