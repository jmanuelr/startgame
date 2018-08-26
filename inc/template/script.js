$(function() {



    // Default initialization
    $('.wysihtml5-default').wysihtml5({
        parserRules:  wysihtml5ParserRules,
        stylesheets: ["assets/css/components.css"]

    });


	// Editor events
    /*
    $('.wysihtml5-init').on('click', function() {
        $(this).off('click').addClass('disabled');
        $('.wysihtml5-events').wysihtml5({
            parserRules:  wysihtml5ParserRules,
            stylesheets: ["assets/css/components.css"],
            events: {
                load: function() {
                    $.jGrowl('Editor has been loaded.', { theme: 'bg-slate-700', header: 'WYSIHTML5 loaded' });
                },
                change_view: function() {
                    $.jGrowl('Editor view mode has been changed.', { theme: 'bg-slate-700', header: 'View mode' });
                }
            }
        });
    });
    */


    // Style form components
    //$('.styled').uniform();
});