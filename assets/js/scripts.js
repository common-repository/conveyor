// Override the onClose action of wpLink so the default diaglog close button works
wpLink.onClose = function () {
	wpLink.isMCE() || (jQuery('#conveyor_link_value').focus(), wpLink.range && (wpLink.range.moveToBookmark(wpLink.range.getBookmark()), wpLink.range.select()))
};

jQuery('.conveyor_link_btn').on('click', function(event) {
	
	wpActiveEditor = true;
	wpLink.open();
	return false;
});

jQuery('#wp-link-submit').on('click', function(event) {
		
	var linkAtts = wpLink.getAttrs();

	jQuery('#conveyor_link_value').val(linkAtts.href);

	if(linkAtts.target == '_blank')
	{
		jQuery('#conveyor_open_new_window_value').prop('checked', true);
	}
	else
	{
		jQuery('#conveyor_open_new_window_value').prop('checked', false);
	}
		
	wpLink.textarea = jQuery('#conveyor_link_value');
	wpLink.close();
		
	event.preventDefault ? event.preventDefault() : event.returnValue = false;
	event.stopPropagation();
	return false;
});

jQuery('#wp-link-cancel').on('click', function(event) {
	
	wpLink.textarea = jQuery('#conveyor_link_value');
	wpLink.close();
		
	event.preventDefault ? event.preventDefault() : event.returnValue = false;
	event.stopPropagation();
	return false;
});