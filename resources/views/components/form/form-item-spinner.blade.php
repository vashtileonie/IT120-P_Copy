@props([
    'inline' => false
])

<div class="@if(! $inline) col-sm-9 @else mr-3 @endif">
    <div class="form-control d-flex justify-content-center">
        <div class="spinner-grow text-secondary mx-1 spinner-grow-sm my-auto" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <div class="spinner-grow text-secondary mx-1 spinner-grow-sm my-auto" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <div class="spinner-grow text-secondary mx-1 spinner-grow-sm my-auto" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
</div>