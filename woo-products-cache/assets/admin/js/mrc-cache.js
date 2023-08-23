var $ = jQuery.noConflict();
$(document).ready(function () {
    'use strict';




    /**
     * generating cache for products
     */
     $('.generate-gen-cache').on('click', function(){
        var _t = $(this);
        if ( _t.hasClass('sending') ) {
            return false; //for clickers
        }
        _t.addClass('sending');


        $('.cf-spinner-wrapper').show();
        var form_data = new FormData();
           
        $('.response-json p').remove();

        form_data.append('action', 'sch_products_cache');

        jQuery.ajax({
            url: mrc_obj.ajax_url,
            type: 'post',
            contentType: false,
            processData: false,
            data: form_data,
            success: function (response) {
                
                var obj = JSON.parse(response);
                if ( obj.status == 'failed' ) {
                    var p = $('<p />',{
                        'text' : 'Generation failed. Please contact admin'
                    }).appendTo('.response-json');
                    _t.removeClass('sending');
                    hide_spinner();
                    return false;
                }
                var p = $('<p />',{
                    'text' : 'Cache generated.'
                }).appendTo('.response-json');
                _t.removeClass('sending');
                hide_spinner();
                return false;
                
            },  
            error: function (response) {
                alert('An error occured. Cache could not be generated. Please contact admin');
            }

            
        });
        
        return false;
    });





});


function hide_spinner() {
    $('.cf-spinner-wrapper').hide();
}