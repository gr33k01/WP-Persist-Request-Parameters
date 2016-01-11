(function( $ ) {
	/*
	* var valuesToPersist avaliable via wp_localize_script()
	*/

	/*
	* var valuesToPersist avaliable via wp_localize_script()
	*/

	var valuesToPersist = prpValues.valuesToPersist;

	function getParameterByName(name) {
	    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
	    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
	        results = regex.exec(location.search);
	    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
	}

	if(!valuesToPersist.length) return;

	for(var i = 0; i < valuesToPersist.length; i++){

		var cookieExists = Cookies.get(valuesToPersist[i]) != undefined;
		var parameterExists = getParameterByName(valuesToPersist[i]) != "";
		var staleCookieExists = ( Cookies.get(valuesToPersist[i]) != getParameterByName(valuesToPersist[i]) ) && parameterExists && cookieExists;
		

		if ( !cookieExists  && parameterExists ) {
			console.log('Cookie with key '  + valuesToPersist[i] + ' does not exist.');
		}

		if ( staleCookieExists ) {
			console.log('Stale cookie with key '  + valuesToPersist[i] + ' detected.');
			console.log('Old value: [' + Cookies.get(valuesToPersist[i]) + ']...');
			console.log('New value: [' + getParameterByName(valuesToPersist[i]) + ']...');
		}

		if ( (!cookieExists  && parameterExists) || staleCookieExists ) {
			console.log('Setting cookie with key ['  + valuesToPersist[i] + '] to: [' +  getParameterByName(valuesToPersist[i]) + ']...');
			Cookies.set( valuesToPersist[i], getParameterByName(valuesToPersist[i]) );
			console.log('Cookie with key ['  + valuesToPersist[i] + '] now has value: [' + Cookies.get(valuesToPersist[i]) + '].');
		}
	}
})( jQuery );


