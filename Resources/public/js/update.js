jQuery(document).ready(function(){
	var tabs = jQuery('.form-tabs');
	var type = jQuery('#neutron_page_block_general_type');
	
	if(type.val() != 'type.sortable'){
		tabs.tabs("option","disabled",[1]);
	}
	
	type.change(function(){
		if(type.val() == 'type.sortable'){ 
			tabs.tabs("option","disabled",[]);
		} else {
			tabs.tabs("option","disabled",[1]);
		}
	});
	
});