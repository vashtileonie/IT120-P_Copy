<div class="modal fade" id="view-image-modal" tabindex="-1" aria-labelledby="view-image-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="view-image-label">Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <img src="" class="img-fluid">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(() => {
    $('#view-image-modal').on('show.bs.modal', function (e) {
        let target = $(e.relatedTarget);
        $('#view-image-modal').find('img').attr('src', target.data('src'));
    });
});
</script>