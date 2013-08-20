(function registerScrolling($) {

    $('[class^="dropdown"] > a').click(function(e){

        return;
    });

    var prevTouchPosition = {},
        scrollYClass = 'scroll-y',
        scrollXClass = 'scroll-x',
        searchTerms = '.' + scrollYClass + ', .' + scrollXClass;

    $('*').not('[class^="dropdown"] > a').on('touchstart', function (e) {

        // console.log('touchstart');

        var $scroll = $(e.target).closest(searchTerms),
            targetTouch = e.originalEvent.targetTouches[0];

        // Store previous touch position if within a scroll element
        prevTouchPosition = $scroll.length ? { x: targetTouch.pageX, y: targetTouch.pageY } : {};
    });

    $('*').not('[class^="dropdown"] > a').on('touchmove', function (e) {

        // console.log('touchmove');

        var $scroll = $(e.target).closest(searchTerms),
            targetTouch = e.originalEvent.targetTouches[0];

        if (prevTouchPosition && $scroll.length) {
            // Set move helper and update previous touch position
            var move = {
                x: targetTouch.pageX - prevTouchPosition.x,
                y: targetTouch.pageY - prevTouchPosition.y
            };
            prevTouchPosition = { x: targetTouch.pageX, y: targetTouch.pageY };

            // Check for scroll-y or scroll-x classes
            if ($scroll.hasClass(scrollYClass)) {
                var scrollHeight = $scroll[0].scrollHeight,
                    outerHeight = $scroll.outerHeight(),

                    atUpperLimit = ($scroll.scrollTop() === 0),
                    atLowerLimit = (scrollHeight - $scroll.scrollTop() === outerHeight);

                if (scrollHeight > outerHeight) {
                    // If at either limit move 1px away to allow normal scroll behavior on future moves,
                    // but stop propagation on this move to remove limit behavior bubbling up to html
                    if (move.y > 0 && atUpperLimit) {
                        $scroll.scrollTop(1);
                        e.stopPropagation();
                    } else if (move.y < 0 && atLowerLimit) {
                        $scroll.scrollTop($scroll.scrollTop() - 1);
                        e.stopPropagation();
                    }

                    // If only moving right or left, prevent bad scroll.
                    if(Math.abs(move.x) > 0 && Math.abs(move.y) < 3){
                      e.preventDefault()
                    }

                    // Normal scrolling behavior passes through
                } else {
                    // No scrolling / adjustment when there is nothing to scroll
                    e.preventDefault();
                }
            } else if ($scroll.hasClass(scrollXClass)) {
                var scrollWidth = $scroll[0].scrollWidth,
                    outerWidth = $scroll.outerWidth(),

                    atLeftLimit = $scroll.scrollLeft() === 0,
                    atRightLimit = scrollWidth - $scroll.scrollLeft() === outerWidth;

                if (scrollWidth > outerWidth) {
                    if (move.x > 0 && atLeftLimit) {
                        $scroll.scrollLeft(1);
                        e.stopPropagation();
                    } else if (move.x < 0 && atRightLimit) {
                        $scroll.scrollLeft($scroll.scrollLeft() - 1);
                        e.stopPropagation();
                    }
                    // If only moving up or down, prevent bad scroll.
                    if(Math.abs(move.y) > 0 && Math.abs(move.x) < 3){
                      e.preventDefault();
                    }

                    // Normal scrolling behavior passes through
                } else {
                    // No scrolling / adjustment when there is nothing to scroll
                    e.preventDefault();
                }
            }
        } else {
            // Prevent scrolling on non-scrolling elements
            e.preventDefault();
        }
    });
})(jQuery);