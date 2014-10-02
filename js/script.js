//if someone use prototype or other library
//we better be safe :-)
jQuery.noConflict();

(function($, window, document){
    /*global ApolloParams, Modernizr, debounce, throttle */
    "use strict";


    var A13,
        $html       = $(document.documentElement),
        body        = document.body,
        $body       = $(body),
        $window     = $(window),
        G           = ApolloParams,
        isTouch     = Modernizr.touch,
        header, mid,//DOM elements

        BP = [650]; //media queries break points


    window.A13 = { //A13 = APOLLO 13
        //run after DOM is loaded
        onReady : function(){
            if(typeof $.fn.masonry !== 'undefined'){
                //add scroll bar to fix some delayed resize issues
                $html.addClass('show-scroll');
            }

            //bind html elements to vars
            mid = $('#mid');
            header = $('#header');

//            log ($window.width(), $window.height());

            //bind resize
            $window.resize(debounce(A13.layout.resize, 250));
            $body.on('webfontsloaded', function(){ $window.resize(); });
            A13.layout.set(); //set current size
            A13.runPlugins();
            A13.elementsActions.init();
            A13.galleryView();
            A13.worksOrGalleriesList();
            A13.A13Slider();
            A13.A13Scroller();
            A13.A13FullWidthPhotos();
            A13.FrontPageSlider();
        },

        layout : {
            pointers : [],

            size : 0,

            add : function(f){
                A13.layout.pointers.push(f);
            },

            set : function(){
                var size = !window.getComputedStyle? null : getComputedStyle(body,':after').getPropertyValue('content'),
                    width = $window.width(),
                    index = (size === null)? -1 : size.indexOf("narrow"),
                    to_return;

                //if we can get value of current media query(normal desktop browsers)
                if(index !== -1){
                    to_return = parseInt(size.substr(index + 6), 10);
                }
                //most mobile browsers can't get above so we get normal window measure
                else{
                    to_return = width;
                }

                A13.layout.size = to_return;

                return to_return;
            },

            resize : function(e){
                //log ('go go resize callbacks!')
                var A = A13.layout,
                    size = A.set(),
                    pointers = A.pointers;

//                log ('window size: '+$window.width()+' X '+$window.height());
//                log ('resize ', e.timeStamp);

                //call each registered for resize function
                for(var i = 0; i < pointers.length; i++){
                    pointers[i].call(this, e, size);
                }
            }
        },

        runPlugins : function(){
            //Resize iframe videos (YT, VIMEO)
            $("div.post-media, div.real-content").fitVids();
        },

        elementsActions : {
            init : function(){
                var $e = A13.elementsActions;

                /******* TOP MENU *********/
                $e.topMenu();

                /******* CLOSING PAGES TO VIEW BACKGROUND *********/
                $e.hider();

                /******* CHANGES HEADER STYLE DEPENDING ON AVAILABLE PLACE *********/
                $e.header();

                /******* TO TOP LINK *********/
                $e.toTop();

                /******* BLOG MASONRY *********/
                $e.blogMasonry();

                /******* Contact & Comment validation *********/
                $e.formValidation();

                /******* Tabs from short codes *********/
                $e.shortCodeTabs();

                /******* Lightbox *********/
                $e.lightbox();

            },

            topMenu : function(){
                var a = $('#access'),
                    sub_menus = a.find('ul.sub-menu'),
                    sub_parents = sub_menus.parent().addClass('parent'),
                    menu = a.children('div.menu-container'),
                    menu_list = menu.children(),
                    menu_init = a.find('h3.assistive-text'),
                    size = A13.layout.size,

                    registerHover = function(){
                        //Hover action
                        sub_parents
                            .hoverIntent({
                                over: function(){
                                    var _this = $(this);
                                    //better homogeneity
                                    _this.addClass('hovered');
                                    //hide every menu that is open on same level
                                    _this.siblings('li').has('ul').removeClass('hovered');
                                },
                                out: function(){
                                    $(this).removeClass('hovered');
                                },
                                interval: 50,
                                timeout: 500
                            })
                            .on('click.touchsub', function(e){
                                if(parseFloat($(this).children('ul').css('opacity')) === 0){
                                    //stop event to enable showing sub menu on touch devices
                                    e.preventDefault();
                                }
                            });
                    },

                    unregisterHover = function(){
                        //unbind hoverintent
                        sub_parents
                            .unbind("mouseenter")
                            .unbind("mouseleave")
                            .removeProp('hoverIntent_t')
                            .removeProp('hoverIntent_s')
                            .off('click.touchsub');
                    },

                    mobile_menu_toggle = function(){
                        if(menu.hasClass('open')){
                            menu.slideUp(200, function(){
                                menu_list.hide();//helps with menu 'flicker' on IOS
                            });
                            menu.removeClass('open');
                        }
                        else{
                            menu_list.show(); //helps with menu 'flicker' on IOS
                            menu.slideDown(200);
                            menu.addClass('open');
                        }
                    },

                    mobile_submenu_toggle = function(e){
                        var menu = $(this).children('ul');

                        if(!menu.hasClass('open')){
                            menu.slideDown(200);
                            menu.addClass('open');
                            e.preventDefault();
                        }
                    },

                    //resize for menu
                    layout = function(event, size){
                        //if wide screen
                        if(size > BP[0]){
                            a.removeClass('touch');
                            menu_init.off('.touch');
                            //clean after touch menu
                            menu.removeClass('open').attr('style','');
                            menu_list.attr('style','');

                            if(sub_menus.length){
                                sub_parents.off('.touch');
                                //clean after touch menu
                                sub_menus.removeClass('open').attr('style','');
                                registerHover();
                            }
                        }
                        else{
                            a.addClass('touch clearfix');
                            //bind open menu
                            //no double binds!
                            menu_init.off('.touch');
                            menu_init.on('click.touch', mobile_menu_toggle);

                            if(sub_menus.length){
                                unregisterHover();
                                //bind open submenu
                                //no double binds!
                                sub_parents.off('.touch');
                                sub_parents.on('click.touch', mobile_submenu_toggle);
                            }
                        }
                    };

                //register resize
                A13.layout.add(layout);

                //initial layout
                layout({}, size);

                //show menu
                menu.addClass('loaded');
            },

            hider:  function(){
                var C = $('#content'),
                    bg = $('#bg-image');

                //if static page with background, or contact page with map
                if((bg.length && $body.hasClass('page')) || ($body.hasClass('contact-page') && $('#map-canvas').length)){
                    $('<em class="hider" />')
                        .appendTo(C)
                        .click(function(){
                            //content hidden
                            if(C.hasClass('hideIt')){
                                //collect normal dimensions
                                var saveStyle = C.attr('style'),
                                    width = C.attr('style','').removeClass('hideIt').css('visibility','hidden').width(),
                                    height = C.height(),
                                    pR = C.css('padding-right'),
                                    pB = C.css('padding-bottom');

                                C.attr('style',saveStyle).animate({width: width, height: height, paddingRight: pR, paddingBottom: pB},500,
                                    function(){
                                        C.attr('style',''); //just in case
                                    });
                            }
                            //content visible
                            else{
                                C.css('overflow','hidden').animate({width: 0, height: 0, paddingRight: 0, paddingBottom: 0},500,
                                    function(){
                                        C.addClass('hideIt').css('overflow','');
                                    });
                            }
                        });
                }
            },

            header:  function(){
                var H = $('#header'),
                    HH = H.find('div.head'),
                    F = $('#footer'),
                    H_p = parseInt(H.css('padding-top'), 10),
                    _class = 'no-space',
                    logo = $('#logo').children(),

                    enough_space = function(){
                        if( H.hasClass(_class) ){
                            H.removeClass(_class);
                            $body.append(F);
                        }
                    },

                    not_enough_space = function(){
                        if( !H.hasClass(_class) ){
                            H.addClass(_class);
                            H.append(F);
                        }
                    },

                    //resize function
                    layout = function(event, size){
                        if(size > BP[0]){
                            if( $window.height() < ( H_p + HH.height() + F.outerHeight() ) ){
                                not_enough_space();
                            }
                            else{
                                enough_space();
                            }
                        }
                        else{
                            enough_space();
                        }
                    };

                //register resize
                A13.layout.add(layout);

                //initial layout
                layout({}, A13.layout.size);

                //if img logo we need event for loading it
                if(logo.is('img')){
                    logo.load(function(){
                        //inform about possible resize
                        $body.trigger('logoLoaded');
                    });
                }

                //measure again after logo is loaded
                $body.on('logoLoaded', function(e){ layout(e, A13.layout.size); });
            },

            toTop : function(){
                var tt = $('#to-top'),
                    cb = function(){
                        if ($window.scrollTop() > 100) {
                            tt.css('opacity', 1);
                        } else {
                            tt.css('opacity', 0);
                        }
                    };

                if(tt.length){
                    cb(); //fire after refresh
                    $window.scroll(debounce(cb, 250));
                    // scroll body to 0px on click
                    tt.click(function () {
                        $('body,html').animate({
                            scrollTop: 0
                        }, 800);
                        return false;
                    });
                }
            },

            blogMasonry : function(){
                var $container = $('#masonry-parent');
                if($container.length){
                    A13.lazy({
                        container        : $container,
                        childrenSelector : 'div.archive-item'
                    });
                }
            },

            formValidation : function(){
                //if enabled theme validation, then validate also comment form
                var c_f_selector, c_f;
                if($body.hasClass(G.validation_class)){
                    c_f_selector = '#commentform, form[name="apollo-contact-form"]';
                }
                else{
                    c_f_selector = 'form[name="apollo-contact-form"]';
                }

                c_f = $(c_f_selector);
                if (c_f.length) {
                    (function(){
                        var info = c_f.find('div.form-info').click(function(){
                                info.slideUp(300,function(){ info.removeClass('error'); });
                            }),
                            comment_submit = $('#comment-submit');

                        //fix for not submitting form after check http://jibbering.com/faq/names/
                        if(comment_submit.length){
                            comment_submit.attr('name','othername');
                        }

                        c_f.submit(function(e){
                            var form = $(this),
                                error_number = 0,
                                inputs = form.find('input[aria-required], textarea'), //only required fields
                                captcha = form.find('input[name="cptch_number"]');

                            //check if captcha is used
                            if(captcha.length){ inputs = inputs.add(captcha); }

                            //check every input for errors
                            for(var item = 0; item < inputs.length; item++){
                                var inp = inputs.eq(item),
                                    inp_p = inp.parent();
                                //scan for empty fields
                                if( ! $.trim( inp.val()).length ){
                                    inp_p.addClass('error');
                                    error_number++;
                                    continue;
                                }

                                //check e-mail field
                                if( inp.is('#email') ){
                                    var emailRegEx = /^[A-Z0-9._%+\-]+@[A-Z0-9.\-]+\.[A-Z]{2,4}$/i;
                                    if (inp.val().search(emailRegEx) === -1) {
                                        inp_p.addClass('error');
                                        error_number++;
                                        continue;
                                    }
                                }

                                // everything ok
                                inp.parent().removeClass('error');
                            }

                            //if there were some errors
                            if( error_number > 0 ){
                                e.preventDefault();
                                //animate error text
                                info.addClass('error').text(info.data('error-msg')).slideDown();
                            }
                            //no errors - normal submit
                        });
                    })(); // <---- call it instantly
                }
            },

            shortCodeTabs : function(){
                //tabs Container
                var tC = $('div.tabsCell');

                if(tC.length){
                    var tabs = tC.find('div.tab_content').hide(),
                        tabsOptions = tC.find('ul.tabs li'); //Hide all content

                    //Default Action
                    tabsOptions.filter(':first-child').addClass('active'); //Activate first tab
                    tabs.filter(':first-child').show(); //Show first tab content

                    //On Click Event
                    tabsOptions.click(function(e) {
                        e.preventDefault();

                        var tab = $(this),
                            parent = tab.parents('div.tabsCell').eq(0),
                            activeTab = tab.find("a").attr("href"); //Find the rel attribute value to identify the active tab + content

                        if(tab.hasClass('active')){
                            return;
                        }

                        tab.siblings().removeClass('active'); //Remove any "active" class
                        tab.addClass('active'); //Add "active" class to selected tab
                        parent.find('div.tab_content').hide(); //Hide all tab content
                        parent.find(activeTab).fadeIn(); //Fade in the active content
                    });
                }
            },

            lightbox : function(elems){
                //if no lightbox script do nothing
                if(typeof $.jackBox !== 'undefined'){
                    //if run only for some elements
                    if(typeof elems !== 'undefined'){
                        elems.not('.link') //not items that are marked as links
                            .each(function(){ $(this).jackBox("newItem"); });
                    }
                    else{
                        $('a.alpha-scope[data-group]').jackBox("init", {
                            baseName: G.jsurl+"/jackbox",
                            className: 'a.alpha-scope',
                            defaultShareImage: G.defimgurl,
                            showPageScrollbar: true,
                            deepLinking: false,
                            showInfoByDefault: true
                        });
                    }
                }
            }
        },

        galleryView : function(){
            var $container = $('#a13-gallery').filter('.bricks');
            if($container.length){
                //em for cover
                $container.find('a.g-item').append('<em class="cov" />');

                A13.lazy({
                    container        : $container,
                    childrenSelector : 'a.g-item',
                    imagesAlso       : true,
                    afterAddCB       : A13.elementsActions.lightbox //adds lightbox for new item
                });
            }
        },

        worksOrGalleriesList : function(){
            var $container = $('#a13-works, #a13-galleries');
            if($container.length){
                A13.lazy({
                    container        : $container,
                    childrenSelector : 'a.g-item',
                    imagesAlso       : true,
                    filter           : '#genre-filter'
                });

                //open item when it is tapped twice
                $container.on('click', 'a.g-item',{}, function(e){
                    var t = $(this);

                    if(isTouch && !t.hasClass('touched')){
                        e.preventDefault();//if clicked in link
                        t.addClass('touched').siblings().removeClass('touched');
                    }
                });
            }
        },

        A13Slider : function(){
            var $container = $('#a13-gallery').filter('.slider');
            if($container.length){
                var images = [],
                    items = $container.find('a.g-item'),
                    i,item, type;

                //collect data from item
                for(i = 0; i < items.length; i++){
                    item = items.eq(i);
                    type = item.data('type');

                    images.push({
                        type:       type,
                        image:      item.data('image'),
                        title:      item.data('title'),
                        desc:       $(item.data('description')).html(),
                        autoplay:   item.data('autoplay'),
                        movie_type: item.data('movie_type'),
                        bg_color:   item.data('bg_color'),
                        url:        type==='image' && item.hasClass('link')? item.attr('href') : false
                    });
                }

                //call script
                $.a13slider({
                    parent                  :   $container.parent(),                // where will be embeded slider
                    autoplay				:	parseInt(G.autoplay, 10),			// Slider starts playing automatically
                    random                  :   parseInt(G.random, 10),             // Randomize slide order (Ignores start slide)
                    slide_interval          :   parseInt(G.slide_interval, 10),     // Time between transitions
                    transition              :   parseInt(G.transition, 10),         // 0-None, 1-Fade, 2-Carousel
                    transition_speed		:	parseInt(G.transition_speed, 10),   // Speed of transition
                    fit_variant				:	parseInt(G.fit_variant, 10),        // 0-always, 1-landscape, 2-portrait, 3-when_needed
                    slide_links             :   'blank',                            // type of slide links ('num', 'name', 'blank', false)
                    slides                  :   images                              // Slideshow Images
                });

                //after collect remove all DOM elements
                $container.remove();
            }
        },

        A13Scroller : function(){
            var $container = $('#a13-scroll-pan');
            if($container.length){
                var $tape		= $('#a13-work-slides'),
                    $items      = $tape.children(),
                    $images     = $items.find('img'),
                    $images_number	= $images.length,
                    arrows          = $('<div class="arr left" /><div class="arr right" />').appendTo($container),
                    scroller_width	= 0,
                    tempCounter     = 0,
                    scrollSpeed     = 450,
                    maxScroll       = 0, //left tape edge
                    minScroll,           //right tape edge

                    init = function(){
                        config();
                        initEvents();
                        A13.removeLoader();
                        $container.addClass('ready');
                    },

                    config = function(){
                        //reset
                        scroller_width = 0;

                        //calculate width of all items
                        $items.each(function(){
//                            console.log(scroller_width, $(this).outerWidth(true));
                            scroller_width += $(this).outerWidth(true);
                        });
                        $tape.css('width',scroller_width+'px');

                        //setup min value
                        minScroll = -(scroller_width - $container.width());
                    },

                    move = function(val){
                        if(val < minScroll){ val = minScroll; }
                        else if(val > maxScroll){ val = maxScroll; }

                        //we turned off css transitions for touch devices, so scrolling with finger will work proper
                        if(Modernizr.csstransitions && !isTouch){
                            $tape.css({left : val + 'px'});
                        }
                        else{
                            $tape.stop().animate({
                                left : val + 'px'
                            },600,'easeOutExpo');
                        }
                    },

                    initEvents = function(){
                        //slide as we scroll with the mouse
                        $container
                            //first for throttled function
                            .mousewheel(throttle(function(e, delta) {
                                move(parseInt($tape.css('left'), 10) + delta*scrollSpeed);
                            }))
                            //second for every call to not scroll page while using mouse over tape
                            .mousewheel(function(e){e.preventDefault();});

                        arrows.click(function(){
                            var dir = $(this).hasClass('left')? 1 : -1;
                            move(parseInt($tape.css('left'), 10) + dir*scrollSpeed);
                        });

                        //bind events
                        if(isTouch){
                            var $frame = $container,    //visible frame, parent of tape
                                frameDOM = $frame[0],   //DOM element
                                tape = $tape,           //moving part
                                currentPosition,        //position of tray on start
                                currentX,               //current position of finger
                                startX,                 //where was finger at move start
                                lastX,                  //last finger saved for comparison
                                preLastDistance = 0,    //pre last distance, for edge cases
                                lastT,                  //last time we checked distance
                                threshold = 120,        //maximum time of no-move
                                maxTapDistance = 7,
                                multiplier = 5,
                                now,

                                //for checking if current move want get out of tape scope
                                checkEdges = function(distance){
                                    if(distance > 0){
                                        return 0;
                                    }
                                    else if(distance < minScroll){
                                        return minScroll;
                                    }
                                    return distance;
                                },

                                onTouchStart = function(e){
                                    //do nothing
                                    if($frame.hasClass('nomove') === true){
                                        return;
                                    }
                                    if (e.touches.length === 1) {
                                        //collect init data
                                        lastT = Number(new Date());
                                        lastX = startX = currentX = e.touches[0].pageX;
                                        tape.stop(); //stop any animation
                                        currentPosition = parseInt(tape.css('left'), 10);

                                        //bind events for other work
                                        frameDOM.addEventListener('touchmove', onTouchMove, false);
                                        frameDOM.addEventListener('touchend', onTouchEnd, false);
                                    }
                                    //more fingers - we don't react
                                    else{ e.preventDefault(); }
                                },

                                onTouchMove = function(e){
                                    e.preventDefault();

                                    currentX = e.touches[0].pageX;
                                    now = Number(new Date());
                                    //if it is time for new measure new distance
                                    if(now - lastT > threshold){
                                        preLastDistance = lastX - currentX;
                                        lastT = now;
                                        lastX = currentX;
                                    }

                                    //update position of tape
                                    tape.css('left', checkEdges(parseInt(currentPosition - (startX - currentX), 10)) );
                                },

                                onTouchEnd = function(e){
                                    var now = Number(new Date()),
                                        time = now - lastT,
                                        //calculate distance in full time cycle
                                        lastDistance = parseInt(threshold/time * (lastX - currentX), 10),
                                        ldAbs = Math.abs(lastDistance),
                                        animationDistance = 0;

                                    if(ldAbs > maxTapDistance * multiplier){
                                        animationDistance = lastDistance;
                                    }
                                    else if(Math.abs(preLastDistance) > maxTapDistance && time < threshold){
                                        animationDistance = preLastDistance;
                                    }

                                    //micro move we treat like tap
                                    if(!(preLastDistance === 0 && ldAbs <= maxTapDistance)){
                                        //it was NOT tap
                                        //it was slide
                                        e.preventDefault();

                                        if(animationDistance !== 0){
                                            tape.stop()
                                                .animate({
                                                    left : checkEdges(parseInt(tape.css('left'), 10) - animationDistance * multiplier)
                                                }, 1000, 'easeOutSine');
                                        }
                                    }

                                    // finish the touch by undoing the touch session
                                    frameDOM.removeEventListener('touchmove', onTouchMove, false);
                                    frameDOM.removeEventListener('touchend', onTouchEnd, false);
                                    //clean after work
                                    preLastDistance = currentX = startX = 0;
                                };

                            frameDOM.addEventListener('touchstart', onTouchStart, false);
                        }
                    },

                    //resize function
                    layout = function(){
                        //reset
                        scroller_width = 0;

                        //reset widths
                        $images.each(function() {
                            var $img = $(this);
                                $img.css('width','').css('width', $img.width());

                            scroller_width += $img.outerWidth(true);
                        });

                        //new values
                        $tape.css('width',scroller_width+'px');
                        minScroll = -(scroller_width - $container.width());

                        //check if out of bounds
                        move(parseInt($tape.css('left'), 10));
                    };

                //register resize
                A13.layout.add(layout);

                //loader
                A13.addLoader($container);

                //preload the images
                $images.each(function() {
                    var $img = $(this);
                    $('<img/>').load(function(){
                        //counters odd issue when overflow:hidden; is enabled on container
//                        console.log('set', $img.attr('src'),$img.width(), this.width);
                        var width = $img.width();
                        width = width === 0? this.width : width; //protection from wrong reading of width after load
                        $img.css('width', width);

                        ++tempCounter;
                        //if last image is loaded start everything
                        if(tempCounter === $images_number){ init(); }
                    }).attr('src',$img.attr('src'));
                });

                //add interactive elements
                $items.each(function(){
                    var $t = $(this),
                        dt = $t.data('title');

                    $t.append('<i></i>'+(typeof dt === 'undefined' ? '' : '<em>'+dt+'</em>'));
                });

                //add items to lightbox
                A13.elementsActions.lightbox($items);
            }
        },

        A13FullWidthPhotos : function(){
            var $container = $('#a13-full-photos');
            if($container.length){
                var $items  = $container.children();
//                    $images = $items.find('img');

                //add interactive elements
                $items.append('<i></i>');

                //add items to lightbox
                A13.elementsActions.lightbox($items);
            }
        },

        FrontPageSlider : function(){
            if($body.hasClass('front-page-slider')){
                var layout = function(event, size){
                    var slider = $('#a13-revo-slider'),
                        w_h = $window.height(),
                        s_h = slider.height();

//                console.log(w_h, s_h);
                    if(size > BP[0] && w_h > s_h){
                        slider.addClass('position').css('top', (w_h -s_h)/2);
                    }
                    else{
                        slider.removeClass('position').css('top', '');
                    }
                };

                //register resize
                A13.layout.add(layout);

                //initial layout
                layout({}, A13.layout.size);
            }
        },

        lazy : function(options){
            options = $.extend( true, {}, {
                container        : '',
                childrenSelector : '',
                imagesAlso       : false, /* Resize images in bricks also */
                filter           : false, /* if false we are not using filter */
                afterAddCB       : function(){}
            }, options );

            var $container          = options.container,
                defWidth            = parseInt(G.brick_width, 10),
                defMargin           = (typeof G.brick_margin === 'undefined')? 0 : parseInt(G.brick_margin, 10),
                defHeight           = (typeof G.brick_height === 'undefined')? 0 : parseInt(G.brick_height, 10),
                loadAll             = (typeof G.per_page === 'undefined')? 0 : parseInt(G.per_page, 10),
                minLoad             = 2,
                //copy all html to var and remove it from DOM
                bricksSave          = $container.children().remove(),
                bricksNo            = bricksSave.length,
                $parent             = $container.parent(),
                filter              = (options.filter === false)? '' : $(options.filter),
                noImageResize       = (typeof $container.data('no-resize') !== 'undefined'),
                _throttle,

                countWidth = function(items){
                    var space = $parent.width(),
                        bricks = (items instanceof jQuery)? items : $container.children(),
                        perRow = parseInt(space/defWidth, 10),
                        fluidWidth, fluidHeight;

                    if(perRow < 1){ perRow = 1; }
                    fluidWidth = Math.floor((space - (perRow+1) * defMargin) / perRow);

                    //or items will be wider then 1.2 of normal width
                    if(fluidWidth > 1.2 * defWidth){
                        perRow++;
                        fluidWidth = Math.floor((space - (perRow+1) * defMargin) / perRow);
                    }

                    bricks.css('width', fluidWidth);

//                    if(options.imagesAlso)
//                        bricks.find('span').css('height','');

                    //keep ratio of resize for height
                    if(defHeight > 0){
                        fluidHeight = Math.round(fluidWidth/defWidth * defHeight);
                        bricks.css('height', fluidHeight);
                    }
                    //prepare img parent element for zooming effect
                    if(options.imagesAlso){
                        //defined height of brick
                        if(noImageResize){
                            bricks.find('i').css('height', fluidHeight);
                        }
                        else{
                            bricks.find('i').each(function(){
                                var t = $(this).css('height',''),
                                    img = t.children().addClass('resize').css('height', 'auto'),
                                    h = img.height();
                                t.height(h);
                                img.css('height', '').height(); //read of height just to break webkit flow in inserting DOM changes
                                img.removeClass('resize');
                            });
                        }
                    }

                    return fluidWidth + defMargin;
                },

                bindLoadMore = function(){
                    var load_more = $('<div class="navigation lazy"><a href="#" id="#load-more">'+ G.load_more +'</a></div>').insertAfter($container),
                        action = function(e){
                            if(typeof e !== 'undefined'){
                                e.preventDefault();
                            }

                            //instant turn off event
                            load_more.off('click');

                            $window.off('.lazyload');
                            load_more.slideUp(100, function(){load_more.remove();});
                            loadTillViewIsFull();
                        },

                        cb = function(){
                            var scrollPos = $window.scrollTop() + $window.height();

                            if ($container.height() -  scrollPos < 250) {
                                action();
                            }
                        };

                    load_more.click(action);

                    //on IOS throttle for scroll causes some JavaScript issues
                    _throttle = isTouch? 'debounce' : 'throttle';
                    $window.on('scroll.lazyload resize.lazyload', window[_throttle](cb, 150));
                },

                loadTillViewIsFull = function(){
                    A13.addLoader(isTouch? mid : $body);

                    var pointer = $container.data('pointer'),
                        current = (typeof pointer === 'undefined')? 0 : parseInt(pointer, 10),
                        improve = (current + minLoad > bricksNo)? bricksNo - current : minLoad,
                        limit   = current + improve,
                        $newElems;

                    //create items html
                    $newElems = bricksSave.slice(current,limit);

                    //append items and position them
                    $newElems
                        .appendTo($container)
                        .css({ opacity: 0 })
                        .imagesLoaded(function(){
                            //if load of initial elements
                            if(current === 0){
                                $newElems.addClass('ready'); // for enabling transition

                                $container.masonry({
                                    itemSelector : options.childrenSelector,
                                    columnWidth : countWidth,
                                    isAnimated: !Modernizr.csstransitions,
                                    isFitWidth: true,
                                    animationOptions: {
                                        duration: 300,
                                        easing: 'swing',
                                        queue: false
                                    }
                                });

                                //show elements
                                $newElems.css({
                                    opacity: 1
                                });

                                //show parent
                                $container.addClass('loaded');

                                //callback(lightbox)
                                options.afterAddCB($newElems);
                            }
                            else{
                                //resize items
                                countWidth($newElems);
                                //show
                                $newElems.css({
                                    opacity: 1, //show elements
                                    top : $window.height() + $window.scrollTop() + 100 // for animation purpose(animate from bottom of screen
                                });

                                //READ of TOP property to break chain for chrome so it makes job proper!!!
                                //probably chrome optimization error
                                $newElems.css('top');

                                $newElems.addClass('ready');

                                //check if new elements match filter
                                if(filter.length){
                                    var genre = filter.find('li.selected').data('filter');
                                    if(genre !== '__all'){
                                        $newElems.hide().filter('[data-genre-'+genre+']').show();
                                    }
                                }

                                //position
                                $container.masonry( 'appended', $newElems, false );//false so it wont go in to setTimeout

                                //callback(lightbox)
                                options.afterAddCB($newElems);
                            }

                            //save pointer
                            current = current+improve;
                            $container.data('pointer', current);

                            //if loading only one set of items but to full
                            if(loadAll > 0){
                                if(current < bricksNo){
                                    loadTillViewIsFull();
                                }
                                else{
                                    A13.removeLoader();
                                }
                            }
                            else{
                                //load next items if there is space available and still some items to load
                                if(($container.height() < (2*$window.height() + $window.scrollTop())) && current < bricksNo){
                                    loadTillViewIsFull();
                                }
                                //bind scroll to load more items
                                else{
                                    A13.removeLoader();

                                    //if we loaded all items
                                    if(current === bricksNo){ return; }

                                    bindLoadMore();
                                }
                            }
                        });
                };

            loadTillViewIsFull();

            //filter bind
            if(filter.length){
                var label = filter.find('li.label'),
                    filters = filter.find('li').not(label);

                label.click(function(){
                    filters.toggle(300);
                });

                filters.click(function(e){
                    e.preventDefault();

                    filters.removeClass('selected');

                    var f = $(this).addClass('selected'),
                        genre = f.data('filter'),
                        allItems = $container.children(),
                        currentItems;

                    if(genre === '__all'){ //__all so users will not overwrite this
                        allItems.show();
                    }
                    else{
                        currentItems = $container.children().filter('[data-genre-'+genre+']').show();
                        allItems.not(currentItems).hide();
                    }

                    //masonry refresh layout
                    $container.masonry( 'option', { itemSelector : options.childrenSelector+':visible' }).masonry( 'reload' );

                    //trigger scroll to load more elements if there is place
                    $window.trigger('scroll.lazyload');
                });

            }
        },

        addLoader : function(elem){
            if($('#loader').length){ return; }//there is some loader

            var _in = (typeof elem !== 'undefined'),
                _appendTo = _in ? elem : $body;
            $('<div id="loader"'+( _in ? ' class="in"' : '')+' />').
                appendTo(_appendTo).hide().fadeIn();
        },

        removeLoader : function(){
            var l = $body.find('#loader');
            l.fadeOut().promise().done(function(){l.remove();});
        },

        setRGBA_n_RGB : function(el, style, color){
            if(typeof color === 'undefined' || !color.length){ return; }

            //rgba conversion to rgb
            var reg = /\(\s*(\d+),\s*(\d+),\s*(\d+),\s*(\d+\.?\d*)\s*\)/,
                result = reg.exec(color),
                rgb = '';
            if(result !== null){
                rgb = 'rgb('+result[1]+','+result[2]+','+result[3]+')';
            }

            //set color
            try {
                el.style[style] = color;
            }
            //browsers without RGBA support
            catch(e) {
                el.style[style] = rgb;
            }
        }
    };

    //start Theme
    A13 = window.A13;
    $(document).ready(A13.onReady);

})(jQuery, window, document);