<button 
    id="import-button"
    class="@if(isset($customClasses)) {{ $customClasses }} @else 'btn btn-primary' @endif">
    <i class="fas fa-file-import fa-sm text-white-50"></i> {{ $text }}
</button>

<form id="import-form" class="d-none" action="{{ $url }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <input id="file-input" type="file" name="file" class="d-none">

    <button
        type="submit"
        class="@if(isset($customClasses)) {{ $customClasses }} @else 'btn btn-primary' @endif">
    </button>
</form>

<script>
    $(document).ready(function() {
        $('#import-button').click(function() {
            $('#file-input').trigger('click');
        });

        $('#file-input').on('change', function() {
            var $this = $(this);

            if ($this[0].files.length) {
                // needed in case the button component gets passed a d-inline-block custom class
                $('#import-button').attr('style', 'display: none !important;');
                var filename = $this[0].files[0].name;
                $('#import-form button[type=submit]').html(
                    '<i class="fas fa-file-import fa-sm text-white-50"></i> Start Import: ' + filename
                );
                $('#import-form').removeClass('d-none');
            }
        });
    });
</script>