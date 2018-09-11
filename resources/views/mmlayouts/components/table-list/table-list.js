//Init datatables
$(document).ready(function() {
    $.fn.dataTable.moment( 'DD/MM/YYYY' );
        $('table[id^=table-list]').DataTable();
});
   
// Highlight rows when license % => 25
$('table[id^=table-list]').dataTable( {
	'rowCallback': function( row, data, dataIndex ) {
        if (parseFloat($(row).find('#td-licence-usage span').text()) >= '25' ) {        
             $(row).addClass('highlight');    
        }
    },
    // page length of 10
    "order": [],
    "pageLength": 10,
    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
    "columnDefs": [ {
      "targets"  : 'no-sort',
      "orderable": false,
    }]
});


//Enable tooltips on icons
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});