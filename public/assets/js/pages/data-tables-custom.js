var orientation = '';
var count = 0;
$("table").find('thead tr th').each(function () {
    count++;
});
if (count > 6) {
    orientation = 'landscape';
} else {
    orientation = 'portrait';
}

let table = $('#main-datatable').resize().DataTable({
    dom: 'Blfrtip',
    searching: false,
    lengthChange: false,
    paging: false,
    buttons: [
        {
            extend: 'copy',
            className : 'btn btn-primary mb-2 text-start m-1',
            text: '<i class="fa fa-copy"></i> Copy'
        },
        {
            extend: 'excel',
            orientation: orientation,
            className : 'btn btn-primary mb-2 float-right text-start m-1',
            text: '<i class="fa fa-file-excel"></i> Excel'
        },
        // {
        //     extend: 'pdf',
        //     className : 'btn btn-primary mb-2',
        //     text: '<i class="fas fa-file-pdf-o"></i>'
        // },
        {
            extend: 'print',
            orientation: orientation,
            className : 'btn btn-primary mb-2 float-right text-start  m-1',
            text: '<i class="fa fa-print"></i> print'
        },
    ],
    "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
    "pageLength": 9000,
    "sScrollY": "100%",
    "sScrollX": "100%",
});