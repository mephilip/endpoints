/**
 * PRIMARY THEME JAVASCRIPT FILE
 *
 * This is your public-facing, front-end Javascript. It compiles to assets/js/app.min.js in your theme directory.
 *
 * This is used to initialize your custom Javascript. If you would like to change how Foundation and it's plugins are
 * initialized, you can. See http://foundation.zurb.com/docs/javascript.html for documentation.
 */
(function($){

    // Foundation JavaScript
    $(document).foundation({
    	topbar : {
    		sticky_class: 'snap-to-top'
    	}
    });

    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) {

        var scroll_pos = 0;
        var scroll_time;

        $(window).scroll(function() {
            clearTimeout(scroll_time);
            var current_scroll = $(window).scrollTop();

            if (current_scroll >= $('.navigation-bar.fixed').outerHeight()) {
                if (current_scroll <= scroll_pos) {
                    $('.navigation-bar.fixed').show();    
                }
                else {
                    $('.navigation-bar.fixed').hide();  
                }
            }

            scroll_time = setTimeout(function() {
                scroll_pos = $(window).scrollTop();
            }, 100);
        });
    }


    //Your code goes here

})(jQuery);

var currentPageItem = function(){
    var $pageItem = $('.page-item');
    if($pageItem.length) {
        $pageItem.each(function(){
            var $scrollTop = $(document).scrollTop(),
                $itemId = $(this).attr('id'),
                $itemOffset = $(this).offset().top,
                $itemHeight = $(this).outerHeight();
            if($scrollTop >= $itemOffset && $scrollTop <= ($itemOffset + $itemHeight)) {
                $bodyScroll = $itemId;
                if(location.hash != '#'+$itemId) {
                    history.replaceState('', '', '#'+$itemId);
                }
            }
        });
    }
    else {
        window.location.hash = '';
        history.pushState('', document.title, window.location.pathname);
    }
};
$(document).ready(function() {
    // global variables
    var $window = $(window),
        $windowWidth = $window.width(),
        $windowHeight = $window.height(),
        $pageItem = $('.page-item');

    /*if($windowHeight > $pageItem.outerHeight()) {
     $pageItem.css('height', $windowHeight);
     }*/

    var $teamCarousel = $('.team-carousel');
    if($teamCarousel.length) {
        $('.team-carousel li').css('width' , $windowWidth);
        $teamCarousel
            .on('jcarousel:targetin', 'li', function() {
                $(this).addClass('active');
            })
            .on('jcarousel:targetout', 'li', function() {
                $(this).removeClass('active');
            })
            .jcarousel({
                scroll: 1,
                wrap: 'circular'
            });

        $teamCarousel
            .touchwipe({
                wipeLeft: function() {
                    $teamCarousel.jcarousel('scroll', '+=1');
                },
                wipeRight: function() {
                    $teamCarousel.jcarousel('scroll', '-=1');
                },
                min_move_x: 20,
                preventDefaultEvents: false
            });
        $('.team-carousel-prev').click(function() {
            $('.team-carousel').jcarousel('scroll', '-=1');
        });

        $('.team-carousel-next').click(function() {
            $('.team-carousel').jcarousel('scroll', '+=1');
        });

        $('.team-carousel-pagination')
            .on('jcarouselpagination:active', 'a', function() {
                $(this).addClass('active');
            })
            .on('jcarouselpagination:inactive', 'a', function() {
                $(this).removeClass('active');
            })
            .jcarouselPagination({
                'item': function() {
                    return '<a href="#team"></a>';
                }
            });
    }


    var $teamModal = $('.team-modal');
    $('.toggle-btn').on('click', function(e){
        var $this = $(this),
            $dataNav = $this.data('nav');
        $this.hide();
        $teamModal.hide();
        $('.toggle-nav-'+$dataNav).addClass('active').find('.toggle-nav-scroll').css('height' , $windowHeight);
        if ($dataNav === 'right') {
            if (typeof(ga) !== "undefined") {
                ga('send', 'event', 'Search Clicks', 'search-open', 'search-button');
            }
            $('#search_input').focus();
        }
        else if ($dataNav === 'left') {
            $mainNavLock.show();
        }
    });

    $('.team-link').on('click', function(e){
        var itemId = $(this).attr('href');
        e.preventDefault();
        $('.team-modal').show();
        $('.team-modal-scroll').css('height' , $(window).height());
        $teamCarousel.jcarousel('reload');
        $teamCarousel.jcarousel('scroll', $(itemId));
    });

    var $mainNavLock = $('.main-nav-lock');
    $mainNavLock.on('click', function() {
        $('.all-reviews-close').trigger('click');
        $('.toggle-close').trigger('click');
    });

    $('.toggle-close').on('click', function(){
        var $this = $(this),
            $toggleNav = $this.closest('.toggle-nav'),
            $dataNav = $toggleNav.data('nav');
        $toggleNav.removeClass('active');
        $teamModal.hide();
        $('.toggle-btn-'+$dataNav).show();
        $mainNavLock.hide();
        $('.all-reviews-nav').hide();
        currentPageItem();
    });

    $('.scroll-to').on('click', function(e) {
        var $scrollHref = $(this).attr('href');
        e.preventDefault();
        $('.toggle-close').trigger('click');
        $(window).scrollTo($scrollHref, 300);
    });



    $('.main-nav a').on('click', function(){
        $('.toggle-close').trigger('click');
    });
    if (window.location.hash === '#search') {
        $('.btn-search').trigger('click');
    }

    $('.all-reviews-btn').on('click',function(){
        $('.all-reviews-nav').show();
    });
    $('.all-reviews-close').on('click', function(){
        $('.all-reviews-nav').hide();
    });

    $('.how-we').each(function() {
        var parent_height = $(this).height();
        var child_height  =	$("ul", this).height();
        var child 		  = $("ul", this);
        var margin_top    = (parent_height - child_height) / 2;
        child.css( "margin-top", margin_top);
    });

    $('#how-open').on('click', function(){
        var reveal = $('#how-reveal');
        var open   = $(this);
        if(reveal.hasClass('active')){
            reveal.removeClass('active');
            reveal.slideUp();
            open.removeClass('active');
        } else {
            reveal.addClass('active');
            reveal.slideDown();
            open.addClass('active');
        }
    });

    $('#how-open-two').on('click', function(){
        var reveal = $('#how-reveal-two');
        var open   = $(this);
        if(reveal.hasClass('active')){
            reveal.removeClass('active');
            reveal.slideUp();
            open.removeClass('active');
        } else {
            reveal.addClass('active');
            reveal.slideDown();
            open.addClass('active');
        }
    });

    $('.update-open').on('click', function(){
        var reveal = $('.update-reveal');
        var open   = $(this);
        if(reveal.hasClass('active')){
            reveal.removeClass('active');
            reveal.slideUp();
            open.removeClass('active');
        } else {
            reveal.addClass('active');
            reveal.slideDown();
            open.addClass('active');
        }
    });

    $('#filter-open').on('click', function(){
        var reveal = $('#filter-reveal');
        var open   = $(this);
        if(reveal.hasClass('active')){
            reveal.removeClass('active');
            reveal.slideUp();
            open.removeClass('active');
        } else {
            reveal.addClass('active');
            reveal.slideDown();
            open.addClass('active');
        }
    });
    $('.expert-reveal').on('click', function(){
        $(this).parent('.side-widget').addClass('active');
    });

    $('.expert-close').on('click', function(){
        $(this).parent('.side-widget').removeClass('active');
    });

    $('.link-module').on('click', function(){
        $(this).find(".link-open").show();
    });
    
    $("#scroll-table").on('click', function(e){
    	$('html, body').animate({
        	scrollTop: $("#compare").offset().top
    	}, 500);
		e.preventDefault();
	});
    
            function popOut(thisObj, action){
                var parent = thisObj.parent('.pop-out');
                var section = parent.parent('.sidebar');
                if(action == 'open'){
                    parent.addClass('active');
                    section.addClass('popout');
                } else if (action == 'close'){
                    parent.removeClass('active');
                    section.removeClass('popout');

                }
                return false;
            }
        
            $('.read-more').on('click',function(){
                popOut($(this), 'open');
            });
            
            $('.close-out').on('click',function(){
                popOut($(this), 'close');
            });

    function triggerPopOut(){
        var currentPopOut = $(document.location.hash);
        var currentReadMore = currentPopOut.children('.read-more');
        if(currentPopOut.hasClass('pop-out')){
            currentReadMore.trigger('click');
        }
    }
    triggerPopOut();

});
$(window).resize(function(){
    var $window = $(window),
        $windowWidth = $window.width(),
        $windowHeight = $window.height(),
        $pageItem = $('.page-item');


    /*if($windowHeight > $pageItem.outerHeight()) {
     $pageItem.css('height', $windowHeight);
     }
     $('.team-carousel li').css('width' , $windowWidth);*/

    $('.how-we').each(function() {
        var parent_height = $(this).height();
        var child_height  =	$("ul", this).height();
        var child 		  = $("ul", this);
        var margin_top    = (parent_height - child_height) / 2;
        child.css( "margin-top", margin_top);
    });
});

$(document).scroll(function(){
    var $pageItem = $('.page-item');
    if($pageItem.length) {
        var $bodyScroll = '';
        $pageItem.each(function(){
            var $scrollTop = $(document).scrollTop(),
                $itemId = $(this).attr('id'),
                $itemOffset = $(this).offset().top,
                $itemHeight = $(this).outerHeight();
            if($scrollTop >= $itemOffset && $scrollTop <= ($itemOffset + $itemHeight) && $('.search').is(':hidden') && $('.team-modal').is(':hidden')) {
                $bodyScroll = $itemId;
                if(location.hash != '#'+$itemId) {
                    history.replaceState('', '', '#'+$itemId);
                }
            }
            else if($('.team-modal').is(':visible')) {
                if(location.hash != '#team') {
                    history.replaceState('', '', '#team');
                }
            }
            else if($('.search').is(':visible')) {
                if(location.hash != '#search') {
                    history.replaceState('', '', '#search');
                }
            }
        });
        $('body').attr('data-scroll', $bodyScroll);
    }
});
