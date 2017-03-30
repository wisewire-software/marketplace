/**
 * js cookies
 * https://github.com/js-cookie/js-cookie
 */
!function(e){if("function"==typeof define&&define.amd)define(e);else if("object"==typeof exports)module.exports=e();else{var n=window.Cookies,t=window.Cookies=e();t.noConflict=function(){return window.Cookies=n,t}}}(function(){function e(){for(var e=0,n={};e<arguments.length;e++){var t=arguments[e];for(var o in t)n[o]=t[o]}return n}function n(t){function o(n,r,i){var c;if(arguments.length>1){if(i=e({path:"/"},o.defaults,i),"number"==typeof i.expires){var s=new Date;s.setMilliseconds(s.getMilliseconds()+864e5*i.expires),i.expires=s}try{c=JSON.stringify(r),/^[\{\[]/.test(c)&&(r=c)}catch(a){}return r=encodeURIComponent(String(r)),r=r.replace(/%(23|24|26|2B|3A|3C|3E|3D|2F|3F|40|5B|5D|5E|60|7B|7D|7C)/g,decodeURIComponent),n=encodeURIComponent(String(n)),n=n.replace(/%(23|24|26|2B|5E|60|7C)/g,decodeURIComponent),n=n.replace(/[\(\)]/g,escape),document.cookie=[n,"=",r,i.expires&&"; expires="+i.expires.toUTCString(),i.path&&"; path="+i.path,i.domain&&"; domain="+i.domain,i.secure?"; secure":""].join("")}n||(c={});for(var p=document.cookie?document.cookie.split("; "):[],u=/(%[0-9A-Z]{2})+/g,d=0;d<p.length;d++){var f=p[d].split("="),l=f[0].replace(u,decodeURIComponent),m=f.slice(1).join("=");'"'===m.charAt(0)&&(m=m.slice(1,-1));try{if(m=t&&t(m,l)||m.replace(u,decodeURIComponent),this.json)try{m=JSON.parse(m)}catch(a){}if(n===l){c=m;break}n||(c[l]=m)}catch(a){}}return c}return o.get=o.set=o,o.getJSON=function(){return o.apply({json:!0},[].slice.call(arguments))},o.defaults={},o.remove=function(n,t){o(n,"",e(t,{expires:-1}))},o.withConverter=n,o}return n()});

/**
 * Require js cookies plugin
 * https://github.com/js-cookie/js-cookie
 */
(function(){
	$this = this;
	this.body = $('#explore-body');
	this.list = $('#explore-items');
	this.help_modal_cookie_name = 'help_modal';
	this.help_modal = Cookies.get( this.help_modal_cookie_name ) !== undefined ? false : true;
	//console.log(this.help_modal, Cookies.get( this.help_modal_cookie_name ));
	this.help_modal_timeout = false;

	if(this.body.width()<768)
		list_layout();

	$( window ).resize(function() {	  		
		check_layout();
	});

	function check_layout(){
		if(this.body.width()<768)
			list_layout();
		else
			if($('#btn-view-grid').hasClass('active'))
				grid_layout();
	}

	function list_layout(){
		$('#explore-items').addClass('list-layout'); 
		$('#explore-items').removeClass('grid-layout'); 
		$('#explore-items').show();
	}	

	function grid_layout(){
		$('#explore-items').addClass('grid-layout'); 
		$('#explore-items').removeClass('list-layout'); 
		$('#explore-items').show();
	}

	function getQueryStrings() {
		var assoc  = {};
		var decode = function (s) { return decodeURIComponent(s.replace(/\+/g, " ")); };
		var queryString = location.search.substring(1);
		var keyValues = queryString.split('&');

		for(var i in keyValues) {
			var key = keyValues[i].split('=');
			if (key.length > 1) {
				assoc[decode(key[0])] = decode(key[1]);
			}
		}

		return assoc;
	}


	this.load = function(params){
		
		this.restart_help_modal_timeout();				
		if(!params.list_view) {

			var queryString = getQueryStrings();
			if( typeof(queryString['nogrades']) != 'undefined' && queryString['nogrades'] != null){
				params['nogrades'] = queryString['nogrades'];
			}

			if( typeof(queryString['sepllcheck']) != 'undefined' && queryString['sepllcheck'] != null){
				params['sepllcheck'] = queryString['sepllcheck'];
			}

			$('.ajax-loading').css({'display':'inline-block'});
			this.body.load( '?ajax=1 #explore-body>*', params, function(){
				$('.select').selectpicker({
					style: 'btn-select'
				});
				$('.ajax-loading').css({'display':'none'});
				check_layout();
			});
		}else{
			Cookies.set( 'exploreall_list_view', params.list_view );
		}
	}
	
	this.restart_help_modal_timeout = function(){
		
		if (this.help_modal_timeout) {
			//console.log('clear timeout for help modal');
			clearTimeout( this.help_modal_timeout );
		}
		
		// if modal has to be displayed and search page
		if (this.help_modal === true && $('body').hasClass('page-template-template-explore')) {
			//console.log('i will show help modal');
			this.help_modal_timeout = setTimeout(function(controller){
				Cookies.set( controller.help_modal_cookie_name, '1', { expires: 14 } );
				controller.help_modal = false;
				/* 
				 * Uncomment this to show popup again
				*/
				//$('#helpModal').modal();
			},15000, this);
		}
	};
	
	this.init = function(){
		
		this.restart_help_modal_timeout();
		
		this.body.delegate('.filter','click',function(e){
			e.preventDefault();
			var filter = $(this);
			$this.load( { filter: filter.data('filter'), filter_value: filter.attr('href').substr(1) } );

			var currentUrl  = window.location.href;
			currentUrl = currentUrl.replace(/\/[0-9]+\//, "/");
			window.history.pushState({}, "", currentUrl);

			var searchValue = $('#explore-items').data('searchvalue');

			if(searchValue){
				ga('send', 'event', 'Search', 'Filter By', searchValue, {
					'dimension1':  searchValue,
					'dimension2' : filter.data('filter'),
					'dimension4' : filter.attr('href').substr(1),
					'metric1':  '1'
				});
			}else{
				ga('send', 'event', 'Search', 'Filter By', filter.data('filter'), {
					'dimension2' : filter.data('filter'),
					'dimension4' : filter.attr('href').substr(1),
					'metric1':  '1'
				});
			}
		});
		
		this.body.delegate('.filter-remove','click',function(e){
			e.preventDefault();
			var filter = $(this);
			$this.load( { filter_remove: filter.data('filter'), filter_value: filter.attr('href').substr(1) } );
		});
		
		this.body.delegate('.filter-order-by','change',function(e){
			var filter = $(this);
			$this.load( { order_by: filter.val() } );
		});
		
		this.body.delegate('#btn-view-grid','click',function(e){
			e.preventDefault();
			$this.load( { list_view: 'grid' } );
			grid_layout();

			$(this).parent('.grid').find('a').removeClass('active');
			$(this).toggleClass('active');
			
			return false;
		});
		
		this.body.delegate('#btn-view-list','click',function(e){
			e.preventDefault();
			$this.load( { list_view: 'list' } );
			list_layout();			         
			
			$(this).parent('.grid').find('a').removeClass('active');
			$(this).toggleClass('active');
			
			return false;
		});
		
		
		this.body.delegate('#btn-filters-overlay-open','click',function(e) {
			e.preventDefault();
			$('#filters-overlay').addClass('active');
		});  

		this.body.delegate('#btn-filters-overlay-close','click',function(e) {
			e.preventDefault();
			$('#filters-overlay').removeClass('active');
		});  

		this.body.delegate('#btn-header-filters-overlay-close','click',function(e) {
			e.preventDefault();
			$('#filters-overlay').removeClass('active');
		});

		this.body.delegate('.btn-filters-clear','click',function(e) {			
			$('.ajax-loading').css({'display':'inline-block'});
		});
	};
	
	this.init();
	
})();