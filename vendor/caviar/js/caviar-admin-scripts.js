jQuery(document).ready(function ($) {
    function updateColorPickers(){
      $('.wp-color-picker').each(function(){
        $(this).wpColorPicker({
          // you can declare a default color here,
          // or in the data-default-color attribute on the input
          defaultColor: false,
          // a callback to fire whenever the color changes to a valid color
          change: function(event, ui){},
          // a callback to fire when the input is emptied or an invalid color
          clear: function() {},
          // hide the color picker controls on load
          hide: true,
          // show a group of common colors beneath the square
          // or, supply an array of colors to customize further
          palettes: ['#ffffff','#000000','#ff7c0b', '#ff1616']
        });
      }); 
    }

    function uploadImage() {
        $(document).on('click', '.uploadSingleImage', function (e) {
            e.preventDefault();
            var fieldId     = jQuery(this).data('parent');
            var theTarget   = jQuery(this).data('target');
            var theSize     = jQuery(this).data('size');
            console.log(fieldId == ""); console.log("fieldId");
            if (custom_uploader) {
                custom_uploader.open();
                return;
            }

            var custom_uploader = wp.media({
                title   : jQuery(this).data('uploader_title'),
                button  : {
                    text: jQuery(this).data('uploader_button_text')
                },
                    multiple: false  // Set this to true to allow multiple files to be selected
                })
            .on('select', function() {
                var attachment = custom_uploader.state().get('selection').first().toJSON();

                jQuery('#' + theTarget).val(attachment.id);

                if(fieldId == "" || !fieldId){
                    var divTarget   = 'img#image-' + theTarget;
                    var urlTarget   = '.image-url#imageUrl-' + theTarget;
                } else {
                    var divTarget   = '#caviar-'+fieldId+' img#image-' + theTarget;
                    var urlTarget   = '#caviar-'+fieldId+' .image-url#imageUrl-' + theTarget;
                }

                switch(theSize) {
                    case "icon"     :
                    case "small"    :   var theImage = attachment.sizes.thumbnail.url;
                    break;
                    case "medium"   :   var theImage = attachment.url;
                    break;
                    case "large"    :   var theImage = attachment.sizes.full.url
                    break;
                }
                
                jQuery(divTarget).attr('src',theImage);
                jQuery(urlTarget).attr('value',theImage);

            })
            .open();
        });
        
        $(document).on('change', '.image-url', function (e) {
            e.preventDefault();
            var fieldId = jQuery(this).data('parent');
            var theTarget = jQuery(this).attr('data-target');
            var placeImg = jQuery('.thumb-preview').data('placeimg');

            if(fieldId == "" || !fieldId){
                var divTarget   = 'img#image-' + theTarget;
                var urlTarget   = '.image-url#imageUrl-' + theTarget;
            } else {
                var divTarget   = '#caviar-'+fieldId+' img#image-' + theTarget;
                var urlTarget   = '#caviar-'+fieldId+' .image-url#imageUrl-' + theTarget;
            }

            jQuery(divTarget).attr('src', $(this).val());
        });
    }

    function removeImage(){
       
        $(document).on('click', '.clearSingleImage', function (e) {
            e.preventDefault();
            var fieldId = jQuery(this).data('parent');
            var theTarget = jQuery(this).attr('data-target');
            var placeImg = jQuery('.thumb-preview').data('placeimg');
            
            if(fieldId == "" || !fieldId){
                var divTarget   = 'img#image-' + theTarget;
                var urlTarget   = '.image-url#imageUrl-' + theTarget;
            } else {
                var divTarget   = '#caviar-'+fieldId+' img#image-' + theTarget;
                var urlTarget   = '#caviar-'+fieldId+' .image-url#imageUrl-' + theTarget;
            }

            confirmed = confirm("Are you sure want to remove the image?");
            
            if (confirmed) {
              jQuery(divTarget).attr('src', placeImg);
              jQuery(urlTarget).attr('value', '');
            }
        });
    }

    // // Delete a repeating section
    jQuery(document).on('click', '.deleteField', function(){
        $(this).closest('.repeatingSection').remove();

        return false;
    });
    
    function each_opt(options){
        var opt = new Array();
        var i = 0;
        $.each(options, function(index, key){
            opt[i] = "<option value='"+index+"'>"+key+"</option>";
            ++i;
        });

        return opt.join(' ');
    }

    function each_radio(name, options){
        var opt = new Array();
        var i = 0;
         $.each(options, function(index, key){
            opt[i] = "<input id='"+index+"' type='radio'name='"+name+"' value='"+index+"'/> <label class='radio-label' for='"+index+"'>"+key+"</label>";
            ++i;
        });
        return opt.join(" ");
    }

    function each_checkbox(name, options){
        var opt = new Array();
        var i = 0;
         $.each(options, function(index, key){
            opt[i] = "<input id='"+index+"' type='checkbox'name='"+name+"[]' value='"+index+"'/> <label class='radio-label' for='"+index+"'>"+key+"</label>";
            ++i;
        });
        return opt.join(" ");
    }

    function addField(){
        jQuery(document).on('click', '.addField', function(e) {
            e.preventDefault();
            var markup = new Array(); 
            var i         =  0;
            var parent    =  jQuery(this).parent().prev().data('id');
            var elId      =  '#caviar-'+jQuery(this).parent().prev().data('id');
            var fieldName =  jQuery(elId).data('name');
            var fieldId   =  jQuery(elId).data('id');
            var fieldnum  =  parseInt(jQuery(elId).find('.repeatingSection').length);
            var objFields =  jQuery(elId).data('fields');
            var arrHTML   =  new Array();
            
            // console.log(jQuery(elId).find('.repeatingSection').length);
            // console.log(jQuery(elId).attr('class'));
            // console.log(jQuery(elId).attr('data-name'));
            // console.log(jQuery(elId).data('id'));
            // console.log(parseInt(jQuery(elId).find('.repeatingSection').length));

            callAccordion();
            
            $.each(objFields, function(index, key){
                switch (key.type){
                    case 'text':
                        markup[i] = "<div class='widget-separator'> "+
                                        "<span class='control-label'>"+key.title+"</span> "+
                                        "<input type='text' name='"+fieldName+"["+(fieldnum)+"]["+index+"]' value='' class='widefat repeatedField'> "+
                                    "</div>";
                    break;

                    case 'textarea':
                        markup[i] = "<div class='widget-separator'> "+
                                        "<span class='control-label'>"+key['title']+"</span> "+
                                        "<textarea name='"+fieldName+"["+(fieldnum)+"]["+index+"]' class='widefat repeatedField' rows='5' cols='30'></textarea> "+
                                    "</div>";
                    break;

                    case 'select':
                        markup[i] = "<div class='widget-separator'> <span class='control-label'>"+key['title']+"</span> <select class='widefat repeatedField' name='"+fieldName+"["+(fieldnum)+"]["+index+"]'>"+each_opt(key['options']);+"</select> </div>";
                        break;
                    case 'radio':
                        markup[i] = "<div class='widget-separator'> <span class='control-label'>"+key['title']+"</span> <div class='radio-wrapper widefat'>"+each_radio(fieldName+"["+(fieldnum)+"]["+index+"]", key['options']);+"</div></div>";
                        break; 
                    case 'checkbox':
                        markup[i] = "<div class='widget-separator'> <span class='control-label'>"+key['title']+"</span> <div class='checkbox-wrapper widefat'>"+each_checkbox(fieldName+"["+(fieldnum)+"]["+index+"]", key['options']);+"</div></div>";
                        break; 
                    case 'upload':
                        markup[i] = 
                        "<div class='widget-separator'><span class='control-label'>"+key['title']+"</span> "+
                            "<div id='"+(fieldnum)+"' class='uploadImage upload-controls widefat'> "+
                                "<div class='upload-wrapper'>    "+
                                    "<figure class='upload-preview column'> "+
                                        "<section class='upload-button-group clearfix'><a class='button uploadSingleImage upImage-"+(fieldnum)+" u-pull-left' href='#' title='Upload' data-target='"+(fieldnum)+"' data-parent='"+parent+"' data-size='medium'><i class='fa fa-cloud-upload pr-small'></i> Upload</a><a class='button clearSingleImage "+(fieldnum)+" u-pull-left' href='#' title='Remove' data-parent='"+parent+"' data-target='"+(fieldnum)+"'><i class='fa fa-eraser pr-small'></i> Remove</a> "+
                                        "</section> "+
                                        "<img id='image-"+(fieldnum)+"' class='thumb-preview' src='' alt='thumby'> "+
                                    "</figure> "+
                                    "<div class='column'> "+
                                        "<input type='url' class='value-hidden image-url widefat mb-small repeatedField' id='imageUrl-"+(fieldnum)+"' name='"+fieldName+"["+(fieldnum)+"]["+index+"]' value='' data-target='"+(fieldnum)+"'> "+
                                    "</div> "+
                                "</div> "+
                            "</div> "+
                        "</div>";
                    break;

                    default:
                    break;
                } 

                ++i;
            });

            $(".dynamicAccordion-"+fieldId).append(
                '<div class="repeatingSection repeater_wrapper"> '+
                    '<label class="repeater-title control-label widefat" id="itemFeatures" for="itemFeatures">New Field</label> '+
                    '<div class="accordion-content">'+markup.join(" ")+'<a href="#" class="button button-secondary button-large deleteField">Delete</a></div> '+
                    '<input type="hidden" class="widefat repeaterOrder" value="'+parseInt(fieldnum)+'" /> '+
                    '<br /> <br /> '+
                '</div> ').accordion('refresh');

            fieldnum++;
        });
    }

    function callAccordion(){
        $( ".repeater-field" )
          .accordion({
            header: '> .repeatingSection > .repeater-title',
            active: false,
            collapsible: true,
            activate: function(event, ui) {
                 $( this ).accordion( "refresh" );
            }
          })
        .sortable({
            axis: "y",
            handle: ".repeater-title",
            placeholder: "ui-state-highlight",
            start: function(e, ui) {
                // creates a temporary attribute on the element with the old index
                $(this).attr('data-previndex', ui.item.index());
            },
            stop: function( event, ui ) {
              // IE doesn't register the blur when sorting
              // so trigger focusout handlers to remove .ui-state-focus
              ui.item.children( ".repeater-title" ).triggerHandler( "focusout" );

              // Refresh accordion to handle new order
              $( this ).accordion( "refresh" );
            },
            update: function(event, ui) {
                var newIndex = ui.item.index();
                var oldIndex = $(this).attr('data-previndex');
                
                $(this).removeAttr('data-previndex');

                $('.repeatingSection').each(function(index){
                    // $(this).data('id', index); // updates the data object
                    // $(this).attr('data-id', index); // updates the attribute
                    $(this).find('.repeaterOrder').val(index);
                });
            }
        });
    }

    updateColorPickers(); 
    uploadImage();
    removeImage();
    callAccordion();
    addField();
});