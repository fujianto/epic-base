jQuery(document).ready(function ($) {
    function updateColorPickers(){
      $('#widgets-right .wp-color-picker').each(function(){
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
          palettes: ['#ffffff','#000000','#ff7c0b']
        });
      }); 
    }

    updateColorPickers(); 

     var _custom_media = true,
        _orig_send_attachment = wp.media.editor.send.attachment;

    function uploadImage(){
      $('.uploadSingleImage').click(function (e) {
          e.preventDefault();
          var theTarget = jQuery(this).attr('data-target');

          var custom_uploader = wp.media({
              title: 'Get Image',
              button: {
                  text: 'Use Image'
              },
              multiple: false // Set this to true to allow multiple files to be selected
          })
              .on('select', function () {
              var attachment = custom_uploader.state().get('selection').first().toJSON();

              jQuery('#' + theTarget).val(attachment.id);
              var divTarget = '#uploadImage-' + theTarget;

              if (jQuery(divTarget + ' img').length) {
                  jQuery(divTarget + ' img').attr('src', attachment.url);
                  jQuery('.image-url').val(attachment.url);
              } else {
                  jQuery(divTarget).append("<img src='" + attachment.url + "' alt='thumb' title='thumb' />");
              }
          })
              .open();
      });
    }

    function removeImage(){
      $('.clearSingleImage').click(function (e) {
          e.preventDefault();
          var theTarget = jQuery(this).attr('data-target');
          var placeImg = jQuery('.thumb-preview').data('placeimg');

          confirmed = confirm("Are you sure want to remove the image?");

          if (confirmed) {
              jQuery('.thumb-preview').attr('src', placeImg);
              jQuery('.image-url').val('');
              jQuery('.value-hidden').val('');
          }
      });
    }
});