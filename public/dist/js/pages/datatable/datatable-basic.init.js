/*************************************************************************************/
// -->Template Name: Bootstrap Press Admin
// -->Author: Themedesigner
// -->Email: niravjoshi87@gmail.com
// -->File: datatable_basic_init
/*************************************************************************************/

/****************************************
 *       Basic Table                   *
 ****************************************/
$('#zero_config').DataTable({
    "columnDefs": [{
        "orderable": false,
        "targets": -1
    }],
    "processing": true,
    "serverside": true,
    // "lengthChange": false,
    // "buttons": ['copy', 'excel', 'pdf', 'colvis'],
    "drawCallback": function() {
        var bool = 1
        var path = location.pathname

        $('tbody>tr').hover(function () {
            var id = $(this).attr('data-id')
            var select = $(this).attr('data-select')
            
            $('form>button', this).addClass('white-text').removeClass('materialize-red-text')
            $(this).addClass('blue white-text')
            
            if (select == id) 
                $(this).addClass('blue white-text')
        }, function () {
            var id = $(this).attr('data-id')
            var select = $(this).attr('data-select')

            $('form>button', this).addClass('materialize-red-text').removeClass('white-text')
            $(this).removeClass('blue white-text')

            if (select == id) 
                $(this).addClass('blue white-text')
        })

        $('td#no-data').on('click', function() {
            bool = 0
        })

        $('tr#data').click(function () {
            var id = $(this).attr('data-id')

            if (bool) location = path+'/'+id+'/edit' 
            bool = 1
        })

        $('tr#show').click(function () {
            var id = $(this).attr('data-id')

            if (bool) location = path+'/'+id
            bool = 1
        })

        $('tr#data_select').click(function () {
            var id = $(this).attr('data-id')
            var select = $(this).attr('data-select')

            $.ajax({
                url: '/api/siswa/'+id,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if(response != null) {
                        $('tr#data_select').attr('data-select', null)
                        $('tr[data-id='+id+']').attr('data-select', response.data.student.id)
                        $('#student').val(id)
                        $('#nis').val(response.data.student.nis)
                        $('#full_name').val(response.data.student.full_name)
                        $('#clas').val(response.data.claz.name)
                    }
                }
            })

            $('tbody>tr').removeClass('blue white-text')
            if (select == id) {
                $(this).addClass('blue white-text')
            } 
        })
    }
});

/****************************************
 *       Default Order Table           *
 ****************************************/
$('#default_order').DataTable({
    "order": [
        [3, "desc"]
    ]
});

/****************************************
 *       Multi-column Order Table      *
 ****************************************/
$('#multi_col_order').DataTable({
    columnDefs: [{
        targets: [0],
        orderData: [0, 1]
    }, {
        targets: [1],
        orderData: [1, 0]
    }, {
        targets: [4],
        orderData: [4, 0]
    }]
});

/****************************************
 *       Complex header Table          *
 ****************************************/
$('#complex_header').DataTable();

/****************************************
 *       DOM positioning Table         *
 ****************************************/
$('#DOM_pos').DataTable({
    "dom": '<"top"i>rt<"bottom"flp><"clear">'
});

/****************************************
 *     alternative pagination Table    *
 ****************************************/
$('#alt_pagination').DataTable({
    "pagingType": "full_numbers"
});

/****************************************
 *     vertical scroll Table    *
 ****************************************/
$('#scroll_ver').DataTable({
    "scrollY": "300px",
    "scrollCollapse": true,
    "paging": false
});

/****************************************
 * vertical scroll,dynamic height Table *
 ****************************************/
$('#scroll_ver_dynamic_hei').DataTable({
    scrollY: '50vh',
    scrollCollapse: true,
    paging: false
});

/****************************************
 *     horizontal scroll Table    *
 ****************************************/
$('#scroll_hor').DataTable({
    "scrollX": true
});

/****************************************
 * vertical & horizontal scroll Table  *
 ****************************************/
$('#scroll_ver_hor').DataTable({
    "scrollY": 300,
    "scrollX": true
});

/****************************************
 * Language - Comma decimal place Table  *
 ****************************************/
$('#lang_comma_deci').DataTable({
    "language": {
        "decimal": ",",
        "thousands": "."
    }
});

/****************************************
 *         Language options Table      *
 ****************************************/
$('#lang_opt').DataTable({
    "language": {
        "lengthMenu": "Display _MENU_ records per page",
        "zeroRecords": "Nothing found - sorry",
        "info": "Showing page _PAGE_ of _PAGES_",
        "infoEmpty": "No records available",
        "infoFiltered": "(filtered from _MAX_ total records)"
    }
});