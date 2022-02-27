// Call the dataTables jQuery plugin
$(document).ready(function() {
  $('#dataTable').DataTable({
    "lengthMenu": [[50, 100, 250, 500, -1], [50, 100, 250, 500, "All"]],
    "iDisplayLength": 100,
  });
});
