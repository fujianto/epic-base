 jQuery(document).ready(function($) {
     $('#createNewPage').click(function(e) 
     {
        e.preventDefault();
        var data = {
            action: 'process_createPage',
            nonce: myAjax.nonce
        };

        // $.post( myAjax.url, data, function( response ) 
        // {
        //     $('#txtAjaxPage').val( response.data );
        // });

        jQuery.ajax({
            url     :  myAjax.url,
            type    : "POST",
            data    : data,
            beforeSend  : function(){
                jQuery('<div class="xpiner"> <i class="fa fa-spinner fa-spin  fa-2x"></i> </div>').insertBefore('#txtAjaxPage');
            },
            success     : function(response) {
                $('#txtAjaxPage').val( response.data );
                jQuery('.xpinner').html(' ');
                jQuery('.xpinner').hide();
            }
        });

    });
});