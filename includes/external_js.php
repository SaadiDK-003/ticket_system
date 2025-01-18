<!-- JQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<!-- Bootstrap 5 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<!-- Select 2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- DataTable -->
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>

<script>
    // Success Toast
    const toastS = document.querySelector('.toast-success');
    const toastSuccess = bootstrap.Toast.getOrCreateInstance(toastS);

    // Danger Toast
    const toastD = document.querySelector('.toast-danger');
    const toastDanger = bootstrap.Toast.getOrCreateInstance(toastD);

    // ToolTips
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

    $(document).ready(function() {
        $(document).on("click", "#open-mobile-nav", function(e) {
            $(".mobile-nav-container").addClass("active");
        });
        $(document).on("click", "#close-mobile-nav", function(e) {
            $(".mobile-nav-container").removeClass("active");
        });
    });
</script>