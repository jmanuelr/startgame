/* ------------------------------------------------------------------------------
*
*  # Modal dialogs and extensions
*
*  Specific JS code additions for components_modals.html page
*
*  Version: 1.1
*  Latest update: Jul 5, 2016
*
* ---------------------------------------------------------------------------- */

$(function() {


    // Basic modals
    // ------------------------------

    // Load remote content
    $('#modal_remote').on('show.bs.modal', function(objeto) {
        console.log('tsk: '+$(objeto.relatedTarget).attr('tsk'));
        $(this).find('.modal-body').load('assets/demo_data/wizard/education.html', function() {

            // Init Select2 when loaded
            $('.select').select2({
                minimumResultsForSearch: Infinity
            });
        });
    });


    // Bootbox extension
    // ------------------------------


    // Custom bootbox dialog with form
    $('#bootbox_form').on('click', function() {
        bootbox.dialog({
                title: "This is a form in a modal.",
                message: '<div class="row">  ' +
                    '<div class="col-md-12">' +
                        '<form class="form-horizontal">' +
                            '<div class="form-group">' +
                                '<label class="col-md-4 control-label">Name</label>' +
                                '<div class="col-md-8">' +
                                    '<input id="name" name="name" type="text" placeholder="Your name" class="form-control">' +
                                    '<span class="help-block">Here goes your name</span>' +
                                '</div>' +
                            '</div>' +
                            '<div class="form-group">' +
                                '<label class="col-md-4 control-label">How awesome is this?</label>' +
                                '<div class="col-md-8">' +
                                    '<div class="radio">' +
                                        '<label>' +
                                            '<input type="radio" name="awesomeness" id="awesomeness-0" value="Really awesome" checked="checked">' +
                                            'Really awesomeness' +
                                        '</label>' +
                                    '</div>' +
                                    '<div class="radio">' +
                                        '<label>' +
                                            '<input type="radio" name="awesomeness" id="awesomeness-1" value="Super awesome">' +
                                            'Super awesome' +
                                        '</label>' +
                                    '</div>' +
                                '</div>' +
                            '</div>' +
                        '</form>' +
                    '</div>' +
                    '</div>',
                buttons: {
                    success: {
                        label: "Save",
                        className: "btn-success",
                        callback: function () {
                            var name = $('#name').val();
                            var answer = $("input[name='awesomeness']:checked").val()
                            bootbox.alert("Hello " + name + ". You've chosen <b>" + answer + "</b>");
                        }
                    }
                }
            }
        );
    });



});
