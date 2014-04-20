jQuery(document).ready(function($){
	
	var form_field;
    var upload_field_ID = '';
	
	
	$('#delete_thumb').click(function() {				
		var conf = confirm("Are you sure want to delete?");
		if (conf == false) {
		  return false
		}	
		$('#default_thumb_url').val('');		
		$('#default_thumb_id').val('');
		$('.button-primary').click();
	});
	
	$('#upload_default_thumb').click(function() {		
		upload_field_ID = jQuery(this).prev('input');
        form_field      = jQuery('#default_thumb_url').attr( 'name' );
		tb_show('Upload Thumb', 'media-upload.php?type=image&amp;TB_iframe=true&amp;post_id=0', false);
		return false;
	});
	
	window.send_to_editor = function(html) {

	 if (form_field) {
            var class_string    = jQuery( 'img', html ).attr( 'class' );
            var image_url       = jQuery( 'img', html ).attr( 'src' );
            var classes         = class_string.split( /\s+/ );
            var image_id        = 0;

            for ( var i = 0; i < classes.length; i++ ) {
                var source = classes[i].match(/wp-image-([0-9]+)/);
                if ( source && source.length > 1 ) {
                    image_id = parseInt( source[1] );
                }
            }
	 }
	 
		var image_url = $('img',html).attr('src');
		$('#default_thumb_url').val(image_url);
		$('#default_thumb_id').val(image_id);
		tb_remove();
		$('#uploaded_thumb_preview img').attr('src',image_url);
		get_thumbID(image_url);
 		$('.button-primary').click();
	}	
});

