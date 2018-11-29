/**
 * Created by Nepsrock on 2018-11-28.
 */
var mww_website_ids_global_object = {"ajax_url":"http://localhost/wordpress/wp-admin/admin-ajax.php"};
$ = jQuery;
function mww_activate (moduleId,thisObj) {
    $.post(ajaxurl,{
            'action': 'activate',
            'data':   {module_id:moduleId}
        },
        function(response){
            $(thisObj).css('display','none');
            $(thisObj).closest('div').find('.deactivate').removeAttr('style');
        }


    );
}


function mww_deactivate (moduleId,thisObj) {
    $.post(ajaxurl,{
            'action': 'deactivate',
            'data':   {module_id:moduleId}
        },
        function(response){
            $(thisObj).css('display','none');
            $(thisObj).closest('div').find('.activate').removeAttr('style');
        }
    );
}
