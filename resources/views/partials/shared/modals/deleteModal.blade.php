<div class="modal fade" id="deleteModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="delete-modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="delete_alert_div"></div>
            <div class="modal-body" id="delete-modal-body">
                {{ __('messages.delete_record_message') ?? 'Are you sure you want to delete this record?' }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    {{ __('lang.close') ?? 'Close' }}
                </button>
                <button type="button" href="#" class="btn btn-danger" id="submit_delete">
                    {{ __('lang.delete') ?? 'Delete' }}
                </button>
            </div>
        </div>
    </div>
</div>

