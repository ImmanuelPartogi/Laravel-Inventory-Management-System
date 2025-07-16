$(document).ready(function() {
    // Toggle sidebar
    $('#sidebarCollapse').on('click', function() {
        $('#sidebar').toggleClass('active');
    });

    // Auto-hide alert messages after 5 seconds
    $('.alert').delay(5000).fadeOut(500);

    // DataTable initialization (if needed)
    if ($.fn.DataTable) {
        $('.datatable').DataTable({
            responsive: true
        });
    }

    // Bootstrap tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
});
