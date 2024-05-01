@props([
    'message'
    ,'name' => 'formMsg'
    ,'type' => 'alert-success'
])

@if (session()->has($name))
    <div class="alert {{ $type }} alert-dismissible fade show form-msg" role="alert" {{ $attributes }}>
        <p>{{ session($name) }}</p>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <script>
        $(document).ready(function() {
            setTimeout(() => {
                $('.form-msg').alert('close');

                {{ session()->forget($name) }}
            }, {{ config('webtool.flash_msg_timeout') }});
        });
    </script>
@endif