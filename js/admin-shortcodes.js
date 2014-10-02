jQuery(document).ready(function($) {
    "use strict";

    var shg = $('#shortcode-generator');
	if( shg.length ){
		//hide generated html
		var sc_codes = shg.find('select.shortcodes-codes').hide(),
            sc_fields = shg.find('div.shortcodes-fields').hide();


		$('#shortcode-categories')
            //reset on page refresh
            .val('')
            .change(function(){
                sc_codes.hide();
                $('#apollo13-' + $(this).val() + '-codes' ).show().change();
		});

		sc_codes.change(function(){
			sc_fields.hide();
			$('#apollo13-' + $(this).val() + '-fields' ).show();
		});
		
		shg.find('span.add-more-fields').click(function(){
			var button = $(this),
                mark = button.parent(),
                new_number = mark.parent().data( 'number'),
                insert = $('<fieldset class="added"></fieldset>').insertBefore(mark);

            //copy fields
            mark.siblings('.additive').clone().appendTo(insert);

			//stored data about number of new elements
			if(typeof new_number === 'undefined'){
				new_number = 1;
				mark.parent().data( 'number', new_number );
			}
			else{
				new_number = parseInt(new_number, 10) + 1;
				mark.parent().data( 'number', new_number );
			}

			//make unique id of cloned elements
			insert.find('.additive').not('div').each(function(){
				var elem = $(this),
                    id = elem.attr('id');
				elem.attr('id', id + new_number ).attr('name', id + new_number);
			});
			
			//add remove button
			$('<span class="button">Remove fields</span>').appendTo(insert).click(function(){
				$(this).parent().remove();
			});

		});

        var create_shortcode = function(){
            var tag = sc_codes.filter(':visible').eq(0).val();
            if( !tag ){
                return;
            }

            var attr = '',
                content = '',
                code = '',
                subtags = {},
                subtags_code = '',
                addclear = false,
                div = sc_fields.filter(':visible'),
                fields = div.find('input[type="text"], input[type="radio"]:checked, select, textarea');

            //parse info from id, class of each field
            fields.each(function(){
                var field = $(this),
                    field_id = field.attr('id'),
                    data, value, key;

                //get info form field
                if(field_id){
                    data = field_id.split("-");
                }
                else{
                    data = field.attr('name').split("-");
                }

                //if subtag is present
                if( typeof data[3] !== 'undefined' ){
                    //if input about adding clear element
                    if (field.hasClass('addclear') ) {
                        if( $(this).val() === 'on' ){
                            addclear = true;
                        }

                        // skip other operations for this tag
                        return;
                    }

                    //making key name
                    key = data[3];

                    if ( typeof data[4] !== 'undefined' ){
                        key += '-' + data[4];
                    }

                    //if not exists we create key position
                    if( !subtags[key] ){
                        subtags[key] = {'attr': '', 'content' : ''};
                    }

                    //if field is shortcode attribute
                    if (field.hasClass('attr')) {
                        value = field.val();
                        if (!(value === 'default' || value === '')){
                            //add to attribute with value to shortcode attributes string
                            subtags[key].attr += ' ' + data[2] + '="' + value + '"';
                        }
                    }
                    //if field is shortcode content
                    else if (field.hasClass('content')) {
                        subtags[key].content += field.val();
                    }
                }
                //no subtag
                else{
                    //if field is shortcode attribute
                    if($(this).hasClass('attr')){
                        value = field.val();
                        if( !(value === 'default' || value === '') ){
                            attr += ' ' + data[2] + '="' + value + '"';
                        }
                    }
                    //if field is shortcode content
                    else if(field.hasClass('content')){
                        content += field.val();
                    }
                }
            });
            //ufff

            //now we parse subtags if they exist
            $.each(subtags, function(key, value) {
                key = key.split("-")[0];//no numbers part(-1,-2, etc.)
                subtags_code += '['+ key + value.attr + ']' + value.content + '[/'+ key + ']';
            });

            //and return code
            //one tag shortcode(example: [line], [clear])
            if( subtags_code === '' && attr === '' && content === '' ){
                code = '[' + tag + ']';
            }
            //no content - selfclose one tag shortcode ([image atribs /])
            else if( subtags_code === '' && content === '' ){
                code = '[' + tag + attr + ' /]';
            }
            //subtags but no main tag(example: columns)
            else if( tag.substring(0,6) === 'nocode' ){
                code = subtags_code;
            }
            //normal short code or short code with subtags
            else{
                code = '[' + tag + attr + ']' + content + subtags_code + '[/' + tag + ']';
            }

            // clear for columns
            if( addclear ){
                code += '[clear]';
            }
            window.send_to_editor(code);
//			alert(code);
        };

        //process
		$('#send-to-editor').click(create_shortcode);
	}
});