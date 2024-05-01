<div class="form-group {{ $wrapper_class }}">
    <label for="brand_id">{{ trans('Brand:') }} &nbsp;</label>
    <select class="form-control" data-source="{{ $route }}" data-target="{{ $target }}" id="brand_id" name="brand_id" {{ $required_attr . $disabled_attr }}>
        <option value="">{{ trans('Select from list') }}</options>
        @foreach($brands as $brand)
            <option value="{{ $brand->id }}" @if(request('brand_id') == $brand->id || old('brand_id', $brand_id) == $brand->id) selected @endif>
                {{ $brand->name }}
            </option>
        @endforeach
    </select>
</div>