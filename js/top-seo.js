/**
 * top-seo.js
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

 (function($) {
   // Site title and description.
   $('#seo-submit').on('click', function() {
    var key = $('#seo-keywords').val();
    var desc = $('#seo-description').val();
    $.ajax({
     type: 'POST',
     url: ajaxurl,
     data: {
       'action' : 'topseo_save_postdata',
       'meta_keywords': key,
       'meta_description': desc,
     },
     success: function(response) {
     }
    });
    return false;
   });
 })(jQuery);
