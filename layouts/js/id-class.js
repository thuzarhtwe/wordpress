/**
 * id-class.js
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

 (function($) {
 	// Site title and description.
    $('#id-submit').on('click', function() {
        var masthead = $('#id-masthead').val(),
            colophon = $('#id-colophon').val(),
            secondary = $('#id-secondary').val();
            $.ajax({
             type: 'POST',
             url: ajaxurl,
             data: {
               'action' : 'header_save_postdata',
               'ajax_masthead': masthead,
               'ajax_colophon': colophon,
               'ajax_secondary': secondary
            },
            success: function(response) {
            }
        });
        return false;
 	});
 })(jQuery);
