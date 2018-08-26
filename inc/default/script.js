var table;

$(function() {

    // Table setup
    // Setting datatable defaults
    $.extend( $.fn.dataTable.defaults, {

        autoWidth: false,
        columnDefs: [{
            orderable: false,
            //width: '100px',
            //targets: [ 5 ]
        }],
        dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
        drawCallback: function (parametro) {
            //console.log('_iDisplayStart: '+parametro._iDisplayStart);
            //console.log(parametro);
            //_iDisplayStart
            //_iDisplayLength
            //aaSorting (array)
            setStyleDatatable();
            $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
        },
        preDrawCallback: function() {
            //console.log(parametro);
            $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
        }
    });


    //https://datatables.net/manual/server-side
    // ------------------------------
    // displayStart

    // AJAX sourced data
    table = $('.datatable-ajax').DataTable({// DataTable vs dataTable
        language: {
            url: "assets/js/plugins/tables/datatables/local/pt_br.json"
        },
        ajax: {
            url: 'inc/default/json.php',
            type: 'POST',
            data: {
                "mnu":  getParameterByName('mnu')
            }
        },
        serverSide: true,
        processing: true,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
        pages: 5,

        columnDefs: [{
            targets: 4,
            data: null,
            render: function ( data, type, row ) {
                var label = (data[4]=="A")?"Ativo":"Inativo";
                var classe = (data[4]=="A")?"success":"default";
                return "<label class='label label-"+classe+"'>"+label+"</label>";
                //return data +' ('+ row[3]+')';
            }
        },
        {
            targets: 5,
            data: null,
            defaultContent: "<button class='btn btn-default'><i class='icon-pencil5'></i>&nbsp;Editar</button>"
        },
        {
            orderable: false,
            targets: [0, 2]
        }],
        columns: [
            {data: "0"},
            {data: "1", name: "cdd_nome"},
            {data: "2"},
            {data: "3"},
            {data: null},
            {data: null}
        ]
    });



    $('.datatable-ajax tbody').on('click', 'button', function () {
        var data = table.row($(this).parents('tr')).data();
        //console.log(data);
        $('#div_lista').hide();
        $('#div_form').html('<i class="spinner icon-spinner"></i> Carregando...');
        $('#div_form').show();
        $('#div_form').load('inc/default/frm.php?ajax=on&act=frm&id='+data[0]+'&mnu='+getParameterByName('mnu'), function() {
            //alert(data[0] +" id editar "+ data[ 2 ]);
        });
    });

});

function setStyleDatatable(){

    $('.dataTables_filter input[type=search]').attr('placeholder','Buscar...');
    //$('.dataTables_filter input[type=search]').addClass('form-control');
    $('.dataTables_length select').select2({
            minimumResultsForSearch: Infinity,
            width: 'auto'
    });
}

function reloadTable(){
    table.ajax.reload(null, false);
}//fnc