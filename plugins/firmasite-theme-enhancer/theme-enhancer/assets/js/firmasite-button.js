(function() {
    tinymce.PluginManager.add('firmasitebutton', function( editor, url ) {

		function firmasite_set_href(href){
			if ( null == href )	href = "#"; 
			return href;
		}

		
		// New event
		editor.on('init', function(args) {
			tinymce.activeEditor.formatter.register('div_class', {block : 'div', classes : '%value'});
			tinymce.activeEditor.formatter.register('div_class_remove', {block : 'div', classes : 'alert alert-block alert-warning alert-danger alert-success alert-info'});
			tinymce.activeEditor.formatter.register('span_class', {inline : 'span', classes : '%value'});
			tinymce.activeEditor.formatter.register('span_class_remove', {inline : 'span', classes : 'text-muted text-warning text-danger text-success text-info'});
			tinymce.activeEditor.formatter.register('span_class_remove_label', {inline : 'span', classes : 'label label-default label-success label-warning label-danger label-info label-primary'});
			tinymce.activeEditor.formatter.register('span_class_remove_badge', {inline : 'span', classes : 'badge'});
			tinymce.activeEditor.formatter.register('a_class', {inline : 'a', classes : '%value', attributes : {href: '%href_value'} });
			tinymce.activeEditor.formatter.register('a_class_remove', {inline : 'a', classes : 'btn btn-default btn-warning btn-primary btn-danger btn-success btn-info'});
			tinymce.activeEditor.formatter.register('a_class_remove_size', {inline : 'a', classes : 'btn btn-default btn-lg btn-sm btn-xs btn-block'});
			tinymce.activeEditor.formatter.register('div_class_remove_well', {block : 'div', classes : 'well well-sm well-lg'});
			tinymce.activeEditor.formatter.register('div_class_modal', {block : 'div', classes : 'panel panel-default', wrapper : true, merge_siblings: false});
			tinymce.activeEditor.formatter.register('div_class_wrapper', {block : 'div', classes : '%value', wrapper: true});
			tinymce.activeEditor.formatter.register('div_class_modal_remove', {block : 'div', classes : 'panel-body panel-header panel-footer'});
		});
        editor.addButton( 'firmasitebutton', {
            text: firmasitebutton.title,
            type: 'menubutton',
            icon: false,
            menu: [
                {
                    // Container
					text: firmasitebutton.container,
                    menu: [
                        {
                            // Wells
							text : firmasitebutton.well,
							menu: [
								{
									//Small Well
									text : firmasitebutton.well_small,
									onclick: function(e) {
										e.stopPropagation();
										tinymce.activeEditor.formatter.remove('div_class_remove_well');
										tinymce.activeEditor.formatter.apply('div_class',{value : 'well well-sm'});  
									}       
								},
								{
									//Standard Well
									text : firmasitebutton.well_standard,
									onclick: function(e) {
										e.stopPropagation();
										tinymce.activeEditor.formatter.remove('div_class_remove_well');
										tinymce.activeEditor.formatter.apply('div_class',{value : 'well'});  
									}       
								},
								{
									//Large Well
									text : firmasitebutton.well_large,
									onclick: function(e) {
										e.stopPropagation();
										tinymce.activeEditor.formatter.remove('div_class_remove_well');
										tinymce.activeEditor.formatter.apply('div_class',{value : 'well well-lg'});  
									}       
								}
							]

                        },
                        {
							// Message Box
                            text : firmasitebutton.messagebox,
							menu: [
								{
									//Alert Box
									text : firmasitebutton.messagebox_alert,
									onclick: function(e) {
										e.stopPropagation();
										tinymce.activeEditor.formatter.remove('div_class_remove');
										tinymce.activeEditor.formatter.apply('div_class',{value : 'alert alert-block alert-warning'});  
									}       
								},
								{
									//Alert Box (Danger)
									text : firmasitebutton.messagebox_error,
									onclick: function(e) {
										e.stopPropagation();
										tinymce.activeEditor.formatter.remove('div_class_remove');  
										tinymce.activeEditor.formatter.apply('div_class',{value : 'alert alert-block alert-danger'});  
									}       
								},
								{
									//Alert Box (Success)
									text : firmasitebutton.messagebox_success,
									onclick: function(e) {
										e.stopPropagation();
										tinymce.activeEditor.formatter.remove('div_class_remove');  
										tinymce.activeEditor.formatter.apply('div_class',{value : 'alert alert-block alert-success'});  
									}       
								},
								{
									//Alert Box (Info)
									text : firmasitebutton.messagebox_info,
									onclick: function(e) {
										e.stopPropagation();
										tinymce.activeEditor.formatter.remove('div_class_remove');  
										tinymce.activeEditor.formatter.apply('div_class',{value : 'alert alert-block alert-info'});  
									}       
								}
								
							]

                        },
                        {
                           // Modal Box
							text : firmasitebutton.modal,
							menu: [
								{
									//Modal Body
									text : firmasitebutton.modal_body,
									onclick: function(e) {
										e.stopPropagation();
										tinymce.activeEditor.formatter.remove('div_class_modal_remove'); 
										tinymce.activeEditor.formatter.remove('div_class_modal');  
										tinymce.activeEditor.formatter.apply('div_class_modal');  
										tinymce.activeEditor.formatter.apply('div_class_wrapper',{value : 'panel-body'}); 
									}       
								},
								{
									//Modal Footer
									text : firmasitebutton.modal_footer,
									onclick: function(e) {
										e.stopPropagation();
										tinymce.activeEditor.formatter.remove('div_class_modal_remove'); 
										tinymce.activeEditor.formatter.remove('div_class_modal');  
										tinymce.activeEditor.formatter.apply('div_class_modal');  
										tinymce.activeEditor.formatter.apply('div_class_wrapper',{value : 'panel-footer'}); 
									}       
								}
							]

                        }						
                    ]

                },
                {
                   // Text Style
				    text: firmasitebutton.text,
                    menu: [
                        {
                            // Label
							text : firmasitebutton.label,
							menu: [
								{
									// Label Standard
									text : firmasitebutton.label_standard,
									onclick: function(e) {
										e.stopPropagation();
										tinymce.activeEditor.formatter.remove('span_class_remove_label');  
										tinymce.activeEditor.formatter.apply('span_class',{value : 'label label-default'});  
									}       
								},
								{
									// Label Warning
									text : firmasitebutton.label_warning,
									onclick: function(e) {
										e.stopPropagation();
										tinymce.activeEditor.formatter.remove('span_class_remove_label');
										tinymce.activeEditor.formatter.apply('span_class',{value : 'label label-warning'});  
									}       
								},
								{
									// Label Danger
									text : firmasitebutton.label_important,
									onclick: function(e) {
										e.stopPropagation();
										tinymce.activeEditor.formatter.remove('span_class_remove_label');  
										tinymce.activeEditor.formatter.apply('span_class',{value : 'label label-danger'});  
									}       
								},
								{
									// Label Success
									text : firmasitebutton.label_success,
									onclick: function(e) {
										e.stopPropagation();
										tinymce.activeEditor.formatter.remove('span_class_remove_label');  
										tinymce.activeEditor.formatter.apply('span_class',{value : 'label label-success'});  
									}       
								},
								{
									// Label Information
									text : firmasitebutton.label_info,
									onclick: function(e) {
										e.stopPropagation();
										tinymce.activeEditor.formatter.remove('span_class_remove_label');  
										tinymce.activeEditor.formatter.apply('span_class',{value : 'label label-info'});  
									}       
								},
								{
									// Label primary
									text : firmasitebutton.label_primary,
									onclick: function(e) {
										e.stopPropagation();
										tinymce.activeEditor.formatter.remove('span_class_remove_label');  
										tinymce.activeEditor.formatter.apply('span_class',{value : 'label label-primary'});  
									}       
								}
							]
                        },
                        {
                            // Text Style
							text : firmasitebutton.textcolor,
							menu: [
								{
									// Muted
									text : firmasitebutton.text_muted,
									onclick: function(e) {
										e.stopPropagation();
										tinymce.activeEditor.formatter.remove('span_class_remove');  
										tinymce.activeEditor.formatter.apply('span_class',{value : 'text-muted'});  
									}       
								},
								{
									// Alert
									text : firmasitebutton.text_alert,
									onclick: function(e) {
										e.stopPropagation();
										tinymce.activeEditor.formatter.remove('span_class_remove');
										tinymce.activeEditor.formatter.apply('span_class',{value : 'text-warning'});  
									}       
								},
								{
									// Danger
									text : firmasitebutton.text_error,
									onclick: function(e) {
										e.stopPropagation();
										tinymce.activeEditor.formatter.remove('span_class_remove');  
										tinymce.activeEditor.formatter.apply('span_class',{value : 'text-danger'});  
									}       
								},
								{
									// Success
									text : firmasitebutton.text_success,
									onclick: function(e) {
										e.stopPropagation();
										tinymce.activeEditor.formatter.remove('span_class_remove');  
										tinymce.activeEditor.formatter.apply('span_class',{value : 'text-success'});  
									}       
								},
								{
									// Information
									text : firmasitebutton.text_info,
									onclick: function(e) {
										e.stopPropagation();
										tinymce.activeEditor.formatter.remove('span_class_remove');  
										tinymce.activeEditor.formatter.apply('span_class',{value : 'text-info'});  
									}       
								},
							]
                        }											
                    ]

                },
                {
                   // Button
				    text: firmasitebutton.button,
                    menu: [
                        {
                            // Button Color
							text : firmasitebutton.buttoncolor,
							menu: [
								{
									//Standard
									text : firmasitebutton.button_standard,
									onclick: function(e) {
										e.stopPropagation();
										tinymce.activeEditor.formatter.remove('a_class_remove'); 
										href = firmasite_set_href(tinymce.activeEditor.selection.getNode().getAttribute('href'));
										tinymce.activeEditor.formatter.apply('a_class',{value : 'btn btn-default', href_value: href});  
									}       
								},
								{
									//Primary
									text : firmasitebutton.button_primary,
									onclick: function(e) {
										e.stopPropagation();
										tinymce.activeEditor.formatter.remove('a_class_remove');  
										href = firmasite_set_href(tinymce.activeEditor.selection.getNode().getAttribute('href'));
										tinymce.activeEditor.formatter.apply('a_class',{value : 'btn btn-primary'});  
									}       
								},
								{
									//Alert
									text : firmasitebutton.button_alert,
									onclick: function(e) {
										e.stopPropagation();
										tinymce.activeEditor.formatter.remove('a_class_remove');
										href = firmasite_set_href(tinymce.activeEditor.selection.getNode().getAttribute('href'));
										tinymce.activeEditor.formatter.apply('a_class',{value : 'btn btn-warning', href_value: href});  
									}       
								},
								{
									//Danger
									text : firmasitebutton.button_error,
									onclick: function(e) {
										e.stopPropagation();
										tinymce.activeEditor.formatter.remove('a_class_remove');  
										href = firmasite_set_href(tinymce.activeEditor.selection.getNode().getAttribute('href'));
										tinymce.activeEditor.formatter.apply('a_class',{value : 'btn btn-success', href_value: href});  
									}       
								},
								{
									//Success
									text : firmasitebutton.button_success,
									onclick: function(e) {
										e.stopPropagation();
										tinymce.activeEditor.formatter.remove('a_class_remove');  
										href = firmasite_set_href(tinymce.activeEditor.selection.getNode().getAttribute('href'));
										tinymce.activeEditor.formatter.apply('a_class',{value : 'btn btn-success', href_value: href});  
									}       
								},
								{
									//Information
									text : firmasitebutton.button_info,
									onclick: function(e) {
										e.stopPropagation();
										tinymce.activeEditor.formatter.remove('a_class_remove');  
										href = firmasite_set_href(tinymce.activeEditor.selection.getNode().getAttribute('href'));
										tinymce.activeEditor.formatter.apply('a_class',{value : 'btn btn-info', href_value: href});  
									}       
								}
							]
                        },											
                        {
                            // Button Size
							text : firmasitebutton.buttonsize,
							menu: [
								{
									//Mini
									text : firmasitebutton.button_mini,
									onclick: function(e) {
										e.stopPropagation();
										tinymce.activeEditor.formatter.remove('a_class_remove_size');  
										href = firmasite_set_href(tinymce.activeEditor.selection.getNode().getAttribute('href'));
										tinymce.activeEditor.formatter.apply('a_class',{value : 'btn btn-default btn-xs', href_value: href});  
									}       
								},
								{
									//Small
									text : firmasitebutton.button_small,
									onclick: function(e) {
										e.stopPropagation();
										tinymce.activeEditor.formatter.remove('a_class_remove_size');  
										href = firmasite_set_href(tinymce.activeEditor.selection.getNode().getAttribute('href'));
										tinymce.activeEditor.formatter.apply('a_class',{value : 'btn btn-default btn-sm', href_value: href});  
									}       
								},
								{
									//Standard
									text : firmasitebutton.button_standard,
									onclick: function(e) {
										e.stopPropagation();
										tinymce.activeEditor.formatter.remove('a_class_remove_size');  
										href = firmasite_set_href(tinymce.activeEditor.selection.getNode().getAttribute('href'));
										tinymce.activeEditor.formatter.apply('a_class',{value : 'btn btn-default', href_value: href});  
									}       
								},
								{
									//Large
									text : firmasitebutton.button_large,
									onclick: function(e) {
										e.stopPropagation();
										tinymce.activeEditor.formatter.remove('a_class_remove_size');  
										href = firmasite_set_href(tinymce.activeEditor.selection.getNode().getAttribute('href'));
										tinymce.activeEditor.formatter.apply('a_class',{value : 'btn btn-default btn-lg', href_value: href});  
									}       
								},
								{
									//Block
									text : firmasitebutton.button_block,
									onclick: function(e) {
										e.stopPropagation();
										tinymce.activeEditor.formatter.remove('a_class_remove_size');  
										href = firmasite_set_href(tinymce.activeEditor.selection.getNode().getAttribute('href'));
										tinymce.activeEditor.formatter.apply('a_class',{value : 'btn btn-default btn-lg btn-block', href_value: href});  
									}       
								}
							]
                        }											
                    ]

                },


				
				
				
           ]
        });
    });
})();