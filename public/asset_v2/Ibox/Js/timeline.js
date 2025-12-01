jQuery(document).ready(function($){
	var timelines = $('.cd-horizontal-timeline'),
		eventsMinDistance = 120;

	(timelines.length > 0) && initTimeline(timelines);

	function initTimeline(timelines) {
        timelines.each(function() {
            var timeline = $(this),
                timelineComponents = {};

            // Cache timeline components
            timelineComponents['timelineWrapper'] = timeline.find('.events-wrapper');
            timelineComponents['eventsWrapper'] = timelineComponents['timelineWrapper'].children('.events');
            timelineComponents['fillingLine'] = timelineComponents['eventsWrapper'].children('.filling-line');
            timelineComponents['timelineEvents'] = timelineComponents['eventsWrapper'].find('a');
            timelineComponents['timelineDates'] = parseDate(timelineComponents['timelineEvents']);
            timelineComponents['eventsMinLapse'] = minLapse(timelineComponents['timelineDates']);
            timelineComponents['timelineNavigation'] = timeline.find('.cd-timeline-navigation');
            timelineComponents['eventsContent'] = timeline.children('.events-content');

            // Get the width of the timeline wrapper (visible area)
            var wrapperWidth = timelineComponents['timelineWrapper'].width();

            // Calculate the width of each li based on 5 days visible
            var liWidth = wrapperWidth / 5;

            // Set each li element's width to be liWidth
            timelineComponents['timelineEvents'].parent('li').css('width', liWidth + 'px');

            // Assign a left position to the single events along the timeline
            setDatePosition(timelineComponents, liWidth);

            // Assign a width to the timeline based on the number of events
            var timelineTotWidth = setTimelineWidth(timelineComponents, liWidth);

            // The timeline has been initialized - show it
            timeline.addClass('loaded');

            // Automatically scroll to the last event on load
            var lastEvent = timelineComponents['timelineEvents'].last();
            updateFilling(lastEvent, timelineComponents['fillingLine'], timelineTotWidth);
            lastEvent.addClass('selected');
            updateOlderEvents(lastEvent);

            // Scroll to the position of the last event
            var lastEventPosition = lastEvent.position().left;
            var timelineTranslate = -lastEventPosition + (wrapperWidth / 2) - (liWidth / 2);
            translateTimeline(timelineComponents, timelineTranslate, wrapperWidth - timelineTotWidth);

            // Detect click on the next/prev arrow
            timelineComponents['timelineNavigation'].on('click', '.next', function(event) {
                event.preventDefault();
                updateSlide(timelineComponents, timelineTotWidth, 'next');
            });
            timelineComponents['timelineNavigation'].on('click', '.prev', function(event) {
                event.preventDefault();
                updateSlide(timelineComponents, timelineTotWidth, 'prev');
            });

            // Detect click on a single event
            timelineComponents['eventsWrapper'].on('click', 'a', function(event) {
                event.preventDefault();
                timelineComponents['timelineEvents'].removeClass('selected');
                $(this).addClass('selected');
                updateOlderEvents($(this));
                updateFilling($(this), timelineComponents['fillingLine'], timelineTotWidth);
                updateVisibleContent($(this), timelineComponents['eventsContent']);
            });
        });
    }



	function updateSlide(timelineComponents, timelineTotWidth, string) {
		//retrieve translateX value of timelineComponents['eventsWrapper']
		var translateValue = getTranslateValue(timelineComponents['eventsWrapper']),
			wrapperWidth = Number(timelineComponents['timelineWrapper'].css('width').replace('px', ''));
		//translate the timeline to the left('next')/right('prev')
		(string == 'next')
			? translateTimeline(timelineComponents, translateValue - wrapperWidth + eventsMinDistance, wrapperWidth - timelineTotWidth)
			: translateTimeline(timelineComponents, translateValue + wrapperWidth - eventsMinDistance);
	}

	function showNewContent(timelineComponents, timelineTotWidth, string) {
		//go from one event to the next/previous one
		var visibleContent =  timelineComponents['eventsContent'].find('.selected'),
			newContent = ( string == 'next' ) ? visibleContent.next() : visibleContent.prev();

		if ( newContent.length > 0 ) { //if there's a next/prev event - show it
			var selectedDate = timelineComponents['eventsWrapper'].find('.selected'),
				newEvent = ( string == 'next' ) ? selectedDate.parent('li').next('li').children('a') : selectedDate.parent('li').prev('li').children('a');

			updateFilling(newEvent, timelineComponents['fillingLine'], timelineTotWidth);
			updateVisibleContent(newEvent, timelineComponents['eventsContent']);
			newEvent.addClass('selected');
			selectedDate.removeClass('selected');
			updateOlderEvents(newEvent);
			updateTimelinePosition(string, newEvent, timelineComponents, timelineTotWidth);
		}
	}

	function updateTimelinePosition(string, event, timelineComponents, timelineTotWidth) {
		//translate timeline to the left/right according to the position of the selected event
		var eventStyle = window.getComputedStyle(event.get(0), null),
			eventLeft = Number(eventStyle.getPropertyValue("left").replace('px', '')),
			timelineWidth = Number(timelineComponents['timelineWrapper'].css('width').replace('px', '')),
			timelineTotWidth = Number(timelineComponents['eventsWrapper'].css('width').replace('px', ''));
		var timelineTranslate = getTranslateValue(timelineComponents['eventsWrapper']);

        if( (string == 'next' && eventLeft > timelineWidth - timelineTranslate) || (string == 'prev' && eventLeft < - timelineTranslate) ) {
        	translateTimeline(timelineComponents, - eventLeft + timelineWidth/2, timelineWidth - timelineTotWidth);
        }
	}

	function translateTimeline(timelineComponents, value, totWidth) {
		var eventsWrapper = timelineComponents['eventsWrapper'].get(0);
		value = (value > 0) ? 0 : value; //only negative translate value
		value = ( !(typeof totWidth === 'undefined') &&  value < totWidth ) ? totWidth : value; //do not translate more than timeline width
		setTransformValue(eventsWrapper, 'translateX', value+'px');
		//update navigation arrows visibility
		(value == 0 ) ? timelineComponents['timelineNavigation'].find('.prev').addClass('inactive') : timelineComponents['timelineNavigation'].find('.prev').removeClass('inactive');
		(value == totWidth ) ? timelineComponents['timelineNavigation'].find('.next').addClass('inactive') : timelineComponents['timelineNavigation'].find('.next').removeClass('inactive');
	}

	function updateFilling(selectedEvent, filling, totWidth) {
		//change .filling-line length according to the selected event
		var eventStyle = window.getComputedStyle(selectedEvent.get(0), null),
			eventLeft = eventStyle.getPropertyValue("left"),
			eventWidth = eventStyle.getPropertyValue("width");
		eventLeft = Number(eventLeft.replace('px', '')) + Number(eventWidth.replace('px', ''))/2;
		var scaleValue = eventLeft/totWidth;
		setTransformValue(filling.get(0), 'scaleX', scaleValue);
	}

	function setDatePosition(timelineComponents, min) {
		for (i = 0; i < timelineComponents['timelineDates'].length; i++) {
			// Calculate the distance between the first number and the current number in the array
			var distance = Math.abs(timelineComponents['timelineDates'][i] - timelineComponents['timelineDates'][0]),
				distanceNorm = Math.round(distance/timelineComponents['eventsMinLapse']) + 2;
			timelineComponents['timelineEvents'].eq(i).css('left', distanceNorm * min + 'px');
		}
	}


	function setTimelineWidth(timelineComponents, width) {
		// Calculate the time span based on the difference between the first and last number
		var timeSpan = Math.abs(timelineComponents['timelineDates'][timelineComponents['timelineDates'].length - 1] - timelineComponents['timelineDates'][0]),
			timeSpanNorm = timeSpan / timelineComponents['eventsMinLapse'],
			timeSpanNorm = Math.round(timeSpanNorm) + 4,
			totalWidth = timeSpanNorm * width;

		// Set the width of the events wrapper
		timelineComponents['eventsWrapper'].css('width', totalWidth + 'px');

		// Update the filling line
		updateFilling(timelineComponents['timelineEvents'].eq(0), timelineComponents['fillingLine'], totalWidth);

		return totalWidth;
	}


	function updateVisibleContent(event, eventsContent) {
		// Extract the numeric part from the data-date attribute
		var eventDate = event.data('date').match(/\d+/)[0],
			visibleContent = eventsContent.find('.selected'),
			selectedContent = eventsContent.find('[data-date*="_' + eventDate + '"]'), // Match the numeric part of data-date
			selectedContentHeight = selectedContent.height();

		// Determine the entering and leaving classes based on the index of selected content
		if (selectedContent.index() > visibleContent.index()) {
			var classEntering = 'selected enter-right',
				classLeaving = 'leave-left';
		} else {
			var classEntering = 'selected enter-left',
				classLeaving = 'leave-right';
		}

		// Set the classes for animation
		selectedContent.attr('class', classEntering);
		visibleContent.attr('class', classLeaving).one('webkitAnimationEnd oanimationend msAnimationEnd animationend', function() {
			visibleContent.removeClass('leave-right leave-left');
			selectedContent.removeClass('enter-left enter-right');
		});

		// Adjust the height of the content area
		eventsContent.css('height', selectedContentHeight + 'px');
	}


	function updateOlderEvents(event) {
		event.parent('li').prevAll('li').children('a').addClass('older-event').end().end().nextAll('li').children('a').removeClass('older-event');
	}

	function getTranslateValue(timeline) {
		var timelineStyle = window.getComputedStyle(timeline.get(0), null),
			timelineTranslate = timelineStyle.getPropertyValue("-webkit-transform") ||
         		timelineStyle.getPropertyValue("-moz-transform") ||
         		timelineStyle.getPropertyValue("-ms-transform") ||
         		timelineStyle.getPropertyValue("-o-transform") ||
         		timelineStyle.getPropertyValue("transform");

        if( timelineTranslate.indexOf('(') >=0 ) {
        	var timelineTranslate = timelineTranslate.split('(')[1];
    		timelineTranslate = timelineTranslate.split(')')[0];
    		timelineTranslate = timelineTranslate.split(',');
    		var translateValue = timelineTranslate[4];
        } else {
        	var translateValue = 0;
        }

        return Number(translateValue);
	}

	function setTransformValue(element, property, value) {
		element.style["-webkit-transform"] = property+"("+value+")";
		element.style["-moz-transform"] = property+"("+value+")";
		element.style["-ms-transform"] = property+"("+value+")";
		element.style["-o-transform"] = property+"("+value+")";
		element.style["transform"] = property+"("+value+")";
	}

	//based on http://stackoverflow.com/questions/542938/how-do-i-get-the-number-of-days-between-two-dates-in-javascript
	function parseDate(events) {
		var dateArrays = [];

		events.each(function() {
			var dateStr = $(this).data('date');
			var dayMatch = dateStr.match(/\d+/); // Extracts the numeric part (e.g., 30)

			if (dayMatch) {
				var day = parseInt(dayMatch[0], 10); // Parse the numeric string to an integer
				dateArrays.push(day); // Push the extracted number into the array
			}
		});

		return dateArrays;
	}



	function daydiff(first, second) {
	    return Math.round((second-first));
	}

	function minLapse(dates) {
		// Determine the minimum distance among the numbers
		var dateDistances = [];
		for (i = 1; i < dates.length; i++) {
			var distance = Math.abs(dates[i] - dates[i - 1]); // Calculate the difference between consecutive numbers
			dateDistances.push(distance);
		}
		return Math.min.apply(null, dateDistances); // Return the minimum distance
	}


	/*
		How to tell if a DOM element is visible in the current viewport?
		http://stackoverflow.com/questions/123999/how-to-tell-if-a-dom-element-is-visible-in-the-current-viewport
	*/
	function elementInViewport(el) {
		var top = el.offsetTop;
		var left = el.offsetLeft;
		var width = el.offsetWidth;
		var height = el.offsetHeight;

		while(el.offsetParent) {
		    el = el.offsetParent;
		    top += el.offsetTop;
		    left += el.offsetLeft;
		}

		return (
		    top < (window.pageYOffset + window.innerHeight) &&
		    left < (window.pageXOffset + window.innerWidth) &&
		    (top + height) > window.pageYOffset &&
		    (left + width) > window.pageXOffset
		);
	}

	function checkMQ() {
		//check if mobile or desktop device
		return window.getComputedStyle(document.querySelector('.cd-horizontal-timeline'), '::before').getPropertyValue('content').replace(/'/g, "").replace(/"/g, "");
	}
});
