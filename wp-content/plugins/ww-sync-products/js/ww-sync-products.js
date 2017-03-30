jQuery( document ).ready(function() {

// LO ITEMS //////////////////////////////////////////////////////////////

		jQuery('.lo-theloader').hide();
		jQuery('#losync').on('click',function(e){
		e.preventDefault();
		jQuery('.lo-theloader').show();
		jQuery('.lo-loading-text').show();
		jQuery('.lo-loading-text').text('Loading...');

		jQuery.ajax({ 
		url: '/wp-content/plugins/ww-sync-products/WiseWireSyncProducts.php',
				 data: {action: 'lo',manual:1},
				 type: 'post',
				 success: function(output) {
							  var obj = jQuery.parseJSON(output);
		jQuery('.lo-theloader').hide();
		jQuery('.lo-loading-text').show().text(obj.count+' products: '+obj.updated+' updated // '+obj.added+' added');
						  },
		error: function(x, e){
		jQuery('.lo-theloader').hide();

		var errorText;
		 if (x.status==0) {
				errorText = 'You are offline!!\n Please Check Your Network.';
			} else if(x.status==404) {
				errorText = 'Requested URL not found.';
			} else if(x.status==500) {
				errorText = 'Internel Server Error.';
			} else if(e=='parsererror') {
				errorText = 'Error.\nParsing JSON Request failed.';
			} else if(e=='timeout'){
				errorText = 'Request Time out.';
			} else {
				errorText = 'Unknow Error.\n'+x.status;
			}
		   jQuery('.lo-loading-text').show().text(errorText);
		}
		});

		});


// API CACHE SYNC ///////////////////////////////////////////////////////
		

jQuery('.api-theloader').hide();
		jQuery('#apisync').on('click',function(e){
		e.preventDefault();
		jQuery('.api-theloader').show();
		jQuery('.api-loading-text').show();
		jQuery('.api-loading-text').text('Loading...');

		jQuery.ajax({ 
		url: '/wp-content/plugins/ww-sync-products/WiseWireSyncProducts.php',
				 data: {action: 'api',manual:1},
				 type: 'post',
				 success: function(output) {
							  var obj = jQuery.parseJSON(output);
		jQuery('.api-theloader').hide();
		jQuery('.api-loading-text').show().text(obj.count+' products: '+obj.updated+' updated // '+obj.added+' added');
						  },
		error: function(x, e){
		jQuery('.api-theloader').hide();

		var errorText;
		 if (x.status==0) {
				errorText = 'You are offline!!\n Please Check Your Network.';
			} else if(x.status==404) {
				errorText = 'Requested URL not found.';
			} else if(x.status==500) {
				errorText = 'Internel Server Error.';
			} else if(e=='parsererror') {
				errorText = 'Error.\nParsing JSON Request failed.';
			} else if(e=='timeout'){
				errorText = 'Request Time out.';
			} else {
				errorText = 'Unknow Error.\n'+x.status;
			}
		   jQuery('.api-loading-text').show().text(errorText);
		}
		});

		});		


});