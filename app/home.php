<!DOCTYPE html>
<html>
<head>
<title>Instacopy</title>
<link rel="stylesheet" type="text/css" href="style/default.css" />
<meta charset="UTF-8">
</head>
<body>
<div class="logo">
	<img src="images/instacopy.png" alt="instacopy logo"/>
</div>
<script>
window.onload = function ()
{
	// Load the SDK asynchronously
  	(function(d, s, id) {
	    var js, fjs = d.getElementsByTagName(s)[0];
	    if (d.getElementById(id)) return;
	    js = d.createElement(s); js.id = id;
	    js.src = "//connect.facebook.net/en_US/sdk.js";
	    fjs.parentNode.insertBefore(js, fjs);
  	}(document, 'script', 'facebook-jssdk'));

	FB.api('/me', function(response) {
	    console.log(JSON.stringify(response));
	});
}
</script>
</body>
</html>