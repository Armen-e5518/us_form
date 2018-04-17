$(document).ready(function () {

    var table = $('#form-data-table').DataTable({
        "pageLength": 10,
        "deferRender": true,
        dom: 'Bfrtip',
        "order": [[0, "desc"]],
        buttons: [
            'csv',
            'excel',
            {
                extend: 'pdf',
                text: 'PDF',
                exportOptions: {
                    modifier: {
                        columns: [0, 1, 2, 3, 4, 5],
                        page: 'current'
                    }

                },
                customize: function(doc) {
                    //pageMargins [left, top, right, bottom]
                    console.log(doc);
                    // doc.pageMargins = [ 150, 20, 150, 20 ];
                    doc.dataPadding = [ 150, 20, 150, 20 ];

                }
            }
        ],

    });

    $('#form-data-table thead th').each(function () {
        $(this).append('<input type="text" placeholder="Search" />');
    });

    table.columns().every(function () {
        var that = this;

        $('input', this.header()).on('keyup change', function () {
            if (that.search() !== this.value) {
                that
                    .search(this.value)
                    .draw();
            }
        });
    });


});

