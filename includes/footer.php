<footer>
    <h4 class="text-white text-center mb-0">&copy; <?= date('Y') ?>, <?= FOOTER_TEXT ?></h4>
</footer>

<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <!-- Toast Success -->
    <div id="ToastSuccess" class="toast toast-success align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body"></div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
    <!-- Toast Danger -->
    <div id="ToastDanger" class="toast toast-danger align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body"></div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>