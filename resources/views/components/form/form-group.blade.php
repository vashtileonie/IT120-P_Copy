@props([
    'name'
    ,'inline' => true
    ,'label' => ''
    ,'form_group_class' => ''
])

<div class="form-group @if($inline) row mb-4 @endif {{ $form_group_class }}">
    @if ($label)
        @php
            $tool_tip = tool_tip($label);
        @endphp
        <label for="{{ $name }}" @if($inline) class="col-sm-3 col-form-label text-center" @endif>
            <x-tooltip label="{{ $label }}" key="{{ $name }}" />
        </label>
    @endif

    {{ $slot }}
</div>