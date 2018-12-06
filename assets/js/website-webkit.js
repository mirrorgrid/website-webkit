/**
 * Created by Nepsrock on 2018-11-28.
 */

var mww_website_ids_global_object = {"ajax_url":"http://localhost/wordpress/wp-admin/admin-ajax.php"};
$ = jQuery;
function mww_activate (moduleId,nonce,thisObj) {
    debugger;
    $.ajax({
        url: ajaxurl,
        type: 'POST',
        data: {action: 'activate', module_id: moduleId,security:nonce},
        beforeSend: function () {
            $(thisObj).text('Activating...');
            $(thisObj).attr('disabled','true');
            $(thisObj).prepend('<i class="mww_loader dashicons dashicons-update"></i>');



        },
        success: function (response) {
            $(thisObj).css('display', 'none');
            $(thisObj).closest('div').find('.deactivate').removeAttr('style');
            $(thisObj).html('Activate');
            $(thisObj).removeAttr('disabled');
            $(thisObj).find('.mww_loader').hide();
        }
    });
}


function mww_deactivate (moduleId,nonce,thisObj) {
    $.ajax({
        url: ajaxurl,
        type: 'POST',
        data: {action: 'deactivate', module_id: moduleId,security:nonce},
        beforeSend: function () {
            $(thisObj).html('Deactivating...');
            $(thisObj).attr('disabled','true');
            $(thisObj).prepend('<i class="mww_loader dashicons dashicons-update"></i>');
        },
        success: function (response) {
            $(thisObj).css('display', 'none');
            $(thisObj).closest('div').find('.activate').removeAttr('style');
            $(thisObj).html('Deactivate');
            $(thisObj).removeAttr('disabled');
            $(thisObj).prev().prev('.mww_loader').hide();
        }
    });
}


$(document).ready(function() {
    $(".select2-class").select2({
        width: 'resolve',
        placeholder: "Select a custom type",
    });
});