// usage: log('inside coolFunc', this, arguments);
// paulirish.com/2009/log-a-lightweight-wrapper-for-consolelog/
window.log = function(){
	log.history = log.history || [];   // store logs to an array for reference
	log.history.push(arguments);
  	if(this.console) {
    	arguments.callee = arguments.callee.caller;
    	var newarr = [].slice.call(arguments);
    	(typeof console.log === 'object' ? log.apply.call(console.log, console, newarr) : console.log.apply(console, newarr));
  	}
};

// make it safe to use console.log always
(function(b){function c(){}for(var d="assert,count,debug,dir,dirxml,error,exception,group,groupCollapsed,groupEnd,info,log,timeStamp,profile,profileEnd,time,timeEnd,trace,warn".split(","),a;a=d.pop();){b[a]=b[a]||c}})((function(){try
{console.log();return window.console;}catch(err){return window.console={};}})());

var upBase;

;(function(){

	function UpBase(){
		this.init();
	}

	UpBase.prototype.init = function() {
		this.initClassFixing();
  		this.initDropDowns();
  		this.initToolTips();
  		this.initModals();
	};

	UpBase.prototype.initClassFixing = function(){
		var first_last = new Array('table tr', 'table td', 'dl dt', 'ul li', '.table_container .table_default');
		for (var i=0; i<first_last.length; i++){
			var f = first_last[i];
			$(f+":first-child").addClass("first");
			$(f+":last-child").addClass("last");
		}
		$("table tr:odd").addClass("odd");
		//nth-child fixes for media-grid
		$(".media-block:nth-of-type(2n+3)").addClass("n3");
		$(".media-block:nth-of-type(3n+4)").addClass("n4");
		$(".media-block:nth-of-type(4n+5)").addClass("n5");
		$(".media-block:nth-of-type(5n+6)").addClass("n6");
		$(".media-block:nth-of-type(6n+7)").addClass("n7");
	}

	UpBase.prototype.initTabs = function(){
		/* Bind tabbing action from all uls with a class of 'tabs' to all divs
		/  with a class of '.pane' that share the same container div */
		try {
			$("ul.tabs").tabs("> .pane",{
				current:'active'
			});	
			// Bind tabbing action from all uls with a class of 'pills' to all divs
			// with a class of '.pane' that share the same container div
			$("ul.pills").tabs("> .pane",{
				current:'active'
			});	
		} catch(e){
			trace('Error loading tabs ' + e);
		}
	}

	UpBase.prototype.initDropDowns = function(){
		// Set dropdowns on click
		console.log('initDropDowns');
		$('html').not('.touch').on("click", ".dropdown-trigger, .dd-menu-trigger", toggleDropDown);

		$('html').not('.touch').on('mouseenter', '.dropdown-trigger-hover, .dd-menu-trigger-hover', showDropDown);
		$('html').not('.touch').on('mouseleave', '.dropdown-trigger-hover, .dd-menu-trigger-hover', hideDropDown);
		
		$('html.touch').on("touchend", ".dropdown-trigger, .dd-menu-trigger, .dropdown-trigger-hover, .dd-menu-trigger-hover", toggleDropDown);
		console.log('assing');
		$(document).on('click', '.dropdown-active a, .menu-active a', function(){
				console.log('clicker');
				var $this = $(this);
				var $parent = $this.closest('.dropdown-active, .menu-active');
				$parent.removeClass('open');
		});

		function getDropDownTarget(e){
			if ($('html').hasClass('touch')) {
				e.preventDefault();
			}
			var $this = $(e.target);
			var $t = $this.closest(".dropdown, .dd-mod");
			if (!$t.length){
				var target = $this.data('target');
				$t = $(target);
			}
			return $t;
		}

		function showDropDown(e){
			var t = getDropDownTarget(e);
			t.addClass('dropdown-active menu-active open');
		}

		function hideDropDown(e){
			var t = getDropDownTarget(e);
			t.removeClass('dropdown-active menu-active open');
		}

		function toggleDropDown(e){
			//console.log(e.type);
			console.log('toggleDropDown');
			e.stopImmediatePropagation();
			var targetMaybe = getDropDownTarget(e);
			if (targetMaybe.is(':visible')){
				hideDropDown(e);
			} else {
				showDropDown(e);
			}
		}
	}

	UpBase.prototype.initToolTips = function(){
    	// Show tooltips on hover
		$(document.body).delegate(".tip-trigger", "mouseenter mouseleave", function() {
			$(this).toggleClass("tip-active");
		});

		// Show popovers on hover
		$(document.body).delegate(".pop-trigger", "mouseenter mouseleave", function() {
			$(this).toggleClass("pop-active");
  		});
  	}

	UpBase.prototype.initModals = function(){
		// Apply modal action to anything with ID of "modal"
		// Launch when user clicks any object with a class of "modal-trigger"
		$('.modal-trigger').click(function(){
				$('.modal').modal();
			});
		// Create a close button for the modal, dismiss modal by clicking the background
		$('.close-modal, .simplemodal-overlay').live('click', function(){
			$.modal.close();
		});
		if ($.modal){
			// Don't let opacity be set by the plugin
			$.modal.defaults.opacity = 'inherit';
			// Add a class to overlay and container when the modal is shown
			$.modal.defaults.onShow = function(){
				$('.simplemodal-overlay').addClass('overlay-active');
				$('.simplemodal-container').addClass('modal-active');
			}
		}
	}

	$(document).ready(function() {
		upBase = new UpBase();
	}); /* end jQuery functions */

})();

/* Universal Functions */

function trace(msg){
	try{console.log(msg);} catch(e){}
}

Array.prototype.getRandom = function(){
	var r = Math.floor(Math.random() * this.length);
	return this[r];
}

Array.prototype.getLast = function(){
	var l = this.length - 1;
	return this[l];
}

Array.prototype.remove = function(removeMe){
	var index = this.indexOf(removeMe);
	if (index > -1){
		this.splice(index, 1);
	}
	return this;
}

Array.prototype.fill = function(size, oneBased){
	for (var i = 0; i<size; i++){
		var j = i;
		if (oneBased){
			j = i + 1;
		}
		this.push(j);
	}
	return this;
}