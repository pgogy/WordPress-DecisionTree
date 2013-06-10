function create_data(){

	data = new Object;
	
	jQuery(".prompt")
		.each(
		
			function(index,value){
			
				set = new Object;
			
				set.id = jQuery(value).attr("id");
				
				set.name = jQuery(value)
					.children()
					.first()
					.next()
					.html();
					
				set.html = jQuery(value)
					.children()
					.first()
					.next()
					.next()
					.next()
					.next()
					.children()
					.last()
					.prev()
					.val();	
					
				set.colour = jQuery(value)
					.children()
					.first()
					.next()
					.next()
					.next()
					.children()
					.last()
					.children()
					.first()
					.val();	
				
				set.choices = Array();

				data[set.id]=set;
				
				
			}
		
		);		

	jQuery(".option")
		.each(
			
			function(index,value){
			
				set = data[jQuery(value)
						.parent()
						.parent()
						.parent()
						.parent()
						.parent()
						.attr("id")];
				
				set.choices.push(Array(
					jQuery(value)
					.children()
					.first()
					.next()
					.html(),
					
					jQuery(value)
					.next()
					.children()
					.last()
					.prev()
					.val()
				
					)
				);
				
				data[jQuery(value)
						.parent()
						.parent()
						.parent()
						.parent()
						.parent()
						.attr("id")] = set;
			
			}

		);
		
	if(data){
	
		jQuery("#data_save").val(JSON.stringify(data, null, 2));
		
		return true;
	
	}else{

		return false;
		
	}

}

function delete_prompt(obj){

	var del = confirm("Are you sure you want to delete");

	if(jQuery(".title").length!=1){

		if(del==true){

			obj.parentNode.remove();
			
		}
	
	}
	
	select_menus();

}

function delete_choice(obj){

	obj.parentNode.parentNode.remove();
	
}

function expand_choice(obj){
	
	jQuery(obj)
		.parent()
		.children()
		.each(
		
			function(index,value){
			
				if(value.tagName=="DIV"){
				
					jQuery(value)
						.toggleClass("hide",1);
				
				}
			
			}
		
		)

}

function choices_children(){

	return jQuery(".title").length;

}

function get_select_menu_options(){
	
	choices_store = Array("<option value='null'>Choose</option>");

	jQuery(".title")
		.each(
		
			function(index,value){
			
				choices_store.push("<option value='" + jQuery(value).parent().attr("id") + "'>" + (index+1) + ". " + jQuery(value).html() + "</option>");
			
			}
		
		);
		
	return choices_store.join("");

}

function select_menus(){

	choices_store = Array();

	jQuery(".title")
		.each(
		
			function(index,value){
		
				choices_store.push("<option value='" + index + "'>" + jQuery(value).html() + "</option>");
			
			}
		
		);
		
	selected = Array()	
		
	jQuery(".route option:selected")
		.each(
		
			function(index,value){
			
				selected.push(jQuery(value).val());
			
			}
		
		);	
		
	jQuery(".route").html(get_select_menu_options());
	
	if(choices_children()!=1){
	
		jQuery(".route")
			.each(
			
				function(index,value){
				
					jQuery(value).prop("disabled", false);
				
				}
			
			)
	
	}
	
	jQuery(".route")
		.each(
		
			function(index,value){

				selected_item = selected.shift();
			
				jQuery(value)
					.children()
					.each(
					
						function(index,value){
						
							if(jQuery(value).val()==selected_item){
							
								jQuery(value).prop("selected",true);
							
							}
						
						}
					
					);
			
			}
		
		);	
	
	
	
}

function edit_title(obj){

	jQuery(obj)
		.toggleClass("hide",1);
	
	jQuery(obj)
		.next()
		.toggleClass("hide",0)
		.toggleClass("show",1);
		
	jQuery(obj)
		.next()
		.children()
		.first()
		.val(jQuery(obj).html());	

}

function edit_option_title(obj){

	jQuery(obj)
		.toggleClass("hide",1);
	
	jQuery(obj)
		.parent()
		.next()
		.toggleClass("hide",0)
		.toggleClass("show",1);
		
	jQuery(obj)
		.parent()
		.next()
		.children()
		.first()
		.val(jQuery(obj).html());

}			
		
function save_text(obj){
			
	if(jQuery(obj).prev().val()!=""){
	
		jQuery(obj)
			.prev()
			.prev()
			.html(jQuery(obj).prev().val());
			
	}
		
	select_menus();	

}

function save_route_choice(obj){

	if(jQuery(obj).prev().prev().val()!=""){
	
		jQuery(obj)
			.parent()
			.parent()
			.children()
			.first()
			.children()
			.first()
			.next()
			.html(jQuery(obj).prev().prev().val());
	}
	
	jQuery(obj)
		.parent()
		.toggleClass("show",0)
		.toggleClass("hide",1);
		
	jQuery(obj)
		.parent()
		.parent()
		.children()
		.first()	
		.toggleClass("show",1);	

}

function save_option(obj){
			
	if(jQuery(obj).prev().val()!=""){
	
		name = jQuery(obj).prev().val();
		
	}else{
	
		name = "Option name"
	
	}
	
	jQuery(obj)
		.parent()
		.toggleClass("show",0)
		.toggleClass("hide",1);
		
	jQuery(obj)
		.parent()
		.parent()
		.children()
		.first()	
		.toggleClass("hide",0);	
		
	if(choices_children()!=1){
	
		state = "";
		get_children = true;

	}else{
	
		state = "disabled";
		get_children = false;
	
	}
		
	html = '<div><div class="option"><span onclick="javascript:left_choice(this)"><</span><p onclick="javascript:edit_option_title(this)">' + name + '</p><span onclick="javascript:right_choice(this)">></span><span onclick="javascript:delete_choice(this)">X</span></div><form class="option_form hide"><input type="text" value="" /><select class="route" ' + state + ' >';
	if(get_children){
		html += get_select_menu_options();
	}
	html += '</select><a onclick="javascript:save_route_choice(this)">Change</a></form></div>';	
		
	jQuery(obj)
		.parent()
		.parent()
		.children()
		.last()
		.append(html);

}

function move_up(obj){

	jQuery(obj)
		.parent()
		.parent()
		.insertBefore(obj.parentNode.parentNode.previousSibling);
	
	jQuery(".prompt")
		.each(
		
			function(index,value){
			
				jQuery(value).attr("id",index);
			
			}
		
		);

}

function move_down(obj){

	jQuery(obj)
		.parent()
		.parent()
		.insertAfter(obj.parentNode.parentNode.nextSibling);
		
	jQuery(".prompt")
		.each(
		
			function(index,value){
			
				jQuery(value).attr("id",index);
			
			}
		
		);	

}

function left_choice(obj){
	
	jQuery(obj)
		.parent()
		.parent()
		.insertBefore(obj.parentNode.parentNode.previousSibling);

}

function right_choice(obj){
	
	jQuery(obj)
		.parent()
		.parent()
		.insertAfter(obj.parentNode.parentNode.nextSibling);

}

function add_decision(){

	jQuery("#decisions")
		.children()
		.first()
		.clone()
		.appendTo("#decisions")
		.attr("id", parseInt(
					jQuery("#decisions")
						.children()
						.first()
						.attr("id")) + jQuery(".title").length);
	
	jQuery("#decisions")
		.children()
		.last()
		.children()
		.first()
		.next()
		.html("New Choice");

	jQuery("#decisions")
		.children()
		.last()
		.children()
		.last()
		.prev()
		.children()
		.last()
		.children()
		.last()
		.html("");
		
	select_menus();	

	jscolor.init();

}

window.addEventListener("load", function load(event){
		attach_form_action();
	}
);

function attach_form_action(){
	jQuery("#post")
		.on("submit", function(){
		
			return create_data();
		
		}
		
	);
}

function add_link_html(obj){

	href = jQuery(obj)
		.parent()
		.children()
		.first()
		.attr("href");
		
	html = jQuery(obj)
		.parent()
		.children()
		.first()
		.html();

	jQuery("#posthtml")
		.val("<a href='" + href + "'>" + html + "</a>");

}

function add_img_html(obj){

	jQuery("#imghtml")
		.val("<img src='" + obj.src + "' />");

}