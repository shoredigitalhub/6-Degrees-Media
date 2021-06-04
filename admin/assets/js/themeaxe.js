;
(function($){
	var axetarget = window.location.hash;

	$(document).ready(function(){
		themeaxe_manageSettingActiveTab();
		$('.handlediv').click(function(){
			var t = $(this);
			$(t.parent('.postbox')).toggleClass('close');
		});
		$('.selectallforcopy').on('click',function(e){
			e.preventDefault();
			e.stopPropagation();
			$(this).select();
		});
		$('.axesortme').sortable({'handle':'.axesorthandle'});
		$('.axeclosehandle').on('click',function(){
			if(confirm('Are you sure you want to proceed?')){
				var t = $(this);
				$(t.parent('.themeaxe-form-row ')).remove();
			}
		});
		$('.axethemetoggler').off('click').on('click',function(e){
			var t = $(this);
			e.preventDefault();
			e.stopPropagation();
			if(!t.hasClass('activeaxethemetoggler')){
				var d = t.attr('data'),
				a = $('a',t),
				href = a.attr('href');
				$('#activetabis').val(d);
				$('.axethemetoggle').removeClass('activeaxethemetoggle');
				$('#'+d).addClass('activeaxethemetoggle');
				$('.axethemetoggler').removeClass('activeaxethemetoggler');
				t.addClass('activeaxethemetoggler');
				stateObj = { axe: "pushed" };
				title = a.text();
				history.pushState(stateObj, title + " | Light AXe", href);
			}
		});
		$('#axeaddsocialmediabtn').click(function(){
			var htm = '<tr class="themeaxe-form-row axesortable ui-sortable">';
			htm += '<td align="center" class="axesorthandle">=</td>';
			htm += '<td><input type="text" placeholder="Title" name="socialmediatitle[]" required value="" /></td>';
			htm += '<td><input type="url" placeholder="Link" name="socialmedialink[]" required value="" /></td>';
			htm += '<td><input type="url" placeholder="Icon Link" class="themeaxemedialoader" name="socialmediaicon[]" value="" /></td>';
			htm += '<td><input type="text" placeholder="Class(es)" class="" name="socialmediaclasses[]" value="" /></td>';
			htm += '<td><select  class="" name="socialmediafontawesome[]"><option value="yes">Yes</option><option value="no" selected="selected">No</option></select></td>';
			htm += '<td><input type="text" placeholder="Item Class(es)" class="" name="socialmediaitemclasses[]" value="" /></td>';
			htm += '<td align="center" class="axeclosehandle">x</td>';
			htm += '</tr>';
			$('#axesocialgroup').append(htm);
		});
		$('#axeaddwidgetbtn').click(function(){
			var htm = '<tr class="themeaxe-form-row axesortable ui-sortable">';
			htm += '<td align="center" class="axesorthandle">=</td>';
			htm += '<td><input type="text" placeholder="Title" name="widgettitle[]" required value="" /></td>';
			htm += '<td><input type="text" placeholder="Id" name="widgetid[]" required value="" /></td>';
			htm += '<td><input type="text" placeholder="Class(es)" name="widgetclass[]" required value="" /></td>';
			htm += '<td align="center" width="20%"><input type="text" readonly value="[sidebox id=\'\' class=\'\']"/></td>';
			htm += '<td align="center" class="axeclosehandle">x</td>';
			htm += '</tr>';
			$('#axewidgetgroup').append(htm);
		});
		$('#axeaddgfontbtn').click(function(){
			var htm = '<tr class="themeaxe-form-row axesortable ui-sortable">';
			htm += '<td align="center" class="axesorthandle">=</td>';
			htm += '<td><input type="text" placeholder="Name" name="gfontname[]" required value="" /></td>';
			htm += '<td><input type="text" placeholder="Font Family" name="gfontfamily[]" required value="" /></td>';
			htm += '<td><input type="url" placeholder="Font Link" name="gfontlink[]" required value="" /></td>';
			htm += '<td><input type="text" placeholder="Fallback Font Family" name="gfontfallback[]" value="" /></td>';
			htm += '<td align="center" class="axeclosehandle">x</td>';
			htm += '</tr>';
			$('#axegfontgroup').append(htm);
		});
		$('.axeaddaftercontentbtn').click(function(){

			var t = $(this),
			p = t.parents('.axethemeadminwrapper'),
			type = t.attr('dtype') ? t.attr('dtype') : 'richtext',
			func_name = type.capitalize();
			type = '<input type="hidden" name="axe_after_content_type[]" value="'+type+'" />';
			if (typeof(window['axe_ContentType_' + func_name]) !== "function")
			{
				func_name = 'Richtext';
			}
			htm = '';

			htm += '<tr class="themeaxe-form-row axesortable ui-sortable">';
			htm += '<td align="center" class="">=</td>';
			htm += '<td>';
			htm += '<div class="editorblock">';

			if (typeof(window['axe_ContentType_' + func_name]) === "function")
			{
				htm += window['axe_ContentType_' + func_name](type);
			}
			else
			{
				console.log("Error.  Function " + func_name + " does not exist.");
			}

			htm += '</div>';
			htm += '</td>';
			htm += '<td align="center" class="axeclosehandle">x</td>';
			htm += '</tr>';
			$('#axeaftercontentgroup',p).append(htm);
			jscolor.init();
		});
		$('.axethemeadminwrapper tr td .editorshow').click(function(){
			$(this).next('.axemetaeditorblock').slideToggle();
		});
		$('.themeaxemedialoader').hover(function(){
			var s = $(this).val();
			if(s){
				s = '<div style="position:absolute;width:100px;height:100px;z-index:100"><img src="'+s+'" style="max-width:100px;max-height:100px;border:1px solid #cecece;padding:2px;background:#FFF;" /></div>';
				$('#themeimgpreview').append(s);
			}
		},function(){
			var t = $('#themeimgpreview div');
			if(t.length){
				t.remove();
			}
		});

		/*Uploading files*/
		var file_frame;
		var wp_media_post_id = wp.media.model.settings.post.id; /*// Store the old id*/
		var set_to_post_id = 10; /*// Set this*/
		var axet = null;

		$('.themeaxemedialoader').on('click', function( event ){
			axet =$(this);

			event.preventDefault();

			/*If the media frame already exists, reopen it.*/
			if ( file_frame ) {
				/*Set the post ID to what we want*/
				file_frame.uploader.uploader.param( 'post_id', set_to_post_id );
				/*Open frame*/
				file_frame.open();
				return;
			} else {
				/*Set the wp.media post id so the uploader grabs the ID we want when initialised*/
				wp.media.model.settings.post.id = set_to_post_id;
			}

			/*Create the media frame.*/
			file_frame = wp.media.frames.file_frame = wp.media({
				title: $( this ).data( 'uploader_title' ),
				button: {
					text: $( this ).data( 'uploader_button_text' ),
				},
				multiple: false  /*// Set to true to allow multiple files to be selected*/
			});

			/*When an image is selected, run a callback.*/
			file_frame.on( 'select', function() {
				/*We set multiple to false so only get one image from the uploader*/
				attachment = file_frame.state().get('selection').first().toJSON();

				/*Do something with attachment.id and/or attachment.url here*/
				axet.val(attachment.url);

				/*Restore the main post ID*/
				wp.media.model.settings.post.id = wp_media_post_id;
			});

			/*Finally, open the modal*/
			file_frame.open();
		});

		/*Restore the main ID when the add media button is pressed*/
		$('a.add_media').on('click', function() {
			/*axet = jQuery(this);*/
			wp.media.model.settings.post.id = wp_media_post_id;
		});


	});

function themeaxe_manageSettingActiveTab(){
	var t = $('.axesettingsblocks'),
	miactive = 'activeaxethemetoggler',
	biactive = 'activeaxethemetoggle';
	axetarget = axetarget.replace('#','');
	if(t.length && axetarget){
		$('#activetabis').val(axetarget);
		$('.axethemetoggler',t).removeClass(miactive);
		$('.axethemetoggler[data="'+axetarget+'"]',t).addClass(miactive);
		$('.axethemetoggle',t).removeClass(biactive);
		$('#'+axetarget,t).addClass(biactive);
	}
}

window['axe_ContentType_Richtext'] = function(type){
	htm = '<div><strong>Rich Text</strong></div>';
	htm += type;
	htm += '<label for="axe_after_content_id">';
	htm += 'ID';
	htm += '</label> ';
	htm += '<input type="text" name="axe_after_content_id[]" class="widefat" value="" placeholder="ID" />';
	htm += '<label for="axe_after_content_title">';
	htm += 'Title';
	htm += '</label> ';
	htm += '<input type="text" name="axe_after_content_title[]" class="widefat" value="" placeholder="Title" />';
	htm += '<label for="axe_after_content_subtitle">';
	htm += 'Subitle';
	htm += '</label> ';
	htm += '<input type="text" name="axe_after_content_subtitle[]" class="widefat" value="" placeholder="Subtitle" />';
	htm += themeaxe_AfterContentContainerCommonFields();
	htm += '<label for="axe_after_content">';
	htm += 'Content';
	htm += '</label> ';
	htm +='<textarea id="axe_after_content" name="axe_after_content[]" class="widefat" placeholder="Content"></textarea>';
	return htm;
}
window['axe_ContentType_Clear'] = function(type){
	var htm = '<div><strong>Clear</strong></div>'+type,
	ind = 0,
	hidden = [['id','clear-div'],['title',''],['subtitle',''],['content',''],['autopara','no']],
	limit = hidden.length;
	for(ind=0;ind < limit; ind++){
		key = hidden[ind][0] == 'content' ? '' : '_'+hidden[ind][0];
		val = hidden[ind][1];
		htm += '<input type="hidden" name="axe_after_content'+key+'[]" value="'+val+'" />';
	}
	htm += themeaxe_AfterContentContainerCommonFields();
	return htm;
}
window['axe_ContentType_Separator'] = function(type){
	var htm = '<div><strong>Separator</strong></div>'+type,
	ind = 0,
	hidden = [['id','separator'],['title',''],['subtitle',''],['content',''],['autopara','no']],
	limit = hidden.length;
	for(ind=0;ind < limit; ind++){
		key = hidden[ind][0] == 'content' ? '' : '_'+hidden[ind][0];
		val = hidden[ind][1];
		htm += '<input type="hidden" name="axe_after_content'+key+'[]" value="'+val+'" />';
	}
	htm += themeaxe_AfterContentContainerCommonFields();
	return htm;
}
window['axe_ContentType_Sectionstart'] = function(type){
	var htm = '<div><strong>Section Start</strong></div>'+type,
	ind = 0,
	hidden = [['content',''],['autopara','no']],
	limit = hidden.length;
	for(ind=0;ind < limit; ind++){
		key = hidden[ind][0] == 'content' ? '' : '_'+hidden[ind][0];
		val = hidden[ind][1];
		htm += '<input type="hidden" name="axe_after_content'+key+'[]" value="'+val+'" />';
	}
	htm += '<label for="axe_after_content_id">';
	htm += 'ID';
	htm += '</label> ';
	htm += '<input type="text" name="axe_after_content_id[]" class="widefat" value="" placeholder="ID" />';
	htm += '<label for="axe_after_content_title">';
	htm += 'Title';
	htm += '</label> ';
	htm += '<input type="text" name="axe_after_content_title[]" class="widefat" value="" placeholder="Title" />';
	htm += '<label for="axe_after_content_subtitle">';
	htm += 'Subitle';
	htm += '</label> ';
	htm += '<input type="text" name="axe_after_content_subtitle[]" class="widefat" value="" placeholder="Subtitle" />';
	htm +=themeaxe_AfterContentContainerCommonFields();

	return htm;
}
window['axe_ContentType_Sectionend'] = function(type){
	var htm = '<div><strong>Section End</strong></div>'+type,
	ind = 0,
	hidden = [['id','section-end'],['title',''],['subtitle',''],['outerwrapper','0'],['innerwrapper','0'],['content',''],['autopara','no'],['containclass',''],['class',''],['bg',''],['bgcolor',''],['bgstyle',''],['bgposx',''],['bgposy','']],
	limit = hidden.length;
	for(ind=0;ind < limit; ind++){
		key = hidden[ind][0] == 'content' ? '' : '_'+hidden[ind][0];
		val = hidden[ind][1];
		htm += '<input type="hidden" name="axe_after_content'+key+'[]" value="'+val+'" />';
	}
	return htm;
}

function themeaxe_AfterContentContainerCommonFields(){
	htm = '';

	htm += '<div class="w w4 axepadright"><label for="axe_after_content_containerclass">';
	htm += 'Container Class';
	htm += '</label> ';
	htm += '<input type="text" name="axe_after_content_containerclass[]" class="widefat" value="" placeholder="Container Class" />';
	htm += '</div>';
	htm += '<div class="w w2 axepad"><label for="axe_after_content_outerwrapper">';
	htm += 'Within Wrapper';
	htm += '</label><br/><select name="axe_after_content_outerwrapper[]" class="widefat"><option value="0">No</option><option value="wrapwidth">Yes</option></select></div>';
	htm += '<div class="w w4 axepad"><label for="axe_after_content_class">';
	htm += 'Content Class';
	htm += '</label><input type="text" name="axe_after_content_class[]" class="widefat" value="" placeholder="Content Class" /></div>';
	htm += '<div class="w w2 axepadleft"><label for="axe_after_content_innerwrapper">';
	htm += 'Within Wrapper';
	htm += '</label><br/><select  name="axe_after_content_innerwrapper[]" class="widefat"><option value="0">No</option><option value="wrapwidth">Yes</option></select></div>';
	htm += '<div class="clear">';
	htm += '<div class="w w6 axepadright">';
	htm += '<label for="axe_after_content_bg" class="clear">';
	htm += 'Background Image';
	htm += '</label> ';
	htm += '<input type="text" name="axe_after_content_bg[]" class="widefat themeaxemedialoader" value="" placeholder="Background Image URL" />';
	htm += '</div>';
	htm += '<div class="w w6 axepadleft">';
	htm += '<label for="axe_after_content_bgcolor" class="clear">';
	htm += 'Background Color';
	htm += '</label> ';
	htm += '<input type="text" name="axe_after_content_bgcolor[]" class="widefat color" value="" placeholder="Background Color" />';
	htm += '</div>';
	htm += '</div>';

	return htm;
}

String.prototype.capitalize = function() {
	return this.charAt(0).toUpperCase() + this.slice(1);
}
})(jQuery);