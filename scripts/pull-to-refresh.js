(function($) {
    var methods = {
        init: function(options) {
            // Initialise the settings
            var settings = $.extend({
                'height': 50,
                'instruction': 'Pull down to refresh...',
                'message': 'Release to refresh...',
                'confirmation': 'Refreshing...',
            }, options);

            var $that = this,
                startY = 0,
                moveAdjustFactor = 2,
                distanceMoved = 0,
                height = settings.height,
                mainElTop = 0,
                scrollTop = 0;

            // Insert the pull to refresh element
            this.before('<div id="pull-to-refresh"><span>' + settings.instruction + '</span></div>');

            methods.$controlEl = $('#pull-to-refresh');

            var paddingTop = ((height / 2) - (methods.$controlEl.find('span').height() / 2));

            methods.marginAdjustment = parseInt(methods.$controlEl.css('marginTop'));
            height -= methods.marginAdjustment;

            // Set up the CSS to control the visibility of the element
            methods.$controlEl.css({
                'height': height,
                'marginTop': -height,
            });

            // Vertically centre the span within the parent element
            methods.$controlEl.find('span').css({
                'display': 'block',
                'paddingTop': paddingTop
            });

            // Store the top margin value
            methods.marginTop = parseInt(methods.$controlEl.css('marginTop'));
            methods.marginTopAbs = Math.abs(methods.marginTop);

            // Events are namespaced to prevent conflicts
            // Handle the touchstart event
            this.bind('touchstart.ptr', function(e) { 
                // Store the position the touch event started at
                if(e.originalEvent.targetTouches.length == 1) startY = e.originalEvent.targetTouches[0].pageY;

                mainElTop = $that.offset().top;
                scrollTop = $(window).scrollTop();
            });

            // Handle the touchend event
            this.bind('touchend.ptr', function() { 
                // If the whole of the element is visible
                if(distanceMoved > (methods.marginTopAbs + methods.marginAdjustment)) {
                    var marginAdj = methods.marginAdjustment;

                    methods.$controlEl
                        .animate({ 
                            'marginTop': marginAdj,
                            'paddingTop': 0
                        }, 250)
                        .find('span').text(settings.confirmation);

                    // Run the callback function
                    settings.callback();
                } else {
                    // Hide the element again
                    methods.$controlEl.animate({ 
                        'marginTop': methods.marginTop, 
                        'paddingTop': 0
                    }, 250)
                }

                distanceMoved = 0;
            });

            // Handle the touchmove event
            this.bind('touchmove.ptr', function(e) {
                var e = e.originalEvent;

                if(e.targetTouches.length == 1) {
                    var touchY = e.targetTouches[0].pageY;

                    // If the top of the element is visible on the screen
                    if(mainElTop >= scrollTop) {
                        // The element has been moved down
                        if(touchY > startY) {
                            // Calculate how far the element has moved
                            distanceMoved = Math.round((touchY - startY) / moveAdjustFactor);

                            // If some of the element is still hidden
                            if(distanceMoved < methods.marginTopAbs && (methods.marginTop + distanceMoved) < methods.marginAdjustment) {
                                methods.$controlEl.css('marginTop', (methods.marginTop + distanceMoved)).find('span').text(settings.instruction);
                            } else {
                                var marginAdj = methods.marginAdjustment;

                                methods.$controlEl.css({
                                    'marginTop': marginAdj,
                                    'paddingTop': ((distanceMoved - methods.marginTopAbs) + Math.abs(marginAdj))
                                }).find('span').text(settings.message);
                            }

                            return false;
                        }
                    }
                }
            });
        },

        // Hides the element (to be called after callback function has executed)
        hide: function() {
            methods.$controlEl.animate({ 'marginTop': methods.marginTop }, 250)
        }
    };

    $.fn.pullToRefresh = function(method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || ! method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Method ' +  method + ' does not exist.');
        }  
    };
})(jQuery);
