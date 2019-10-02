
  var baseurl = 'https://xxxx/debug.php';
  function sendXhrEvent (url, event, resolve, reject) {

	  	    request = new XMLHttpRequest();

	  	    request.onreadystatechange = () => {
			    	    	if (this.readyState === XMLHttpRequest.DONE ){
								            if (request.status === 200) {
										    				    	resolve(request);
										    				    } else {
															    		            	reject(request);
															    				    }
							    	}
			    		  		        };

	  	    request.open('POST', url,true);
	  	    request.onabort = function () {
			            	reject(request);
			    	    };
	  		request.onerror = function () {
					        	reject(request);
						};
	  	    request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	  	    request.send("post="+JSON.stringify(event));

  }


(function(_window, _document, _onerror, _onunhandledrejection) {

			  var queue = function(exception) {
				  			  	    queue.data.push(exception);
				  			  	  };
			  queue.data = [];
			  var _oldOnerror = _window[_onerror];
			  _window[_onerror] = function(message, source, lineno, colno, exception) {

				  			  sendXhrEvent(
								  					  baseurl,
								  					  	{message: message, source:source,lineno:lineno,colno:colno,exception:exception},
								  					  	function(){}, 
								  					  	function (){
																		  				( new Image() ).src = baseurl + '?message=' + encodeURIComponent( message ) +
																				  	        '&source='     + encodeURIComponent( source ) +
																				  	        '&lineno='    + encodeURIComponent( lineno ) +
																				  	        '&colno='    + encodeURIComponent( colno ) +
																'&exception='    + encodeURIComponent( exception ) ;
																				  	}
								  					  	);


				  			  	    if (_oldOnerror) _oldOnerror.apply(_window, arguments);

				  			  	  };
	/*
	 * 		  var _oldOnunhandledrejection = _window[_onunhandledrejection];
	 * 		  		  _window[_onunhandledrejection] = function(exception) {
	 *
	 * 		  		  			  			( new Image() ).src = basurl + '?' +
	 * 		  		  			  							  	        '&exception='    + encodeURIComponent( exception );
	 *
	 * 		  		  			  							  	        			  	    if (_oldOnunhandledrejection) _oldOnunhandledrejection.apply(_window, arguments);
	 * 		  		  			  							  	        			  	    			  	  };
	 * 		  		  			  							  	        			  	    			  	  */
				
			})(window, document, 'onerror', 'onunhandledrejection');

