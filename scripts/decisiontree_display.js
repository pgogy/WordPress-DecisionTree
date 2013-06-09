choices = Array();

function show_choice(id, ref, obj){
		
	if(choices[ref]!=undefined){
	
		jQuery(obj)
		.parent()
		.parent()
		.nextAll()
		.remove();
		
	}
	
	jQuery('#' + id)
		.clone()
		.appendTo('.choice');
	
	choices[ref] = id;
		
	jQuery(obj)
		.parent()
		.children()
		.each(
		
			function(index,value){
			
				jQuery(value)
					.css({ opacity: 0.25 });
			
			}
		
		);
		
	jQuery(obj)
		.css({ opacity: 1});

}