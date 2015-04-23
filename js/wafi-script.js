jQuery(document).ready(function(jQuery){
	
	var form_field;
    var upload_field_ID = '';
	
	
	jQuery('#delete_thumb').click(function() {				
		var conf = confirm("Are you sure want to delete?");
		if (conf == false) {
		  return false
		}	
		jQuery('#default_thumb_url').val('');		
		jQuery('#default_thumb_id').val('');
		jQuery('.button-primary').click();
	});
	
	jQuery('#upload_default_thumb').click(function() {		
		upload_field_ID = jQuery(this).prev('input');
        form_field      = jQuery('#default_thumb_url').attr( 'name' );
		tb_show('Upload Thumb', 'media-upload.php?referer=wp_afi&type=image&amp;TB_iframe=true&amp;post_id=0', false);
		return false;
	});
	
	window.send_to_editor = function(html) {

	 if (form_field) {
			var itemRS = jQuery(html);
			var image_url       = itemRS.attr( 'src' );
			
/*			var class_string = itemRS.attr('class');			
            var classes         = class_string.split( /\s+/ );
            var image_id        = 0;

            for ( var i = 0; i < classes.length; i++ ) {
                var source = classes[i].match(/wp-image-([0-9]+)/);
                if ( source && source.length > 1 ) {
                    image_id = parseInt( source[1] );
                }
            }*/
			var image_id = jQuery(html).data('id');
			
			
	 }
	 
		var image_url = jQuery('img',html).attr('src');
		jQuery('#default_thumb_url').val(image_url);
		jQuery('#default_thumb_id').val(image_id);
		tb_remove();
		jQuery('#uploaded_thumb_preview img').attr('src',image_url);
 		jQuery('.button-primary').click();
	}	
	
	
	jQuery('.cat_include').click(function(){
		jQuery('.cat_include').prop('checked',false);
		jQuery('.cat_include').prop('checked',true);
	});
});

