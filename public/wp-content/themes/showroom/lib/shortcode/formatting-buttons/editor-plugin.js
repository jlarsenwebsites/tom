/**
 * This file contains all the main JavaScript functionality needed for the editor formatting buttons.
 * 
 */

/**
 * Define all the formatting buttons with the HTML code they set.
 */
var shortcodeButton=[
		{
			id:'dropcaps',
			image:'drop.png',
			title:'Drop Caps',
			allowSelection:true,
			fields:[{id:'letter', name:'Letter'}],
			generateHtml:function(letter){
				return '[dropcap]'+letter+'[/dropcap]';
			}
		},
		{
			id:'list',
			image:'checkb.png',
			title:'List',
			allowSelection:false,
			fields:[{id:'style', name:'List Style', values:['bullet_check', 'bullet_star', 'bullet_dot', 'bullet_pencil', 'bullet_arrow2', 'bullet_arrow4' ]}, { id:"list1", name:"List 1"}, { id:"list2", name:"List 2"}, { id:"list3", name:"List 3"} ],
			generateHtml:function(obj){
				return '[list style="'+obj.style+'"][li]'+obj.list1+'[/li][li]'+obj.list2+'[/li][li]'+obj.list2+'[/li][/list]';
			}
		},
		{
			id:'frame',
			image:'fr.png',
			title:'Image frame',
			allowSelection:false,
			fields:[{id:'src', name:'Image URL'},{id:'align', name:'Align', values:['none', 'left', 'right']}],
			generateHtml:function(obj){
				return '[image_frame url="'+obj.src+'" align="'+obj.align+'"][/image_frame]';
			}
		},
		{
			id:'lightbox',
			image:'lb.png',
			title:'Lightbox image',
			allowSelection:false,
			fields:[{id:'src', name:'Thumbnail URL'}, {id:'href', name:'Preview Image URL'}, {id:'description', name:'Description'}, {id:'align', name:'Align', values:['none', 'left', 'right']}],
			generateHtml:function(obj){
				return '[image_lightbox thumbnail="'+obj.src+'" full_url="'+obj.href+'" title="'+obj.description+'" align="'+obj.align+'" ][/image_lightbox]';
			}
		},
		{
			id:'infoboxes',
			image:'info.png',
			title:'Info Box',
			allowSelection:false,
			fields:[{id:'text', name:'Text'},{id:'type', name:'Type', values:['alert_box', 'note_box', 'notice_box','success_box','warning_box','download_box']}],
			generateHtml:function(obj){
				return '[infobox style="'+obj.type+'"]'+obj.text+'[/infobox]';
			}
		},
		{
			id:'twocolumns',
			image:'col_2.png',
			title:'Two Columns',
			allowSelection:false,
			fields:[{id:'columnone', name:'Column One Content', textarea:true}, {id:'columntwo', name:'Column Two Content', textarea:true}],
			generateHtml:function(obj){
				return '[column_wrapper][col column="2" last="false"]'+obj.columnone+'[/col][col column="2" last="true"]'+obj.columntwo+'[/col][/column_wrapper]';
			}
		},
		{
			id:'threecolumns',
			image:'col_3.png',
			title:'Three Columns',
			allowSelection:false,
			fields:[{id:'columnone', name:'Column One Content', textarea:true}, {id:'columntwo', name:'Column Two Content', textarea:true}, {id:'columnthree', name:'Column Three Content', textarea:true}],
			generateHtml:function(obj){
				return '[column_wrapper][col column="3" last="false"]'+obj.columnone+'[/col][col column="3" last="false"]'+obj.columntwo+'[/col][col column="3" last="true"]'+obj.columnthree+'[/col][/column_wrapper]';
			}
		},
		{
			id:'fourcolumns',
			image:'col_4.png',
			title:'Four Columns',
			allowSelection:false,
			fields:[{id:'columnone', name:'Column One Content', textarea:true}, {id:'columntwo', name:'Column Two Content', textarea:true}, {id:'columnthree', name:'Column Three Content', textarea:true}, {id:'columnfour', name:'Column Four Content', textarea:true}],
			generateHtml:function(obj){
				return '[column_wrapper][col column="4" last="false"]'+obj.columnone+'[/col][col column="4" last="false"]'+obj.columntwo+'[/col][col column="4" last="false"]'+obj.columnthree+'[/col][col column="4" last="true"]'+obj.columnfour+'[/col][/column_wrapper]';
			}
		},
		{
			id:'toggle',
			image:'toggle.png',
			title:'Toggle Box',
			allowSelection: false,
			fields:[{id:'toggletitle' , name:'Title'},{id:'toggleitemtitle', name:'Toggle Item Title'}, {id:'content', name:'Content', textarea: true},{id:'toggleitemtitle2', name:'Toggle Item Title'}, {id:'content2', name:'Content', textarea: true},{id:'toggleitemtitle3', name:'Toggle Item Title'}, {id:'content3', name:'Content', textarea: true}],
			generateHtml:function(obj){
				var html='';

				html='[toggle title="'+obj.toggletitle+'"][toggleitem title="'+obj.toggleitemtitle+'"]'+obj.content+'[/toggleitem][toggleitem title="'+obj.toggleitemtitle2+'"]'+obj.content2+'[/toggleitem][toggleitem title="'+obj.toggleitemtitle3+'"]'+obj.content3+'[/toggleitem][/toggle]';
				
				return html;
			}
		},
			{
			id:'tabs',
			image:'tabs.png',
			title:'jQuery Tab',
			allowSelection:false,
			fields:[{id:'id1', name:'First Tab ID'}, {id:'tab1', name:'First Tab Title'}, {id:'content1', name:'First Content', textarea: true}, {id:'id2', name:'Second Tab ID'},{id:'tab2', name:'Second Tab Title'}, {id:'content2', name:'Second Content', textarea: true},{id:'id3', name: 'Third Tab ID'},{id:'tab3', name: 'Third Tab Title'},{id:'content3', name:'Third Content' , textarea: true}],
			generateHtml:function(obj){
			
			var html='';
				html='[tabs ids="'+obj.id1+','+obj.id2+','+obj.id3+'" titles="'+obj.tab1+','+obj.tab2+','+obj.tab3+'"] [pane id="'+obj.id1+'"] '+obj.content1+' [/pane] [pane id="'+obj.id2+'"] '+obj.content2+' [/pane] [pane id="'+obj.id3+'"] '+obj.content3+' [/pane][/tabs]';
						
				return html;
			}
		},
		{
			id:'accordion',
			image:'accordion.png',
			title:'jQuery Accordion',
			allowSelection:false,
			fields:[{id:'accordiontitle' , name:'Title'},{id:'accordionitemtitle', name:'Item Title'}, {id:'content', name:'Content', textarea: true},{id:'accordionitemtitle2', name:'Item Title'}, {id:'content2', name:'Content', textarea: true},{id:'accordionitemtitle3', name:'Item Title'}, {id:'content3', name:'Content', textarea: true}],
			generateHtml:function(obj){
			
			var html='';
				html='[accordion title="'+obj.accordiontitle+'"][accordionitem title="'+obj.accordionitemtitle+'"]'+obj.content+'[/accordionitem][accordionitem title="'+obj.accordionitemtitle2+'"]'+obj.content2+'[/accordionitem][accordionitem title="'+obj.accordionitemtitle3+'"]'+obj.content3+'[/accordionitem][/accordion]';
						
				return html;
			
			}
		},
		{
			id:'testimonials',
			image:'testimonial.png',
			title:'jQuery Testimonial',
			allowSelection:false,
			fields:[{id:'author1', name:'Author'}, {id:'img1', name:'Image Url'}, {id:'testi1', name:'Testimonial', textarea:true},{id:'author2', name:'Author'}, {id:'img2', name:'Image Url'}, {id:'testi2', name:'Testimonial', textarea:true},{id:'author3', name:'Author'}, {id:'img3', name:'Image Url'}, {id:'testi3', name:'Testimonial', textarea:true} ],
			generateHtml:function(obj){
			
			var html='';
html='[testimonials] [testim author="'+obj.author1+'" img="'+obj.img1+'"] '+obj.testi1+' [/testim] [testim author="'+obj.author2+'" img="'+obj.img2+'"] '+obj.testi2+' [/testim] [testim author="'+obj.author3+'" img="'+obj.img3+'"] '+obj.testi3+' [/testim][/testimonials]';
						
				return html;
			
			
			}
		},
		{
			id:'servicebox',
			image:'servicebox.png',
			title:'Service Box',
			allowSelection:false,
			fields:[{id:'size' , name:'Size',values:['one-half','one-third','two-third','one-fourth','three-fourth'] },{id:'last', name:'Last',values:['true','false']},{id:'title', name:'Title'},{id:'icon', name:'Icon'}, {id:'content', name:'Content', textarea: true}, {id:'link', name:'Link'}, {id:'linkname', name:'Link Name'}, {id:'target', name:'Target', values:['_blank', '_self','_parent', '_top']} ],
			generateHtml:function(obj){
			
			var html='';
				html='[servicebox size="'+obj.size+'" last="'+obj.last+'" title="'+obj.title+'" icon="'+obj.icon+'" link="'+obj.link+'" linkname="'+obj.linkname+'" target="'+obj.target+'" ]'+obj.content+'[/servicebox]';
						
				return html;
			
			}
		},
		{
			id:'button',
			image:'but.png',
			title:'Button',
			allowSelection:false,
			fields:[{id:'linked' , name:'Link'},{id:'size', name:'Size', values:['small','medium','large']},{id:'rounded', name:'Rounded', values:['true','false']},{id:'buttonname' , name:'Button Name'}],
			generateHtml:function(obj){
			
			var html='';
				html='[button link="'+obj.linked+'" size="'+obj.size+'" rounded="'+obj.rounded+'" ]'+obj.buttonname+'[/button]';
						
				return html;
			
			}
		},
		{
			id:'pricingtable',
			image:'price.png',
			title:'Pricing Table',
			allowSelection:false,
			fields:[{id:'size' , name:'Size',values:['one-half','one-third','one-fourth'] },{id:'last', name:'Last',values:['true','false']},{id:'price', name:'Price'},{id:'title', name:'Title'}, {id:'terms', name:'Terms'}, {id:'content', name:'Content', textarea: true},{id:'link_name', name:'Link Name'},{id:'linkurl', name:'Link URL'},{id:'bestprice' , name:'BestPrice',values:['false','true'] }],
			generateHtml:function(obj){
			
			var html='';
				html='[pricetable size="'+obj.size+'" last="'+obj.last+'" price="'+obj.price+'" terms="'+obj.terms+'" title="'+obj.title+'" linkname="'+obj.link_name+'" linkurl="'+obj.linkurl+'" bestprice="'+obj.bestprice+'"]'+obj.content+'[/pricetable]';
						
				return html;
			
			}
		}
		
		
];

/**
 * Contains the main formatting buttons functionality.
 */
ButtonManager={
	dialog:null,
	idprefix:'shortcode-',
	ie:false,
	opera:false,
		
	/**
	 * Init the formatting button functionality.
	 */
	init:function(){
			
		var length=shortcodeButton.length;
		for(var i=0; i<length; i++){
		
			var btn = shortcodeButton[i];
			ButtonManager.loadButton(btn);
		}
		
		if ( jQuery.browser.msie ) {
			ButtonManager.ie=true;
		}
		
		if (jQuery.browser.opera){
			ButtonManager.opera=true;
		}
		
	},
	
	/**
	 * Loads a button and sets the functionality that is executed when the button has been clicked.
	 */
	loadButton:function(btn){
		tinymce.create('tinymce.plugins.'+btn.id, {
	        init : function(ed, url) {
			        ed.addButton(btn.id, {
	                title : btn.title,
	                image : url+'/btnicons/'+btn.image,
	                onclick : function() {
			        	
			           var selection = ed.selection.getContent();
					  
	                  if(btn.allowSelection && selection){
	                	   //modification via selection is allowed for this button and some text has been selected
	                	   selection = btn.generateHtml(selection);
	                	   ed.selection.setContent(selection);
	                   }else if(btn.fields){
	                	   //there are inputs to fill in, show a dialog to fill the required data

	                	   ButtonManager.showDialog(btn, ed);
	                   }else if(btn.list){
	                
	                	    //this is a list
	                	    var list, dom = ed.dom, sel = ed.selection;
	                	    
							
							// Check for existing list element
		               		list = dom.getParent(sel.getNode(), 'ul');
		               		
		               		// Switch/add list type if needed
		               		ed.execCommand('InsertUnorderedList');
		               		
		               		// Append styles to new list element
		               		list = dom.getParent(sel.getNode(), 'ul');
		               		
		               		if (list) {
		               			dom.addClass(list, btn.list);
		               			dom.addClass(list, 'imglist');
		               		}
	                   }else{
	                	   //no data is required for this button, insert the generated HTML
	                	   ed.execCommand('mceInsertContent', true, btn.generateHtml());
	                   }
	                }
	            });
	        }
	    });
		
	    tinymce.PluginManager.add(btn.id, tinymce.plugins[btn.id]);
	},
	
	/**
	 * Displays a dialog that contains fields for inserting the data needed for the button.
	 */
	showDialog:function(btn, ed){

		
		if(ButtonManager.ie){
			ed.dom.remove('caret');
		    var caret = '<div id="caret">&nbsp;</div>';
		    ed.execCommand('mceInsertContent', false, caret);	
			var selection = ed.selection;
		}
	    
		var html='<div>';
		for(var i=0, length=btn.fields.length; i<length; i++){
			var field=btn.fields[i], inputHtml='';
			if(btn.fields[i].values){
				//this is a select list
				inputHtml='<select id="'+ButtonManager.idprefix+btn.fields[i].id+'">';
				jQuery.each(btn.fields[i].values, function(index, value){
					inputHtml+='<option value="'+value+'">'+value+'</option>';
				});
				inputHtml+='</select>';
			}else{
				if(btn.fields[i].textarea && !ButtonManager.opera){
					//this field should be a text area
					inputHtml='<textarea id="'+ButtonManager.idprefix+btn.fields[i].id+'" ></textarea>';
				}else{
					//this field should be a normal input
					inputHtml='<input type="text" id="'+ButtonManager.idprefix+btn.fields[i].id+'" />';
				}
			}
			html+='<div class="shortcode-field"><label>'+btn.fields[i].name+'</label>'+inputHtml+'</div>';
		}
		html+='<a href="" id="insertbtn" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button"><span class="ui-button-text">Insert</span></a></div>';
	
		var dialog = jQuery(html).dialog({
							 title:btn.title, 
							 modal:true,
							 close: function(event, ui){
								jQuery(this).html('').remove();
							}
							 });
		
		ButtonManager.dialog=dialog;
		
		//set a click handler to the insert button
		dialog.find('#insertbtn').click(function(event){
			event.preventDefault();
			ButtonManager.executeCommand(ed,btn,selection);
		});
		
			
	},
	
	/**
	 * Executes a command when the insert button has been clicked.
	 */
	executeCommand:function(ed, btn, selection){

    		var values={}, html='';
    		
    		if(!btn.allowSelection){
    			//the button doesn't allow selection, generate the values as an object literal
	    		for(var i=0, length=btn.fields.length; i<length; i++){
	        		var id=btn.fields[i].id,
	        			value=jQuery('#'+ButtonManager.idprefix+id).val();
	        		
	    			values[id]=value;
	    		}
	    		html = btn.generateHtml(values);
    		}else{
    			//the button allows selection - only one value is needed for the formatting, so
    			//return this value only (not an object literal)
    			value = jQuery('#'+ButtonManager.idprefix+btn.fields[0].id).attr("value")
    			html = btn.generateHtml(value);
    		}
    		
    	ButtonManager.dialog.remove();

    	if(ButtonManager.ie){
	    	selection.select(ed.dom.select('div#caret')[0], false);
	    	ed.dom.remove('caret');
    	}

  		ed.execCommand('mceInsertContent', false, html);
    	
	}
		
		
};


/**
 * Init the formatting functionality.
 */
(function() {
	
	ButtonManager.init();
	/*Tooltip();*/
	
			
		
    
})();

