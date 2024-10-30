jQuery(document).ready(function() {
	jQuery('.radiowidget').change(function() {
		if (this.value == '1')
		{
			jQuery('.userid').prop("disabled", false);
			jQuery('.list_widget').prop("disabled", false);
			jQuery('.profilewidget').show();
		}
		else if (this.value == '0')
		{
			jQuery('.userid').prop("disabled", true);
			jQuery('.list_widget').prop("disabled", true);
			jQuery('.profilewidget').hide();
		}
	});
});

jQuery(document).on('widget-updated', function(e, widget){
    jQuery('.radiowidget').change(function() {
		if (this.value == '1')
		{
			jQuery('.userid').prop("disabled", false);
			jQuery('.list_widget').prop("disabled", false);
			jQuery('.profilewidget').show();
		}
		else if (this.value == '0')
		{
			jQuery('.userid').prop("disabled", true);
			jQuery('.list_widget').prop("disabled", true);
			jQuery('.profilewidget').hide();
		}
	});
});

