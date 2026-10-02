<div data-control="toolbar loader-container">
    <button
        class="btn btn-primary"
        data-request="onRetryAllFailedJobs"
        data-request-confirm="<?= __("Are you sure?") ?>"
        data-list-checked-request
        >
        <i class="icon-refresh"></i>
        <?= __("initbiz.initdry::lang.failed_jobs.retry_all") ?>
    </button>

    <button
        class="btn btn-primary"
        data-request="onRetrySelectedFailedJobs"
        data-request-confirm="<?= __("Are you sure?") ?>"
        data-list-checked-trigger
        data-list-checked-request
        disabled>
        <i class="icon-refresh"></i>
        <?= __("initbiz.initdry::lang.failed_jobs.retry_selected") ?>
    </button>

    <div class="toolbar-divider"></div>

    <button
        class="btn btn-secondary"
        data-request="onDelete"
        data-request-message="<?= __("Deleting...") ?>"
        data-request-confirm="<?= __("Are you sure?") ?>"
        data-list-checked-trigger
        data-list-checked-request
        disabled>
        <i class="icon-delete"></i>
        <?= __("Delete") ?>
    </button>
</div>
