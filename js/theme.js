(function($){
    $(document).ready(function(){		//when DOM is ready
        pandora.init();
    });
	$(window).resize(function() {
		pandora.resizeHomepageSlider();
		pandora.adjustCollectionItemHeight();
		pandora.adjustFooterPadding();
		pandora.adjustSliderNavPos();
	});
})(jQuery);

var pandora = {
	init: function() {
		this.initScrollTop();
		this.initFormElements();
		this.adjustFooterPadding();
		this.initUserAuthMenu();
		this.initHomepageSlider();
		this.adjustSliderNavPos();
		this.adjustCollectionItemHeight();
		this.initNavigationSelector();
		this.initSingleProductImageSlider();
		this.initProductLightbox();
		this.initCart();
		this.initQuickShop();
		this.initQuickShopImageSlider();
		this.initAccountLogin();
		this.initAddressManage();
	},
	initScrollTop: function() {
		$('.back-to-the-top').click(function () {
			$('body,html').animate({
				scrollTop: 0
			}, 400);
			return false;
		});
	},
	initFormElements: function() {
		if($("select:not(.no-uniform)").length > 0) {
			$("select:not(.no-uniform)").uniform();
		}

		$('._product-purchase-btn').click(function() {
			if($(this).attr('disabled') != 'disabled')
			{
				var productId = $(this).parents('.item-info').attr('id');
				productId = productId.match(/\d+/g);
				$('#product-actions-' + productId).submit();
			}
			return false;
		});
		$('.form-submit-btn').click(function(){
			$(this).parents('form').submit();
		});
	},
	customFormElements: function(selector) {
		$(selector).uniform();
	},
	initNavigationSelector: function() {
		var selector = $('.navigationSelector');
		if(selector.length > 0)
		{
			selector.change(function(){
				window.location = $('option:selected', $(this)).attr('value');
			});
		}
	},
	adjustFooterPadding: function() {
		var mainfooterwrapper = $('.main-footer-wrapper');
		$('.main-content-wrapper').css({ paddingBottom: mainfooterwrapper.height() });
	},
	initUserAuthMenu: function() {
		$('.main-header .menu .account').not('._logged-in').click(function(){
			if($('._user_auth').is(':visible'))
			{
				$('._user_auth .password').css('visibility', 'hidden');	//hack to prevent "forget" from showing while runnin slideup animation
				$('._user_auth').slideUp(500, function(){
					$('._user_auth .password').css('visibility', 'visible');
				});
			}
			else
			{
				$('._user_auth').slideDown(500);
			}
			return false;
		});
	},
	initHomepageSlider: function() {
		$('#hompage-slider_content').cycle({
			fx: 'fade',
			speed: '600',
			timeout: 0,
			prev:   '.previous', 
			next:   '.next',
			pager: '#pager',
			activePagerClass: "active",
			easing: 'swing',
			slideResize: 0,
			containerResize: 1,
			slideExpr: '.item',
			pause: true,
			pagerAnchorBuilder: function(idx, slide) {  return ''; }
		});

        if($('#hompage-slider_content').children('.item').length <= 1)
        {
            $('#hompage-slider_content .blank-item').hide();
            $('.homepage-slider .navigation').hide();
        }

		$('#pager a').click(function(){
			var index = $('#pager a').index($(this));
			$('#hompage-slider_content').cycle(index);
			return false;
		});
		
		$('#hompage-slider_content').touchwipe({
		    wipeLeft: function() { $('#hompage-slider_content').cycle('next'); },
		    wipeRight: function() { $('#hompage-slider_content').cycle('prev'); },
			wipeUp: function() { return false; },
			wipeDown: function() { return false; },
		    min_move_x: 20,
		    min_move_y: 20,
		    preventDefaultEvents: false
		});
	},
	adjustSliderNavPos: function() {
		var nav = $('.main-slider nav');
		var nav_width = nav.outerWidth();
		var scr_width = $(window).width();
		nav.css('left', (scr_width-nav_width)/2);
	},
	resizeHomepageSlider: function() {
		$('#hompage-slider_content .item, #hompage-slider_content').width($('body').width());
	},
	getCurrentResponsiveType: function() {
		var window_w = $(window).width();
		if(window_w > 767 && window_w < 959 ) {	//ipad
			type = 'tablet';
		} else if(window_w <= 767) {	//iphone
			type = 'mobile';
		} else {	//full
			type = 'pc';
		}
		return type;
	},
	adjustCollectionItemHeight: function() {
		var type = pandora.getCurrentResponsiveType();

		var items = $('.items ._collection-item');
		if(items.length > 0)
		{	
			var columns = 4;	//normal
			if(type == 'tablet') { columns = 3; }	//tablet
			if(type == 'mobile') { columns = 2; }	//mobile

			pandora.resizeRowItemHeight(items, columns);
		}
	},
	resizeRowItemHeight: function(items, columns) {
		var chunks = chunk(items, columns);
		
		for(var row in chunks)
		{
			var maxHeight = Math.max.apply(null, chunks[row].map(function ()
			{
				var height = $(this).find('.image-wrapper').innerHeight() + $(this).find('h2').innerHeight() + $(this).find('.price').innerHeight();
				return height + 8;
			}).get());
			chunks[row].height(maxHeight);
		}
	},
	initSingleProductImageSlider: function() {
						
		$('#_single-product-slider').cycle({
			fx: 'scrollHorz',
			speed: '600',
			timeout: 0,
			easing: 'swing',
			slideResize: 0,
			containerResize: 1,
			slideExpr: '.image'
		});

		var navBtns = $('.main-item .thumbnails div a')
		navBtns.click(function(){
			var index = navBtns.index($(this));
			navBtns.removeClass('active');
			$(this).addClass('active');
			pandora.slideChanged = false;
			$('#_single-product-slider').cycle(index);
			return false;
		});
		
		$('.main-item .thumbnails .next').click(function(){
			$('#_single-product-slider').cycle('prev');
			var active = $('.main-item .thumbnails a.active');
			active.removeClass('active');
			var index = navBtns.index(active);
			
			if(index == 0)
			{
				navBtns.last().addClass('active');
			}
			else
			{
				navBtns.eq(index-1).addClass('active');
			}
			
			return false;
		});
		
		$('.main-item .thumbnails .previous').click(function(){
			$('#_single-product-slider').cycle('next');
			var active = $('.main-item .thumbnails a.active');
			active.removeClass('active');
			var index = navBtns.index(active);

			if(index == ($('.main-item .thumbnails div a').length-1))
			{
				navBtns.first().addClass('active');
			}
			else
			{
				navBtns.eq(index+1).addClass('active');
			}

			return false;
		});
			
	},
	initQuickShopImageSlider: function() {
						
		$('#_quick-shop-product-slider').cycle({
			fx: 'scrollHorz',
			speed: '600',
			timeout: 0,
			easing: 'swing',
			slideResize: 0,
			containerResize: 1,
			slideExpr: '.image'
		});

		var navBtns = $('.quick-shop .thumbnails div a')
		navBtns.click(function(){
			var index = navBtns.index($(this));
			navBtns.removeClass('active');
			$(this).addClass('active');
			pandora.slideChanged = false;
			$('#_quick-shop-product-slider').cycle(index);
			return false;
		});
		
		$('.quick-shop .thumbnails .next').click(function(){
			$('#_quick-shop-product-slider').cycle('prev');
			var active = $('.quick-shop .thumbnails a.active');
			active.removeClass('active');
			var index = navBtns.index(active);
			
			if(index == 0)
			{
				navBtns.last().addClass('active');
			}
			else
			{
				navBtns.eq(index-1).addClass('active');
			}
			
			return false;
		});
		
		$('.quick-shop .thumbnails .previous').click(function(){
			$('#_quick-shop-product-slider').cycle('next');
			var active = $('.quick-shop .thumbnails a.active');
			active.removeClass('active');
			var index = navBtns.index(active);

			if(index == ($('.quick-shop .thumbnails div a').length-1))
			{
				navBtns.first().addClass('active');
			}
			else
			{
				navBtns.eq(index+1).addClass('active');
			}

			return false;
		});
			
	},
	initCart: function() {
		$('#cart_submit').click(function(){
			$('.__checkout-btn').trigger('click');
			return false;
		});
		
		$('#cart_update').click(function(){
			$('.__update-btn').trigger('click');
			return false;
		});
		
		
		// + 1 quantity
		$('.main-cart .quantity .more').click(function(){
			var quantity = $(this).siblings('input[type=text]');
			var newQuantity = parseInt(quantity.val()) + 1;
			quantity.val(newQuantity);
			return false;
		});
		
		// - 1 quantity
		$('.main-cart .quantity .less').click(function(){
			var quantity = $(this).siblings('input[type=text]');
			var oldQuantity = parseInt(quantity.val());
			if(oldQuantity > 1)
			{
				var newQuantity = oldQuantity - 1;
				quantity.val(newQuantity);
			}
			return false;
		});
		
		//allow only numbers to be entered in quantity box
		$('.main-cart .quantity input[type=text]').keydown(function(event) {
	        // Allow: backspace, delete, tab and escape
	        if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27
		 		|| 
	            (event.keyCode == 65 && event.ctrlKey === true) 
				|| 
	            (event.keyCode >= 35 && event.keyCode <= 39)) {
	                 return;
	        }

	        // Ensure that it is a number and stop the keypress
	        if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
	            event.preventDefault(); 
	        }   
		});
	},
	initQuickShop: function() {		
		$('.quickshop').click(function(){
			$('.lightbox').fadeIn(350);	//IE does not allow to fadein transparent stuff
			$('.quick-shop').fadeIn(350, pandora.adjustQuickShopPopupPosition());
			
			return false;
		});
		
		$('.lightbox, .close').live('click', function(){
			pandora.closeQuickShopPopup();
			return false;
		});
		
		$(window).resize(function(){
			pandora.adjustQuickShopPopupPosition();
		});
	},
	adjustQuickShopPopupPosition: function() {
		$('.quick-shop').css({
			position: 'fixed',
			left: ($(window).width() - $('.quick-shop').outerWidth())/2,
			top: ($(window).height() - $('.quick-shop').outerHeight())/2
		});	
	},
	closeQuickShopPopup: function() {
		$('.quick-shop').fadeOut(350);			//close popup
		$('.lightbox').hide();
	},
	initProductLightbox: function() {

		$('.lightbox-launcher').click(function(){
			
			var elem = $(this);
			var imgSrc = elem.attr('href');
			$('.lightbox').show();
			
			var productImage = new Image();
			productImage.onload = function() {
				$('.quick-shop').html(productImage);
				$('.quick-shop').append('<a href="#" class="close"></a>');
				pandora.adjustQuickShopPopupPosition();
				$('.quick-shop').fadeIn(350, function(){
					pandora.adjustQuickShopPopupPosition();
				});
			};
			productImage.src = imgSrc;
			
			return false;
		});
		
		$('.lightbox, .close, .quick-shop > img').live('click', function(){
			pandora.closeQuickShopPopup();
			return false;
		});

		$(window).resize(function(){
			pandora.adjustQuickShopPopupPosition();
		});
	},
	initAccountLogin: function() {

		if (window.location.hash == '#recover') {
			$('#login_form').hide();
			$('#password_recovery').show();
		}
		
		$('#forgot_password').click(function() {
			$('#login_form').fadeOut(200, function(){
				$('#password_recovery').fadeIn(200);
			});
			return false;
		});
	
		$('#login').click(function() {
			$('#password_recovery').fadeOut(200, function(){
				$('#login_form').fadeIn(200);
			});
			return false;
		});
	
		$('#login_submit').click(function() {
			$('#customer_login').submit();
			return false;
		});
	
		$('#recover_submit').click(function() {
			$(this).parents('form').submit();
			return false;
		});
	},
	initAddressManage: function() {

		$('.edit-address-btn').click(function(){
			var editForm = 'edit_' + $(this).parents('.row').attr('id');				
			$('#' + editForm ).slideDown(300);
			return false;
		});
		
		$('.address-edit-form-cancel').click(function(){
			$(this).parents('.address-edit-form').slideUp(300);
			return false;
		});
	}
}

function chunk (arr, len) {

  var chunks = [],
      i = 0,
      n = arr.length;

  while (i < n) {
    chunks.push(arr.slice(i, i += len));
  }

  return chunks;
}