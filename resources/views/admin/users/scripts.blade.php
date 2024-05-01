<script>
$(document).ready(function () {
    $(document).on('change', '#role_id', function () {
        if ($(this).val() == 1) {
            $('#account_type, #account_id').removeAttr('required');
            $('#account_type, #account_id').closest('div.form-group').hide();
        } else {
            $('#account_type, #account_id').attr('required', 'required');
            $('#account_type, #account_id').closest('div.form-group').show();
        }
    });

    if ($('#role_id').val().length) {
        $('#role_id').trigger('change');
    }
    console.log(1);
});
</script>