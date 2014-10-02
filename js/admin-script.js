/*global tb_show, tb_remove, alert, plupload, AdminParams, ajaxurl, wp, console */
(function($){
    "use strict";

    window.A13_ADMIN = { //A13 = APOLLO 13
        settings : {},

        //run after DOM is loaded
        onReady : function(){
            A13_ADMIN.upload();
            A13_ADMIN.utils.init();
            A13_ADMIN.metaActions.init();
            A13_ADMIN.settingsAction();
        },

        upload : function(){
            //uploading files variable
            var custom_file_frame,
                field_for_uploaded_file,
                $upload_input,
                upload_buttons_selector = 'input.upload-image-button',

                //on start of selecting/uploading file
                a13_upload_file = function(event){
                    event.preventDefault();

                    var upload_button = $(this);

                    //makes 'Upload Files' tab default one
                    wp.media.controller.Library.prototype.defaults.contentUserSetting=false;

                    //find text input to write in
                    $upload_input = $('input[type=text]', $(this).parent());

                    //remember in which input we want to write
                    field_for_uploaded_file = $upload_input.attr('name');

                    //If the frame already exists, reopen it
                    if (typeof(custom_file_frame)!=="undefined") {
                        custom_file_frame.close();
                    }

                    //Create WP media frame.
                    custom_file_frame = wp.media.frames.customHeader = wp.media({
                        //Title of media manager frame
                        title: "WP Media Uploader",
//                        frame: 'post',
                        frame: shortcode_lightbox_input()? 'post' : 'select',
                        state: shortcode_lightbox_input()? 'insert' : 'library',
//                        editing:    true,
                        multiple:   false,
                        library: {
                            type: 'image'
                        },
                        button: {
                            text: upload_button.data('media-button-name') || "Insert image"
                        }
                    });

                    //callback for selected image
                    custom_file_frame.on('insert select change', a13_select_file);

                    //Open modal
                    custom_file_frame.open();
                },

                //after of selecting/uploading file
                a13_select_file = function(){
                    var whole_state     = custom_file_frame.state(), //for thumb dimenssions in shortcodes
                        attachment      = whole_state.get('selection').first().toJSON(),
                        selected_size   = whole_state._defaultDisplaySettings.size; //shortcodes only

                    //do something with attachment variable, for example attachment.filename
                    //Object:
                    //attachment.alt - image alt
                    //attachment.author - author id
                    //attachment.caption
                    //attachment.dateFormatted - date of image uploaded
                    //attachment.description
                    //attachment.editLink - edit link of media
                    //attachment.filename
                    //attachment.height
                    //attachment.icon - don't know WTF?))
                    //attachment.id - id of attachment
                    //attachment.link - public link of attachment, for example ""http://site.com/?attachment_id=115""
                    //attachment.menuOrder
                    //attachment.mime - mime type, for example image/jpeg"
                    //attachment.name - name of attachment file, for example "my-image"
                    //attachment.status - usual is "inherit"
                    //attachment.subtype - "jpeg" if is "jpg"
                    //attachment.title
                    //attachment.type - "image"
                    //attachment.uploadedTo
                    //attachment.url - http url of image, for example "http://site.com/wp-content/uploads/2012/12/my-image.jpg"
                    //attachment.width


                    //if there is some field waiting for input
                    if (field_for_uploaded_file !== undefined) {

                        //if selected media is image
                        if(attachment.type === 'image'){
                            var file_url    = shortcode_lightbox_input()? attachment.sizes[selected_size].url : attachment.url,
                                _id         = $upload_input.attr('id'),
                                split_index = _id.lastIndexOf('_'),
                                id_start    = _id.substring(0, split_index),
                                id_end      = _id.substring(split_index);

                            //insert its src to waiting field
                            $upload_input.val(file_url);

                            //search & fill other inputs(META)
                            if(id_start.length){
                                //title of photo
                                $('#' + id_start + '_name' + id_end).val(attachment.caption);

                                //get attachment id
                                var pos_inp = $('#' + id_start + '_id' + id_end);
                                if(typeof attachment.id !== 'undefined'){
                                    pos_inp.val(attachment.id);
                                }
                                else{
                                    //remove id if any
                                    pos_inp.val('');
                                }

                                //change thumb
                                pos_inp.parent().next('img.thumb').attr('src', file_url).show();
                            }

                            //if upload for shortcode "Image with lightbox" to input "Image", then we auto-fill other inputs
                            if(shortcode_lightbox_input()){
                                //fill title
                                $('#apollo13-image-alt').val(attachment.title);
                                //fill url
                                //switched off
//                                $('#apollo13-image-url').val(attachment.link);
                                //fill dimensions
                                $('#apollo13-image-dimensions').val('width:' + attachment.sizes[selected_size].width + 'px; height:' + attachment.sizes[selected_size].height + 'px;');
                            }
                        }
                        //search for link and its href
                        else{
                            //insert its src to waiting field
                            $upload_input.val(attachment.url);
                        }

                        //send event to update fieldset
                        $upload_input.parents('div.fieldset').trigger('fill_fieldset');

                        //clean waiting variable
                        field_for_uploaded_file = undefined;
                    }
                },

                //checks for special case input
                shortcode_lightbox_input = function(){
                    return field_for_uploaded_file === 'apollo13-image-img';
                };

            $(document).on('click', upload_buttons_selector, a13_upload_file);
        },

        utils: {
            init : function(){
                var AU = A13_ADMIN.utils;

                AU.contact_drop_area();
                AU.color_picker();
                AU.slider_option();
                AU.sortable_socials();
                AU.fonts.init(AU);
            },

            contact_drop_area: function(){
                var da = $('#contact_drop_area');
                if(da.length){
                    var ll          = $('#contact_ll'),
                        zoom        = $('#contact_zoom'),
                        type        = $('#contact_map_type'),
                        llRegEx     = /ll=([0-9\.,\-]+)&?/ig,
                        zoomRegEx   = /&z=([0-9]+)&?/ig,
                        typeRegEx   = /&t=([a-z]+)&?/ig,
                        matches,

                        processField = function(){
                        var val     = da.val();

                        //if any value then please proceed
                        if(val.length){
//                            console.log(llRegEx.exec(val),zoomRegEx.exec(val), typeRegEx.exec(val));

                            //Latitude, Longitude
                            matches = llRegEx.exec(val);
                            if(matches !== null && matches.length === 2){
                                ll.val(matches[1]);
                            }

                            //Zoom
                            matches = zoomRegEx.exec(val);
                            if(matches !== null && matches.length === 2){
                                zoom.val(matches[1]).blur();
                            }

                            //Map type
                            matches = typeRegEx.exec(val);
                            if(matches !== null && matches.length === 2){
                                var realType;
                                if(matches[1] === 'k'){
                                    realType = 'SATELLITE';
                                }
                                else if(matches[1] === 'm'){
                                    realType = 'ROADMAP';
                                }
                                else if(matches[1] === 'h'){
                                    realType = 'HYBRID';
                                }
                                else if(matches[1] === 'p'){
                                    realType = 'TERRAIN';
                                }

                                type.val(realType);
                            }
                        }
                    };

                    //bind drop area
                    da.on('input blur', processField);

                }
            },

            /*** color picker ***/
            color_picker : function(){
                var input_color = $('input.with-color');
                if(input_color.length){
                    input_color.wheelColorPicker({
                        dir: AdminParams.colorDir,
                        format: 'rgba',
                        validate: true,
                        color: null
                    });

                    //transparent value
                    $('body').on('click', 'button.transparent-value', function(){
                        $(this).prev('input.with-color').attr('style','').val('transparent');
                        return false;
                    });
                }
            },

            /**** SLIDER FOR SETTING NUMBER OPTIONS ****/
            slider_option : function(){
                var sliders = $('div.slider-place');
                if(sliders.length){
                    //setup sliders
                    sliders.each(function(index){
                        var min,max,unit,$s;
                        //collect settings
                        $s = sliders.eq(index);
                        min = $s.data('min');
                        min = (min === '')? 10 : min; //0 is allowed now
                        max = $s.data('max');
                        max = (max === '')? 30 : max; //0 is allowed now
                        unit = $s.data('unit');

                        $s.slider({
                            range: "min",
                            animate: true,
                            min: min,
                            max: max,
                            slide: function( event, ui ) {
                                $( this ).prev('input.slider-dump').val( ui.value + unit );
                            }
                        });
                    });

                    //set values of sliders
                    $( "input.slider-dump" ).bind('blur', function(){
                        var _this = $(this),
                            value = parseInt(_this.val(), 10),
                            slider = _this.next('div.slider-place'),
                            unit = slider.data('unit');

                        if( !isNaN(value) && (value + '').length){ //don't work on empty && compare as string
                            slider.slider( "option", "value", value );
                            _this.val(value + unit);
                        }
                    }).trigger('blur');
                }
            },

            /**** SORTABLE SOCIALS ****/
            sortable_socials : function(){
                var pos_selector = 'input.vhidden',

                    create_sort = function(event/*, ui*/){
                        var items = $(event.target).find(pos_selector);

                        items.sort(function(a,b){
                            var _a = parseInt( $(a).val(), 10 ),
                                _b = parseInt( $(b).val(), 10 );
                            return _a - _b;
                        });

                        for(var i = 0, len = items.length; i < len; i++){
                            items.eq(i).val(i).parent().parent().appendTo('#sortable-socials > .inside');
                        }
                    },

                    update_sort = function(event, ui){
                        var index_1 = parseInt($(ui.item).find(pos_selector).val(), 10),
                            index_2 = parseInt($(ui.item).prev().find(pos_selector).val(), 10),
                            temp;

                        if(!index_2){
                            index_2 = 0;
                        }

                        //switch indexes if needed
                        if(index_1 > index_2){
                            temp    = index_1;
                            index_1 = index_2;
                            index_2 = temp;
                        }

                        var items = $('#sortable-socials').find(pos_selector);
                        for(var i = index_1; i <= index_2; i++){
                            items.eq(i).val(i);
                        }
                    };

                $('#sortable-socials').sortable({
                    axis: 'y',
                    distance: 10,
                    placeholder: "ui-state-highlight",
                    items: 'div.text-input',
                    cursor: 'move',
                    revert: true,
                    forcePlaceholderSize: true,
                    create: create_sort,
                    update: update_sort
                });
            },

            /**** SELECTING GOOGLE FONTS ****/
            fonts : {
                init: function(AU){
                    var s = $('select.fonts-choose'),
                        F = AU.fonts;
                    if(s.length){
                        //bind font change
                        s.change(F.change);

                        //bind sample text update
                        $('input.sample-text')
                            .on('blur input keyup', F.updateSampleText )
                            .on('dblclick', F.editSampleText);
                        $('span.sample-view').on('dblclick', F.editSampleText);

                        //bind selecting font parameters
                        $('div.font-info').on('change', 'input[type="checkbox"]',{}, F.makeFontWithParams);

                        //run to load selected font after page is loaded
                        s.change();
                    }
                },

                change: function(){
                    var _s = $(this),
                        parent = _s.parent(),
                        first_load = false,
                        F = A13_ADMIN.utils.fonts;

                    if(_s.hasClass('first-load')){
                        _s.removeClass('first-load');
                        first_load = true;
                    }

                    //if font is classic font don't make request
                    if(_s.find('option').filter(':selected').hasClass('classic-font')){
                        //set family for sample view
                        parent.find('span.sample-view').css('font-family', _s.val());
                        //clear font info
                        parent.find('div.font-info').find('div.variants, div.subsets').empty();
                        //fill hidden input
                        F.makeFontWithParams(_s, true);
                        return;
                    }

                    //google font details request
                    $.post(ajaxurl, {
                            action : 'a13_font_details', //called in backend
                            font : _s.val()    //value of select
                        },
                        function(r) { //r = response
                            //check if font was found
                            if(r !== false){
                                F.createHeadLink(r);
                                //don't overwrite saved option in first 'change' event
                                if(!first_load){
                                    parent.find('span.sample-view').css('font-family', r.family);
                                    F.fillInfo(r, _s);
                                    F.makeFontWithParams(_s);
                                }
                            }
                        },
                        'json'
                    );
                },

                createHeadLink: function(r){
                    var apiUrl = [],
                        url;

                    apiUrl.push('//fonts.googleapis.com/css?family=');
                    apiUrl.push(r.family.replace(/ /g, '+')); //font name -> font+name

                    if ($.inArray('regular', r.variants) !== -1) {
                        apiUrl.push(':');
                        apiUrl.push('regular,bold');
                    }
                    else{
                        apiUrl.push(':');
                        apiUrl.push(r.variants[0]);
                        apiUrl.push(',bold');
                    }
                    apiUrl.push('&subset=');
                    $.each(r.subsets, function(index, val){
                        //add comma if more subsets
                        if(index > 0){
                            apiUrl.push(',');
                        }
                        apiUrl.push(val);

                    });

                    url = apiUrl.join('');
                    // url: '//fonts.googleapis.com/css?family=Anonymous+Pro:bold&subset=greek'

                    $('head').append('<link href="'+url+'" rel="stylesheet" type="text/css" />');
                },

                updateSampleText: function(){
                    var inp = $(this);
                    inp.parent().find('span.sample-view').html(inp.val());
                },

                editSampleText: function(){
                    var elem = $(this);

                    if(elem.is('span')){//enable edit
                        elem.hide().prev().show().focus();
                    }
                    else{//disable edit
                        elem.hide().next().show();
                    }
                },

                fillInfo: function(r, select){
                    var info = select.parent().find('div.font-info'),
                        v = info.find('div.variants'),
                        s = info.find('div.subsets'),
                        html = '';

                    $.each(r.subsets, function(){
                        html += '<label><input type="checkbox" name="subset" value="'+this+'" />'+this+'</label>'+"\n";
                    });
                    s.empty().append(html);

                    html = '';
                    $.each(r.variants, function(){
                        html += '<label><input type="checkbox" name="variant" value="'+this+'" />'+this+'</label>'+"\n";
                    });
                    v.empty().append(html);
                },

                makeFontWithParams: function(s, classic_font){
                    //if called as event callback
                    if(!(s instanceof jQuery)){
                        s = $(this).parents('div.input-desc').eq(0).find('select');
                    }
                    if(typeof classic_font === 'undefined'){
                        classic_font = false;
                    }

                    var name = s.val(),
                        parent = s.parent(),
                        font_input = parent.find('input.font-request'),
                        variants = parent.find('.variants input').filter(':checked'),
                        subsets = parent.find('.subsets input').filter(':checked');

                    //it is not needed to strip colon and other stuff form classic fonts
                    //but missing colon will be used to easily distinguish classic from google
                    if(!classic_font){
                        //variants
                        //colon even if no variant
                        name +=':';
                        $.each(variants, function(index, val){
                            //add comma if more subsets
                            if(index !== 0){
                                name +=',';
                            }
                            name += $(val).val();
                        });

                        //subsets
                        $.each(subsets, function(index, val){
                            //add comma if more subsets
                            if(index === 0){
                                name +=':';
                            }
                            else{
                                name +=',';
                            }
                            name += $(val).val();
                        });
                    }

                    //fill input
                    font_input.val(name);
                }
            }

        },

        helpers : {
            //rewrite 'name', 'for', 'id', 'value' of children
            reindex_fields : function(element, new_index){
                var to_change = {
                    'name'  : '[name]',
                    'for'   : '[for]',
                    'id'    : '[id]',
                    'value' : '.switch-control input[type="radio"], .switch-control option'
                };

                //update counters
                element.attr('title', new_index);
                element.find('input.position').val(new_index);

                //change switch group name
                element.find('div.switch-group').each(function(){
                    var elem = $(this),
                        attr = elem.attr('data-switch'),
                        change = attr.lastIndexOf('_'),
                        name = attr.substring(0, change) + '_' + new_index;
                    elem.attr('data-switch', name);
                });

                //update inputs
                $.each(to_change, function(index, selector){
                    element.find(selector).each(function(){
                        var elem = $(this),
                            attr = elem.attr(index),
                            change = attr.lastIndexOf('_'),
                            name = attr.substring(0, change) + '_' + new_index;
                        elem.attr(index, name);
                    });
                });
            },

            //adds 'temp' to name of radio inputs so they won't lose selected value
            //while reindexing
            prepare_radio : function(element){
                element
                    .find('input[type="radio"]').each(function(){
                        var t = $(this),
                            n = t.attr('name');

                        t.attr('name', n+'temp');
                    });
            }
        },

        metaActions : {
            init : function(){
                //if there are meta fields check for special elements
                var apollo_meta = $('div.apollo13-metas'),
                    AM = A13_ADMIN.metaActions;

                if (apollo_meta.length) {
                    //bind switcher(hides unused options like image vs video)
                    apollo_meta.find('div.switch').children('div.input-parent').find('input[type="radio"], select').change(AM.change_switch);

                    //add actions for thumb boxes
                    AM.thumbBoxes_init(apollo_meta);
                    
                    //bind multi upload
                    AM.multi_upload();
                }
            },

            /* New MULTI UPLOAD WP 3.5 <=  */
            multi_upload : function(){
                var mu_button = $('#a13-multi-upload');

                if(mu_button.length){
                    var custom_file_frame,

                    //on start of selecting/uploading images
                        a13_upload_file = function(event){
                            event.preventDefault();

                            //makes 'Upload Files' tab default one
                            wp.media.controller.Library.prototype.defaults.contentUserSetting=false;

                            //If the frame already exists, reopen it
                            if (typeof(custom_file_frame)!=="undefined") {
                                custom_file_frame.close();
                            }

                            //Create WP media frame.
                            custom_file_frame = wp.media.frames.customHeader = wp.media({
                                //Title of media manager frame
                                title: "WP Media Uploader",
                                frame: 'select',
                                state: 'library',
                                multiple: true,
                                library: {
                                    type: 'image'
                                },
                                button: {
                                    text: "Insert image(s)"
                                }
                            });

                            //callback for selected images
                            custom_file_frame.on('select', a13_select_file);

                            //Open modal
                            custom_file_frame.open();
                        },

                    //after of selecting/uploading file
                        a13_select_file = function(){

                            var AM = A13_ADMIN.metaActions,
                                whole_state     = custom_file_frame.state(),
                                images          = whole_state.get('selection').models,
                                items_num       = images.length,
                                add_more_button = $('div.apollo13-metas').find('span.add-more-fields'),
                                added_set, attachment, number, fields, thumb_src, thumb;

                            if (items_num) {
                                for(var i = 0; i < items_num; i++){
                                    added_set   = AM.add_item.apply(add_more_button);
                                    number      = added_set.attr('title');
                                    attachment  = images[i].toJSON();
                                    fields      = added_set.find('div.thumb-fields');
                                    thumb_src   = (typeof attachment.sizes.thumbnail !== 'undefined')? attachment.sizes.thumbnail.url : attachment.sizes.full.url;
                                    thumb       = fields.find('img.thumb');

                                    //fill fields
                                    $('#post_image_' + number).val(attachment.url);
                                    $('#post_image_name_' + number).val(attachment.title);
                                    $('#post_image_id_' + number).val(attachment.id);

                                    if(typeof thumb_src !== 'undefined' && thumb_src.length){
                                        if(thumb.length){
                                            thumb.attr('src', thumb_src).show();
                                        }
                                    }

                                    //send event to update field-set
                                    added_set.trigger('fill_fieldset');
                                }

                            }
                        };

                    mu_button.click(a13_upload_file);
                }
            },

            thumbBoxes_init : function(apollo_meta){
                var AM = A13_ADMIN.metaActions,
                    thumb_boxes = apollo_meta.find('div.thumb-info'),
                    one_and_empty = false;

                if(thumb_boxes.length){
                    //if only one item
                    if(thumb_boxes.length === 1){
                        //check is it filled, if not hide it later(save field-set as prototype)
                        if($('#post_image_1').val().length === 0 && $('#post_video_1').val().length === 0){
                            one_and_empty = true;
                        }
                    }

                    //adds 'remove button' for all additives sets
                    $('<span class="button remove-fieldset">Remove item</span>').appendTo(apollo_meta.find('div.thumb-info'));

                    if(one_and_empty){
                        thumb_boxes.eq(0).parent().addClass('hidden');
                    }
                    else{
                        //fill thumb-info with data
                        for(var i = 0, count = thumb_boxes.length; i < count; i++ ){
                            AM.fill_thumb_info.apply(thumb_boxes.eq(i));
                        }
                    }

                    apollo_meta
                        .on('click','span.thumb-show-fields',{}, AM.show_thumb_fields)
                        //bind add more fields button
                        .on('click', 'span.add-more-fields', {single: true}, AM.add_item)
                        .on('click','span.remove-fieldset', {}, AM.remove_item)
                        .on('blur', 'div.thumb-fields input', {}, AM.fill_thumb_info)
                        .on('fill_fieldset', 'div.fieldset', {}, AM.fill_thumb_info);

                    apollo_meta.sortable({
                        axis: 'y',
                        distance: 10,
                        placeholder: "ui-state-highlight",
                        handle: 'div.thumb-info',
                        items: 'div.additive',
                        revert: true,
                        forcePlaceholderSize: true,
                        cursor: 'move',
                        update: AM.update_sort_thumbs
                    });
                }

            },

            fill_thumb_info : function(event){
                var elem = this;
                //if not yet a jQuery object then make it so
                if(!(elem instanceof jQuery)){
                    elem = $(elem);
                }

                //check if we have element to fill
                if(!elem.is('div.thumb-info')){
                    //maybe we are passing field-set
                    elem = $(this).find('div.thumb-info');
                    if(!elem.length){
                        //maybe we are passing children
                        elem = $(this).parents('div.thumb-fields');

                        if(elem.length){
                            //found it :-)
                            elem = elem.prev('.thumb-info');
                        }
                        else{
                            //what we are doing here?
                            return;
                        }
                    }
                }

                var fields          = elem.next('.thumb-fields'),
                    type            = fields.find('div.switch').find('input[type="radio"]').filter(':checked').val(),
                    big_img         = fields.find('img.thumb'),
                    thumb_src       = big_img.attr('src'),
                    thumb_alt_src   = fields.find('input.for-thumb').val(),
                    thumb_title     = fields.find('input.for-thumb-title').val(),
                    thumb_title_v   = fields.find('input.for-thumb-title-video').val();

//                if(!fields.is(':visible')){
//                    elem.siblings().hide();
//                }

                if(typeof type !== 'undefined'){
                    if(type.lastIndexOf('image') !== -1){
                        if(typeof thumb_title !== 'undefined'){
                            elem.find('span.thumb-title').text(thumb_title);
                        }
                        //read from real thumb
                        if(typeof thumb_src !== 'undefined' && thumb_src.length){
                            elem.find('img').attr('src', thumb_src).show();
                        }
                        //read from input with URL to thumb
                        else if(typeof thumb_alt_src !== 'undefined' && thumb_alt_src.length){
                            elem.find('img').attr('src', thumb_alt_src).show();
                        }
                    }
                    else if(type.lastIndexOf('video') !== -1){
                        if(typeof thumb_title_v !== 'undefined'){
                            elem.find('span.thumb-title').text(thumb_title_v);
                        }
                        //hide thumb
                        elem.find('img').attr('src', '').hide();
                    }
                }
            },

            clear_thumb_info : function(elem){
                var position = elem.find('input.position').val();

                elem
                    //hide big thumb
                    .find('img.thumb').attr('src', '').hide()
                    //empty id of attachment
                    .end().find('#post_image_id_' + position).val('')
                    //other fields
                    .end().find('div.thumb-info')
                    //hide small thumb
                    .find('img').attr('src', '').hide()
                    //clear title
                    .end().find('span.thumb-title').text('');
            },

            //show/hide thumb fields
            show_thumb_fields : function(event, fast){
                var link            = $(this),
                    current_text    = link.text(),
                    info            = link.parents('.thumb-info'),
                    elems           = info.siblings(),
                    speed           = typeof fast === 'undefined'? 200 : 0;

                link.text(link.data('swaptext')).data('swaptext', current_text);
                if(link.hasClass('open')){
                    elems.slideUp(speed);
                    link.removeClass('open');
                }
                else{
                    elems.slideDown(speed);
                    link.addClass('open');
                }
            },

            /**** SORTABLE THUMBS ****/
            update_sort_thumbs : function(event, ui){
                var index_1 = parseInt(ui.item.attr('title'), 10),
                    index_2 = parseInt(ui.item.prev().attr('title'), 10),
                    temp,
                    items = ui.item.parents('div.apollo13-metas').find('div.additive'),
                    i;


                if(!index_2){
                    index_2 = 1;
                }

                //switch indexes if needed
                if(index_1 > index_2){
                    temp    = index_1;
                    index_1 = index_2;
                    index_2 = temp;
                }

                //man o man, I made stupid indexes for that one. MUST always start from 0 Index!
                //reindex other sortable elements
                for(i = index_1-1; i < index_2; i++){
                    A13_ADMIN.helpers.prepare_radio(items.eq(i));
                }
                for(i = index_1-1; i < index_2; i++){
                    A13_ADMIN.helpers.reindex_fields(items.eq(i), i+1);
                }
            },

            change_switch : function(){
                var input   = $(this),
                    parent  = input.parents('div.switch').eq(0), /* first switch parent */
                    to_show = input.val();

                parent
                    .children('div.switch-group').hide()
                    .filter('[data-switch="'+to_show+'"]').show();
            },

            add_item : function(event){
                var marked_place    = $(this).parent(),
                    _prototype      = marked_place.prev('div.additive'),
                    insert          = A13_ADMIN.metaActions.clear_fieldset(_prototype.clone(true, true)), //clone last element
                    current_number  = parseInt(insert.attr('title'), 10),
                    new_number      = current_number + 1,
                    opener          = insert.find('span.thumb-show-fields'),
                    single_add      = (typeof event !== 'undefined' && typeof event.data.single !== 'undefined');

                //adding first item
                if(_prototype.hasClass('hidden')){
                    _prototype.removeClass('hidden');
                    opener = _prototype.find('span.thumb-show-fields');
                    insert = _prototype;
                }
                else{
                    //alter current number
                    insert.attr('title', new_number);

                    A13_ADMIN.helpers.prepare_radio(insert);
                    A13_ADMIN.helpers.reindex_fields(insert, new_number);

                    //alter mover
                    insert
                        .find('input.position').val(new_number)
                        .end().insertBefore(marked_place)
                        .siblings('.counter-input').val(new_number)
                        //reset switch
                        .end().find('input[name="image_or_video_' + new_number + '"]').eq(0).prop('checked', true).change();
                }

                //open field-set
                //adding one item
                if(single_add && !opener.hasClass('open')){
                    opener.click();
                }
                //adding multiple items
                else if(!single_add && opener.hasClass('open')){
                    opener.trigger('click', [1]);
                }

                return insert;
            },

            clear_fieldset : function(element){
                var inputs = element.find('input[type="text"]'),
                    text_area = element.find('textarea'),
                    i, count;

                for(i = 0, count = inputs.length; i < count; i++){
                    inputs.eq(i).val('');
                }
                for(i = 0, count = text_area.length; i < count; i++){
                    text_area.eq(i).val('');
                }

                A13_ADMIN.metaActions.clear_thumb_info(element);

                return element;
            },

            remove_item : function(){
                var main = $(this).parents('.fieldset.additive'),
                    index = parseInt(main.attr('title'), 10),
                    successors = main.nextAll('.fieldset.additive'),
                    predecessors = main.prevAll('.fieldset.additive'),
                    counter, i, count;

                //if only one left
                if(!successors.length && !predecessors.length ){
                    A13_ADMIN.metaActions.clear_fieldset(main).addClass('hidden');
                }
                //last one
                else if(!successors.length && predecessors.length){
                    counter = parseInt(main.prevAll('input.counter-input').val(), 10);
                    main.prevAll('input.counter-input').val(counter - 1);
                    main.fadeOut(250,function(){ main.remove(); });
                }
                //have successors
                else if(successors.length){
                    for(i = 0, count = successors.length; i < count; i++ ){
                        A13_ADMIN.helpers.prepare_radio(successors.eq(i));
                    }
                    for(i = 0, count = successors.length; i < count; i++ ){
                        A13_ADMIN.helpers.reindex_fields(successors.eq(i), index + i);
                    }

                    counter = parseInt(main.prevAll('input.counter-input').val(), 10);
                    main.prevAll('input.counter-input').val(counter - 1);
                    main.fadeOut(250,function(){ main.remove(); });
                }
            }
        },

        settingsAction : function(){
            //sliding options fields sets
            var hide_fieldset = function(){
                var bar = $(this),
                    block = bar.parent(),
                    input = bar.find('input[type="hidden"]');

                if(block.hasClass('closed')){
                    block.removeClass('closed');
                    bar.next('div.inside').slideDown(300);
                    input.val('1');
                }
                else{
                    input.val('0');
                    bar.next('div.inside').slideUp(300, function(){
                        block.addClass('closed');
                    });
                }
            };

            $('div.fieldset-name').click(hide_fieldset);

            //iframe with help
            var show_help = function(e){
                e.preventDefault();

                tb_show('Apollo13 inline documentation', $(this).attr('href') + '?TB_iframe=true&amp;width=1100' );
            };

            $('.help-info a').click(show_help);
        }
    };

    var A13_ADMIN = window.A13_ADMIN;

    //start ADMIN
    $(document).ready(A13_ADMIN.onReady);

})(jQuery);