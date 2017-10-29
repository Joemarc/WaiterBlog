;(function($, window, document, undefined) {
	"use strict";

	$(document).ready(function() {
		jQuery.exists = function(selector) {
			return ($(selector).length > 0);
		};

        // woocommerce
        if ($.exists('#pa_size, #pa_color')) {
            var size = $('#pa_size'),
                color = $('#pa_color'),
                qty = $('.quantity .qty'),
                options = $('#options'),
                color_option = $('select#pa_color option');

            $('.variations, .quantity').hide();
            color.val('').change();
            size.val('').change();

            if (color.length > 0) {
                var color_string = '<div class="color-options">Color: <ul>';
                color_option.each(function() {
                    if ($(this).val() != '') {
                        color_string += '<li>';
                        color_string += '<input type="radio" name="colorFilters" id="'+ $(this).val() +'-filter">';
                        color_string += '<label for="'+ $(this).val() +'-filter" id="'+ $(this).val() +'-filter" data-val="'+ $(this).val() +'" style="background-color:'+ $(this).val() +';"></label>';
                        color_string += '</li>';
                    }
                });
                color_string += '</ul></div>';

                options.append(color_string);
            }

            if (qty.length > 0) {
                var qty_string = '';
                qty_string += '<div class="centerbox quantity">Qty: <ul>';
                qty_string += '<li><a id="minus1" class="minus" style="">_</a></li>';
                qty_string += '<li><input id="qty1" type="text" value="1" class="qty" /></li>';
                qty_string += '<li><a id="add1" class="plus">+</a></li>';
                qty_string += '</ul></div>';

                options.append(qty_string);
            }

            var initSize = function() {
                if (size.length > 0) {
                    var size_string = '<div class="size-picker">Size: <ul class="range-picker" id="range-picker">';
                    $('select#pa_size option').each(function() {
                        if ($(this).val() != '') {
                            size_string += '<li>' + $(this).val() + '</li>';
                        }
                    });
                    size_string += '</ul></div>';

                    options.append(size_string);
                }
            };
            initSize();

            options.on('click', '.color-options ul li label', function(e) {
                // e.preventDefault();
                size.val('').change();
                color.val('').change();
                color.find('option').removeAttr('selected');
                color.find('option:contains("'+ $(this).data('val') +'")').attr('selected', 'selected');
                color.change();
                $('.size-picker').remove();
                initSize();
                sizeActive();
            });
            options.on('change', '#qty1', function(e) {
                isNaN($(this).val()) ? qty.val(1) : qty.val($(this).val());
            });
            options.on('click', '.size-picker ul#range-picker li', function(e) {
                e.preventDefault();
                size.val('').change();
                size.find('option').removeAttr('selected');
                size.find('option:contains("'+ $(this).text() +'")').attr('selected', 'selected');
                size.change();
                qty.hide();
            });

        }

		if ($.exists('.products')) {
			//open/close lateral filter
			$('.e-filter-trigger').on('click', function(){
				triggerFilter(true);
			});
			$('.e-filter .e-close').on('click', function(){
				triggerFilter(false);
			});

			var triggerFilter = function($bool) {
				var elementsToTrigger = $([$('.e-filter-trigger'), $('.e-filter'), $('.e-tab-filter'), $('.e-gallery')]);
				elementsToTrigger.each(function(){
					$(this).toggleClass('filter-is-visible', $bool);
				});
			};

			//mobile version - detect click event on filters tab
			var filter_tab_placeholder = $('.e-tab-filter .placeholder a'),
				filter_tab_placeholder_default_value = 'Select',
				filter_tab_placeholder_text = filter_tab_placeholder.text();

			$('.e-tab-filter li').on('click', function(event){
				//detect which tab filter item was selected
				var selected_filter = $(event.target).data('type');

				//check if user has clicked the placeholder item
				if( $(event.target).is(filter_tab_placeholder) ) {
					(filter_tab_placeholder_default_value == filter_tab_placeholder.text()) ? filter_tab_placeholder.text(filter_tab_placeholder_text) : filter_tab_placeholder.text(filter_tab_placeholder_default_value) ;
					$('.e-tab-filter').toggleClass('is-open');

				//check if user has clicked a filter already selected
				} else if( filter_tab_placeholder.data('type') == selected_filter ) {
					filter_tab_placeholder.text($(event.target).text());
					$('.e-tab-filter').removeClass('is-open');

				} else {
					//close the dropdown and change placeholder text/data-type value
					$('.e-tab-filter').removeClass('is-open');
					filter_tab_placeholder.text($(event.target).text()).data('type', selected_filter);
					filter_tab_placeholder_text = $(event.target).text();

					//add class selected to the selected filter item
					$('.e-tab-filter .selected').removeClass('selected');
					$(event.target).addClass('selected');
				}
			});

			//close filter dropdown inside lateral .e-filter
			$('.e-filter-block h4').on('click', function(){
				$(this).toggleClass('closed').siblings('.e-filter-content').slideToggle(300);
			});

			//fix lateral filter and gallery on scrolling
			$(window).on('scroll', function(){
				(!window.requestAnimationFrame) ? fixGallery() : window.requestAnimationFrame(fixGallery);
			});

			var fixGallery = function() {
				var offsetTop = $('.e-main-content').offset().top,
					scrollTop = $(window).scrollTop();
				( scrollTop >= offsetTop ) ? $('.e-main-content').addClass('is-fixed') : $('.e-main-content').removeClass('is-fixed');
			};


			//search filtering
			//credits http://codepen.io/edprats/pen/pzAdg
			var inputText;
			var $matching = $();

			var delay = (function(){
				var timer = 0;
				return function(callback, ms){
					clearTimeout (timer);
					timer = setTimeout(callback, ms);
				};
			})();

			$(".e-filter-content input[type='search']").keyup(function(){
				// Delay function invoked to make sure user stopped typing
				delay(function(){
					inputText = $(".e-filter-content input[type='search']").val().toLowerCase();
					// Check to see if input field is empty
					if ((inputText.length) > 0) {
						$('.mix').each(function() {
							var $this = $(this);

							// add item to be filtered out if input text matches items inside the title
							if($this.attr('class').toLowerCase().match(inputText)) {
								$matching = $matching.add(this);
							} else {
								// removes any previously matched item
								$matching = $matching.not(this);
							}
						});
						$('.e-gallery .sort').mixItUp('filter', $matching);
					} else {
						// resets the filter to show all item if input is empty
						$('.e-gallery .sort').mixItUp('filter', 'all');
					}
				}, 200 );
			});
			/*****************************************************
			MixItUp - Define a single object literal
			to contain all filter custom functionality
			*****************************************************/
			var buttonFilter = {
				// Declare any variables we will need as properties of the object
				$filters: null,
				groups: [],
				outputArray: [],
				outputString: '',

				// The "init" method will run on document ready and cache any jQuery objects we will need.
				init: function(){
					var self = this; // As a best practice, in each method we will asign "this" to the variable "self" so that it remains scope-agnostic. We will use it to refer to the parent "buttonFilter" object so that we can share methods and properties between all parts of the object.

					self.$filters = $('.e-main-content');
					self.$container = $('.e-gallery .sort');

					self.$filters.find('.e-filters').each(function(){
						var $this = $(this);

						self.groups.push({
							$inputs: $this.find('.filter'),
							active: '',
							tracker: false
						});
					});

					self.bindHandlers();
				},

				// The "bindHandlers" method will listen for whenever a button is clicked.
				bindHandlers: function(){
					var self = this;

					self.$filters.on('click', 'a', function(e){
						self.parseFilters();
					});
					self.$filters.on('change', function(){
					  self.parseFilters();
					});
				},

				parseFilters: function(){
					var self = this;

					// loop through each filter group and grap the active filter from each one.
					for(var i = 0, group; group = self.groups[i]; i++){
						group.active = [];
						group.$inputs.each(function(){
							var $this = $(this);
							if($this.is('input[type="radio"]') || $this.is('input[type="checkbox"]')) {
								if($this.is(':checked') ) {
									group.active.push($this.attr('data-filter'));
								}
							} else if($this.is('select')){
								group.active.push($this.val());
							} else if( $this.find('.selected').length > 0 ) {
								group.active.push($this.attr('data-filter'));
							}
						});
					}
					self.concatenate();
				},

				concatenate: function(){
					var self = this;

					self.outputString = ''; // Reset output string

					for(var i = 0, group; group = self.groups[i]; i++){
						self.outputString += group.active;
					}

					// If the output string is empty, show all rather than none:
					!self.outputString.length && (self.outputString = 'all');

					// Send the output string to MixItUp via the 'filter' method:
					if(self.$container.mixItUp('isLoaded')){
						self.$container.mixItUp('filter', self.outputString);
					}
				}
			};
			var productCustomization = $('.e-customization'),
				cart = $('.e-cart'),
				mcart = $('.m-cart'),
				animating = false;

			// initCustomization(productCustomization);

			$('body').on('click', function(event){
				//if user clicks outside the .e-gallery list items - remove the .hover class and close the open ul.size/ul.color list elements
				if( $(event.target).is('body') || $(event.target).is('.e-gallery') ) {
					deactivateCustomization();
				}
			});

			var initCustomization = function(items) {
				items.each(function(){
					var actual = $(this),
						addToCartBtn = actual.find('.add-to-cart'),
						touchSettings = actual.next('.e-customization-trigger');

					//detect click on the add-to-cart button
					addToCartBtn.on('click', function(e) {
						e.preventDefault();
						if(!animating) {
							//animate if not already animating
							animating =  true;
							resetCustomization(addToCartBtn);

							addToCartBtn.addClass('is-added').find('path').eq(0).animate({
								//draw the check icon
								'stroke-dashoffset':0
							}, 300, function(){
								setTimeout(function(){
									updateCart();
									addToCartBtn.removeClass('is-added').find('em').on('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function(){
										//wait for the end of the transition to reset the check icon
										addToCartBtn.find('path').eq(0).css('stroke-dashoffset', '19.79');
										animating =  false;
									});

									if( $('.no-csstransitions').length > 0 ) {
										// check if browser doesn't support css transitions
										addToCartBtn.find('path').eq(0).css('stroke-dashoffset', '19.79');
										animating =  false;
									}
								}, 600);
							});
						}
					});

					//detect click on the settings icon - touch devices only
					touchSettings.on('click', function(event){
						event.preventDefault();
						resetCustomization(addToCartBtn);
					});
				});
			};
			initCustomization(productCustomization);

			var resetCustomization = function(selectOptions) {
				//close ul.color/ul.size if they were left open and user is not interacting with them anymore
				//remove the .hover class from items if user is interacting with a different one
				selectOptions.siblings('[data-type="select"]').removeClass('is-open').end().parents('.e-single-item').addClass('hover').parent('li').siblings('li').find('.e-single-item').removeClass('hover').end().find('[data-type="select"]').removeClass('is-open');
			};

			var deactivateCustomization = function() {
				productCustomization.parent('.e-single-item').removeClass('hover').end().find('[data-type="select"]').removeClass('is-open');
			};

			var updateCart = function() {
				//show counter if this is the first item added to the cart
				( !cart.hasClass('items-added') ) && cart.addClass('items-added');

				var cartItems = cart.find('span'),
					text = parseInt(cartItems.text()) + 1;
				cartItems.text(text);

				( !mcart.hasClass('items-added') ) && cart.addClass('items-added');

				var cartItems = mcart.find('span'),
					text = parseInt(cartItems.text()) + 1;
				cartItems.text(text);
			};
		//END IF
		}

		if ($.exists('.p-details')) {
			$('.main-img-slider').slick({
				slidesToShow: 1,
				slidesToScroll: 1,
				infinite: true,
				arrows: true,
				fade:true,
				speed: 300,
				lazyLoad: 'ondemand',
				asNavFor: '.thumb-nav',
				prevArrow: '<div class="slick-prev"><i class="fa fa-caret-left" aria-hidden="true"></i><span class="sr-text">Previous</span></div>',
				nextArrow: '<div class="slick-next"><i class="fa fa-caret-right" aria-hidden="true"></i><span class="sr-text">Next</span></div>'
			});
			// Thumbnail/alternates slider for product page
			$('.thumb-nav').slick({
				slidesToShow: 3,
				slidesToScroll: 1,
				infinite: true,
				centerPadding: '0px',
				asNavFor: '.main-img-slider',
				dots: false,
				centerMode: true,
				draggable: false,
				speed:200,
				focusOnSelect: true,
				prevArrow: '<div class="slick-prev"><i class="fa fa-caret-left" aria-hidden="true"></i><span class="sr-text">Previous</span></div>',
				nextArrow: '<div class="slick-next"><i class="fa fa-caret-right" aria-hidden="true"></i><span class="sr-text">Next</span></div>'
			});
			//keeps thumbnails active when changing main image, via mouse/touch drag/swipe
			$('.main-img-slider').on('afterChange', function(event, slick, currentSlide, nextSlide){
				//remove all active class
				$('.thumb-nav .slick-slide').removeClass('slick-current');
				//set active class for current slide
				$('.thumb-nav .slick-slide:not(.slick-cloned)').eq(currentSlide).addClass('slick-current');
			});
			//Zoom image

			//Photoswipe configuration for product page zoom
			var initPhotoSwipeFromDOM = function(gallerySelector) {

				// parse slide data (url, title, size ...) from DOM elements
				// (children of gallerySelector)
				var parseThumbnailElements = function(el) {
					var thumbElements = el.childNodes,
						numNodes = thumbElements.length,
						items = [],
						figureEl,
						linkEl,
						size,
						item;
					for(var i = 0; i < numNodes; i++) {
						figureEl = thumbElements[i]; // <figure> element
						// include only element nodes
						if(figureEl.nodeType !== 1) {
							continue;
						}
						linkEl = figureEl.children[0]; // <a> element
						size = linkEl.getAttribute('data-size').split('x');
						// create slide object
						item = {
							src: linkEl.getAttribute('href'),
							w: parseInt(size[0], 10),
							h: parseInt(size[1], 10)
						};
						if(figureEl.children.length > 1) {
							// <figcaption> content
							item.title = figureEl.children[1].innerHTML;
						}
						if(linkEl.children.length > 0) {
							// <img> thumbnail element, retrieving thumbnail url
							item.msrc = linkEl.children[0].getAttribute('src');
						}
						item.el = figureEl; // save link to element for getThumbBoundsFn
						items.push(item);
					}
					return items;
				};
				// find nearest parent element
				var closest = function(el, fn) {
					return el && ( fn(el) ? el : closest(el.parentNode, fn) );
				};
				// triggers when user clicks on thumbnail
				var onThumbnailsClick = function(e) {
					e = e || window.event;
					e.preventDefault ? e.preventDefault() : e.returnValue = false;
					var eTarget = e.target || e.srcElement;
					// find root element of slide
					var clickedListItem = closest(eTarget, function(el) {
						return (el.tagName && el.tagName.toUpperCase() === 'FIGURE');
					});
					if(!clickedListItem) {
						return;
					}
					// find index of clicked item by looping through all child nodes
					// alternatively, you may define index via data- attribute
					var clickedGallery = clickedListItem.parentNode,
						childNodes = clickedListItem.parentNode.childNodes,
						numChildNodes = childNodes.length,
						nodeIndex = 0,
						index;
					for (var i = 0; i < numChildNodes; i++) {
						if(childNodes[i].nodeType !== 1) {
							continue;
						}
						if(childNodes[i] === clickedListItem) {
							index = nodeIndex;
							break;
						}
						nodeIndex++;
					}
					if(index >= 0) {
						// open PhotoSwipe if valid index found
						openPhotoSwipe( index, clickedGallery );
					}
					return false;
				};
				// parse picture index and gallery index from URL (#&pid=1&gid=2)
				var photoswipeParseHash = function() {
					var hash = window.location.hash.substring(1),
					params = {};

					if(hash.length < 5) {
						return params;
					}
					var vars = hash.split('&');
					for (var i = 0; i < vars.length; i++) {
						if(!vars[i]) {
							continue;
						}
						var pair = vars[i].split('=');
						if(pair.length < 2) {
							continue;
						}
						params[pair[0]] = pair[1];
					}
					if(params.gid) {
						params.gid = parseInt(params.gid, 10);
					}
					return params;
				};
				var openPhotoSwipe = function(index, galleryElement, disableAnimation, fromURL) {
					var pswpElement = document.querySelectorAll('.pswp')[0],
						gallery,
						options,
						items;
					items = parseThumbnailElements(galleryElement);
					// define options (if needed)
					options = {
						bgOpacity : 1,
						tapToClose : true,
						tapToToggleControls : false,
						closeOnScroll: false,
						history:false,
						closeOnVerticalDrag:false,
						captionEl: false,
						fullscreenEl: false,
						zoomEl: false,
						shareEl: false,
						counterEl: false,
						arrowEl: true,
						galleryUID: galleryElement.getAttribute('data-pswp-uid'),
						getThumbBoundsFn: function(index) {
							// See Options -> getThumbBoundsFn section of documentation for more info
							var thumbnail = items[index].el.getElementsByTagName('img')[0], // find thumbnail
								pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
								rect = thumbnail.getBoundingClientRect();
							return {x:rect.left, y:rect.top + pageYScroll, w:rect.width};
						}

					};
					// PhotoSwipe opened from URL
					if(fromURL) {
						if(options.galleryPIDs) {
							// parse real index when custom PIDs are used
							// http://photoswipe.com/documentation/faq.html#custom-pid-in-url
							for(var j = 0; j < items.length; j++) {
								if(items[j].pid == index) {
									options.index = j;
									break;
								}
							}
						} else {
							// in URL indexes start from 1
							options.index = parseInt(index, 10) - 1;
						}
					} else {
						options.index = parseInt(index, 10);
					}
					// exit if index not found
					if( isNaN(options.index) ) {
						return;
					}
					if(disableAnimation) {
						options.showAnimationDuration = 0;
					}
					// Pass data to PhotoSwipe and initialize it
					gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options);
					gallery.init();
					var psIndex = gallery.getCurrentIndex();
					var psIndexSlick = psIndex;
					// console.log(psIndexSlick);
					gallery.listen('afterChange', function() {
					  psIndex = gallery.getCurrentIndex();
					  psIndexSlick = psIndex;
					  // console.log(psIndexSlick);
					  $(".main-img-slider").slick( "slickGoTo", psIndexSlick);
					});
				};
				  var options = {
				  loop: false
				};
				// loop through all gallery elements and bind events
				var galleryElements = document.querySelectorAll( gallerySelector );

				for(var i = 0, l = galleryElements.length; i < l; i++) {
					galleryElements[i].setAttribute('data-pswp-uid', i+1);
					galleryElements[i].onclick = onThumbnailsClick;
				}
				// Parse URL and open gallery if it contains #&pid=3&gid=1
				var hashData = photoswipeParseHash();
				if(hashData.pid && hashData.gid) {
					openPhotoSwipe( hashData.pid ,  galleryElements[ hashData.gid - 1 ], true, true );
				}
			};
			// execute above function
			initPhotoSwipeFromDOM('.product-images');
			//END IF
		}

		//Size picker
        var sizeActive = function() {
            if ($.exists('.range-picker')) {
                $('.range-picker').on('click', function(e) {
                    var sizeList = $('#range-picker').children();
                    for (var i = 0; i <= sizeList.length - 1; i++) {
                        if (sizeList[i].classList.contains('active')) {
                            sizeList[i].classList.remove('active');
                        }
                    }
                    e.target.classList.add('active');
                });
                //END IF
            }
        };
        sizeActive();

		// Qty
		if ($.exists('.range-picker')) {
			$('.plus').on('click',function(){
				var $qty=$(this).closest('ul').find('.qty');
				var currentVal = parseInt($qty.val());
				if (!isNaN(currentVal) && currentVal < 7) {
					$qty.val(currentVal + 1);
                    $qty.change();
				}
            });
			$('.minus').on('click',function(){
				var $qty=$(this).closest('ul').find('.qty');
				var currentVal = parseInt($qty.val());
				if (!isNaN(currentVal) && currentVal > 1) {
					$qty.val(currentVal - 1);
                    $qty.change();
				}
			});
		//END IF
		}
		//Product Filter
		if ($.exists('.sort')) {
			buttonFilter.init();
			$('.e-gallery .sort').mixItUp({
				controls: {
					enable: false
				},
				callbacks: {
					onMixStart: function(){
						$('.e-fail-message').fadeOut(200);
					},
					onMixFail: function(){
						$('.e-fail-message').fadeIn(200);
					}
				}
			});
		}
	});
})(jQuery, window, document);

