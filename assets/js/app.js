
$(document).ready(function() {

  // Auto-dismiss flash alerts after 4 seconds
  setTimeout(function() {
    $('.alert-dismissible').fadeOut(600, function() {
      $(this).remove();
    });
  }, 4000);

  // Confirm before any delete link with data-confirm
  $(document).on('click', '[data-confirm]', function(e) {
    if (!confirm($(this).data('confirm'))) {
      e.preventDefault();
    }
  });

  // Tooltip init
  $('[data-toggle="tooltip"]').tooltip();

  // Highlight overdue follow-up rows
  $('table tbody tr').each(function() {
    var $td = $(this).find('td:nth-child(8)');
    if ($td.hasClass('text-danger')) {
      $(this).addClass('table-warning');
    }
  });

});