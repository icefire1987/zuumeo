function getURI() {
	 var uri = document.location.href;
	 var canonical = jQuery("link[rel=canonical]").attr("href");

	 if (canonical && canonical.length > 0) {
		  if (canonical.indexOf("http") < 0) {
				canonical = document.location.protocol + "//" + document.location.host + canonical;
		  }
		  uri = canonical;
	 }

	 return uri;
}